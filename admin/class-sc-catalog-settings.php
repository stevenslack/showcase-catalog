<?php
/**
 * Showcase Catalog Settings Page
 * 
 * @link       http://s2webpress.com
 * @since      1.0.0
 *
 * @package    SC_Catalog
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly.

class SC_Catalog_Settings {

    /**
     * Showcase Catalog Settings Construct
     * 
     * @since    1.0.0
     */
    public function __construct() {

        // add a submenu page
        add_action( 'admin_menu', array( $this, 'add_settings_page' ) );
        // register the general settings 
        add_action( 'admin_init', array( $this, 'general_settings' ) );

    }


    /**
     * Add the Settings Page as a subpage to the Showcase Catalog Post Type
     */
    public function add_settings_page() {

    	// adds a submenu page under Showcase Catalog's Custom Post Type
        add_submenu_page(
            'edit.php?post_type=sc-catalog', 
			__( 'Showcase Catalog Settings', 'sc-catalog' ),
			__( 'Settings', 'sc-catalog' ),
            'administrator',
            'sc-catalog-settings', 
            array( $this, 'display_admin_page' )
        );

    }


    /**
     * Display for the Settings page with Tabs
     * 
     * @return sting html
     */
    public function display_admin_page() {

    	// establish active tab
    	$active_tab = 'general_settings';
    	// page URL string
    	$page_url = '?post_type=sc-catalog&amp;page=sc-catalog-settings&amp;tab=';

        ?>
        <div class="wrap">
            <h2><?php echo esc_html( get_admin_page_title() ); ?></h2>   
            <?php settings_errors(); ?>

			<?php if( isset( $_GET[ 'tab' ] ) ) {
				$active_tab = $_GET[ 'tab' ];

			} else if ( $active_tab == 'labels' ) {
				$active_tab = 'labels';
			} else {
				$active_tab = 'general_settings';
			} // end if/else ?>

			<h2 class="nav-tab-wrapper">
				<a href="<?php echo $page_url; ?>general_settings" class="nav-tab <?php echo $active_tab == 'general_settings' ? 'nav-tab-active' : ''; ?>"><?php _e( 'General Settings', 'sc-catalog' ); ?></a>
				<a href="<?php echo $page_url; ?>labels" class="nav-tab <?php echo $active_tab == 'labels' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Labels', 'sc-catalog' ); ?></a>
			</h2>

            <form method="post" action="options.php">
            <?php

				if ( $active_tab == 'general_settings' ) {

					settings_fields( 'sc_catalog_general_group' );
					do_settings_sections( 'sc_catalog_general' );

				} elseif ( $active_tab == 'labels' ) {

					// settings_fields( 'pr-nocontent-settings' );
					// do_settings_sections( 'pr-nocontent-settings' );
				}
						
				submit_button();

            ?>
            </form>
        </div>
        <?php

    } // END display_admin_page()


    /**
     * Register the general Showcase Catalog settings
     * @return void
     */
    public function general_settings() {

		register_setting( 
			'sc_catalog_general_group',
			'sc_catalog_general'
		);

		/**
		 *  The Page Settings
		 */
		add_settings_section(
			'page_settings',
			__( 'Page Settings', 'sc-catalog' ),
			array( $this, 'page_section' ),
			'sc_catalog_general'
		);
		
		add_settings_field(	
			'sc_catalog_archive_id',						
			__( 'Products Page', 'sc-catalog' ),							
			array( $this, 'select_archive_page' ),	
			'sc_catalog_general',	
			'page_settings'			
		);

		add_settings_field(	
			'sc_catalog_archive_title',					
			__( 'Products Page Title', 'sc-catalog' ),							
			array( $this, 'page_title' ),	
			'sc_catalog_general',	
			'page_settings'			
		);

		/**
		 *  The Image Settings
		 */
		add_settings_section(
			'image_settings',
			__( 'Image Settings', 'sc-catalog' ),
			array( $this, 'image_section' ),
			'sc_catalog_general'
		);

		add_settings_field(	
			'sc_catalog_item_img',					
			__( 'Single Product Image', 'sc-catalog' ),							
			array( $this, 'single_product_image' ),	
			'sc_catalog_general',	
			'image_settings'			
		);

		add_settings_field(	
			'sc_catalog_item_catalog',					
			__( 'Product Catalog Images', 'sc-catalog' ),							
			array( $this, 'product_catalog' ),	
			'sc_catalog_general',	
			'image_settings'			
		);

    }

    /**
	 * Page Settings Description
	 * @return string description of this settings section content
	 */
	public function page_section() {
		return;
	} // end page_section


	/**
	 * Select the archive page
	 * @return int the page ID
	 */
	public function select_archive_page() {

		$options = get_option( 'sc_catalog_general' );

		if ( isset( $options['sc_catalog_archive_id'] ) ) {
			$value = $options['sc_catalog_archive_id'];
		} else {
			$value = null;
		}

		wp_dropdown_pages(
		    array(
		         'name' => 'sc_catalog_general[sc_catalog_archive_id]',
		         'echo' => 1,
		         'show_option_none' => __( '&mdash; Select Page &mdash;' ),
		         'option_none_value' => '0',
		         'selected' =>  $value
		    )
		);
		
	}


	/**
	 * The Showcase Catalog Archive Page Title
	 * @return string html input
	 */
	public function page_title() {
		$options = get_option( 'sc_catalog_general' );

		$value = '';

		if ( isset( $options['sc_catalog_archive_title'] ) )
			$value = $options['sc_catalog_archive_title'];

		// output the input :)
		printf( '<input type="text" name="sc_catalog_general[sc_catalog_archive_title]" value="%s" />', $value );
	}


    /**
	 * Image Settings Description
	 * @return string description of this settings section content
	 */
	public function image_section() {
		printf( __( 'The <strong>single product image</strong> is the image that appears on a page that displays only that product. The <strong>product catalog image</strong> is the size of each image in the catalog or products page display. After updating the image settings below you may need to <a href="%s" target="_blank">regenerate your thumbnails</a>.', 'sc-catalog' ), 'https://wordpress.org/plugins/regenerate-thumbnails/' );
	} // end image_section


	/**
	 * Single Product Image Settings
	 * 
	 */
	public function single_product_image() {

		// get the general options
		$options = get_option( 'sc_catalog_general' );

		if ( isset( $options['single-width'] ) ) {
			$width = $options['single-width']; 
		} else {
			$width = '500'; // default
		}

		if ( isset( $options['single-height'] ) ) {
			$height = $options['single-height']; 
		} else {
			$height = '300'; // default
		}

		if ( isset( $options['single-crop'] ) ) {
			$crop = $options['single-crop']; 
		} else {
			$crop = 0; // defaults to false
		}

		?>
			<input name="sc_catalog_general[single-width]" id="single-width" type="text" size="3" value="<?php echo $width; ?>" /> &times; <input name="sc_catalog_general[single-height]" id="single-height" type="text" size="3" value="<?php echo $height; ?>" />px

			<label><input name="sc_catalog_general[single-crop]" id="single-crop" type="checkbox" value="1" <?php checked( $crop, 1 ); ?> /> <?php _e( 'Hard Crop?', 'sc-catalog' ); ?></label>

		<?php

	}


	/**
	 * Catalog Product Image Settings
	 * 
	 */
	public function product_catalog() {

		// get the general options
		$options = get_option( 'sc_catalog_general' );

		if ( isset( $options['catalog-width'] ) ) {
			$width = $options['catalog-width']; 
		} else {
			$width = '300'; // default
		}

		if ( isset( $options['catalog-height'] ) ) {
			$height = $options['catalog-height']; 
		} else {
			$height = '300'; // default
		}

		if ( isset( $options['catalog-crop'] ) ) {
			$crop = $options['catalog-crop']; 
		} else {
			$crop = 0;
		}

		?>
			<input name="sc_catalog_general[catalog-width]" id="catalog-width" type="text" size="3" value="<?php echo $width; ?>" /> &times; <input name="sc_catalog_general[catalog-height]" id="catalog-height" type="text" size="3" value="<?php echo $height; ?>" />px

			<label><input name="sc_catalog_general[catalog-crop]" id="catalog-crop" type="checkbox" value="1" <?php checked( $crop, 1 ); ?> /> <?php _e( 'Hard Crop?', 'sc-catalog' ); ?></label>

		<?php
	}

}