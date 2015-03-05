<?php
/**
 * No Cart Front end Functions
 * 
 * @link       http://s2webpress.com
 * @since      1.0.0
 *
 * @package    No_Cart
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly.

class No_Cart_Front {

	/**
	 * No Cart Front End construct
	 *
	 * @since     1.0.0
	 */
	public function __construct() {

		// $this->options = get_option( 'nocart-options' );
		
		add_action( 'wp_enqueue_scripts', array( $this, 'no_cart_scripts' ) );

	}

	/**
	 * No Cart Front End Scripts
	 * 
	 * @since     1.0.0
	 */
	public function no_cart_scripts() {

		wp_enqueue_style( 'no-cart-style', plugins_url( 'assets/css/no-cart.css', __FILE__ )  );

	}


	public function select_display_page() {

		$options = get_option( 'no_cart_general' );

		if ( isset( $options['nocart_archive_id'] ) ) {
			$value = $options['nocart_archive_id'];
		} else {
			$value = null;
		}
		
	}


}