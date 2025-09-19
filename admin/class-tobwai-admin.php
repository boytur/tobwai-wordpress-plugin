<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class Tobwai_Admin {

    public function enqueue_assets( $hook ) {
        if ( 'toplevel_page_tobwai' !== $hook ) return;

        wp_enqueue_style( 'tobwai-admin', TOBWAI_PLUGIN_URL . 'assets/css/admin.css', [], TOBWAI_PLUGIN_VERSION );
        wp_enqueue_script( 'tobwai-admin', TOBWAI_PLUGIN_URL . 'assets/js/admin.js', [ 'jquery' ], TOBWAI_PLUGIN_VERSION, true );
    }

    public function register_menu() {
        add_menu_page(
            __( 'Tobwai Plugin', 'tobwai-wordpress-plugin' ),
            __( 'Tobwai Plugin', 'tobwai-wordpress-plugin' ),
            'manage_options',
            'tobwai',
            [ $this, 'render_settings_page' ],
            'dashicons-admin-generic',
            80
        );
    }

    public function register_settings() {
        register_setting( 'tobwai_settings', 'tobwai_license_key', [
            'type' => 'string',
            'sanitize_callback' => 'sanitize_text_field',
            'default' => '',
        ] );

        add_settings_section(
            'tobwai_main',
            __( 'General Settings', 'tobwai-wordpress-plugin' ),
            function() {
                echo '<p>' . esc_html__( 'Basic configuration for Tobwai Plugin.', 'tobwai-wordpress-plugin' ) . '</p>';
            },
            'tobwai_settings'
        );

        add_settings_field(
            'tobwai_license_key',
            __( 'License Key', 'tobwai-wordpress-plugin' ),
            function () {
                $v = get_option('tobwai_license_key', '');
                echo '<input type="text" name="tobwai_license_key" value="' . esc_attr($v) . '" class="regular-text" />';
            },
            'tobwai_settings',
            'tobwai_main'
        );
    }

    public function render_settings_page() {
        if ( ! current_user_can( 'manage_options' ) ) return;
        ?>
        <div class="wrap">
            <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
            <form action="options.php" method="post">
                <?php
                    settings_fields( 'tobwai_settings' );
                    do_settings_sections( 'tobwai_settings' );
                    submit_button( __( 'Save Changes', 'tobwai-wordpress-plugin' ) );
                ?>
            </form>
        </div>
        <?php
    }
}
