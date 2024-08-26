<?php
namespace XSC\BMF\Updater;

use WP_Error;

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) )
    exit;

class Module
{
    private static $remote_data = null;
    const REMOTE_INFO_URL = 'https://s3.eu-west-1.amazonaws.com/zaterdagochtend.releases/xsc-bmf/release.json';

    public static function init()
    {
        add_filter( 'update_plugins_'.XSC_BMF_UPDATE_URI, [__CLASS__, 'maybe_show_update_available'], 10, 3 );
        add_filter( 'plugins_api', [__CLASS__, 'modify_plugin_details'], 10, 3 );
    }

    public static function get_remote_data()
    {
        if(!self::$remote_data)
        {
            $response = wp_remote_get(self::REMOTE_INFO_URL);
            if(is_wp_error($response))
            {
                self::$remote_data = $response;
                return self::$remote_data;
            }

            $status_code = wp_remote_retrieve_response_code($response);
            if($status_code !== 200)
            {
                self::$remote_data = new WP_Error($status_code, 'Could not fetch remote data', $response);
                return self::$remote_data;
            }

            self::$remote_data = json_decode($response['body']);
            self::$remote_data->sections = (array) self::$remote_data->sections;
        }

        return self::$remote_data;
    }

    public static function maybe_show_update_available($update, array $plugin_data, string $plugin_file)
    {
        // only check this plugin
        if($plugin_file !== XSC_BMF_BASENAME)
        {
            return $update;
        }

        // already done update check elsewhere
        if (!empty($update))
        {
            return $update;
        }

        $response = self::get_remote_data();
        if(is_wp_error($response))
        {
            return $update;
        }

        $body = $response;
        $latest_version = $body->version;
        
        // Is our version higher than the remote one? -1 if not, meaning an update is available.
        if(version_compare(XSC_BMF_VERSION, $latest_version) >= 0)
        {
            return $update;
        }

        return (array) $body;
    }

    public static function modify_plugin_details( $result, $action = null, $args = null )
    {
		if( $action !== 'plugin_information' )
        {
            return $result;
        }

        if($args->slug !== XSC_BMF_SLUG)
        {
            return $result;
        }
		
        $response = self::get_remote_data();
        if(is_wp_error($response))
        {
            return $result;
        }

        return $response;
    }
}
