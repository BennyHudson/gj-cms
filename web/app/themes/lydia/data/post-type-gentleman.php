<?php
/**
 * Data - Page
 * --------
 * @category Custom Fields
 * @version 1.0
 * @package lydia/ACF
 */
namespace BMAS\Data;

defined( 'ABSPATH' ) || exit;

use StoutLogic\AcfBuilder\FieldsBuilder;

$data = new FieldsBuilder('gentleman', ['title' => 'Discover more']);

$data
    ->setLocation('post_type', '==', 'gentleman');

$data
    ->addText('first_name')->setAttr('width', '50')
    ->addText('last_name')->setAttr('width', '50')
    ->addText('specialty')
    ->addWysiwyg('preview_text')
    ->addRelationship('gentleman', [
        'instructions' => '',
        'post_type' => ['gentleman'],
        'filters' => [
            0 => 'search'
        ],
        'elements' => [
            0 => 'featured_image',
        ],
        'max' => 4,
        'return_format' => 'id',
    ]);

return $data;
