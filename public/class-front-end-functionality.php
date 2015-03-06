<?php
/**
 * Showcase Catalog Front end Functions
 * 
 * @link       http://s2webpress.com
 * @since      1.0.0
 *
 * @package    SC_Catalog
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly.

class SC_Catalog_Front {

	/**
	 * Showcase Catalog Front End construct
	 *
	 * @since     1.0.0
	 */
	public function __construct() {

		// $this->options = get_option( 'sc-catalog-options' );
		
		add_action( 'wp_enqueue_scripts', array( $this, 'sc_catalog_scripts' ) );
		add_filter( 'post_class', array( $this, 'sc_catalog_post_class' ) );

	}

	/**
	 * Showcase Catalog Front End Scripts
	 * 
	 * @since     1.0.0
	 */
	public function sc_catalog_scripts() {

		wp_enqueue_style( 'sc-catalog-style', plugins_url( 'assets/css/sc-catalog.css', __FILE__ )  );

	}


	public function select_display_page() {

		$options = get_option( 'sc_catalog_general' );

		if ( isset( $options['sc_catalog_archive_id'] ) ) {
			$value = $options['sc_catalog_archive_id'];
		} else {
			$value = null;
		}
		
	}

	/**
	 * Custom Archive Post Class
	 * @since 1.0.0
	 *
	 * Breaks the posts into three columns
	 * @link http://www.billerickson.net/code/grid-loop-using-post-class
	 *
	 * @param array $classes
	 * @return array
	 */
	function sc_catalog_post_class( $classes ) {
		global $wp_query;
		
		if ( $wp_query->is_post_type_archive( 'sc-catalog' ) ) {
			$classes[] = 'one-third';
			if( 0 == $wp_query->current_post || 0 == $wp_query->current_post % 3 )
				$classes[] = 'first';
			return $classes;
		} else {
			return $classes;
		}
	}


}