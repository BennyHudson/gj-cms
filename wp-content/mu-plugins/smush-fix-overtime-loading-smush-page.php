<?php
/**
 * Plugin Name: [Smush Pro] - Fix Overtime loading on Smush Page
 * Description: [Smush Pro] - Fix overtime loading on Smush Page
 * Author: Thobk @ WPMUDEV
 * Author URI: https://premium.wpmudev.org
 * License: GPLv2 or later
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * This MU plugin limit the number of images for each process. By default, the query limit is 30.000 images.
 * You can also set it by defining this constant `WDEV_SMUSH_QUERY_LIMIT`, e.g
 * define('WDEV_SMUSH_QUERY_LIMIT', 20000 );
 * When you run bulk smush, it will auto start the new chunk after compressing $query_limit images until complete all the images.
 * You can enable email notification to get the notice when the bulk smush is completed.
 * 
 * And note, this MU plugin only process unsmushed images, this means, re-check images button will not work correctly since we do not re-check smushed images.
 * To re-check smushed images, you can ovewrite the config by defining these constants:
 * define('WDEV_SMUSH_MIN_IMAGE_ID', [min image id]);
 * define('WDEV_SMUSH_MAX_IMAGE_ID', [max image id]);
 */

add_action( 'plugins_loaded', 'wpmudev_smpro_fix_overtime_loading_smush_page', 100 );
class WDEV_Smush_Fix_Overtime_Loading {
	private $min_image_id = 0;
	private $max_image_id = 0;
	private $query_limit;
	private $total_images = 0;
	private $smushed_count = 0;
	private $first_unsmushed_id = 0;
	private $last_image_id = 0;
	private $smushed_meta_key;
	public function __construct() {
		$this->set_query_limit( $this->get_query_limit() );
		$this->set_smushed_meta_key( Smush\Core\Modules\Smush::$smushed_meta_key );

		add_filter( 'query', array( $this, 'filter_query' ) );
		add_action('wp_ajax_bulk_smush_start', function() {
			add_action( 'posts_where', array( $this, 'filter_unsmushed_query' ), 10, 2 );
		}, 9);

		// Filter smush data.
		add_filter( 'wp_smush_script_data', array( $this, 'filter_smush_script_data' ) );
		add_action( 'wp_smush_admin_do_meta_boxes_smush-bulk', array( $this, 'filter_smush_stats' ) );
		add_action( 'wp_smush_remove_filters', array( $this, 'filter_smush_stats' ) );
		add_action( 'wp_ajax_scan_for_resmush', array( $this, 'filter_smush_stats' ), 9 );

		add_action( $this->get_process_identifier() .'_completed', array( $this, 'auto_start_bulk_smush' ) );

	}

	public function load_config() {
		static $loaded;
		if ( $loaded ) {
			return;
		}
		$loaded = true;
		$this->set_min_image_id( $this->get_min_image_id() );
		$this->set_max_image_id( $this->get_max_image_id() );
	}

	private function get_process_identifier() {
		$identifier = 'wp_smush_bulk_smush_background_process';
		if ( is_multisite() ) {
			$post_fix   = "_" . get_current_blog_id() . "_";
			$identifier .= $post_fix;
		}

		return $identifier;
	}

	public function set_smushed_meta_key( $meta_key ) {
		$this->smushed_meta_key = $meta_key;
	}

	public function filter_smush_stats() {
		WP_Smush::get_instance()->core()->total_count = $this->get_total_images();
		WP_Smush::get_instance()->core()->smushed_count = $this->get_smushed_count();
		$remain_count = WP_Smush::get_instance()->core()->total_count - WP_Smush::get_instance()->core()->smushed_count;
		WP_Smush::get_instance()->core()->remaining_count = 0 === $remain_count ? '+0' : $remain_count;
	}

	public function filter_smush_script_data( $smush_data ) {
		$smush_data['count_smushed'] = $this->get_smushed_count();
		$smush_data['remaining_count'] = $this->get_total_images() - $smush_data['count_smushed'];
		return $smush_data;
	}

