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

$data = new FieldsBuilder('front_page_config');

$data
    ->addGroup('front', [
        'layout'       => 'block',
        'label' => 'Sections'
    ])

        ->addGroup('hub')
            ->addPostObject('selected',['return_format' => 'id', 'post_type' => ['page']])
        ->endGroup()

    ->endGroup();


/**
 * Location
 */
$data->setLocation('page_type', '==', 'front_page');


return $data;
