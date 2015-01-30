<?php
/**
 * No Cart Template Hooks
 *
 * Action/filter hooks used for No Cart functions/templates
 *
 * @version     1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * No Cart Content Wrappers
 */
add_action( 'no_cart_before', 'nc_content_wrap_open',  10 );
add_action( 'no_cart_after',  'nc_content_wrap_close', 10 );


/**
 * No Cart single content hooks
 */
add_action( 'no_cart_single_image', 'nc_single_image', 5 );
add_action( 'no_cart_item_details', 'nc_item_single_title', 5 );
add_action( 'no_cart_item_content', 'nc_item_content', 10 );