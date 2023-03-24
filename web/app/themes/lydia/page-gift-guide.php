<?php
/**
 * Membership Page
 * --------
 * @category Controllers
 * @package Lydia/Controllers
 * @version 1.0
 */
defined('ABSPATH') || exit();

$context = new \BMAS\Timber\Context(['page-gifting.twig']);

$context->add([
    'sectionNewsletter' => get_field('section_newsletter', 'options'),
]);

$context->render();
