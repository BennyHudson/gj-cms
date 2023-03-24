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

$data = new FieldsBuilder('social_channels');

$data
    ->addRepeater('social', [
        'label'        => 'Channels',
        'instructions' => 'Add company social platforms',
        'required'     => 0,
        'layout'       => 'table'
    ])
        ->addSelect('platform', [
            'label' => 'Platform',
            'choices' => [
                'facebook'  => 'Facebook',
                'instagram' => 'Instagram',
                'linkedin'  => 'LinkedIn',
                'pinterest' => 'Pinterest',
                'skype'     => 'Skype',
                'spotify'   => 'Spotify',
                'tumblr'    => 'Tumblr',
                'twitter'   => 'Twitter',
                'whatsapp'  => 'Whatsapp',
                'vimeo-v'   => 'Vimeo',
                'youtube'   => 'YouTube'
            ],
            'wrapper' => [
                'width' => '30',
            ],
            'ui' => 1,
            'return_format' => 'array',
        ])
        ->addUrl('url', [
            'label' => 'URL',
            'placeholder' => 'eg. https://facebook.com/channel-name',
            'wrapper' => [
                'width' => '50',
            ],
        ]);

/**
 * Location
 */
$data->setLocation('options_page', '==', 'social');

// acf_add_local_field_group($data->build());
