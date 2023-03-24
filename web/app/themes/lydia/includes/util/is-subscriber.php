<?php
/**
 *  Count Post Views for Use with Most Popular
 *  ------
 *  @package Lydia
 *  @since Lydia 1.0
 */
namespace TGJ;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Users utility Class
 * @type Singleton
 * See after the class definition at how to use in template
 */
class Users
{
    /**
     * @var mixed
     */
    private static $instance;

    public function __construct()
    {
        $this->user = wp_get_current_user();
    }

    public static function getInstance()
    {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }

        return static::$instance;
    }

    //checks if current user is admin user
    public function isAdminUser()
    {

        $user          = $this->user;
        $allowed_roles = ['editor', 'administrator', 'author', 'external-client'];
        $roles         = $user->roles;

        if ( count( array_intersect( $allowed_roles, $roles ) ) > 0 ) {
            return true;
        }

        return false;

    }

    /**
     * check if current ACTIVE subscriber
     * @return boolean true if active, false if not
     */
    public function isSubscriber()
    {
        $user  = $this->user;
        $roles = $user->roles;
        if ( ! isset( $user ) || count( $roles ) < 1 || $roles[0] !== 'subscriber' ) {
            return false;
        }

        $subs = get_posts( [
            'post_type'   => 'shop_subscription',
            'post_status' => 'any',
            'numberposts' => -1,
            'meta_key'    => '_customer_user',
            'meta_value'  => $user->ID
        ] );


        if (is_array($subs)) {
            foreach($subs as $sub) {
                if(in_array($sub->post_status, ['wc-active', 'wc-pending-cancel'])) {
                    return true;
                    break;
                }
            }
        } else {
            return false;
        }

    }
}

//main singleton function
//Check if admin user like this: TGJ\Users->isAdminUser()
function Users()
{
    return Users::getInstance();
}
