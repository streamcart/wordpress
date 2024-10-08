<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

if ( ! class_exists( 'Streamcart_Admin' ) ) :

    class Streamcart_Admin {

        const KEY = 'admin_settings_page';

        public function __construct() {
            add_action( 'admin_menu', array( $this, 'add_admin_menu' ) );
            add_action( 'admin_init', array( $this, 'settings_init' ) );
        }

        public function add_admin_menu() {
            add_options_page(
                __( 'Streamcart Settings', 'streamcart' ),
                __( 'Streamcart Settings', 'streamcart' ),
                'manage_options',
                'streamcart-settings',
                array( $this, 'options_page' )
            );
        }

        public function settings_init() {
            register_setting( 'streamcart_user_data_consent', 'streamcart_user_data_consent' );
            register_setting( 'streamcart', 'streamcart_public_key' );

            add_settings_section(
                'streamcart_main_file',
                __( 'Main Settings', 'streamcart' ),
                null,
                'streamcart'
            );

            add_settings_field(
                'streamcart_public_key',
                __( 'Public Key', 'streamcart' ),
                array( $this, 'public_key_render' ),
                'streamcart',
                'streamcart_main_file'
            );
        }

        public function public_key_render() {
            $option = get_option( 'streamcart_public_key' );
            ?>
            <input type='text' class='regular-text' name='streamcart_public_key' value='<?php echo esc_attr( $option ); ?>'>
            <br>
            <span><?php esc_html_e( 'Create your account to generate your integration key on ', 'streamcart' ) .
                esc_html($this->streamcart_app_link_as_html()) ?></span>
            <?php
        }

        public function options_page() {
            ?>
            <form action='options.php' method='post'>
                <h2><?php esc_html_e( 'Streamcart Settings', 'streamcart' ); ?></h2>
                <?php
                settings_fields( 'streamcart' );
                do_settings_sections( 'streamcart' );
                submit_button();
                ?>
            </form>
            <?php
        }

        private function streamcart_app_link_as_html()
        {
            return '<a target="_blank" href="https://app.streamcart.io">app.streamcart.io</a>';
        }
    }

endif;

Streamcart::instance()->setObject(Streamcart_Admin::KEY, new Streamcart_Admin());

?>