	public function get_total_images() {
		if ( ! $this->total_images ) {
			global $wpdb;
			$mime = implode( "', '", Smush\Core\Core::$mime_types );
			$this->total_images = $wpdb->get_var( "SELECT COUNT(1) FROM $wpdb->posts WHERE post_type = 'attachment' AND post_status = 'inherit' AND post_mime_type IN ('$mime')" );
		}

		return (int) $this->total_images;
	}

	public function get_smushed_count() {
		if ( ! $this->smushed_count ) {
			global $wpdb;
			$this->smushed_count = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(1) FROM $wpdb->postmeta WHERE meta_key=%s", $this->smushed_meta_key ) );
		}

		return (int) $this->smushed_count;
	}

	public function get_last_image_id() {
		if ( ! $this->last_image_id ) {
            global $wpdb;
			$mime = implode( "', '", Smush\Core\Core::$mime_types );
			$this->last_image_id = $wpdb->get_var( "SELECT ID FROM $wpdb->posts WHERE post_type = 'attachment' AND post_status = 'inherit' AND post_mime_type IN ('$mime') ORDER BY ID DESC limit 1" );
		}

		return (int) $this->last_image_id;
	}

	public function get_first_unsmushed_image_id() {
		if ( ! $this->first_unsmushed_id ) {
			$args = array(
				'fields'                 => 'ids',
				'post_type'              => 'attachment',
				'post_status'            => 'any',
				'orderby'                => 'ID',
				'order'                  => 'ASC',
				'posts_per_page'         => 1,
				'offset'                 => 0,
				'update_post_term_cache' => false,
				'no_found_rows'          => true,
				'meta_query'             => $this->get_unsmushed_meta_query(),
			);
			$posts = new WP_Query( $args );
			if ( ! empty( $posts->posts ) ) {
				$this->first_unsmushed_id = (int) $posts->posts[0];
			}
        }

		return (int) $this->first_unsmushed_id;
	}

	/**
	 * Get unsmushed meta query.
	 *
	 * @return array
	 */
	private function get_unsmushed_meta_query() {
		$unsmushed_query = array(
			'relation' => 'AND',
			array(
				'key'     => $this->smushed_meta_key,
				'compare' => 'NOT EXISTS',
			),
			array(
				'key'     => 'wp-smush-ignore-bulk',
				'compare' => 'NOT EXISTS',
			),
		);
		return $unsmushed_query;
	}

	public function set_query_limit( $limit ) {
		$this->query_limit = $limit;
	}

	public function get_query_limit() {
		if ( defined( 'WDEV_SMUSH_QUERY_LIMIT' ) && WDEV_SMUSH_QUERY_LIMIT > 1 ) {
			return WDEV_SMUSH_QUERY_LIMIT;
		}

		return 30000;
	}

	public function set_min_image_id( $min_id ) {
		$this->min_image_id = $min_id;
	}

	public function set_max_image_id( $max_id ) {
		$this->max_image_id = $max_id;
	}

	public function get_min_image_id() {
		if ( $this->min_image_id ) {
			return $this->min_image_id;
		}
		if ( defined( 'WDEV_SMUSH_MIN_IMAGE_ID' ) && WDEV_SMUSH_MIN_IMAGE_ID > 0 ) {
			return WDEV_SMUSH_MIN_IMAGE_ID;
		}
		$min_image_id = $this->get_first_unsmushed_image_id() - 1;
		if ( $min_image_id ) {
			$last_image_id = $this->get_last_image_id();
			$min_image_id  = min( $min_image_id, $last_image_id - $this->get_query_limit() );
		}

		return max( $min_image_id, 0 );
	}

