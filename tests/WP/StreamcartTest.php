<?php

namespace Streamcart\WP\Tests\WP;

use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertNotFalse;

class StreamcartTest extends TestCase
{

    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * @covers \Streamcart::is_user_data_consent_checked
     * @return void
     */
    public function test_is_user_data_consent_checked_without_user_consent(): void
    {
        assertFalse(\Streamcart::instance()->is_user_data_consent_checked());
    }

    /**
     * @covers \Streamcart::init_hooks
     * @return void
     */
    public function test_init_hooks_without_user_consent(): void
    {
        $instance = \Streamcart::instance();

        assertNotFalse( \has_action( 'plugins_loaded', [ $instance , 'load_textdomain' ] ) );
        assertNotFalse( \has_action( 'admin_notices', [ $instance, 'add_admin_user_data_consent_notice' ] ) );
        assertNotFalse( \has_action( 'after_plugin_row_meta', [ $instance, 'add_admin_user_data_consent_plugin_row_notice' ] ) );
        assertFalse( \has_action( 'wp_head', [ $instance, 'add_script' ] ) );
    }

    /**
     * @covers \Streamcart::init_hooks
     * @return void
     */
    public function test_init_hooks_with_user_consent(): void
    {
        global $wpdb;

        $insertResult = $wpdb->insert(
            $wpdb->prefix . 'options',
            [
                'option_name' => 'streamcart_user_data_consent',
                'option_value' => 'on',
                'autoload' => 'auto'
            ]
        );

        if(!$insertResult){
            throw new \Exception("Could not insert into " . $wpdb->options);
        }

        \Streamcart::dispose();
        $instance = \Streamcart::instance();

        assertNotFalse( \has_action( 'plugins_loaded', [ $instance , 'load_textdomain' ] ) );
        assertFalse( \has_action( 'admin_notices', [ $instance, 'add_admin_user_data_consent_notice' ] ) );
        assertFalse( \has_action( 'after_plugin_row_meta', [ $instance, 'add_admin_user_data_consent_plugin_row_notice' ] ) );
        assertNotFalse( \has_action( 'wp_head', [ $instance, 'add_script' ] ) );

        $wpdb->delete($wpdb->options, ['option_name' => 'streamcart_user_data_consent']);
    }

}
