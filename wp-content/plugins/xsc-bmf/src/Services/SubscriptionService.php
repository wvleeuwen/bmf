<?php

namespace XSC\BMF\Services;

use XSC\BMF\Model\Entities\EmailSubscription;

// Exit if accessed directly
if (!defined('ABSPATH'))
    exit;

class SubscriptionService
{
    public static function fulfill_single_subscription(EmailSubscription $subscription)
    {
        // Let's make sure the sub is still unfulfilled
        if($subscription->is_activation_fulfilled())
        {
            return;
        }

        $username = $subscription->get_username();
        $subscription->add_order_note('E-mail account with username "' . $username . '" has been created.');

        $subscription->set_is_activation_fulfilled(true);
    }

    public static function cancel_single_subscription(EmailSubscription $subscription)
    {
        // Let's make sure the sub's cancellation is still unfulfilled
        if($subscription->is_cancellation_fulfilled())
        {
            return;
        }

        $username = $subscription->get_username();
        $subscription->add_order_note('E-mail account with username "' . $username . '" has been deleted.');

        $subscription->set_is_cancellation_fulfilled(true);
    }
}
