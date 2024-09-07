<?php

namespace XSC\BMF\Model\Entities;

use WC_Product;

// Exit if accessed directly
if (!defined('ABSPATH'))
    exit;

class EmailSubscriptionProduct extends WC_Product
{
    public const IS_EMAIL_SUB_PRODUCT_TYPE_META = 'bmf_is_email_subscription_product';

    public function set_is_email_sub_product($is_account)
    {
        $key = '_' . self::IS_EMAIL_SUB_PRODUCT_TYPE_META;
        update_post_meta($this->get_id(), $key, $is_account ? 'yes' : 'no');
    }

    public function is_email_sub_product()
    {
        $key = '_' . self::IS_EMAIL_SUB_PRODUCT_TYPE_META;
        return get_post_meta($this->get_id(), $key, true) === 'yes';
    }
}
