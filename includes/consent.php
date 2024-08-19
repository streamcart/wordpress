<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

if ( ! class_exists( 'Streamcart_Consent' ) ) :

    class Streamcart_Consent {

        const KEY = 'consent_page';

        public function __construct() {
            add_action( 'admin_menu', array( $this, 'add_admin_menu' ) );
            add_action( 'admin_post_streamcart_consent_form', array($this, 'handle_consent_form'));
        }

        public function add_admin_menu() {
            add_menu_page(
                esc_html_e('Streamcart Consent', 'streamcart'),
                esc_html_e('Streamcart Consent', 'streamcart'),
                'manage_options',
                'streamcart-consent',
                function () {
                    require CASTLEIT_STREAMCART_PLUGIN_DIR . '/includes/consent/view.php';
                }
            );
        }

        public function handle_consent_form()
        {
            if (isset($_POST['streamcart_user_data_consent']) &&
                $_POST['streamcart_user_data_consent'] == 'on' &&
                isset($_POST['streamcart_consent_form_nonce_field']) &&
                wp_verify_nonce($_POST['streamcart_consent_form_nonce_field'], 'streamcart_consent_form')
            ) {
                update_option('streamcart_user_data_consent', $_POST['streamcart_user_data_consent']);
                wp_redirect( admin_url() );
                exit();
            }

            wp_redirect( admin_url('/admin.php?page=streamcart-consent') );
            exit();
        }

    }

endif;

Streamcart::instance()->setObject(\Streamcart_Consent::KEY, new Streamcart_Consent());
?>
