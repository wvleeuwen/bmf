<?php

namespace XSC\BMF\Services;

// Exit if accessed directly
if (!defined('ABSPATH'))
    exit;

class WooCommerceEmptyCartCommand
{
    const EMPTY_CART_INPUT = 'empty-cart';

    public static function init()
    {
        add_filter('init', [__CLASS__, 'maybe_empty_cart'], 10);
    }

    public static function maybe_empty_cart()
    {
        if (empty($_GET[self::EMPTY_CART_INPUT]))
        {
            return;
        }

        global $woocommerce;
        $woocommerce->cart->empty_cart();
    }
}
