<?php

namespace XSC\BMF\Model\Entities;

use WC_Subscription;

// Exit if accessed directly
if (!defined('ABSPATH'))
    exit;

class EmailSubscription extends WC_Subscription
{
    public const USERNAME_META = 'bmf_username';
    public const IS_ACTIVATION_FULFILLED_META = 'bmf_is_activation_fulfilled';
    public const IS_CANCELLATION_FULFILLED_META = 'bmf_is_cancellation_fulfilled';

    public function get_username()
    {
        foreach ($this->get_items() as $item)
        {
            /** @disregard P1013 get_product_id is definitely defined. */
            $product_id = $item->get_product_id();

            $product = new EmailSubscriptionProduct($product_id);
            if(!$product->is_email_sub_product())
            {
                continue;
            }

            return $item->get_meta(self::USERNAME_META);
        }
    }

    public function is_activation_fulfilled()
    {
        return $this->get_meta(self::IS_ACTIVATION_FULFILLED_META, true);
    }

    public function set_is_activation_fulfilled($is_fulfilled, $save_immediately = true)
    {
        if($is_fulfilled) {
            $this->update_meta_data(self::IS_ACTIVATION_FULFILLED_META, $is_fulfilled);
        } else {
            $this->delete_meta_data(self::IS_ACTIVATION_FULFILLED_META);
        }

        if($save_immediately)
        {
            $this->save_meta_data();
        }
    }

    public function is_cancellation_fulfilled()
    {
        return $this->get_meta(self::IS_CANCELLATION_FULFILLED_META, true);
    }

    public function set_is_cancellation_fulfilled($is_fulfilled, $save_immediately = true)
    {
        if($is_fulfilled) {
            $this->update_meta_data(self::IS_CANCELLATION_FULFILLED_META, $is_fulfilled);
        } else {
            $this->delete_meta_data(self::IS_CANCELLATION_FULFILLED_META);
        }

        if($save_immediately)
        {
            $this->save_meta_data();
        }
    }
}
