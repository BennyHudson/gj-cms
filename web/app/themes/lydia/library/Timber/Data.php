<?php
/**
 * Timber Data
 * --------
 * @category Timber
 * @version 1.0
 * @package Lydia
 */

namespace BMAS\Timber;

defined('ABSPATH') || exit();

use BMAS\Util\CommonHelpers as Helpers;
use BMAS\Timber\Context as Context;

class Data
{
    public function __construct()
    {
        add_filter('timber/context', [$this, 'add_global_data']);
    }

    public function add_global_data($data)
    {
        // Don't include Data In Ajax requests
        if (Helpers::isAjax()) {
            return $data;
        }

        $context = new Context(['no-op'], $data);

        $context->add([
            'menu' => [
                'masthead' => new \Timber\Menu('header'),
                'foundation' => [
                    'main' => new \Timber\Menu('footer'),
                    'info' => new \Timber\Menu('footer-info'),
                    'cat' => new \Timber\Menu('footer-cat'),
                ],
            ],
            'company' => [
                'contact' => get_field('contact', 'general'),
            ],
            'style' => 'default',
        ]);

        $this->add_data_post($context);
        $this->add_global_acf($context);
        $this->add_data_woocommerce($context);

        if (is_post_type_archive('product')) {
            $context->add([
                'archive' => new \Timber\Post(wc_get_page_id('shop')),
            ]);
        }

        return $context->get();
    }

    public static function add_data_post($context)
    {
        if (is_page() || is_singular()) {
            $context->add(['post' => new \Timber\Post()]);
        }

        return $context;
    }

    public function add_global_acf($context)
    {
        $context->add(['membersCatID' => 9415]);
        $context->add([
            'modalNewsletter' => get_field('modal_newsletter', 'options'),
        ]);
        $context->add(['social' => get_field('social', 'social')]);

        $context->add([
            'clubhouse' => [
                'card' => new \Timber\Image(get_field('club_card', 74300)),
                'description' => get_field('club_description', 74300),
                'link' => get_page_link(74300),
            ],
        ]);

        $context->add([
            'categoriesArgs' => [
                'post_type' => ['post', 'article'],
                'post_status' => 'publish',
                'numberposts' => 4,
            ],
        ]);

        $context->add(
            'latestVideosMenu',
            get_posts([
                'post_type' => 'article',
                'posts_per_page' => 3,
                'tax_query' => [
                    [
                        'taxonomy' => 'category',
                        'field' => 'slug',
                        'terms' => 'video',
                    ],
                ],
            ])
        );

        $context->add(
            'latestSessionsMenu',
            get_posts([
                'post_type' => 'article',
                'posts_per_page' => 3,
                'tax_query' => [
                    [
                        'taxonomy' => 'category',
                        'field' => 'slug',
                        'terms' => 'gj-sessions',
                    ],
                ],
            ])
        );

        $context->add(
            'latestPodcastMenu',
            get_posts([
                'post_type' => 'podcasts',
                'posts_per_page' => 3,
            ])
        );

        $context->add(
            'latestHouseNotesMenu',
            get_posts([
                'post_type' => 'house-note',
                'posts_per_page' => 3,
            ])
        );

        if (function_exists('yoast_breadcrumb')) {
            $context->add(
                'breadcrumbs',
                yoast_breadcrumb('<nav class="c-crumbs">', '</nav>', false)
            );
        }

        $currentIssue = get_field('current_issue', 'options');
        $currentIssuePost = new \Timber\Post($currentIssue);
        $currentIssuePost->gallery = explode(
            ',',
            $currentIssuePost->_product_image_gallery
        );
        $context->add('currentIssue', $currentIssuePost);

        return $context;
    }

    public function add_data_woocommerce($context)
    {
        if (!function_exists('is_woocommerce_activated')) {
            $context->add([
                'endpoints' => [
                    'shop' => get_permalink(wc_get_page_id('shop')),
                    'myaccount' => wc_get_page_permalink('myaccount'),
                    'cart' => wc_get_page_permalink('cart'),
                    'terms' => get_permalink(
                        wc_get_page_id('terms-and-conditions')
                    ),
                    'privacy' => get_permalink(
                        wc_get_page_id('privacy-policy')
                    ),
                ],
            ]);

            $context->add('isWooPage', false);
            if (is_cart() || is_checkout() || is_account_page()) {
                $context->add('isWooPage', true);
            }

            return $context;
        }
    }
}
