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

class SC_Catalog_Enqueue {

	/**
	 * Showcase Catalog Front End construct
	 *
	 * @since     1.0.0
	 */
	public function __construct() {

		// $this->options = get_option( 'sc-catalog-options' );
		
		add_action( 'wp_enqueue_scripts', array( $this, 'sc_catalog_scripts' ) );

	}

	/**
	 * Showcase Catalog Front End Scripts
	 * 
	 * @since     1.0.0
	 */
	public function sc_catalog_scripts() {

		wp_register_style( 'sc-catalog-style', SC_URL . '/assets/css/sc-catalog.css', array(), null );
		wp_enqueue_style( 'sc-catalog-style' );

	}


}