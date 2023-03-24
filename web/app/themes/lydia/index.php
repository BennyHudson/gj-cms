<?php
/**
 * Index
 * --------
 * Base fallback template
 * --------
 * @category Controllers
 * @package Lydia/Controllers
 * @version 1.0
 */
defined( 'ABSPATH' ) || exit;

$context = new \BMAS\Timber\Context( ['index.twig'] );

$context->add('post', Timber\Timber::get_posts([
    'post_type'   => $post_types,
    'post_status' => 'publish',
    'orderby'     => 'date'
]));

$context->render();
