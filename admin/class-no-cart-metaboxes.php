<?php
/**
 * No Carts Custom Metaboxes
 * 
 * @link       http://s2webpress.com
 * @since      1.0.0
 *
 * @package    No_Cart
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly.



class No_Cart_Meta {


	/**
	 * No Cart Metaboxes construct
	 *
	 * @since     1.0.0
	 */
	public function __construct() {

		// $this->options = get_option( 'nocart-options' );

		// register no cart metaboxes
		add_action( 'add_meta_boxes', array( $this, 'add_nocart_metaboxes' ) );

		// Save meta
		add_action( 'save_post', array( $this, 'save_meta' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_styles' ) );

	}


	/**
	 * Add the Meta Box to the no-cart custom post type
	 */
	public function add_nocart_metaboxes() {

		add_meta_box( 
			'no-cart-meta', // HTML 'id' attribute of the edit screen section
			__( 'Product Attributes', 'no-cart' ), 
			array( $this, 'no_cart_meta_callback' ), 
			'no-cart',
			'normal',
			'default'
		);

	}


	public function no_cart_meta_callback( $post ) {

		wp_nonce_field( basename( __FILE__ ), 'no_cart_nonce' );
		$no_cart_meta = get_post_meta( $post->ID );

		?>

		<p>
			<label for="no-cart-sku" class="short no-cart-title"><?php _e( 'SKU:', 'no-cart' )?></label>
			<input type="text" name="no-cart-sku" id="no-cart-sku" value="<?php if ( isset ( $no_cart_meta['no-cart-sku'] ) ) echo $no_cart_meta['no-cart-sku'][0]; ?>" />
		</p>
		<p>
			<label for="no-cart-price" class="short no-cart-title"><?php _e( 'Price:', 'no-cart' )?></label>
			<input type="text" name="no-cart-price" id="no-cart-price" value="<?php if ( isset ( $no_cart_meta['no-cart-price'] ) ) echo $no_cart_meta['no-cart-price'][0]; ?>" />
		</p>
		<p>
			<label for="no-cart-sale-price" class="short no-cart-title"><?php _e( 'Sale Price:', 'no-cart' )?></label>
			<input type="text" name="no-cart-sale-price" id="no-cart-sale-price" value="<?php if ( isset ( $no_cart_meta['no-cart-sale-price'] ) ) echo $no_cart_meta['no-cart-sale-price'][0]; ?>" />
		</p>

		<?php

	}


	public function save_meta( $post_id ) {
	 
		// Checks save status
		$is_autosave = wp_is_post_autosave( $post_id );
		$is_revision = wp_is_post_revision( $post_id );
		$is_valid_nonce = ( isset( $_POST[ 'no_cart_nonce' ] ) && wp_verify_nonce( $_POST[ 'no_cart_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
	 
		// Exits script depending on save status
		if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
			return;
		}

		// Checks for input and sanitizes/saves if needed
		if( isset( $_POST[ 'no-cart-sku' ] ) ) {
			update_post_meta( $post_id, 'no-cart-sku', sanitize_text_field( $_POST[ 'no-cart-sku' ] ) );
		}
		if( isset( $_POST[ 'no-cart-price' ] ) ) {
			update_post_meta( $post_id, 'no-cart-price', sanitize_text_field( $_POST[ 'no-cart-price' ] ) );
		}
		if( isset( $_POST[ 'no-cart-sale-price' ] ) ) {
			update_post_meta( $post_id, 'no-cart-sale-price', sanitize_text_field( $_POST[ 'no-cart-sale-price' ] ) );
		}

	}


	public function admin_styles() {

		$screen = get_current_screen();
		$post_type = $screen->id;

		if ( $post_type == 'no-cart' ) {
			// enqueue styles which 
			wp_enqueue_style( 'no-cart-styles', plugin_dir_url( __FILE__ ) . 'css/no-cart-admin.css' );
		}


	}

}