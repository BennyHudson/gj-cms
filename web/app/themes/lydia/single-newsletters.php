<?php
/**
 * Page
 * --------
 * @category Controllers
 * @package Lydia/Controllers
 * @version 1.0
 */
defined( 'ABSPATH' ) || exit;

$context = new \BMAS\Timber\Context( ['newsletter/newsletter-builder.twig'] );

// Get Newsletter Sections
$newsletter = get_field( 'newsletter_builder' );
$context->add('newsletter', $newsletter );

// Get a unique array for newsetters
$newsletterStyles = array_column($newsletter['content'], 'acf_fc_layout');
$context->add('newsletterStyles', array_unique($newsletterStyles) );



$context->render();
