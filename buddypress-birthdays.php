<?php
/**
 * BuddyPress Birthday
 *
 * @package           buddypress-birthday
 * @author            Amit Kumar Agrahari
 * @copyright         2023 Amit Kumar Agrahari
 * @license           GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       BuddyPress Birthday
 * Plugin URI:        https://example.com/plugin-name
 * Description:       Display upcoming birthdays of your members.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Amit Kumar Agrahari
 * Author URI:        https://example.com
 * Text Domain:       buddypress-birthday
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Update URI:        https://example.com/my-plugin/
 */

class BuddyBirthday {

	private static $instance = array();

	/**
	 * Absolute path to this plugin directory.
	 *
	 * @var string
	 */
	private $path;

	/**
	 * Absolute url to this plugin directory.
	 *
	 * @var string
	 */
	private $url;

	/**
	 * Plugin basename.
	 *
	 * @var string
	 */
	private $basename;


	protected function __construct() {
		$this->path     = plugin_dir_path( __FILE__ );
		$this->url      = plugin_dir_url( __FILE__ );
		$this->basename = plugin_basename( __FILE__ );

		$this->buddy_birthday_init();
	}

	/**
	 * The method you use to get the BuddyBirthday's instance.
	 */
	public static function get_instance() : BuddyBirthday {
		$cls = static::class;
		if ( ! isset( self::$instance[ $cls ] ) ) {
			self::$instance[ $cls ] = new static();
		}

		return self::$instance[ $cls ];
	}

	public function buddy_birthday_init() {
		add_action( 'plugins_loaded', array( $this, 'buddy_birthday_setup_constants' ), 0 );
		add_action( 'bp_init', array( $this, 'load_textdomain' ), 2 );
		add_action( 'init', array( $this, 'buddy_birthday_block_init' ) );
		add_filter( 'block_categories_all', array( $this, 'buddy_birthday_add_block_category' ), 10, 2 );
	}

	/**
	 * Define constans
	 */
	public function buddy_birthday_setup_constants() {
		define( 'BUDDY_BIRTHDAY_FILE', __FILE__ );
		define( 'BUDDY_BIRTHDAY_URL', $this->get_url() );
		define( 'BUDDY_BIRTHDAY_PATH', $this->get_path() );
		define( 'BUDDY_BIRTHDAY_TEMPLATE_PATH', $this->get_path() . '/templates/' );
	}

	/**
	 * Get plugin url
	 */
	public function get_url() {
		return $this->url;
	}

	/**
	 * Get Plugin Path
	 */
	public function get_path() {
		return $this->path;
	}

	/**
	 * Load translation files
	 */
	public function load_textdomain() {
		load_plugin_textdomain( 'buddypress-birthday', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
	}

	public function buddy_birthday_block_init() {
		register_block_type( __DIR__ . '/build' );
	}

	public function buddy_birthday_add_block_category( $block_categories, $block_editor_context ) {

		if ( ! ( $block_editor_context instanceof WP_Block_Editor_Context ) ) {
			return $block_categories;
		}
		return array_merge(
			$block_categories,
			array(
				array(
					'slug'  => 'wbcom-designs',
					'title' => esc_html__( 'WBCOM Designs', 'buddypress-birthday' ),
					'icon'  => 'lightbulb', // Slug of a WordPress Dashicon or custom SVG
				),
			)
		);
	}

}

function buddy_birthday() {
	return BuddyBirthday::get_instance();
}

buddy_birthday();
