<?php
/**
 * Showcase Catalog Template Hooks
 *
 * Action/filter hooks used for Showcase Catalog functions/templates
 *
 * @version     1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Showcase Catalog Content Wrappers
 */
add_action( 'sc_catalog_before', 'sc_catalog_content_wrap_open',  10 );
add_action( 'sc_catalog_after',  'sc_catalog_content_wrap_close', 10 );


/**
 * Showcase Catalog single content hooks
 */
add_action( 'sc_catalog_single_image', 'sc_catalog_single_image', 5 );
add_action( 'sc_catalog_item_details', 'sc_catalog_item_single_title', 5 );
add_action( 'sc_catalog_item_details', 'sc_catalog_html_price', 10 );
add_action( 'sc_catalog_item_details', 'sc_catalog_the_sku', 15 );
add_action( 'sc_catalog_item_content', 'sc_catalog_item_content', 10 );