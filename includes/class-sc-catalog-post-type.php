<?php

/**
 * Register all the custom post types and taxonomies
 * 
 * @link       http://s2webpress.com
 * @since      1.0.0
 *
 * @package    SC_Catalog
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly.



class SC_Catalog_CPT {

	/**
	 * Custom Post Type Construct
	 *
	 * @since     1.0.0
	 */
	public function __construct() {

		// $this->options = get_option( 'sc-catalog-options' );

		// register the nocart post type
		add_action( 'init', array( $this, 'register_cpt' ) );

		// register the nocart taxonomy
		add_action( 'init', array( $this, 'register_tax' ) );

	}


	/**
	 * Register sc-catalog custom post type
	 * http://codex.wordpress.org/Function_Reference/register_post_type
	 * 
	 */
	public function register_cpt() {

		$labels = array(
			'name' 					=> __( 'Products',         'sc-catalog' ), 
			'singular_name' 		=> __( 'Product',          'sc-catalog' ), 
			'all_items' 			=> __( 'All Products',     'sc-catalog' ), 
			'add_new' 				=> __( 'Add New Product',  'sc-catalog' ), 
			'add_new_item' 			=> __( 'Add New Product',  'sc-catalog' ),
			'edit' 					=> __( 'Edit Product',     'sc-catalog' ), 
			'edit_item' 			=> __( 'Edit Product',     'sc-catalog' ), 
			'new_item' 				=> __( 'New Product',      'sc-catalog' ), 
			'view_item' 			=> __( 'View Product',     'sc-catalog' ),
			'search_items' 			=> __( 'Search Products',  'sc-catalog' ), 
			'not_found' 			=> __( 'Nothing found. Try creating a new Product.', 'sc-catalog' ), 
			'not_found_in_trash' 	=> __( 'Nothing found in Trash', 'sc-catalog' ),
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

	 	register_post_type( 'sc-catalog', $args );

	}


	public function register_tax() {

		// Adds Category taxonomy for the Showcase Catalog Custom Post Type
		$labels = array(
			'name'              => _x( 'Product Categories', 'taxonomy general name', 'sc-catalog' ),
			'singular_name'     => _x( 'Product Category', 'taxonomy singular name', 'sc-catalog' ),
			'search_items'      => __( 'Search Product Categories', 'sc-catalog' ),
			'all_items'         => __( 'All Product Categories', 'sc-catalog' ),
			'parent_item'       => __( 'Parent Product Category', 'sc-catalog' ),
			'parent_item_colon' => __( 'Parent Product Category:', 'sc-catalog' ),
			'edit_item'         => __( 'Edit Product Category', 'sc-catalog' ),
			'update_item'       => __( 'Update Product Category', 'sc-catalog' ),
			'add_new_item'      => __( 'Add New Product Category', 'sc-catalog' ),
			'new_item_name'     => __( 'New Product Category Name', 'sc-catalog' ),
			'menu_name'         => __( 'Product Category', 'sc-catalog' ),
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

		register_taxonomy( 'sc-catalog-categories', array( 'sc-catalog' ), $args );

	}

}
