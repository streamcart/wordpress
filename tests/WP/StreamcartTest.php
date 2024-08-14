<?php

namespace Streamcart\WP\Tests\WP;

use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertNotFalse;
use function PHPUnit\Framework\assertNull;

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

        $consentPage = $instance->getObject(\Streamcart_Consent::KEY);

        assertNotFalse( \has_action( 'admin_menu', [ $consentPage , 'add_admin_menu' ] ) );
        assertNotFalse( \has_action( 'admin_post_streamcart_consent_form', [ $consentPage , 'handle_consent_form' ] ) );

        $adminSettingsPage = $instance->getObject(\Streamcart_Admin::KEY);

        assertNotFalse( \has_action( 'admin_menu', [ $adminSettingsPage , 'add_admin_menu' ] ) );
        assertNotFalse( \has_action( 'admin_init', [ $adminSettingsPage , 'settings_init' ] ) );
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

        $adminSettingsPage = \Streamcart::instance()->getObject(\Streamcart_Admin::KEY);

        assertNotFalse( \has_action( 'admin_menu', [ $adminSettingsPage , 'add_admin_menu' ] ) );
        assertNotFalse( \has_action( 'admin_init', [ $adminSettingsPage , 'settings_init' ] ) );

        \Streamcart::dispose();
        $instance =
            \Streamcart::instance();
        $instance->includes();

        assertNotFalse( \has_action( 'plugins_loaded', [ $instance , 'load_textdomain' ] ) );
        assertFalse( \has_action( 'admin_notices', [ $instance, 'add_admin_user_data_consent_notice' ] ) );
        assertFalse( \has_action( 'after_plugin_row_meta', [ $instance, 'add_admin_user_data_consent_plugin_row_notice' ] ) );
        assertNotFalse( \has_action( 'wp_head', [ $instance, 'add_script' ] ) );

        $wpdb->delete($wpdb->options, ['option_name' => 'streamcart_user_data_consent']);

        assertNull($instance->getObject(\Streamcart_Consent::KEY));
    }

}
