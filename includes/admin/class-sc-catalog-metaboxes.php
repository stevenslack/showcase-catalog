<?php
/**
 * Showcase Catalogs Custom Metaboxes
 * 
 * @link       http://s2webpress.com
 * @since      1.0.0
 *
 * @package    SC_Catalog
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly.

class SC_Catalog_Meta {


	/**
	 * Showcase Catalog Metaboxes construct
	 *
	 * @since     1.0.0
	 */
	public function __construct() {

		// $this->options = get_option( 'sc-catalog-options' );

		// register Showcase Catalog metaboxes
		add_action( 'add_meta_boxes', array( $this, 'add_sc_catalog_metaboxes' ) );

		// Save meta
		add_action( 'save_post', array( $this, 'save_meta' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_styles' ) );

	}


	/**
	 * Add the Meta Box to the sc-catalog custom post type
	 */
	public function add_sc_catalog_metaboxes() {

		add_meta_box( 
			'sc-catalog-meta', // HTML 'id' attribute of the edit screen section
			__( 'Product Attributes', 'sc-catalog' ), 
			array( $this, 'sc_catalog_meta_callback' ), 
			'sc-catalog',
			'normal',
			'default'
		);

	}


	public function sc_catalog_meta_callback( $post ) {

		wp_nonce_field( basename( __FILE__ ), 'sc_catalog_nonce' );
		$sc_catalog_meta = get_post_meta( $post->ID );

		?>

		<p>
			<label for="sc-catalog-sku" class="short sc-catalog-title"><?php _e( 'SKU:', 'sc-catalog' )?></label>
			<input type="text" name="sc-catalog-sku" id="sc-catalog-sku" value="<?php if ( isset ( $sc_catalog_meta['sc-catalog-sku'] ) ) echo $sc_catalog_meta['sc-catalog-sku'][0]; ?>" />
		</p>
		<p>
			<label for="sc-catalog-price" class="short sc-catalog-title"><?php _e( 'Price:', 'sc-catalog' )?></label>
			<input type="text" name="sc-catalog-price" id="sc-catalog-price" value="<?php if ( isset ( $sc_catalog_meta['sc-catalog-price'] ) ) echo $sc_catalog_meta['sc-catalog-price'][0]; ?>" />
		</p>
		<p>
			<label for="sc-catalog-sale-price" class="short sc-catalog-title"><?php _e( 'Sale Price:', 'sc-catalog' )?></label>
			<input type="text" name="sc-catalog-sale-price" id="sc-catalog-sale-price" value="<?php if ( isset ( $sc_catalog_meta['sc-catalog-sale-price'] ) ) echo $sc_catalog_meta['sc-catalog-sale-price'][0]; ?>" />
		</p>

		<?php

	}


	public function save_meta( $post_id ) {
	 
		// Checks save status
		$is_autosave = wp_is_post_autosave( $post_id );
		$is_revision = wp_is_post_revision( $post_id );
		$is_valid_nonce = ( isset( $_POST[ 'sc_catalog_nonce' ] ) && wp_verify_nonce( $_POST[ 'sc_catalog_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
	 
		// Exits script depending on save status
		if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
			return;
		}

		// Checks for input and sanitizes/saves if needed
		if( isset( $_POST[ 'sc-catalog-sku' ] ) ) {
			update_post_meta( $post_id, 'sc-catalog-sku', sanitize_text_field( $_POST[ 'sc-catalog-sku' ] ) );
		}
		if( isset( $_POST[ 'sc-catalog-price' ] ) ) {
			update_post_meta( $post_id, 'sc-catalog-price', sanitize_text_field( filter_var( $_POST[ 'sc-catalog-price' ], FILTER_SANITIZE_NUMBER_FLOAT ) ) );

		}
		if( isset( $_POST[ 'sc-catalog-sale-price' ] ) ) {
			update_post_meta( $post_id, 'sc-catalog-sale-price', sanitize_text_field( $_POST[ 'sc-catalog-sale-price' ] ) );
		}

	}


	public function admin_styles() {

		$screen = get_current_screen();
		$post_type = $screen->id;

		if ( $post_type == 'sc-catalog' ) {
			// enqueue styles which 
			wp_enqueue_style( 'sc-catalog-styles', SC_URL . 'assets/css/sc-admin.css' );
		}


	}

}