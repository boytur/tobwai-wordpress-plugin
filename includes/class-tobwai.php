<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class Tobwai {
    public function __construct() {}
    public function run() {
        $admin  = new Tobwai_Admin();
        $public = new Tobwai_Public();

        add_action( 'admin_enqueue_scripts', [ $admin, 'enqueue_assets' ] );
        add_action( 'admin_menu', [ $admin, 'register_menu' ] );
        add_action( 'admin_init', [ $admin, 'register_settings' ] );

        add_action( 'wp_enqueue_scripts', [ $public, 'enqueue_assets' ] );
    }
}
