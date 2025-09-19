<?php
if ( ! defined( 'ABSPATH' ) ) exit;
class Tobwai_Activator {
    public static function activate() {
        if ( false === get_option( 'tobwai_option' ) ) {
            add_option( 'tobwai_option', 'default' );
        }
    }
}
