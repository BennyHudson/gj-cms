<?php

namespace PixelYourSite\SuperPack;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

use PixelYourSite;

?>

<?php
$isWpmlActive = isWPMLActive();
if($isWpmlActive) {
    $savedLang = (array)PixelYourSite\GA()->getOption("pixel_lang");
    $languageCodes = array_keys(apply_filters( 'wpml_active_languages',null,null));
    if(!$savedLang) $savedLang = array();
    if(count($savedLang) > 0 && $savedLang[0] != "") { // load pixel settings for first pixel
        $activeLang = explode("_",$savedLang[0]);
    } else {
        $activeLang = $languageCodes;
    }
    // print lang checkbox list
    if ( !empty( $languageCodes ) ) : ?>
    <div class="plate">
        <div class="row pb-3">
            <div class="col-12">
                <?php printLangList($activeLang,$languageCodes,PixelYourSite\GA()->getSlug()); ?>
            </div>
        </div>
    </div>
    <?php endif;
}
 ?>
