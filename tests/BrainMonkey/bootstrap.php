<?php

use Yoast\WPTestUtils\BrainMonkey;

require_once __DIR__ . '/../../vendor/yoast/wp-test-utils/src/BrainMonkey/bootstrap.php';
require_once __DIR__ . '/../../vendor/autoload.php';

BrainMonkey\makeDoublesForUnavailableClasses(
    [
        'WP',
        'WP_Post',
        'WP_Query',
        'WP_Rewrite',
        'WP_Roles',
        'WP_Term',
        'WP_User',
        'wpdb',
    ]
);
