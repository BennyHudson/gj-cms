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

$data = new FieldsBuilder('events_options');

$data
    ->addGroup('events_options', [
        'label'        => 'Events Options',
        'layout'       => 'block'
    ])
        ->addTextarea('introduction', [
            'label' => 'Introduction',
            'rows' => '3',
            'new_lines' => 'none',
            'wrapper' => [
                'width' => '100',
            ],
        ]);

/**
 * Location
 */
$data->setLocation('options_page', '==', 'event-options');


return $data;
