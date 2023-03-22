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
    $languageCodes = array_keys(apply_filters( 'wpml_active_languages',null,null));
}

$pixelsInfo = PixelYourSite\SuperPack()->getAdsAdditionalPixel();

foreach ($pixelsInfo as $index => $pixelInfo) : ?>

    <div class="plate mt-3 pt-4 pb-3 pixel_info">
        <?php PixelYourSite\SuperPack()->render_text_input_array_item('ads_ext_pixel_id', "", $index,true); ?>
        <div class="row">
            <div class="col-11">
                <div class='custom-switch '>
                    <input type="checkbox" value="1" <?php checked($pixelInfo->isEnable, true); ?>
                           id="pixel_ads_is_enable_<?=$index?>" class="custom-switch-input is_enable">
                    <label class="custom-switch-btn" for="pixel_ads_is_enable_<?=$index?>"></label>
                </div>
            </div>
            <div class="col-1">
                <button type="button" class="btn btn-sm remove-row">
                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                </button>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12">
                <p>
                    <input type="text" value="<?= $pixelInfo->pixel ?>"
                           placeholder="AW-123456789" class='form-control pixel_id'/>
                </p>
                <p>
                    <?php PixelYourSite\Ads()->render_switcher_input_array("enhanced_conversions_manual_enabled",($index+1));?>
                    <div class="switcher-label">Enable enhanced conversions</div>
                </p>
                <p>
                    <label class="custom-control custom-checkbox">
                        <input type="checkbox" value="1"
                               class="custom-control-input is_fire_signal" <?php checked($pixelInfo->isFireForSignal, true); ?>>
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description">Fire the active automated events for this pixel</span>
                    </label>
                </p>

                <?php if (PixelYourSite\isWooCommerceActive()) : ?>
                    <p>
                        <label class="custom-control custom-checkbox">
                            <input type="checkbox"
                                   class="custom-control-input is_fire_woo" <?php checked($pixelInfo->isFireForWoo, true); ?>>
                            <span class="custom-control-indicator"></span>
                            <span class="custom-control-description">Fire the WooCommerce events for this pixel</span>
                        </label>
                    </p>
                <?php endif; ?>
                <?php if (PixelYourSite\isEddActive()) : ?>
                    <p>
                        <label class="custom-control custom-checkbox">
                            <input type="checkbox"
                                   class="custom-control-input is_fire_edd" <?php checked($pixelInfo->isFireForEdd, true); ?>>
                            <span class="custom-control-indicator"></span>
                            <span class="custom-control-description">Fire the Easy Digital Downloads events for this pixel</span>
                        </label>
                    </p>
                <?php endif; ?>
                <p>
                    <strong>Display conditions:</strong>
                    <?php SpPixelCondition()->renderHtml($pixelInfo->displayConditions) ?>
                </p>
                <?php
                if ($isWpmlActive && !empty($languageCodes)) {
                    $active = $pixelInfo->wpmlActiveLang;
                    if ($active == null && !is_array($active)) {
                        $active = $languageCodes;
                    }

                    printLangList($active, $languageCodes);
                }
                ?>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<div class="plate mt-3 pt-4 pb-3 pixel_info" id="pys_superpack_google_ads_id" style="display: none;">

    <input type="hidden" name="pys[superpack][ads_ext_pixel_id][]" value="" placeholder="0" class="form-control">
    <div class="row">
        <div class="col-11">
            <div class='custom-switch '>
                <input type="checkbox" value="1" checked
                       id="pixel_ads_is_enable" class="custom-switch-input is_enable">
                <label class="custom-switch-btn" for="pixel_ads_is_enable"></label>
            </div>
        </div>
        <div class="col-1">
            <button type="button" class="btn btn-sm remove-row">
                <i class="fa fa-trash-o" aria-hidden="true"></i>
            </button>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-12">
            <p>
                <input type="text" value="" placeholder="AW-123456789" class='form-control pixel_id'/>
            </p>
            <p>
                <label class="custom-control custom-checkbox">
                    <input type="checkbox" value="1" class="custom-control-input is_fire_signal" checked>
                    <span class="custom-control-indicator"></span>
                    <span class="custom-control-description">Fire the Signal events for this pixel</span>
                </label>
            </p>

            <?php if (PixelYourSite\isWooCommerceActive()) : ?>
                <p>
                    <label class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input is_fire_woo" checked>
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description">Fire the WooCommerce events for this pixel</span>
                    </label>
                </p>
            <?php endif; ?>
            <?php if (PixelYourSite\isEddActive()) : ?>
                <p>
                    <label class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input is_fire_edd" checked>
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description">Fire the Easy Digital Downloads events for this pixel</span>
                    </label>
                </p>
            <?php endif; ?>
            <p>
                <strong>Display conditions:</strong>
                <?php  SpPixelCondition()->renderHtml() ?>
            </p>
            <?php if ($isWpmlActive && !empty($languageCodes)) {
                printLangList($languageCodes, $languageCodes );
            }
            ?>
        </div>
    </div>
</div>


<div class="row my-3">
    <div class="col-12">
        <button class="btn btn-sm btn-primary" type="button"
                id="pys_superpack_add_google_ads_id">
            Add Extra Google Ads Tag
        </button>
    </div>
</div>


<script type="text/javascript">
    jQuery(document).ready(function ($) {
        
        $('#pys_superpack_add_google_ads_id').click(function (e) {
            
            e.preventDefault();

            var $row = $('#pys_superpack_google_ads_id').clone()
                .insertBefore('#pys_superpack_google_ads_id')
                .attr('id', '')
                .css('display', 'block');

        });

    });
</script>