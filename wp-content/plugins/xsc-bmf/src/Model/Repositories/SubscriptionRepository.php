<?php

namespace XSC\BMF\Model\Repositories;

use XSC\BMF\Model\Entities\EmailSubscription;

// Exit if accessed directly
if (!defined('ABSPATH'))
    exit;

class SubscriptionRepository
{
    public static function get_unfulfilled_active_subscription_ids($count = -1)
    {
        $subscriptions = wcs_get_subscriptions([
            'subscriptions_per_page' => -1,
            'subscription_status' => 'active',
            'meta_query' => [
                [
                    'key'       => EmailSubscription::IS_ACTIVATION_FULFILLED_META,
                    'compare'   => 'NOT EXISTS',
                ],
            ]
        ]);

        return array_keys($subscriptions);
    }

    public static function get_unfulfilled_cancelled_subscription_ids($count = -1)
    { 
        $subscriptions = wcs_get_subscriptions([
            'subscriptions_per_page' => -1,
            'subscription_status' => 'cancelled',
            'meta_query' => [
                [
                    'key'       => EmailSubscription::IS_CANCELLATION_FULFILLED_META,
                    'compare'   => 'NOT EXISTS',
                ],
            ]
        ]);

        return array_keys($subscriptions);
    }
}
