<?php

namespace XSC\BMF\Services;

use XSC\BMF\Model\Entities\EmailSubscriptionProduct;

// Exit if accessed directly
if (!defined('ABSPATH'))
    exit;

class WooCommerceProductData
{
    public static function init()
    {
        add_filter('product_type_options', [__CLASS__, 'display_product_type']);
        add_action('woocommerce_process_product_meta', [__CLASS__, 'store_product_type']);
    }

    public static function display_product_type($product_type_options)
    {
        $product_type_options[EmailSubscriptionProduct::IS_EMAIL_SUB_PRODUCT_TYPE_META] = [
            "id"            => EmailSubscriptionProduct::IS_EMAIL_SUB_PRODUCT_TYPE_META,
            "wrapper_class" => '', // Show for every product type (simple, variable, etc).
            "label"         => __("E-mail subscription", XSC_BMF_TEXTDOMAIN),
            "description"   => __("This product represents an E-mail account.", XSC_BMF_TEXTDOMAIN),
            "default"       => "no",
        ];

        return $product_type_options;
    }

    public static function store_product_type($post_id)
    {
        $product = new EmailSubscriptionProduct($post_id);
        $product->set_is_email_sub_product(isset($_POST[EmailSubscriptionProduct::IS_EMAIL_SUB_PRODUCT_TYPE_META]));
    }
}
