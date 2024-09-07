<?php
namespace XSC\BMF;

use XSC\BMF\Services;

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) )
    exit;

class Core
{
     /**
     * @return Core
     */
    public static function get_instance() 
    {
        static $instance = false;

        if ( !$instance ) {
            $class    = get_called_class();
            $instance = new $class();
        }

        return $instance;
    }

    protected function __construct() 
    {
        if(!defined( 'CHROME_DEBUG' ))
        {
            define( 'CHROME_DEBUG', false );
        }

        add_action( 'xsc/bmf/core/loaded', [ $this, 'init' ], 5 );
    }

    public function init() 
    {
        Updater\Module::init();
        Services\WooCommerceProductData::init();
        Services\WooCommerceCart::init();
        Services\WooCommerceEmptyCartCommand::init();
        Services\CronjobIntervals::init();
        Controllers\SubscriptionFulfillmentCronjob::init();
        Controllers\SubscriptionCancellationCronjob::init();
    }
}
