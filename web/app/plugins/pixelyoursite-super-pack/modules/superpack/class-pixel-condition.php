<?php

namespace PixelYourSite\SuperPack;

use function Aws\map;
use function PixelYourSite\isEddActive;
use function PixelYourSite\isWooCommerceActive;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

add_action( 'wp_ajax_pys_filter_condition_autocomplete', '\PixelYourSite\SuperPack\SpPixelCondition::ajax_posts_filter_autocomplete' );

class SpPixelCondition {
    private static $_instance = null;

    public static function instance() {

        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
    /**
     * @var SpCondition[]
     */
    private $conditions = [];
    /**
     * @var SpCondition[]
     */
    private $allConditions = [];

    private function __construct() {
       add_action( 'init', array( $this, 'init' ), 9 );
    }

    function init() {
        $all = new SpAllSiteCondition();
        $single = new SpSingularCondition();
        $archive = new SpArchiveCondition();


        $this->conditions[] = $all;
        $this->conditions[] = $single;
        $this->conditions[] = $archive;


        $this->registerCondition($all);
        $this->registerCondition($single);
        $this->registerCondition($archive);


        if(isWooCommerceActive()) {
            $woo = new SpWooCondition();
            $this->conditions[] = $woo;
            $this->registerCondition($woo);
        }

        if(isEddActive()) {
            $edd = new SpEddCondition();
            $this->conditions[] = $edd;
            $this->registerCondition($edd);
        }
    }



    /**
     * @param SpCondition $condition
     */
    public function registerCondition($condition) {
        $this->allConditions[$condition->get_name()] = $condition;
    }

    /**
     * @param String $name
     * @return false|SpCondition
     */
    public function getCondition($name) {
        if(isset($this->allConditions[$name])) {
            return $this->allConditions[$name];
        }
        return false;
    }

    public function renderHtml($definedCondition = []) {
        $conditionData = [];
        foreach ( $this->allConditions as $condition) {
            $sub_conditions = [];
            foreach ($condition->get_sub_conditions() as $sub) {
                $sub_conditions[] = $sub->get_name();
            }
            $conditionData[$condition->get_name()] = [
                "controls" => $condition->get_controls() ,
                "label" => $condition->get_label(),
                "sub_conditions"=> $sub_conditions,
                "all_label" => $condition->get_all_label()
            ];
        }

        ?>
        <script>
            var conditions = <?=json_encode($conditionData)?>;
        </script>
        <div class="pixel_conditions" data-params='<?=json_encode($definedCondition)?>'>
            <select  class="condition_select condition"  data-name="name">
                <?php foreach ($this->conditions as $condition) :?>
                    <option value="<?=$condition->get_name()?>"><?=$condition->get_label()?></option>
                <?php endforeach; ?>
            </select>

        </div>

    <?php
    }

    /**
     * @param array $data
     *
     * @return array
     * @throws \Exception
     */
    public static function ajax_posts_filter_autocomplete( ) {

        $results = [];
        $queryData = $_POST['query'];
        switch ( $queryData['object'] ) {
            case 'tax':
                $by_field = ! empty( $_POST['by_field'] ) ? $_POST['by_field'] : 'term_taxonomy_id';

                $query_args = [
                    'taxonomy' => $queryData['query']['taxonomy'],
                    'hide_empty' => false,
                    'search' => $_POST['q']
                ];

                $terms = get_terms( $query_args );
                if ( is_wp_error( $terms ) ) {
                    break;
                }
                foreach ( $terms as $term ) {
                    $results[] = [
                        'id' => $term->{$by_field},
                        'text' => $term->name,
                    ];
                }
                break;
            case 'post':
                $query_args = [
                    'post_type' => $queryData['query']['post_type'],
                    'posts_per_page' => -1,
                    's' => $_POST['q']
                ];
                $query = new \WP_Query( $query_args );

                foreach ( $query->posts as $post ) {
                    $text = $post->post_title;
                    $results[] = [
                        'id' => $post->ID,
                        'text' => $text,
                    ];
                }
                break;

        }

        wp_send_json_success([
            'results' => $results,
        ],200);

}


}

/**
 * @return SpPixelCondition
 */
function SpPixelCondition() {
    return SpPixelCondition::instance();
}

SpPixelCondition();