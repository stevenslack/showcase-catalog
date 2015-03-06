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

		$options = get_option( 'sc_catalog_general' );

		$archive_slug = 'catalog';

		if ( isset( $options['sc_catalog_archive_id'] ) ) {
			$archive_slug = get_post( intval( $options['sc_catalog_archive_id'] ) )->post_name;
		}

		$label = array(
			'name'                => __( 'Catalog', 'sc-catalog' ), 
			'singular_name'       => __( 'Item', 'sc-catalog' ), 
			'all_items'           => __( 'All Catalog Items', 'sc-catalog' ), 
			'add_new'             => __( 'Add New Item', 'sc-catalog' ), 
			'add_new_item'        => __( 'Add New Item', 'sc-catalog' ),
			'edit'                => __( 'Edit Item', 'sc-catalog' ), 
			'edit_item'           => __( 'Edit Item', 'sc-catalog' ), 
			'new_item'            => __( 'New Item', 'sc-catalog' ), 
			'view_item'           => __( 'View Item', 'sc-catalog' ),
			'search_items'        => __( 'Search Catalog Items', 'sc-catalog' ), 
			'not_found'           => __( 'Nothing found. Try creating a new Item.', 'sc-catalog' ), 
			'not_found_in_trash'  => __( 'Nothing found in Trash', 'sc-catalog' ),
			'parent_item_colon'   => '',
			);
			
		$args = array(
			'labels'              => $labels,
			'public'              => true,
			'publicly_queryable'  => true,
			'exclude_from_search' => false,
			'show_ui'             => true,
			'show_in_nav_menus'   => true,
			'show_in_menu'        => true,
			'query_var'           => true,
			'menu_position'       => 20,
			'menu_icon'           => 'dashicons-store',	
			'rewrite'             => array( 'slug' => $archive_slug, 'with_front' => false ), 	
			'has_archive'         => true, 	
			'capability_type'     => 'page',
			'hierarchical'        => false,
			'supports'            => array( 'title', 'editor', 'thumbnail', 'page-attributes' ),
		);

	 	register_post_type( 'sc-catalog', $args );
	}

	/**
	 * Register the Catalog Catagories taxonomy
	 */
	public function register_tax() {

			// Adds Category taxonomy for the Showcase Catalog Custom Post Type
		$labels = array(
			'name'              => _x( 'Catalog Categories', 'taxonomy general name', 'sc-catalog' ),
			'singular_name'     => _x( 'Catalog Category', 'taxonomy singular name', 'sc-catalog' ),
			'search_items'      => __( 'Search Catalog Categories', 'sc-catalog' ),
			'all_items'         => __( 'All Catalog Categories', 'sc-catalog' ),
			'parent_item'       => __( 'Parent Catalog Category', 'sc-catalog' ),
			'parent_item_colon' => __( 'Parent Catalog Category:', 'sc-catalog' ),
			'edit_item'         => __( 'Edit Catalog Category', 'sc-catalog' ),
			'update_item'       => __( 'Update Catalog Category', 'sc-catalog' ),
			'add_new_item'      => __( 'Add New Catalog Category', 'sc-catalog' ),
			'new_item_name'     => __( 'New Catalog Category Name', 'sc-catalog' ),
			'menu_name'         => __( 'Catalog Categories', 'sc-catalog' ),
			);
			
		$args = array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_in_nav_menus' => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'catalog-category', 'with_front' => false ), 
		);

		register_taxonomy( 'sc-catalog-categories', array( 'sc-catalog' ), $args );
	}

}
