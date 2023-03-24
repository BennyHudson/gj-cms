<?php
/**
 * Template Name: Hub
 * Template Post Type: page
 * --------
 * @category Controllers
 * @package Lydia/Controllers
 * @version 1.0
 */
defined('ABSPATH') || exit();

$context = new \BMAS\Timber\Context(['template-hub.twig']);

// $context->add([
//     'sectionNewsletter' => get_field('section_newsletter', 'options'),
// ]);

$context->add([
    'hub' => get_field('hub'),
]);

$context->render();
