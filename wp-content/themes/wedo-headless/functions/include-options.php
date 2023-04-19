<?php

  function wedo_options() {
    if (function_exists('acf_add_options_sub_page')) {
      acf_add_options_sub_page(array(
        'page_title'            => 'Podcast Options',
        'menu_title'            => 'Podcast Options',
        'menu_slug'             => 'podcast-options',
        'capability'            => 'edit_posts',
        'parent'                => 'edit.php?post_type=podcasts',
        'position'              => 50,
        'redirect'              => true,
        'post_id'               => 'podcast-options',
        'show_in_graphql'       => true
      ));

      acf_add_options_sub_page(array(
        'page_title'            => 'Clubhouse Partners Options',
        'menu_title'            => 'Clubhouse Partners Options',
        'menu_slug'             => 'clubhouse-partners-options',
        'capability'            => 'edit_posts',
        'parent'                => 'edit.php?post_type=clubhouse-partners',
        'position'              => 50,
        'redirect'              => true,
        'post_id'               => 'clubhouse-partners-options',
        'show_in_graphql'       => true
      ));

      acf_add_options_sub_page(array(
        'page_title'            => 'Event Options',
        'menu_title'            => 'Event Options',
        'menu_slug'             => 'event-options',
        'capability'            => 'edit_posts',
        'parent'                => 'edit.php?post_type=events',
        'position'              => 50,
        'redirect'              => true,
        'post_id'               => 'event-options',
        'show_in_graphql'       => true
      ));
    }

    if (function_exists('acf_add_options_page')) {
      acf_add_options_page(array(
        'page_title'            => 'GJ Options',
        'menu_title'            => 'GJ Options',
        'menu_slug'             => 'gj-options',
        'capability'            => 'edit_posts',
        'position'              => 50,
        'redirect'              => true,
        'post_id'               => 'options',
        'show_in_graphql'       => true,
        'show_in_rest'          => true,
        'graphql_single_name'   => 'gjOption',
        'graphql_plural_name'   => 'gjOptions'
      ));
    }
  }
?>
