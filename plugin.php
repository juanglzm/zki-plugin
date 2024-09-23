<?php

/**
 * Plugin Name:       ZKI Plugin
 * Description:       A basic boilerplate for starting a WordPress plugin that includes custom blocks.
 * Requires at least: 6.6
 * Requires PHP:      7.4
 * Version:           0.1.0
 * Author:            Juan Antonio
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       zki-plugin
 *
 * @package           ZKI_Plugin
 */

declare(strict_types=1);

use ZKI\Plugin\Activator;
use ZKI\Plugin\Deactivator;
use ZKI\Plugin\Plugin;

if (! defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

define( 'ZKI_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'ZKI_PLUGIN_URI', plugin_dir_url( __FILE__ ) );
define('ZKI_PLUGIN_LANG', plugin_dir_path(__FILE__) . 'languages');

// PSR-4 autoloader.
spl_autoload_register(function ($class) {

	// project-specific namespace prefix
	$prefix = 'ZKI\\Plugin\\';

	// base directory for the namespace prefix
	$base_dir = __DIR__ . '/includes/';

	// does the class use the namespace prefix?
	$len = strlen($prefix);
	if (strncmp($prefix, $class, $len) !== 0) {
		// no, move to the next registered autoloader
		return;
	}

	// get the relative class name
	$relative_class = substr($class, $len);

	// replace the namespace prefix with the base directory, replace namespace
	// separators with directory separators in the relative class name, append
	// with .php
	$file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

	// if the file exists, require it
	if (file_exists($file)) {
		require $file;
	}
});

/**
 * Function that runs during plugin activation.
 * @see https://developer.wordpress.org/reference/functions/register_activation_hook/
 */
register_activation_hook( __FILE__, [ Activator::class, 'activate' ] );

/**
 * Function that runs during plugin deactivation.
 * @see https://developer.wordpress.org/reference/functions/register_deactivation_hook/
 */
register_deactivation_hook( __FILE__, [ Deactivator::class, 'deactivate' ] );

/**
 * Actually execute the plugin.
 *
 * All the plugin hooks are registered inside
 * the main plugin class, so we just need
 * to run the initilizer method.
 *
 * @since    1.0.0
 */
function run_zki_plugin()
{
	$plugin = new Plugin;

	$plugin->run();
}
run_zki_plugin();
