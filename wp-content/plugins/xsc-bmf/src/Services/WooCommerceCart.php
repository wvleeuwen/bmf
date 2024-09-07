<?php

namespace XSC\BMF\Services;

use XSC\BMF\Model\Entities\EmailSubscription;

// Exit if accessed directly
if (!defined('ABSPATH'))
    exit;

class WooCommerceCart
{
    const USERNAME_CART_INPUT = 'bmf-username';
    const USERNAME_CART_META = 'bmf_cart_username';

    public static function init()
    {
        add_filter('woocommerce_add_to_cart_validation', [__CLASS__, 'validate'], 10, 4);
        add_filter('woocommerce_add_cart_item_data', [__CLASS__, 'add_meta'], 10, 3);
        add_filter('woocommerce_get_item_data', [__CLASS__, 'display_in_cart'], 10, 2);
        add_action('woocommerce_checkout_create_order_line_item', [__CLASS__, 'add_data_to_order'], 10, 4);
    }

    public static function validate($passed, $product_id, $quantity, $variation_id = null)
    {
        if (empty($_GET[self::USERNAME_CART_INPUT]))
        {
            $passed = false;
            wc_add_notice(__('A username is required.', XSC_BMF_TEXTDOMAIN), 'error');
        }

        return $passed;
    }

    public static function add_meta($cart_item_data, $product_id, $variation_id)
    {
        if (isset($_GET[self::USERNAME_CART_INPUT]))
        {
            $cart_item_data[self::USERNAME_CART_META] = sanitize_text_field( $_GET[self::USERNAME_CART_INPUT] );
        }

        return $cart_item_data;
    }

    public static function display_in_cart($item_data, $cart_item_data)
    {
        if (isset($cart_item_data[self::USERNAME_CART_META]))
        {
            $item_data[] = [
                'key'   => __('Username', XSC_BMF_TEXTDOMAIN),
                'value' => wc_clean($cart_item_data[self::USERNAME_CART_META]) . "@badmotherfucker.com",
            ];
        }

        return $item_data;
    }

    public static function add_data_to_order($item, $cart_item_key, $values, $order)
    {
        if(isset($values[self::USERNAME_CART_META]))
        {
            $item->add_meta_data(
                EmailSubscription::USERNAME_META,
                $values[self::USERNAME_CART_META],
                true
            );
        }
    }
}
