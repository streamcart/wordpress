<?php
/*
 * Plugin Name: Streamcart
 * Version: 0.1.0
 * Author: CastleIt
 * Author URI: https://castleit.io/
 * Text Domain: streamcart
 * Domain Path: /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

define('CASTLEIT_STREAMCART_VERSION', '0.1.0');
define('CASTLEIT_STREAMCART_PLUGIN_DIR', __DIR__);

if ( ! class_exists( 'Streamcart' ) ) :

    final class Streamcart {

        private $is_user_data_consent_checked = null;
        private static $instance = null;

        private function __construct() {
            $this->includes();
            $this->init_hooks();
        }

        public static function instance() {
            if ( is_null( self::$instance ) ) {
                self::$instance = new self();
            }
            return self::$instance;
        }

        private function includes() {
            include_once dirname( __FILE__ ) . '/includes/admin.php';

            if(!$this->is_user_data_consent_checked()) {
                include_once dirname( __FILE__ ) . '/includes/consent.php';
            }
        }

        private function init_hooks() {
            add_action( 'plugins_loaded', array( $this, 'load_textdomain' ) );

            if(!$this->is_user_data_consent_checked()) {
                add_action( 'admin_notices', array( $this, 'add_admin_user_data_consent_notice' ) );
                add_action( 'after_plugin_row_meta', array( $this, 'display_as_mu_plugin' ), 10, 1 );
            } else {
                add_action( 'wp_head', array( $this, 'add_script' ) );
            }

        }

        public function is_user_data_consent_checked()
        {
            if(null === $this->is_user_data_consent_checked) {
                $this->is_user_data_consent_checked = boolval(get_option('streamcart_user_data_consent'));
            }

            return $this->is_user_data_consent_checked;
        }

        public function add_admin_user_data_consent_notice()
        {
            $screen = get_current_screen();
            if (!$screen) {
                return;
            }
            echo '<div class="notice notice-error is-dismissible"><p>';
            echo 'Você precisa consentir com os termos pra usar o plugin: <a href="/wp-admin/admin.php?page=streamcart-consent">AQUI</a>';
            echo '</p></div>';
        }

        public function load_textdomain() {
            load_plugin_textdomain( 'streamcart', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
        }

        public function display_as_mu_plugin( $plugin_file ) {
            if ( strpos( $plugin_file, basename(__FILE__) )  ) {
                echo '<div>Você precisa consentir com os termos pra usar o plugin: <a href="/wp-admin/admin.php?page=streamcart-consent">AQUI</a></div>';
            }
        }

        public function add_script() {
            $public_key = get_option( 'streamcart_public_key' );
            if (!empty($public_key)) {
                echo '<script async type="text/javascript" streamcart-token="' . esc_attr( $public_key ) . '" src="https://cdn.streamcart.io/main.js"></script>';
            }
        }
    }

endif;

Streamcart::instance();
?>
