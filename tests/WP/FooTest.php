<?php

namespace Streamcart\WP\Tests\WP;

use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertNotFalse;

class FooTest extends TestCase
{
    /**
     * @covers \Streamcart::is_user_data_consent_checked
     * @return void
     */
    public function test_is_user_data_consent_checked_initial_state()
    {
        assertFalse(\Streamcart::instance()->is_user_data_consent_checked());
    }

    /**
     * @covers \Streamcart::init_hooks
     * @return void
     */
    public function test_register_hooks_with_error_set() {
        assertNotFalse( \has_action( 'admin_notices', [ \Streamcart::instance(), 'add_admin_user_data_consent_notice' ] ) );
    }

}
