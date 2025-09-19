<?php
/**
 * Plugin Name: Tobwai WordPress Plugin
 * Plugin URI:  https://example.com/tobwai
 * Description: A clean starter template ready for WordPress.org submission.
 * Version:     1.0.0
 * Author:      Your Name
 * Author URI:  https://example.com
 * License:     GPL-2.0-or-later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: tobwai-wordpress-plugin
 * Domain Path: /languages
 *
 * @package Tobwai_WordPress_Plugin
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'TOBWAI_PLUGIN_VERSION', '1.0.0' );
define( 'TOBWAI_PLUGIN_FILE', __FILE__ );
define( 'TOBWAI_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'TOBWAI_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

add_action( 'plugins_loaded', function() {
    load_plugin_textdomain( 'tobwai-wordpress-plugin', false, basename( dirname( __FILE__ ) ) . '/languages' );
} );

require_once TOBWAI_PLUGIN_DIR . 'includes/class-tobwai.php';
require_once TOBWAI_PLUGIN_DIR . 'includes/class-tobwai-activator.php';
require_once TOBWAI_PLUGIN_DIR . 'includes/class-tobwai-deactivator.php';
require_once TOBWAI_PLUGIN_DIR . 'admin/class-tobwai-admin.php';
require_once TOBWAI_PLUGIN_DIR . 'public/class-tobwai-public.php';

register_activation_hook( __FILE__, [ 'Tobwai_Activator', 'activate' ] );
register_deactivation_hook( __FILE__, [ 'Tobwai_Deactivator', 'deactivate' ] );

function tobwai_run() {
    $plugin = new Tobwai();
    $plugin->run();
}
tobwai_run();
