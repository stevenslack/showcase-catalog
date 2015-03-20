<?php
/**
 * Showcase Catalog Taxonomy Meta Fields
 * 
 * @link       http://s2webpress.com
 * @since      1.0.0
 *
 * @package    SC_Catalog
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly.

class SC_Taxonomy_Fields {

	/**
	 * Constructor
	 */
	public function __construct() {

		// Add form uploader
		add_action( 'sc-catalog-categories_add_form_fields', array( $this, 'add_category_fields' ) );
		add_action( 'sc-catalog-categories_edit_form_fields', array( $this, 'edit_category_fields' ), 10 );

	}

	/**
	 * Category thumbnail fields.
	 */
	public function add_category_fields() {
		?>
		<div class="form-field">
			<label><?php _e( 'Thumbnail', 'woocommerce' ); ?></label>
			<div>
				<input type="hidden" id="sc-catalog-id" name="sc-catalog-id" />
				<button type="button" class="upload_image_button button"><?php _e( 'Upload/Add image', 'woocommerce' ); ?></button>
				<button type="button" class="remove_image_button button"><?php _e( 'Remove image', 'woocommerce' ); ?></button>
			</div>
			<div class="clear"></div>
		</div>
		<?php
	}

	public function edit_category_fields( $term ) {
		
	
	}

}



