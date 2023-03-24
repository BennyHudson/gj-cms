<?php

/**
 * @param $query
 * @return mixed
 */
function lydia_add_custom_types_to_query( $query )
{
    if ( is_category() || is_tag() && empty( $query->query_vars['suppress_filters'] ) && ! is_admin() ) {

        $query->set( 'post_type', ['post', 'article', 'nav_menu_item', 'product'] );

        return $query;
    }

    if ( is_home() && empty( $query->query_vars['suppress_filters'] ) && ! is_admin() ) {
        $query->set( 'post_type', ['post', 'article'] );

        return $query;
    }
}

add_filter( 'pre_get_posts', 'lydia_add_custom_types_to_query' );
