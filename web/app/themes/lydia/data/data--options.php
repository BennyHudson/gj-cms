<?php
/**
 * Data - Company
 * --------
 * @category Custom Fields
 * @version 1.0
 * @package lydia/ACF
 */
namespace BMAS\Data;

defined( 'ABSPATH' ) || exit;

use StoutLogic\AcfBuilder\FieldsBuilder;

$data = new FieldsBuilder('article_notice');

$data
    ->addGroup('article_notice')
        ->addTextarea('content', [
            'rows' => '3'
        ])->setWidth('50%')
        ->addLink('link', [
            'return_format' => 'array',
        ])->setWidth('50%')
        ->addImage('image', [
            'return_format' => 'id',
            'preview_size' => 'thumbnail',
        ])
    ->endGroup();

/**
 * Location
 */
$data->setLocation('options_page', '==', 'components');

return $data;
