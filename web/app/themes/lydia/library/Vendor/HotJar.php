<?php
/**
 * GoogleMaps
 * --------
 *
 * @category Assets
 * @version 1.0
 * @package BMAS
 */
namespace BMAS\Vendor;

defined( 'ABSPATH' ) || exit;

class HotJar
{

    public function __construct()
    {
        $this->add_actions();
    }

    /**
     * Add Actions Hooks
     *
     * @return void
     */
    public static function add_actions() {
        add_action( 'wp_head', [__CLASS__, 'enqueue_library'], 90);
    }

    public static function enqueue_library() {

        echo '<!-- Hotjar Tracking Code for https://www.thegentlemansjournal.com -->
            <script>
                (function(h,o,t,j,a,r){
                    h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
                    h._hjSettings={hjid:2703936,hjsv:6};
                    a=o.getElementsByTagName(\'head\')[0];
                    r=o.createElement(\'script\');r.async=1;
                    r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
                    a.appendChild(r);
                })(window,document,\'https://static.hotjar.com/c/hotjar-\',\'.js?sv=\');
            </script>';
    }
}
