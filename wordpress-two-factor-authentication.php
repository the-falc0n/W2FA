<?php

/**
 * Wordpress Two Factor Authentication
 *
 * @author      Rishabh Sharma
 * @copyright   2019 SkyKings InfoTech
 * @license     MIT
 *
 * @wordpress-plugin
 * Plugin Name: Wordpress Two Factor Authentication
 * Plugin URI:  https://github.com/officialrkay/wordpress-two-factor-authentication
 * Description: Wordpress Two Factor Authentication Plugin.
 * Version:     1.0.0-beta
 * Author:      Rishabh Sharma
 * Author URI:  https://example.com
 * Text Domain: ski-wtfa
 * License:     MIT
 * License URI: https://opensource.org/licenses/MIT
 */

define( 'SKI_WTFA_PLUGIN_BASE_PATH', plugin_dir_path( __FILE__ ) );
define( 'SKI_WTFA_PLUGIN_BASE_URL', plugin_dir_url( __FILE__ ) );

// composer autoload
require_once 'vendor/autoload.php';

// Require Plugin Files
require_once 'functions.php';
require_once 'hooks.php';

// Plugin Activation Hook
register_activation_hook( __FILE__, [ 'SKI\WTFA\Events', 'activate' ] );

// Plugin Deactivation Hook
register_activation_hook( __FILE__, [ 'SKI\WTFA\Events', 'deactivate' ] );
