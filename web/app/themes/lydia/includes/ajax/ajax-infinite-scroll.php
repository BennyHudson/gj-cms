<?php
/**
*  Ajax Infinite Scroll Single Posts
*  --------
*  @package GJ
*  @since GJ 5.0
*/
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
function infinite_posts() {

    //$postID = array_map('intval', json_decode(stripslashes($_POST['postID'])));

    $post_type                  = ['post', 'article'];
    $args['post_type']          = $post_type;
    $args['post_status']        = 'publish';
    $args['numberposts']        = 1;
    $args['post__not_in']       = $_POST['postIdArray'];
    $args['category__in']       = $_POST['categoryID'];
    $args['category__not_in']   = [1993]; // Exclude Competitions

    // Get the Posts
	$posts = Timber\Timber::get_posts($args);

    // Set the Context for Timber File
    $context = Timber\Timber::get_context();
    $context['post']  = $posts[0];
    $postID =  $context['post']->ID;

    /**
    * Related Posts
    * --------
    * @since GJ 3.0
    * @version 1.0
    */
    $relatedtime = '1 year ago';
    $context['relatedArgs'] = [
        'post_type'   => $post_type,
        'post_status' => 'publish',
        'numberposts' => 3,
        'orderby'     => 'rand',
        'date_query' => array(
            array(
                'after' => $relatedtime
            ),
            'inclusive' => true,
        )
    ];

    /**
    * Update Post Views and Check if Subscriber
    * --------
    * @since GJ 3.0
    * @version 1.0
    */
    if ( !TGJ\Users()->isAdminUser() ) {
        TGJ\PostViews::update($postID);
        if (TGJ\Users()->isSubscriber()) {
            $context['subscriber'] = true;
        }
    } else {
        $context['subscriber'] = true;
    }

    /**
    * Members only
    * --------
    * @since GJ 3.0
    * @version 1.0
    */
    if ( $context['post']->print_article == true ) {
        $context['members'] = true;
        $context['paywallProduct'] = new Timber\Post(get_field('package_selection', 'options'));
    } else {
        $context['members'] = false;
    }

    /**
    * Check for Post Formats
    * --------
    * @since GJ 3.0
    * @version 1.0
    */
    $context['format'] = get_post_format($postID);

    /**
    * Content Builder
    * --------
    * @since GJ 3.0
    * @version 1.0
    */
    $contentBuilder = get_field('content_builder', $postID);
    $context['contentBuilder'] = $contentBuilder;
    $context['contentBuilderLegacy'] = get_field('article_content_areas', $postID);

    if ( get_field('content_builder', $postID) ) {
        $layouts = ["image_gallery", "masonry_gallery", "recommended_products", "affiliate_products", "standard--full"];
        $lookup = array_values(array_column($contentBuilder, 'acf_fc_layout', 'acf_fc_layout'));
        $imageLookup = array_values(array_column($contentBuilder, 'image_size', 'image_size'));

        $context['extended'] = in_array_any( $layouts, $lookup );
        $context['extendedImage'] = in_array_any( $layouts, $imageLookup );
    }

    /**
    * Get post Categories
    * --------
    * @since GJ 3.0
    * @version 1.0
    */
    $category = get_the_category($postID);
    if ($category[0]->parent == 0) {
        $context['mainCat'] = $category[0]->term_id;
    } else {
        $context['mainCat'] = $category[0]->parent;
    }

    /**
    * Ajax
    * --------
    * @since GJ 3.0
    * @version 1.0
    */
    $context['Ajax'] = true;

    // Output
    Timber\Timber::render( 'components/single-post.twig', $context);

    // If there are no more posts
    if ( count($posts) === 0 ) {
        echo '<p class="c-no-posts">Sorry, there are no more posts.</p>';
        wp_die();
    }

    wp_die();
}

add_action( 'wp_ajax_infinite_posts', 'infinite_posts' );
add_action( 'wp_ajax_nopriv_infinite_posts', 'infinite_posts' );
