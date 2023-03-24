<?php
/**
*  BREADCRUMBS
*  ------
*  Outputs sites breadcrumbs to be called in with
*  <?php lydia_breadcrumb(); ?>
*  ------
*  @package Lydia
*  @since Lydia 1.0
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Breadcrumbs
function lydia_breadcrumbs() {

    // Settings
    $separator          = '<span class="fa fa-angle-right"></span>';
    $breadcrums_id      = 'c-crumbs';
    $breadcrums_class   = 'c-crumbs';
    $home_title         = 'Home';

    // If you have any custom post types with custom taxonomies, put the taxonomy name below (e.g. product_cat)
    $custom_taxonomy    = 'product_cat';

    // Get the query & post information
    global $post,$wp_query;

    // Do not display on the homepage
    if ( !is_front_page() ) {

        // Build the breadcrumbs
        echo '<nav id="' . $breadcrums_id . '" class="' . $breadcrums_class . '" itemprop="breadcrumb">';

        // Home page
        echo '<span class="c-crumb c-crumb-home"><a class="c-crumb-link" href="' . get_home_url() . '" title="' . $home_title . '">' . $home_title . '</a></span>';
        echo '<span class="c-crumb c-crumb-separator separator-home">' . $separator . '</span>';

        if ( is_archive() && !is_tax() && !is_category() && !is_tag() ) {

            echo '<span class="c-crumb c-crumb-current c-crumb-archive"><strong>' . post_type_archive_title($prefix, false) . '</strong></span>';

        } else if ( is_archive() && is_tax() && !is_category() && !is_tag() ) {

            // If post is a custom post type
            $post_type = get_post_type();

            // If it is a custom post type display name and link
            if($post_type != 'post') {

                $post_type_object = get_post_type_object($post_type);
                $post_type_archive = get_post_type_archive_link($post_type);

                echo '<span class="c-crumb c-crumb-cat c-crumb-custom-post-type-' . $post_type . '"><a class="c-crumb-link" href="' . $post_type_archive . '" title="' . $post_type_object->labels->name . '">' . $post_type_object->labels->name . '</a></span>';
                echo '<span class="c-crumb c-crumb-separator">' . $separator . '</span>';

            }

            $custom_tax_name = get_queried_object()->name;
            echo '<span class="c-crumb c-crumb-current c-crumb-archive"><strong>' . $custom_tax_name . '</strong></span>';

        } else if ( is_single() ) {

            // If post is a custom post type
            $post_type = get_post_type();

            // If it is a custom post type display name and link
            if($post_type != 'post') {

                $post_type_object = get_post_type_object($post_type);
                $post_type_archive = get_post_type_archive_link($post_type);

                echo '<span class="c-crumb c-crumb-cat c-crumb-custom-post-type-' . $post_type . '"><a class="c-crumb-link" href="' . $post_type_archive . '" title="' . $post_type_object->labels->name . '">' . $post_type_object->labels->name . '</a></span>';
                echo '<span class="c-crumb c-crumb-separator">' . $separator . '</span>';

            }

            // Get post category info
            $category = get_the_category();

            if(!empty($category)) {

                // Get last category post is in
                $last_category = end(array_values($category));

                // Get parent any categories and create array
                $get_cat_parents = rtrim(get_category_parents($last_category->term_id, true, ','),',');
                $cat_parents = explode(',',$get_cat_parents);

                // Loop through parent categories and store in variable $cat_display
                $cat_display = '';
                foreach($cat_parents as $parents) {
                    $cat_display .= '<span class="c-crumb c-crumb-cat">'.$parents.'</span>';
                    $cat_display .= '<span class="c-crumb c-crumb-separator"> ' . $separator . ' </span>';
                }

            }

            // If it's a custom post type within a custom taxonomy
            $taxonomy_exists = taxonomy_exists($custom_taxonomy);
            if(empty($last_category) && !empty($custom_taxonomy) && $taxonomy_exists) {

                $taxonomy_terms = get_the_terms( $post->ID, $custom_taxonomy );
                $cat_id         = $taxonomy_terms[0]->term_id;
                $cat_nicename   = $taxonomy_terms[0]->slug;
                $cat_link       = get_term_link($taxonomy_terms[0]->term_id, $custom_taxonomy);
                $cat_name       = $taxonomy_terms[0]->name;

            }

            // Check if the post is in a category
            if(!empty($last_category)) {
                echo $cat_display;
                echo '<span class="c-crumb c-crumb-current c-crumb-' . $post->ID . '"><strong title="' . get_the_title() . '">' . get_the_title() . '</strong></span>';

            // Else if post is in a custom taxonomy
            } else if(!empty($cat_id)) {

                echo '<span class="c-crumb c-crumb-cat c-crumb-cat-' . $cat_id . ' c-crumb-cat-' . $cat_nicename . '"><a class="c-crumb-link" href="' . $cat_link . '" title="' . $cat_name . '">' . $cat_name . '</a></span>';
                echo '<span class="c-crumb c-crumb-separator"> ' . $separator . ' </span>';
                echo '<span class="c-crumb c-crumb-current c-crumb-' . $post->ID . '"><strong title="' . get_the_title() . '">' . get_the_title() . '</strong></span>';

            } else {

                echo '<span class="c-crumb c-crumb-current c-crumb-' . $post->ID . '"><strong title="' . get_the_title() . '">' . get_the_title() . '</strong></span>';

            }

        } else if ( is_category() ) {

            // Category page
            echo '<span class="c-crumb c-crumb-current c-crumb-cat"><strong>' . single_cat_title('', false) . '</strong></span>';

        } else if ( is_page() ) {

            // Standard page
            if( $post->post_parent ){

                // If child page, get parents
                $anc = get_post_ancestors( $post->ID );

                // Get parents in the right order
                $anc = array_reverse($anc);

                // Parent page loop
                if ( !isset( $parents ) ) $parents = null;
                foreach ( $anc as $ancestor ) {
                    $parents .= '<span class="c-crumb c-crumb-parent c-crumb-parent-' . $ancestor . '"><a class="c-crumb-link" href="' . get_permalink($ancestor) . '" title="' . get_the_title($ancestor) . '">' . get_the_title($ancestor) . '</a></span>';
                    $parents .= '<span class="c-crumb c-crumb-separator separator-' . $ancestor . '">' . $separator . '</span>';
                }

                // Display parent pages
                echo $parents;

                // Current page
                echo '<span class="c-crumb c-crumb-current c-crumb-' . $post->ID . '"><strong title="' . get_the_title() . '">' . get_the_title() . '</strong></span>';

            } else {

                // Just display current page if not parents
                echo '<span class="c-crumb c-crumb-current c-crumb-' . $post->ID . '"><strong>' . get_the_title() . '</strong></span>';

            }

        } else if ( is_tag() ) {

            // Tag page

            // Get tag information
            $term_id        = get_query_var('tag_id');
            $taxonomy       = 'post_tag';
            $args           = 'include=' . $term_id;
            $terms          = get_terms( $taxonomy, $args );
            $get_term_id    = $terms[0]->term_id;
            $get_term_slug  = $terms[0]->slug;
            $get_term_name  = $terms[0]->name;

            // Display the tag name
            echo '<span class="c-crumb c-crumb-current c-crumb-tag-' . $get_term_id . ' c-crumb-tag-' . $get_term_slug . '"><strong>' . $get_term_name . '</strong></span>';

        } elseif ( is_day() ) {

            // Day archive

            // Year link
            echo '<span class="c-crumb c-crumb-year c-crumb-year-' . get_the_time('Y') . '"><a class="c-crumb-link" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</a></span>';
            echo '<span class="c-crumb c-crumb-separator separator-' . get_the_time('Y') . '">' . $separator . '</span>';

            // Month link
            echo '<span class="c-crumb c-crumb-month c-crumb-month-' . get_the_time('m') . '"><a class="c-crumb-link" href="' . get_month_link( get_the_time('Y'), get_the_time('m') ) . '" title="' . get_the_time('M') . '">' . get_the_time('M') . ' Archives</a></span>';
            echo '<span class="c-crumb c-crumb-separator separator-' . get_the_time('m') . '">' . $separator . '</span>';

            // Day display
            echo '<span class="c-crumb c-crumb-current c-crumb-' . get_the_time('j') . '"><strong>' . get_the_time('jS') . ' ' . get_the_time('M') . ' Archives</strong></span>';

        } else if ( is_month() ) {

            // Month Archive

            // Year link
            echo '<span class="c-crumb c-crumb-year c-crumb-year-' . get_the_time('Y') . '"><a class="c-crumb-link" href="' . get_year_link( get_the_time('Y') ) . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</a></span>';
            echo '<span class="c-crumb c-crumb-separator separator-' . get_the_time('Y') . '">' . $separator . '</span>';

            // Month display
            echo '<span class="c-crumb c-crumb-month c-crumb-month-' . get_the_time('m') . '"><strong title="' . get_the_time('M') . '">' . get_the_time('M') . ' Archives</strong></span>';

        } else if ( is_year() ) {

            // Display year archive
            echo '<span class="c-crumb c-crumb-current c-crumb-current-' . get_the_time('Y') . '"><strong title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</strong></span>';

        } else if ( is_author() ) {

            // Auhor archive

            // Get the author information
            global $author;
            $userdata = get_userdata( $author );

            // Display author name
            echo '<span class="c-crumb c-crumb-current c-crumb-current-' . $userdata->user_nicename . '"><strong title="' . $userdata->display_name . '">' . 'Author: ' . $userdata->display_name . '</strong></span>';

        } else if ( get_query_var('paged') ) {

            // Paginated archives
            echo '<span class="c-crumb c-crumb-current c-crumb-current-' . get_query_var('paged') . '"><strong title="Page ' . get_query_var('paged') . '">'.__('Page') . ' ' . get_query_var('paged') . '</strong></span>';

        } else if ( is_search() ) {

            // Search results page
            echo '<span class="c-crumb c-crumb-current c-crumb-current-' . get_search_query() . '"><strong title="Search results for: ' . get_search_query() . '">Search results for: ' . get_search_query() . '</strong></span>';

        } elseif ( is_404() ) {

            // 404 page
            echo '<span class="c-crumb c-crumb-current"><strong>' . 'Error 404' . '</strong></span>';
        }

        echo '</nav>';

    }
}
