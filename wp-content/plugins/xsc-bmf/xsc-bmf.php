<?php
/*
  Plugin Name: BMF Core
  Description: BMF e-mail services
  Author: Wijnand van Leeuwen
  Version: 1.0.0
  Text Domain: xsc-bmf-textdomain
  Update URI: xsc-bmf
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) )
    exit;

$plugin_info = get_file_data(__FILE__, [
    'version' => 'Version',
    'textdomain' => 'Text Domain',
    'update_uri' => 'Update URI',
]);

define( 'XSC_BMF_SLUG', 'xsc-bmf' );
define( 'XSC_BMF_OPTION_GROUP_SLUG', 'xsc-bmf-options' );
define( 'XSC_BMF_TEXTDOMAIN', $plugin_info['textdomain'] );
define( 'XSC_BMF_PATH', plugin_dir_path( __FILE__ ) );
define( 'XSC_BMF_URL', plugin_dir_url( __FILE__ ) );
define( 'XSC_BMF_BASENAME', plugin_basename( __FILE__ ) );
define( 'XSC_BMF_VERSION', $plugin_info['version'] );
define( 'XSC_BMF_API_NAMESPACE', 'xsc/bmf' );
define( 'XSC_BMF_UPDATE_URI', $plugin_info['update_uri'] );

if ( !defined( 'XSC_BMF_LOG' ) ) {
    define( "XSC_BMF_LOG", XSC_BMF_PATH . 'debug.log' );
}

require XSC_BMF_PATH . 'vendor/autoload.php';
require XSC_BMF_PATH . 'src/Helpers.php';

/**
 * Get Core
 *
 * @return XSC\BMF\Core
 */
function xsc_bmf_core() {
    return XSC\BMF\Core::get_instance();
}

add_action( 'plugins_loaded', function(){
    load_plugin_textdomain( XSC_BMF_TEXTDOMAIN, false, basename( XSC_BMF_PATH ) . '/languages/' );

    xsc_bmf_core();
    do_action('xsc/bmf/core/loaded');
});
