<?php
/**
 * Archive
 * --------
 * @category Controllers
 * @package Lydia/Controllers
 * @version 1.0
 */
defined( 'ABSPATH' ) || exit;

$context = new \BMAS\Timber\Context( ['latest.twig'] );

/*
 * Build the context
 * --------
 * @version 1.0
 */

$context->add( [
    'title' => 'Latest'
] );

$context->render();
