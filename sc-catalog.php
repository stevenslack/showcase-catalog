<?php
/**
 * Showcase Catalog
 *
 * @package   SC_Catalog
 * @author    Steven Slack <steven@s2webpress.com>
 * @license   GPL-2.0+
 * @link      http://s2webpress.com/plugins/sc-catalog
 * @copyright 2014 S2 Web LLC
 *
 * @wordpress-plugin
 * Plugin Name:       Showcase Catalog - Featured Products
 * Plugin URI:        s2webpress.com/plugins/sc-catalog
 * Description:       Add products to your site without having a shopping cart. That's right, this plugin has no shopping cart. This may be useful if you want to showcase products in your brick and morter location but not have to support an online store. Many of the same features as a regular shopping cart such as displaying the price, SKU, sale price, product categories and tags. 
 * Version:           1.0.0
 * Author:            S2 Web
 * Author URI:        http://s2webpress.com
 * Text Domain:       sc-catalog
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages
 */


// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}


class SC_Catalog {


	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	private static $instance = null;


	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;


	/**
	 * The custom post type.
	 * 
	 * @access  public
	 * @since   1.0.0
	 * @var     string
	 */
	public $cpt;

	/**
	 * The custom meta.
	 * 
	 * @access  public
	 * @since   1.0.0
	 * @var     string
	 */
	public $meta;


	/**
	 * The settings page
	 * 
	 * @access  public
	 * @since   1.0.0
	 * @var     string
	 */
	public $settings;


	/**
	 * Initialize the plugin by setting localization and loading public scripts
	 * and styles.
	 *
	 * @since     1.0.0
	 */
	private function __construct() {

		$this->version = '1.0.0';

		$this->load_dependencies();

		// registers the Custom Post Type
		$this->cpt = new SC_Catalog_CPT();
		$this->meta = new SC_Catalog_Meta();

		if ( is_admin() ) {
    		$this->settings = new SC_Catalog_Settings();
    	}

    	// front facing functions
    	new SC_Catalog_Front();

		// Load plugin text domain
		add_action( 'plugins_loaded', array( $this, 'load_sc_catalog_textdomain' ) );

		add_action( 'after_setup_theme', array( $this, 'display_image_sizes' ) );

	}


	/**
	 * Define the internationalization functionality
	 *
	 * Loads and defines the internationalization files for this plugin
	 * so that it is ready for translation.
	 */ 
	function load_sc_catalog_textdomain() {

		$domain = 'sc-catalog';

		$locale = apply_filters( 'plugin_locale', get_locale(), $domain );

		load_textdomain( $domain, trailingslashit( WP_LANG_DIR ) . $domain . '/' . $domain . '-' . $locale . '.mo' );
		load_plugin_textdomain( $domain, false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );

	}


	/**
	 * Load Plugin Files
	 * @return [type] [description]
	 */
	private function load_dependencies() {

		require_once plugin_dir_path( __FILE__ ) . 'includes/class-sc-catalog-post-type.php';
		require_once plugin_dir_path( __FILE__ ) . 'admin/class-sc-catalog-metaboxes.php';
		require_once plugin_dir_path( __FILE__ ) . 'includes/class-sc-catalog-item.php';
		require_once plugin_dir_path( __FILE__ ) . 'includes/sc-catalog-core.php';
		require_once plugin_dir_path( __FILE__ ) . 'includes/sc-catalog-template-hooks.php';
		require_once plugin_dir_path( __FILE__ ) . 'includes/sc-catalog-template-functions.php';
		require_once plugin_dir_path( __FILE__ ) . 'admin/class-sc-catalog-settings.php';
		require_once plugin_dir_path( __FILE__ ) . 'public/class-front-end-functionality.php';

	}


	/**
	 * Return an instance of this class.
	 *
	 * @since     1.0.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}


	/**
	 * Cloning is forbidden.
	 *
	 * @since 1.0.0
	 */
	public function __clone () {

		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?' ), $this->version );

	} // End __clone ()


	/**
	 * Unserializing instances of this class is forbidden.
	 *
	 * @since 1.0.0
	 */
	public function __wakeup () {

		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?' ), $this->version );

	} // End __wakeup ()


	/**
	 * The Activation function. Runs when the plugin is activated
	 * 
	 * @since      1.0.0
	 */
	public static function activate() {

		/** post types are registered on 
		 *  activation and rewrite rules are flushed.
		 */ 
		$sc_catalog_cpt = new SC_Catalog_CPT();
		$sc_catalog_cpt->register_cpt();

		flush_rewrite_rules();

	}


	/**
	 * Add the image sizes set in the options page
	 * 
	 */
	public function display_image_sizes() {

		// Post thumbnails
		if ( ! current_theme_supports( 'post-thumbnails' ) ) {
			add_theme_support( 'post-thumbnails' );
		}
		add_post_type_support( 'sc-catalog', 'thumbnail' );

		// Get General Page Options
		$options = get_option( 'sc_catalog_general' );

		add_image_size( 'sc_catalog_single', $options['single-width'], $options['single-height'], $options['single-crop'] );
		add_image_size( 'sc_catalog_catalog', $options['catalog-width'], $options['catalog-height'], $options['catalog-crop'] );

	}

}


register_activation_hook( __FILE__, array( 'SC_Catalog', 'activate' ) );
register_deactivation_hook( __FILE__, 'flush_rewrite_rules' );


if ( ! function_exists( 'sc_catalog' ) ) {

	function sc_catalog() {

		$nocart = SC_Catalog::get_instance();
		
		return $nocart;
	}

}

sc_catalog();