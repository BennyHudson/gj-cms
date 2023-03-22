<?php
namespace PixelYourSite\SuperPack;

use JetBrains\PhpStorm\ArrayShape;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class SPPixelId {
   public $pixel = '';
   public $isFireForSignal = true;
   public $isFireForWoo = true;
   public $isFireForEdd = true;
   public $isEnable = true;
   public $wpmlActiveLang = null;
   public $displayConditions = [["name"=>"all_site"]]; // [name=>'',sub_name=>'',sub_id=>'',sub_id_name=>'']
   public $extensions = [];

    /**
     * @param $json
     * @return SPPixelId
     */
   static function fromArray($json) {
       $pixel = new SPPixelId();
       $pixel->pixel = isset($json['pixel_id']) ? $json['pixel_id'] : $pixel->pixel;
       $pixel->isFireForSignal = isset($json['is_fire_signal']) ? $json['is_fire_signal'] : $pixel->isFireForSignal;
       $pixel->isFireForWoo = isset($json['is_fire_woo']) ? $json['is_fire_woo'] : $pixel->isFireForWoo;
       $pixel->isFireForEdd = isset($json['is_fire_edd']) ? $json['is_fire_edd'] : $pixel->isFireForEdd;
       $pixel->wpmlActiveLang = isset($json['wpml_active_lang']) ? $json['wpml_active_lang'] : $pixel->wpmlActiveLang;
       $pixel->displayConditions = isset($json['condition']) ? $json['condition'] : $pixel->displayConditions;
       $pixel->extensions = isset($json['extensions']) ? $json['extensions'] : $pixel->extensions;
       $pixel->isEnable = isset($json['is_enable']) ? $json['is_enable'] : $pixel->isEnable;
       return $pixel;
   }


    /**
     * @return bool
     */
    function isValidForCurrentLang() {
        if(isWPMLActive()) {
            $current_lang_code = apply_filters( 'wpml_current_language', NULL );
            if(is_array($this->wpmlActiveLang) && !in_array($current_lang_code,$this->wpmlActiveLang)) {
                return false;
            }
        }
        return true;
    }

    /**
     * @param SPPixelId $pixel
     * @return array
     */
    static function toArray ($pixel) {
        return  [
            "pixel_id" => $pixel->pixel,
            "is_fire_signal" => $pixel->isFireForSignal,
            "is_fire_woo" => $pixel->isFireForWoo,
            "is_fire_edd" => $pixel->isFireForEdd,
            "wpml_active_lang" => $pixel->wpmlActiveLang,
            "condition" => $pixel->displayConditions,
            "extensions" => $pixel->extensions,
            "is_enable" => $pixel->isEnable
        ];
    }


    /**
     * @param \PixelYourSite\PYSEvent $event
     * @param String $type
     * @param array $args
     * @return bool
     */
    public function isValidForEvent($event,$args = []) {

        if(!$this->isEnable || $this->pixel == '') {
            return false;
        }

        if(!$this->isFireForEdd && $event->getCategory() == 'edd') {
            return false;
        }

        if(!$this->isFireForWoo && $event->getCategory() == 'woo') {
            return false;
        }
        if(!$this->isFireForSignal && $event->getCategory() == 'automatic') {
            return false;
        }

        if(!$this->isValidForCurrentLang()) {
            return false;
        }

        return true;
    }

    /**
     * @param \PixelYourSite\PYSEvent $event
     * @param String $type
     * @param array $args
     * @return bool
     */
    public function isConditionalValidForEvent($event,$args = []) {
        foreach($this->displayConditions as $displayCondition) {


            if($event->getId() == "woo_add_to_cart_on_button_click" // fix can fire from ajax
                && isset($displayCondition['name']) && $displayCondition['name'] == "woocommerce"
                && isset($displayCondition['sub_name']) && $displayCondition['sub_name'] == "product"
                && isset($displayCondition['sub_id_name']) && $displayCondition['sub_id_name'] == 'All'
            ) {
                return true;
            }

            if(isset($displayCondition['name']) && !(isset($displayCondition['sub_name']) && $displayCondition['sub_name'] != 'all')) {
                $conditional = SpPixelCondition()->getCondition($displayCondition['name']);
                if(!$conditional || !$conditional->check( [] )) {
                    return false;
                }
            }
            if(isset($displayCondition['sub_name']) && $displayCondition['sub_name'] != 'all') {
                $conditional = SpPixelCondition()->getCondition($displayCondition['sub_name']);
                $args = [];
                if(isset($displayCondition['sub_id'])) {
                    $args['id'] = $displayCondition['sub_id'];
                }
                if(!$conditional || !$conditional->check( $args )) {
                    return false;
                }
            }
        }
        return true;
    }
    /**
     * @return array{sub_id:int,filter:string}|null
     */

    function getWooFilter(){
        return $this->getFilter('woocommerce');
    }

    function getEddFilter() {
        return $this->getFilter('edd');
    }

    function getFilter($type) {
        foreach($this->displayConditions as $displayCondition) {
            if($displayCondition['name'] == $type) {
                if($displayCondition['sub_name'] != "all" && !empty($displayCondition['sub_id']) && $displayCondition['sub_id'] != 'all') {
                    return [
                        'sub_id' => $displayCondition['sub_id'],
                        'filter' => $displayCondition['sub_name']
                    ];
                } else {
                    return [
                        'sub_id' => -1,
                        'filter' => "all"
                    ];
                }

            }
        }
        return null;
    }






}