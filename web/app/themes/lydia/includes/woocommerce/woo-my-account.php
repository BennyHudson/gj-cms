<?php

// Remove Ability to Rebscribe
add_filter('wcs_can_user_resubscribe_to_subscription', '__return_false', 100);

function isSubscriber($userID)
{
    $user = get_user_by('ID', $userID);
    $roles = $user->roles;

    if (!isset($user) || count($roles) < 1 || $roles[0] !== 'subscriber') {
        return false;
    }
    $subs = get_posts([
        'post_type' => 'shop_subscription',
        'post_status' => 'any',
        'numberposts' => -1,
        'meta_key' => '_customer_user',
        'meta_value' => $userID,
    ]);

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

function isAdminUser($userID)
{
    $user = get_user_by('ID', $userID);
    $roles = $user->roles;
    $allowed_roles = ['editor', 'administrator', 'author', 'external-client'];

    if (count(array_intersect($allowed_roles, $roles)) > 0) {
        return true;
    }

    return false;
}
