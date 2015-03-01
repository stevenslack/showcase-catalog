<?php

/**
 * Register all the custom post types and taxonomies
 * 
 * @link       http://s2webpress.com
 * @since      1.0.0
 *
 * @package    No_Cart
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly.



class No_Cart_CPT {

	/**
	 * Custom Post Type Construct
	 *
	 * @since     1.0.0
	 */
	public function __construct() {

		// $this->options = get_option( 'nocart-options' );

		// register the nocart post type
		add_action( 'init', array( $this, 'register_cpt' ) );

		// register the nocart taxonomy
		add_action( 'init', array( $this, 'register_tax' ) );

	}


	/**
	 * Register no-cart custom post type
	 * http://codex.wordpress.org/Function_Reference/register_post_type
	 * 
	 */
	public function register_cpt() {

		$labels = array(
			'name' 					=> __( 'Products',         'no-cart' ), 
			'singular_name' 		=> __( 'Product',          'no-cart' ), 
			'all_items' 			=> __( 'All Products',     'no-cart' ), 
			'add_new' 				=> __( 'Add New Product',  'no-cart' ), 
			'add_new_item' 			=> __( 'Add New Product',  'no-cart' ),
			'edit' 					=> __( 'Edit Product',     'no-cart' ), 
			'edit_item' 			=> __( 'Edit Product',     'no-cart' ), 
			'new_item' 				=> __( 'New Product',      'no-cart' ), 
			'view_item' 			=> __( 'View Product',     'no-cart' ),
			'search_items' 			=> __( 'Search Products',  'no-cart' ), 
			'not_found' 			=> __( 'Nothing found. Try creating a new Product.', 'no-cart' ), 
			'not_found_in_trash' 	=> __( 'Nothing found in Trash', 'no-cart' ),
			'parent_item_colon' 	=> '',
		);

		$args = array(
			'labels'				=> $labels,
			'public' 				=> true,
			'publicly_queryable' 	=> true,
			'exclude_from_search' 	=> false,
			'show_ui' 				=> true,
			'show_in_nav_menus'		=> true,
			'show_in_menu'			=> true,
			'query_var'			 	=> true,
			'menu_position' 		=> 20,
			'menu_icon' 			=> 'dashicons-cart',	
			'rewrite'				=> array( 'slug' => 'products', 'with_front' => false ), 	
			'has_archive' 			=> true, 	
			'capability_type' 		=> 'page',
			'hierarchical' 			=> false,
			'supports' 				=> array( 'title', 'editor', 'thumbnail', 'page-attributes' ),
	 	);

	 	register_post_type( 'no-cart', $args );

	}


	public function register_tax() {

		// Adds Category taxonomy for the No Cart Custom Post Type
		$labels = array(
			'name'              => _x( 'Product Categories', 'taxonomy general name', 'no-cart' ),
			'singular_name'     => _x( 'Product Category', 'taxonomy singular name', 'no-cart' ),
			'search_items'      => __( 'Search Product Categories', 'no-cart' ),
			'all_items'         => __( 'All Product Categories', 'no-cart' ),
			'parent_item'       => __( 'Parent Product Category', 'no-cart' ),
			'parent_item_colon' => __( 'Parent Product Category:', 'no-cart' ),
			'edit_item'         => __( 'Edit Product Category', 'no-cart' ),
			'update_item'       => __( 'Update Product Category', 'no-cart' ),
			'add_new_item'      => __( 'Add New Product Category', 'no-cart' ),
			'new_item_name'     => __( 'New Product Category Name', 'no-cart' ),
			'menu_name'         => __( 'Product Category', 'no-cart' ),
		);

		$args = array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_in_nav_menus'	=> true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'product-category', 'with_front' => false ), 
		);

		register_taxonomy( 'no-cart-categories', array( 'no-cart' ), $args );

	}

}
