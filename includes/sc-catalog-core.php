<?php
/**
 * Showcase Catalog Core Functionality
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

add_filter( 'template_include', 'sc_catalog_template_loader', 99 );
/**
 * Showcase Catalog Template loader
 *
 * Load our own templates instead of the themes.
 *
 * Templates are in the 'templates' folder. Showcase Catalog will look for theme
 * overrides in /theme/sc-catalog/ by default
 *
 * @param mixed $template
 * @return string
 */
function sc_catalog_template_loader( $template ) {

		$options = get_option( 'sc_catalog_general' );

		$shop_id = '';

		if ( ! empty( $options['sc_catalog_archive_id'] ) ) {
			$shop_id = $options['sc_catalog_archive_id'];
		} 

		if ( is_single() && get_post_type() == 'sc-catalog' ) {

			// check for the single-sc-catalog.php template in the theme
			$single_nocart = locate_template( array( 'sc-catalog/single-sc-catalog.php' ), false );

			if ( '' != $single_nocart ) {
				return $single_nocart;
			} else {
				return plugin_dir_path( dirname( __FILE__ ) ) . 'templates/single-sc-catalog.php';
			}

		} elseif ( is_post_type_archive( 'sc-catalog' ) || is_page( $shop_id ) ) {

			// check theme for the archive-sc-catalog.php template 
			$archive_nocart = locate_template( array( 'sc-catalog/archive-sc-catalog.php' ), false );
			
			if ( '' != $archive_nocart ) {
				return $archive_nocart;
			} else {
				return plugin_dir_path( dirname( __FILE__ ) ) . 'templates/archive-sc-catalog.php';
			}
		}

	return $template;

}


/**
 * Get template part for Showcase Catalog template parts
 *
 * @param mixed $slug
 * @param string $name (default: '')
 * @return void
 */
function sc_catalog_get_template_part( $slug, $name = '' ) {
	$template = '';

	// Look in yourtheme/sc-catalog/slug-name.php
	if ( $name ) {
		$template = locate_template( array( "sc-catalog/{$slug}-{$name}.php" ) );
	}

	// Get default slug-name.php
	if ( ! $template && $name && file_exists( plugin_dir_path( dirname( __FILE__ ) ) . "templates/{$slug}-{$name}.php" ) ) {
		$template = plugin_dir_path( dirname( __FILE__ ) ) . "templates/{$slug}-{$name}.php";
	}

	// If template file doesn't exist, look in yourtheme/sc-catalog/slug.php
	if ( ! $template ) {
		$template = locate_template( array( "sc-catalog/{$slug}.php" ) );
	}

	// Allow 3rd party plugin filter template file from their plugin
	$template = apply_filters( 'sc_catalog_get_template_part', $template, $slug, $name );

	if ( $template ) {
		load_template( $template, false );
	}
}