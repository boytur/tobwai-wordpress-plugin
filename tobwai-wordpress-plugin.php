<?php
/**
 * Plugin Name: Tobwai WordPress Plugin
 * Plugin URI:  https://tobhai.shop/tobwai
 * Description: A clean starter template ready for WordPress.org submission.
 * Version:     1.0.0
 * Author:      Piyawat Wonygat
 * Author URI:  https://tobhai.shop/tobwai
 * License:     GPL-3.0
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain: tobwai-wordpress-plugin
 * Domain Path: /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'TOBWAI_PLUGIN_VERSION', '1.0.0' );
define( 'TOBWAI_PLUGIN_FILE', __FILE__ );
define( 'TOBWAI_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'TOBWAI_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

// โหลดไฟล์ class หลัก
require_once TOBWAI_PLUGIN_DIR . 'includes/class-tobwai.php';
require_once TOBWAI_PLUGIN_DIR . 'includes/class-tobwai-activator.php';
require_once TOBWAI_PLUGIN_DIR . 'includes/class-tobwai-deactivator.php';
require_once TOBWAI_PLUGIN_DIR . 'admin/class-tobwai-admin.php';
require_once TOBWAI_PLUGIN_DIR . 'public/class-tobwai-public.php';

// Hook ตอน activate/deactivate
register_activation_hook( __FILE__, [ 'Tobwai_Activator', 'activate' ] );
register_deactivation_hook( __FILE__, [ 'Tobwai_Deactivator', 'deactivate' ] );

// Run plugin
function tobwai_run() {
    $plugin = new Tobwai();
    $plugin->run();
}
tobwai_run();
