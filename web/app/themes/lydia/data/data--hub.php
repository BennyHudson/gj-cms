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

$data = new FieldsBuilder('hub');

$data
    ->addGroup('hub', [
        'layout'       => 'block'
    ])

        ->addGroup('intro')
            ->addImage('logo',['return_format' => 'id',])
        ->endGroup()

        ->addRepeater('sections', [
            'layout' => 'block'
        ])
            ->addText('title')
            ->addTextarea('description', ['rows' => '2'])
            ->addPostObject('featured', ['return_format' => 'id'])
            ->addRelationship('articles', ['return_format' => 'id'])
        ->endGroup()

    ->endGroup();


/**
 * Location
 */
$data->setLocation('post_template', '==', 'template-hub.php');

return $data;
