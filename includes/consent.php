<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

if ( ! class_exists( 'Streamcart_Consent' ) ) :

    class Streamcart_Consent {

        public function __construct() {
            add_action( 'admin_menu', array( $this, 'add_admin_menu' ) );
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
    }

endif;

new Streamcart_Consent();

?>
