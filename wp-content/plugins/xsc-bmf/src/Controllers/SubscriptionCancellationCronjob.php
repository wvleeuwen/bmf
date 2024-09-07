<?php

namespace XSC\BMF\Controllers;

use XSC\BMF\Lib\Cronjob;
use XSC\BMF\Model\Entities\EmailSubscription;
use XSC\BMF\Model\Repositories\SubscriptionRepository;
use XSC\BMF\Services\CronjobIntervals;
use XSC\BMF\Services\SubscriptionService;

// Exit if accessed directly
if (!defined('ABSPATH'))
    exit;

class SubscriptionCancellationCronjob extends Cronjob
{
    protected static function get_interval()
    {
        return CronjobIntervals::CRONJOB_EVERY_MINUTE;
    }

    public static function run()
    {
        $unfulfilled_subs = SubscriptionRepository::get_unfulfilled_cancelled_subscription_ids();
        foreach ($unfulfilled_subs as $subscription_id)
        {
            $subscription = new EmailSubscription($subscription_id);
            SubscriptionService::cancel_single_subscription($subscription);
        }
    }
}
