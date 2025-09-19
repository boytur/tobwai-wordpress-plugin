<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class Tobwai {

    public function __construct() {}

    public function run() {
        $admin  = new Tobwai_Admin();
        $public = new Tobwai_Public();

        // Hooks
        add_action( 'admin_enqueue_scripts', [ $admin, 'enqueue_assets' ] );
        add_action( 'admin_menu', [ $admin, 'register_menu' ] );
        add_action( 'admin_init', [ $admin, 'register_settings' ] );

        add_action( 'wp_enqueue_scripts', [ $public, 'enqueue_assets' ] );

        // Bootstrap constants (ENV → define)
        add_action( 'plugins_loaded', [ $this, 'bootstrap_constants' ] );

        // Verify license when in admin
        add_action( 'admin_init', [ $this, 'maybe_verify_license' ] );
    }

    public function bootstrap_constants() {
        $api = getenv('TOBWAI_API_BASE_URL') ?: get_option('tobwai_api_base_url', '');
        $pub = getenv('TOBWAI_LICENSE_PUBLIC_KEY') ?: get_option('tobwai_license_public_key', '');

        if ( ! defined('TOBWAI_API_BASE_URL') ) {
            define('TOBWAI_API_BASE_URL', $api);
        }
        if ( ! defined('TOBWAI_LICENSE_PUBLIC_KEY') ) {
            define('TOBWAI_LICENSE_PUBLIC_KEY', $pub);
        }
    }

    public function maybe_verify_license() {
        $key = trim( get_option('tobwai_license_key', '') );
        if ( $key === '' ) return;

        // check cache
        if ( false !== get_transient('tobwai_license_status') ) return;

        $resp = wp_safe_remote_post( TOBWAI_API_BASE_URL . '/license/verify', [
            'timeout' => 8,
            'headers' => [ 'Content-Type' => 'application/json' ],
            'body'    => wp_json_encode([
                'license_key' => $key,
                'site_url'    => home_url(),
            ]),
        ]);

        $valid = false;
        if ( ! is_wp_error($resp) && 200 === wp_remote_retrieve_response_code($resp) ) {
            $data  = json_decode( wp_remote_retrieve_body($resp), true );
            $valid = (bool)($data['valid'] ?? false);
        }

        set_transient('tobwai_license_status', $valid ? 'ok' : 'bad', HOUR_IN_SECONDS);

        if ( ! $valid ) {
            add_action('admin_notices', function () {
                echo '<div class="notice notice-error"><p>';
                echo esc_html__('Tobwai license is invalid or expired. Please check your key.', 'tobwai-wordpress-plugin');
                echo '</p></div>';
            });
        }
    }
}
