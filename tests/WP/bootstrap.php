<?php

echo 'Starting Integration Tests' . PHP_EOL;

use Yoast\WPTestUtils\WPIntegration;

ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);

if ( getenv( 'WP_PLUGIN_DIR' ) !== false ) {
    define( 'WP_PLUGIN_DIR', getenv( 'WP_PLUGIN_DIR' ) );
}

$GLOBALS['wp_tests_options'] = [
    'active_plugins' => [ 'streamcart/streamcart.php' ],
];

require_once dirname( __DIR__ ) . '/../vendor/yoast/wp-test-utils/src/WPIntegration/bootstrap-functions.php';

$_tests_dir = WPIntegration\get_path_to_wp_test_dir();
require_once $_tests_dir . 'includes/functions.php';

// Add plugin to active mu-plugins - to make sure it gets loaded.
\tests_add_filter(
    'muplugins_loaded',
    /**
     * Manually load the plugin being tested.
     */
    static function () {
        require \dirname( __DIR__, 2 ) . '/streamcart.php';
    }
);

\tests_add_filter(
    'plugins_url',
    /**
     * Filter the plugins URL to pretend the plugin is installed in the test environment.
     *
     * @param string $url    The complete URL to the plugins directory including scheme and path.
     * @param string $path   Path relative to the URL to the plugins directory. Blank string
     *                       if no path is specified.
     * @param string $plugin The plugin file path to be relative to. Blank string if no plugin
     *                       is specified.
     *
     * @return string
     */
    static function ( $url, $path, $plugin ) {
        $plugin_dir = \dirname( __DIR__, 2 );
        if ( $plugin === $plugin_dir . '/streamcart.php' ) {
            $url = \str_replace( \dirname( $plugin_dir ), '', $url );
        }

        return $url;
    },
    10,
    3
);

WPIntegration\bootstrap_it();
