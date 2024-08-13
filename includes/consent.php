<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

if ( ! class_exists( 'Streamcart_Consent' ) ) :

    class Streamcart_Consent {

        public function __construct() {
            add_action( 'admin_menu', array( $this, 'add_admin_menu' ) );
            add_action( 'admin_post_streamcart_consent_form', array($this, 'handle_consent_form'));
        }

        public function add_admin_menu() {
            add_menu_page(
                __('Streamcart Consent', 'streamcart'),
                __('Streamcart Consent', 'streamcart'),
                'manage_options',
                'streamcart-consent',
                function () {
                    require CASTLEIT_STREAMCART_PLUGIN_DIR . '/includes/consent/view.php';
                }
            );
        }

        public function handle_consent_form()
        {
            if (isset($_POST['streamcart_user_data_consent'])) {
                update_option('streamcart_user_data_consent', $_POST['streamcart_user_data_consent']);
                wp_redirect( admin_url() );
                exit();
            }
        }

    }

endif;

new Streamcart_Consent();

?>
