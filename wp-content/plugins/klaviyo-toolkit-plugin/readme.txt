=== Enhanced Events for Klaviyo ===
Contributors: Tribe Interactive
Tags: Klaviyo, WooCommerce, WooCommerce Subscriptions
Requires at least: 5.0
Tested up to: 6.0.2
Requires PHP: 7.0
Stable tag: v1.6
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Triggers additional events with WooCommerce and Klaviyo.

== Description ==

This simple plugin will unlocks additional event and metrics within Klaviyo, allowing you to create new advanced automation flows and segments.

Documentation: https://www.notion.so/madebytribe/Enhanced-Events-for-Klaviyo-06b901cd9d62465f8f24f09fef0a5634

== Installation ==

1. Download the plugin below
2. Install it on your WordPress site
3. Set your public API key on the plugin's settings page

== Changelog ==

= 1.6 =
* Feature: Coupon generation feature for Klaviyo profile

= 1.5.1 =
* Fix: Remove Private Key from the settings page

= 1.5 =
* Fix: Fix admin header styling
* Fix: JS script updated to track and identify general events
* Fix: License check condition changes in admin license page
* Fix: Change plugin license check hook action to 'init'
* Improvement: WC Subscription Renewal Value + Status Changed Value parameter added
* Improvement: Use WP REST API instead of admin-ajax
* Improvement: Remove "Added To Cart" Event
* Improvement: Admin sidebar layout changes
* Improvement: PlanExpiresAfter & PlanNextPaymentDate parameter added
* Feature: Adding the "next payment date" and "payment interval" fields to WC Subscription Created and Subscription renewal events
* Feature: Klaviyo/sdk installed
* Feature: Add a setting to grab the actual subscription cancelation/end date
* Feature: Added Klaviyo Private API Key option

= 1.4 =
* Improvement: Make Klaviyo API request secure
* Fix: Redirect to single product page for variable subscription product.
* Improvement: Added subscription plan ID in WC subscription
* Improvement: Subscription ID parameter changes in WC subscription created event
* Improvement: Subscription plan expiration date added in WC subscription created event

= 1.3.9 =
* Fix: Improved syntax error.
* Improvement: Updated admin UI

= 1.3.8 =
* Fix: Improved performance for license checks.

= 1.3.7 =
* Improvement: Timestamp updated to track real time events.

= 1.3.6 =
* Bug fix - Add-to-cart issue solved.
* Email change to wc recipient for subscription gifting plugin.
* License API checks updated for klaviyo toolkit settings page.
* Flatsome theme support added.
* Add option to move email address field on checkout to above the name fields.
* Some admin layout changes.

= 1.3.5 =
* Bug fix - SSL certificate verification updated.

= 1.3.4 =
* Bug fixes.

= 1.3.3 =
* Fixing EDD auto-updater function.

= 1.3.2 =
* Bug fix - Add to cart JS.

= 1.3.1 =
* Fixing license deactivation functionality.

= 1.3.0 =
* Performance update - reduce unnecessary js loads.

= 1.2.0 =
* Performance update - reduce license server checks.

= 1.1.0 =
* Bug fix - Klaviyo API connection error.
* Bug fix - Legacy plugin activation fatal error.
* Bug fix - Removed old updater code.

= 1.0.0 =
* Initial release.
