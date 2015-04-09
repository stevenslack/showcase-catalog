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

        add_action( 'admin_init', array( $this, 'save_settings_flush' ) );

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
			__( 'Catalog Display Settings', 'sc-catalog' ),
			array( $this, 'page_section' ),
			'sc_catalog_general'
		);
		
		add_settings_field(	
			'sc_catalog_archive_id',						
			__( 'Catalog Page', 'sc-catalog' ),							
			array( $this, 'select_archive_page' ),	
			'sc_catalog_general',	
			'page_settings'			
		);

		add_settings_field(	
			'sc_catalog_archive_title',					
			__( 'Catalog Page Title', 'sc-catalog' ),							
			array( $this, 'page_title' ),	
			'sc_catalog_general',	
			'page_settings'			
		);

		add_settings_field(	
			'sc_catalog_description',					
			__( 'Catalog Page Description', 'sc-catalog' ),							
			array( $this, 'catalog_description' ),	
			'sc_catalog_general',	
			'page_settings'			
		);

		add_settings_field(	
			'sc_catalog_display',					
			__( 'Catalog Page Display', 'sc-catalog' ),							
			array( $this, 'catalog_item_display' ),	
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
			__( 'Single Catalog Item Image', 'sc-catalog' ),							
			array( $this, 'single_product_image' ),	
			'sc_catalog_general',	
			'image_settings'			
		);

		add_settings_field(	
			'sc_catalog_item_catalog',					
			__( 'Catalog Thumbnail Images', 'sc-catalog' ),							
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
	 * Default options for settings
	 */
	public function sc_settings() {
		
		$defaults = array(
			'sc_catalog_archive_id'		=> null,
			'sc_catalog_archive_title' 	=> 'Catalog',
			'sc_catalog_description'	=> '',
			'sc_catalog_display'		=> 'both',
			'single-width'				=> '500',
			'single-height' 			=> '300',
			'single-crop' 				=> 0,
			'catalog-width'		 		=> '300',
			'catalog-height'		 	=> '300',
			'catalog-crop' 				=> 0
		);
		
		$options = get_option( 'sc_catalog_general', $defaults );

		return $options;
		
	} // end sc_settings


	/**
	 * Select the archive page
	 * @return int the page ID
	 */
	public function select_archive_page() {

		$options = $this->sc_settings();

		// define the variable
		$value = null;

		if ( isset( $options['sc_catalog_archive_id'] ) ) {
			$value = $options['sc_catalog_archive_id'];
		}

		wp_dropdown_pages(
		    array(
		         'name' 				=> 'sc_catalog_general[sc_catalog_archive_id]',
		         'echo' 				=> 1,
		         'show_option_none' 	=> __( 'Catalog' ),
		         'option_none_value' 	=> '0',
		         'selected' 			=>  $value
		    )
		);

		?>

		<p class="description"><?php _e( 'The default catalog page is "catalog" and can be found here:', 'sc-catalog' ); ?>  
		<a href="<?php echo esc_url( get_post_type_archive_link( 'sc-catalog' ) ); ?>"><?php _e( 'The Catalog Page', 'sc-catalog' ); ?></a>
		</p>

		<?php
		
	}


	/**
	 * The Showcase Catalog Archive Page Title
	 * @return string html input
	 */
	public function page_title() {

		$options = $this->sc_settings();

		$value = 'Catalog';

		if ( isset( $options['sc_catalog_archive_title'] ) ) {
			$value = $options['sc_catalog_archive_title'];
		}

		// output the input :)
		printf( '<input type="text" name="sc_catalog_general[sc_catalog_archive_title]" value="%s" />', $value );
	}


	/**
	 * The Desription for the catalog page
	 */
	public function catalog_description() {
	
		$options = $this->sc_settings();

		$value = '';

		if ( isset( $options['sc_catalog_description'] ) ) {
			$value = $options['sc_catalog_description'];
		}

		// Editor Options
		$settings = array( 'media_buttons' => false, 'textarea_name' => 'sc_catalog_general[sc_catalog_description]', 'teeny' => true );

		// call the WordPress wysiwyg editor
		echo wp_editor( $value, 'textcatalogdesc', $settings );

	}


	/**
	 * Select for Displaying Categories
	 */
	public function catalog_item_display() {
	
		$options = $this->sc_settings();

		$value = 'display';

		if ( isset( $options['sc_catalog_display'] ) ) {
			$value = $options['sc_catalog_display'];
		}

		?>
		<select id="sc-display-options" name="sc_catalog_general[sc_catalog_display]">
			<option value=""><?php _e( 'Select a display option', 'sc-catalog' ); ?></option>
			<option value="both"<?php selected( $value, 'both' ) ?>><?php _e( 'Both Categories and Catalog Items', 'sc-catalog' ) ?></option>
			<option value="categories"<?php selected( $value, 'categories' ); ?>><?php _e( 'Only Display Categories', 'sc-catalog' ); ?></option>
			<option value="items"<?php selected( $value, 'items' ); ?>><?php _e( 'Only Display Catalog Items', 'sc-catalog' ); ?></option>	
		</select>
		<p class="description"><?php _e( 'Select which view you would like your catalog page to show.', 'sc-catalog' ); ?></p>
		<?php

	}

    /**
	 * Image Settings Description
	 * @return string description of this settings section content
	 */
	public function image_section() {
		printf( __( 'The <strong>single catalog item image</strong> is the image that appears on a page that displays only that item. The <strong>catalog thumbnail images</strong> are the size of each image in the catalog or items page display. After updating the image settings below you may need to <a href="%s" target="_blank">regenerate your thumbnails</a>.', 'sc-catalog' ), 'https://wordpress.org/plugins/regenerate-thumbnails/' );
	} // end image_section


	/**
	 * Single Product Image Settings
	 * 
	 */
	public function single_product_image() {

		// get the general options
		$options = $this->sc_settings();

		// define variables
		$width 	= '500';
		$height = '300';
		$crop 	= 0;

		if ( isset( $options['single-width'] ) ) {
			$width = $options['single-width']; 
		}

		if ( isset( $options['single-height'] ) ) {
			$height = $options['single-height']; 
		}

		if ( isset( $options['single-crop'] ) ) {
			$crop = $options['single-crop']; 
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
		$options = $this->sc_settings();

		// define variables
		$width 	= '300';
		$height = '300';
		$crop 	= 0;

		if ( isset( $options['catalog-width'] ) ) {
			$width = $options['catalog-width']; 
		}

		if ( isset( $options['catalog-height'] ) ) {
			$height = $options['catalog-height']; 
		}

		if ( isset( $options['catalog-crop'] ) ) {
			$crop = $options['catalog-crop']; 
		}

		?>
			<input name="sc_catalog_general[catalog-width]" id="catalog-width" type="text" size="3" value="<?php echo $width; ?>" /> &times; <input name="sc_catalog_general[catalog-height]" id="catalog-height" type="text" size="3" value="<?php echo $height; ?>" />px

			<label><input name="sc_catalog_general[catalog-crop]" id="catalog-crop" type="checkbox" value="1" <?php checked( $crop, 1 ); ?> /> <?php _e( 'Hard Crop?', 'sc-catalog' ); ?></label>

		<?php
	}

	/**
	 * Flush rewrite rules on page select
	 */
	public function save_settings_flush() {

		$options = $this->sc_settings();

		if ( isset( $options['sc_catalog_archive_id'] ) ) {
			flush_rewrite_rules();
		}
	}

}