/**
 * Google AdManager Ad units.
 *
 * Prepare Adunits for use with Google Admanager.
 *
 * @author AlexanderBMAS.
 */

class AdManager {
    constructor() {
        window.googletag = window.googletag || { cmd: [] };

        const adunits = document.querySelectorAll('.c-ad-block');
        if (adunits == null) return;

        const pageConfig = {
            allowOverlayExpansion: true,
            allowPushExpansion: true,
            sandbox: true
        };

        googletag.cmd.push(() => {
            // googletag.pubads().setForceSafeFrame(true);
            googletag.pubads().setSafeFrameConfig(pageConfig);
            googletag.pubads().enableSingleRequest();
            googletag.pubads().collapseEmptyDivs();
            googletag.pubads().setCentering(true);

            adunits.forEach((adunit) => {
                this.define_adslot(
                    adunit,
                    this.getValueByKey(this.sizes(), adunit.dataset.type),
                    this.getValueByKey(this.size_maps(), adunit.dataset.type)
                );
            });


            googletag.pubads()
                .setTargeting('category', ads_keyvalues.category)
                .setTargeting('ID', ads_keyvalues.id);

            googletag.enableServices();

            if (window.googletag && googletag.apiReady) {
                adunits.forEach((adunit) => {
                    googletag.display('gpt-' + adunit.dataset.code);
                });
            }
        });
    }

    define_adslot(ad, size, map) {

        if (size === 'INT') {

            googletag.defineOutOfPageSlot(
                '/113638206/' + ad.dataset.code,
                'gpt-' + ad.dataset.code
            ).addService(googletag.pubads());

        } else {

            const adslot = googletag.defineSlot(
                '/113638206/' + ad.dataset.code,
                size,
                'gpt-' + ad.dataset.code
            );

            if (typeof map !== 'undefined') {
                adslot.defineSizeMapping(map);
            }

            adslot.addService(googletag.pubads());
        }


    }

    sizes() {
        return {
            // 970x250
            billboard: [
                [1000, 250],
                [970, 250],
                [728, 210],
                [300, 250],
            ],

            // 728x90
            leaderboard: [
                [728, 90],
                [300, 250],
            ],

            // 300x600
            halfpage: [[300, 600]],

            // 300x250
            mpu: [[300, 250]],

            pixel: [[1, 1]],

            int: 'INT'
        };
    }

    size_maps() {
        return {
            // 970x250
            billboard: googletag
                .sizeMapping()
                .addSize([1010, 0], [970, 250])
                .addSize([759, 0], [728, 210])
                .addSize([320, 0], [300, 250])
                .addSize([0, 0], [300, 250])
                .build(),

            // 728x90
            leaderboard: googletag
                .sizeMapping()
                .addSize([759, 0], [728, 90])
                .addSize([320, 0], [300, 250])
                .addSize([0, 0], [300, 250])
                .build(),
        };
    }

    getValueByKey(obj, value) {
        return obj[value];
    }
}

new AdManager();
