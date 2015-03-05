<?php
/**
 * Showcase Catalog Template Functions
 * 
 * These functions can be overritten with actions / filters
 *
 * @version     1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


/**
 * Get Showcase Catalog Item
 * 
 * @return object the Showcase Catalog Item
 */
function get_sc_catalog_item() {

	global $post;

	return new SC_Catalog_Item( $post->ID );

}	


if ( ! function_exists( 'sc_catalog_content_wrap_open' ) ) {

	/**
	 * Output the start of the page wrapper.
	 */
	function sc_catalog_content_wrap_open() {
		?>
		<div id="main" class="site-main sc-catalog-wrap" role="main">
		<?php
	}
}


if ( ! function_exists( 'sc_catalog_content_wrap_close' ) ) {

	/**
	 * Output the start of the page wrapper.
	 */
	function sc_catalog_content_wrap_close() {
		?>
		</div><!-- /.sc-catalog-wrap -->
		<?php
	}
}


if ( ! function_exists( 'sc_catalog_single_image' ) ) {

	/**
	 * The single-content-item featured image
	 * @return string
	 */
	function sc_catalog_single_image() {

		if ( has_post_thumbnail() ) {
		?>
		<div class="item-image">
			<?php the_post_thumbnail( 'sc_catalog_single' ); ?>
		</div>
		<!-- /.item-image -->
		<?php
		}

	}
}


if ( ! function_exists( 'sc_catalog_item_single_title' ) ) {

	/**
	 * Output the items title
	 * 
	 * @return string
	 */
	function sc_catalog_item_single_title() {
		
		?>
		<h1 itemprop="name" class="sc-catalog-item-title entry-title"><?php the_title(); ?></h1>
		<?php

	}

}


if ( ! function_exists( 'sc_catalog_html_price' ) ) {

	/**
	 * The Showcase Catalog Item HTML Price
	 * 
	 * @return string html 
	 */
	function sc_catalog_html_price() {

		$product = get_sc_catalog_item();

		echo $product->adjusted_price();

	}
}


if ( ! function_exists( 'sc_catalog_the_sku' ) ) {

	/**
	 * The Showcase Catalog item SKU
	 * @return string
	 */
	function sc_catalog_the_sku() {

		$product = get_sc_catalog_item();
		$sku = $product->get_sku();

		if ( ! $sku )
			return;

		printf( '<div class="sc-catalog-sku">%1$s: %2$s</div>', __( 'SKU', 'sc-catalog' ), $sku );
		
	}

}


if ( ! function_exists( 'sc_catalog_item_content' ) ) {
	
	/**
	 * Showcase Catalog Item Content
	 * 
	 * @return string the_content
	 */
	function sc_catalog_item_content() {
		?>
		<div class="sc-catalog-item-description"><?php the_content(); ?></div><!-- /.nc-item-description -->
		<?php
	}
}

