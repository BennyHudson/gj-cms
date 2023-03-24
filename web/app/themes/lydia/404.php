<?php
/**
 * 404
 * --------
 * @category Controllers
 * @package Lydia/Controllers
 * @version 1.0
 */
defined( 'ABSPATH' ) || exit;

$context = new \BMAS\Timber\Context( ['404.twig'] );

$context->add([
    'errorBackground' => new \Timber\Image(get_field('error_background_image', 'option')),
]);

$context->render();
