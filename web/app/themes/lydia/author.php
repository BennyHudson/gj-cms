<?php
/**
 * Front Page
 * --------
 * @category Controllers
 * @package Lydia/Controllers
 * @version 1.0
 */
defined( 'ABSPATH' ) || exit;

$context = new \BMAS\Timber\Context( ['archive.twig'] );

$author = new \Timber\User( $wp_query->query_vars['author'] );

/*
 * Build the context
 * --------
 * @version 1.0
 */
$context->add( [
   'author' => $author,
   'title' => 'Author Archives: ' . $author->name()
] );

$context->render();
