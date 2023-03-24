<?php
/**
 * ACF Data
 * --------
 *
 * @category ACF
 * @version 1.0
 * @package BMAS
 */
namespace BMAS\ACF;

defined( 'ABSPATH' ) || exit;

use StoutLogic\AcfBuilder\FieldsBuilder;

class Data
{

    public function __construct()
    {
        $this->init_fields();
    }

    public static function init_fields() {
        add_action('init', function () {
            collect(glob(get_template_directory() .'/data/*.php'))->map(function ($field) {
                return require_once($field);
            })->map(function ($field) {
                if ($field instanceof FieldsBuilder) {
                    acf_add_local_field_group($field->build());
                }
            });
        });
    }
//
//    public static function partial($partial)
//    {
//        $partial = str_replace('.', '/', $partial);
//        return include(get_template_directory() .'/data/{$partial}.php');
//    }

}
