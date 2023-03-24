<?php
/**
 * Membership Page
 * --------
 * @category Controllers
 * @package Lydia/Controllers
 * @version 1.0
 */
defined( 'ABSPATH' ) || exit;

$context = new \BMAS\Timber\Context( ['page-members.twig'] );

$context->add('members', Timber\Timber::get_posts([
    'post_type' => 'gentleman',
    'posts_per_page' => 16,
]));

$context->render();
