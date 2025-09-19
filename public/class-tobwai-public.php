<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class Tobwai_Public {
    public function enqueue_assets() {
        // enqueue front-end css/js ถ้ามี
        // wp_enqueue_style( 'tobwai-frontend', TOBWAI_PLUGIN_URL . 'assets/css/frontend.css', [], TOBWAI_PLUGIN_VERSION );
    }
}
