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

if ( ! class_exists( 'Streamcart' ) ) :

    final class Streamcart {

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
        }

        private function init_hooks() {
            add_action( 'plugins_loaded', array( $this, 'load_textdomain' ) );
            add_action( 'wp_head', array( $this, 'add_streamcart_script' ) );
        }

        public function load_textdomain() {
            load_plugin_textdomain( 'streamcart', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
        }

        public function add_streamcart_script() {
            $public_key = get_option( 'streamcart_public_key' );
            if (!empty($public_key)) {
                echo '<script async type="text/javascript" streamcart-token="' . esc_attr( $public_key ) . '" src="https://cdn.streamcart.io/main.js"></script>';
            }
        }
    }

endif;

function streamcart() {
    return Streamcart::instance();
}

streamcart();
?>
