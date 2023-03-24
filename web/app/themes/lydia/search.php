<?php
/**
 * 404
 * --------
 * @category Controllers
 * @package Lydia/Controllers
 * @version 1.0
 */
defined( 'ABSPATH' ) || exit;

$context = new \BMAS\Timber\Context( ['search.twig'] );

$context->add([
    'title'      => 'Search results for ' . get_search_query(),
    'searchQuery'=> get_search_query(),
]);

$context->render();
