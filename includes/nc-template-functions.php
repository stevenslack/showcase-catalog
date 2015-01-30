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


if ( ! function_exists( 'nc_single_image' ) ) {

	/**
	 * The single-content-item featured image
	 * @return string
	 */
	function nc_single_image() {

		if ( has_post_thumbnail() ) {
		?>
		<div class="item-image">
			<?php the_post_thumbnail( array( 450, 450 ) ); ?>
		</div>
		<!-- /.item-image -->
		<?php
		}

	}
}


if ( ! function_exists( 'nc_item_single_title' ) ) {

	/**
	 * Output the items title
	 * 
	 * @return string
	 */
	function nc_item_single_title() {
		?>
		<h1 itemprop="name" class="nc-item-title entry-title"><?php the_title(); ?></h1>
		<?php
	}

}


if ( ! function_exists( 'nc_item_content' ) ) {
	
	/**
	 * No Cart Item Content
	 * 
	 * @return string the_content
	 */
	function nc_item_content() {
		?>
		<div class="nc-item-description"><?php the_content(); ?></div><!-- /.nc-item-description -->
		<?php
	}
}