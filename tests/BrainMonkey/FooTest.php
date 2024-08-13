<?php

namespace Streamcart\WP\Tests\BrainMonkey;

class FooTest extends TestCase
{
    protected function set_up() {
        parent::set_up();
        $this->instance = \Streamcart::instance();
    }

    public function test_register_hooks_with_error_set() {
        $this->assertNotFalse( \has_action( 'admin_notices', [ $this->instance, 'add_admin_user_data_consent_notice' ] ) );
    }
}
