<?php

/**
 * Main plugin file.
 *
 * @since      1.0.0
 *
 * @package    ZKI_Plugin
 */

declare(strict_types=1);

namespace ZKI\Plugin;

class Plugin
{

	/**
	 * Plugin text domain
	 *
	 * @var string
	 */
	protected $slug;

	/**
	 * Current plugin version
	 *
	 * @var string
	 */
	protected $version;

	public function __construct()
	{
		$this->version = '0.1.0';
		$this->slug = 'zki-plugin';
	}

	/**
	 * Register all the actions and filters that
	 * the plugin will use.
	 *
	 * @since    1.0.0
	 */
	private function set_plugin_hooks()
	{
		// Set locale.
		add_action('plugins_loaded', [$this, 'load_plugin_textdomain']);

		// Register blocks.
		add_action('init', [$this, 'register_plugin_blocks']);

		// Editor Scripts.
		add_action('enqueue_block_editor_assets', [$this, 'enqueue_editor_assets']);

		// Admin Scripts.
		add_action('enqueue_block_editor_assets', [$this, 'enqueue_admin_assets']);

		// Frontend Scripts.
		add_action('wp_enqueue_scripts', [$this, 'enqueue_frontend_assets']);
	}

	/**
	 * Loads a plugin's translated strings.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain()
	{
		load_plugin_textdomain(
			$this->slug,
			false,
			ZKI_PLUGIN_LANG
		);
	}

	/**
	 * Registers the block using the metadata loaded from
	 * the 'block.json' file.
	 *
	 * Behind the scenes, it registers also all assets so
	 * they can be enqueued through the block editor in
	 * the corresponding context.
	 *
	 * @since    1.0.0
	 */
	public function register_plugin_blocks()
	{
		$plugin_blocks = [
			'block-static',
			'block-dynamic',
		];

		foreach ($plugin_blocks as $block) {
			register_block_type(ZKI_PLUGIN_DIR . 'build/blocks/' . $block);
		}
	}

	/**
	 * Load the scripts that will be used to extend
	 * the WordPress Block Editor.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_editor_assets()
	{
		$editor_assets = require_once ZKI_PLUGIN_DIR . 'build/zki-plugin-editor.asset.php';

		wp_enqueue_script(
			'zki-plugin-editor',
			ZKI_PLUGIN_URI . 'build/zki-plugin-editor.js',
			$editor_assets['dependencies'],
			$editor_assets['version'],
			true
		);

		wp_enqueue_style(
			'zki-plugin-editor',
			ZKI_PLUGIN_URI . 'build/zki-plugin-editor.css',
			[],
			$editor_assets['version']
		);
	}

	/**
	 * Load scripts and styles that will be used
	 * inside the WordPress admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_admin_assets()
	{
		$admin_assets = require_once ZKI_PLUGIN_DIR . 'build/zki-plugin-admin.asset.php';

		wp_enqueue_script(
			'zki-plugin-frontend',
			ZKI_PLUGIN_URI . 'build/zki-plugin-admin.js',
			$admin_assets['dependencies'],
			$admin_assets['version'],
			true
		);

		wp_enqueue_style(
			'zki-plugin-frontend',
			ZKI_PLUGIN_URI . 'build/zki-plugin-admin.css',
			[],
			$admin_assets['version']
		);
	}

	/**
	 * Load scripts and styles that will be used
	 * in the frontend part of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_frontend_assets()
	{
		$front_end_assets = require_once ZKI_PLUGIN_DIR . 'build/zki-plugin-frontend.asset.php';

		wp_enqueue_script(
			'zki-plugin-frontend',
			ZKI_PLUGIN_URI . 'build/zki-plugin-frontend.js',
			$front_end_assets['dependencies'],
			$front_end_assets['version'],
			true
		);

		wp_enqueue_style(
			'zki-plugin-frontend',
			ZKI_PLUGIN_URI . 'build/zki-plugin-frontend.css',
			[],
			$front_end_assets['version']
		);
	}

	/**
	 * Get plugin current version
	 *
	 * @since     1.0.0
	 * @return    string
	 */
	public static function get_version(): string
	{
		return self::$version;
	}

	/**
	 * Get plugin slug/textdomain
	 *
	 * @since     1.0.0
	 * @return    string
	 */
	public static function get_slug(): string
	{
		return self::$slug;
	}

	/**
	 * Execute all the plugin code
	 *
	 * @since     1.0.0
	 * @return    void
	 */
	public function run()
	{
		$this->set_plugin_hooks();
	}
}
