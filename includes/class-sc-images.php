<?php
/**
 * Showcase Catalog Images and Image Sizes
 * 
 * @link       http://s2webpress.com
 * @since      1.0.0
 *
 * @package    SC_Catalog
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly.

class SC_Images {

	/**
	 * Showcase Catalog Images Construct
	 *
	 * @since     1.0.0
	 */
	public function __construct() {

		add_action( 'after_setup_theme', array( $this, 'add_image_sizes' ) );

	}

	/**
	 * A helper function for image parameters
	 * 
	 * @param  string     $width 
	 * @param  string     $height
	 * @param  string/int $crop
	 * @return array
	 */
	public function image_params( $width, $height, $crop ) {

		$image_params = array(
			'width'  => $width,
			'height' => $height,
			'crop'   => $crop
		);

		return $image_params;
	}

	/**
	 * Catalog Default Image Sizes
	 */
	public function default_catalog_image_sizes() {

		$image_sizes = array();

		$image_sizes = $this->image_params( '300', '300', 0 );

		return apply_filters( 'default_catalog_image_sizes', $image_sizes );
	}

	/**
	 * Single Catalog Default Image Sizes
	 */
	public function default_single_image_sizes() {

		$image_sizes = array();

		$image_sizes = $this->image_params( '500', '300', 0 );

		return apply_filters( 'sc_default_single_image_sizes', $image_sizes );
	}

	/**
	 * Set the options of the image sizes into the database
	 * 
	 * @param array  $defaults      array of default values for the options
	 * @param string $option_width  option name for the width
	 * @param string $option_height option name for the height
	 * @param string $option_crop   option name for the crop
	 */
	public function set_image_sizes( $defaults, $option_width, $option_height, $option_crop ) {

		// Get General Page Options
		$options = get_option( 'sc_catalog_general' );

		if ( isset( $options[$option_width] ) ) {
			$defaults['width'] = $options[$option_width]; 
		}

		if ( isset( $options[$option_height] ) ) {
			$defaults['height'] = $options[$option_height]; 
		}

		if ( isset( $options[$option_crop] ) ) {
			$defaults['crop'] = $options[$option_crop]; 
		}

		$image_sizes = $this->image_params( $defaults['width'], $defaults['height'], $defaults['crop'] );

		return $image_sizes;

	}

	/**
	 * Get the Image Size
	 * 
	 * @param  array $defaults       | The default settings for the image size
	 * @param  string $option_width  | The name of the option for width
	 * @param  string $option_height | the name of the option for height
	 * @param  string $option_crop   | The name of the option for cropping
	 * @return array                 | An array of image size parameters
	 */
	public function get_image_size( $defaults, $option_width, $option_height, $option_crop ) {

		$image = $this->set_image_sizes( $defaults, $option_width, $option_height, $option_crop );
		$image_sizes = $this->image_params( $image['width'], $image['height'], $image['crop'] );

		return $image_sizes;
	}

	/**
	 * Get the Catalog Image Sizes
	 * 
	 * @return array of image sizes and crop
	 */
	public function get_catalog_image_size() {

		$image_params = $this->get_image_size( $this->default_catalog_image_sizes(), 'catalog-width', 'catalog-height', 'catalog-crop' );

		return $image_params;

	}


	/**
	 * Get the Single Catalog Image Sizes
	 * 
	 * @return array of image sizes and crop
	 */
	public function get_single_image_size() {
		
		$image_params = $this->set_image_sizes( $this->default_single_image_sizes(), 'single-width', 'single-height', 'single-crop' );

		return $image_params;
	}

	/**
	 * Add the image sizes set in the options page
	 * 
	 */
	public function add_image_sizes() {

		// Post thumbnails
		if ( ! current_theme_supports( 'post-thumbnails' ) ) {
			add_theme_support( 'post-thumbnails' );
		}
		add_post_type_support( 'sc-catalog', 'thumbnail' );
		
		// single product images
		$single = $this->get_single_image_size();

		// catalog images
		$catalog = $this->get_catalog_image_size();

		add_image_size( 'sc_catalog_single', $single['width'], $single['height'], $single['crop'] );
		add_image_size( 'sc_catalog', $catalog['width'], $catalog['height'], $catalog['crop'] );

	}


}