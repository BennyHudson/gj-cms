<?php

namespace PixelYourSite\SuperPack;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

use PixelYourSite;

?>

<?php
$isWpmlActive = isWPMLActive();

if($isWpmlActive) : // Show lang select for main pixel
    $savedLang = (array)PixelYourSite\Facebook()->getOption("pixel_lang");
    if(!$savedLang) $savedLang = array();
    $languageCodes = array_keys(apply_filters( 'wpml_active_languages',null,null));

    if(count($savedLang) > 0 && $savedLang[0] != "") { // load pixel settings for first pixel
        $activeLang = explode("_",$savedLang[0]);
    } else {
        $activeLang = $languageCodes;
    }
    // print lang checkbox list
    if ( !empty( $languageCodes ) ) : ?>
    <div class="plate">
        <div class="row  pb-3">
            <div class="col-12">
                <?php printLangList($activeLang,$languageCodes,PixelYourSite\Facebook()->getSlug()); ?>
            </div>
        </div>
    </div>
    <?php endif; ?>
<?php endif; ?>