	public function get_max_image_id() {
		if ( $this->max_image_id ) {
			return $this->max_image_id;
		}

		if ( defined( 'WDEV_SMUSH_MAX_IMAGE_ID' ) && WDEV_SMUSH_MAX_IMAGE_ID > 0 ) {
			return WDEV_SMUSH_MAX_IMAGE_ID;
		}

		$min_image_id  = $this->get_min_image_id();
		$last_image_id = $this->get_last_image_id();
        if ( $min_image_id < $last_image_id - $this->get_query_limit() ) {
            global $wpdb;
			$mime = implode( "', '", Smush\Core\Core::$mime_types );
			$max_image_id = $wpdb->get_var( "SELECT ID FROM $wpdb->posts WHERE ID > {$this->min_image_id} AND post_type = 'attachment' AND post_status = 'inherit' AND post_mime_type IN ('$mime') ORDER BY ID ASC LIMIT {$this->query_limit}, 1" );
			return (int) $max_image_id;
        }
		return 0;
	}

	public function filter_unsmushed_query( $where, $query ) {
		$meta_query = $query->get('meta_query');
		$is_unsmushed_query = false;
		if ( ! empty( $meta_query ) && is_array( $meta_query ) ) {
			$conditions = wp_list_pluck( $meta_query, 'key' );
			$unsmushed_conditions = array(
				'wp-smpro-smush-data',
				'wp-smush-ignore-bulk'
			);
			$matches = array_intersect( $unsmushed_conditions, $conditions );
			$is_unsmushed_query = 2 === count( $matches );
		}
		if ( $is_unsmushed_query ) {
			$this->load_config();
			if ( $this->max_image_id ) {
				$where = $where . " AND {$wpdb->posts}.ID < {$this->max_image_id}";
			}
			if ( $this->min_image_id ) {
				$where = $where . " AND {$wpdb->posts}.ID > {$this->min_image_id}";
			}
		}

		return $where;
	}

	public function filter_query( $query ) {
        if ( ! is_admin() ) {
            return $query;
        }
		$smush_query_regexes = array(
			"#SELECT ID .+ post_mime_type IN \('image/jpg','image/jpeg','image/x-citrix-jpeg','image/gif','image/png','image/x-png'\)#" => 'ID',
			"#SELECT post_id.+ WHERE meta_key='wp-smpro-smush-data'#" => 'post_id',
			"#SELECT DISTINCT post_id.+ WHERE meta_key='wp-smpro-smush-data'#" => 'post_id',
			"#SELECT post_id.+ WHERE meta_key='_wp_attachment_backup_sizes'#" => 'post_id',
            "#SELECT post_id.+ WHERE meta_key='wp-smush-#" => 'post_id',
		);

		foreach ( $smush_query_regexes as $regex => $id_col ) {
			if ( preg_match( $regex, $query, $matches ) ) {
				$this->load_config();
				if ( $this->max_image_id ) {
					$query = str_replace( 'WHERE ', "WHERE {$id_col} < {$this->max_image_id} AND ", $query );
				}
				if ( $this->min_image_id ) {
					$query = str_replace( 'WHERE ', "WHERE {$id_col} > {$this->min_image_id} AND ", $query );
				}
			}
		}

		return $query;
	}

	public function auto_start_bulk_smush() {
		// Reset unsmushed id.
		$this->first_unsmushed_id = 0;
		// If all images are smushed, return.
		if ( ! $this->get_first_unsmushed_image_id() ) {
			return;
		}

		// Disable email, only allow process when the bulk smush is completed.
		add_filter('pre_wp_mail', '__return_false' );

		wp_remote_post(
			admin_url( 'admin-ajax.php?action=bulk_smush_start&_nonce=' . wp_create_nonce( 'wp-smush-ajax' ) ),
			array(
				'timeout'   => 0.01,
				'blocking'  => false,
				'cookies'   => wp_unslash( $_COOKIE ),
				'sslverify' => apply_filters( 'https_local_ssl_verify', false ),
			)
		);
	}
}

function wpmudev_smpro_fix_overtime_loading_smush_page() {
	if ( defined( 'WP_SMUSH_VERSION' ) && class_exists( 'Smush\Core\Core' ) && class_exists( 'WP_Smush' ) ) {
		new WDEV_Smush_Fix_Overtime_Loading();
	}
}
