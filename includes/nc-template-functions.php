<?php
/**
 * No Cart Template Functions
 * 
 * These functions can be overritten with actions / filters
 *
 * @version     1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


if ( ! function_exists( 'nc_content_wrap_open' ) ) {

	/**
	 * Output the start of the page wrapper.
	 */
	function nc_content_wrap_open() {
		?>
		<div id="main" class="site-main no-cart-wrap" role="main">
		<?php
	}
}


if ( ! function_exists( 'nc_content_wrap_close' ) ) {

	/**
	 * Output the start of the page wrapper.
	 */
	function nc_content_wrap_close() {
		?>
		</div><!-- /.no-cart-wrap -->
		<?php
	}
}