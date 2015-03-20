<?php
/**
 * Showcase Catalog Core Functionality
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Get the catalog Page
 * 
 * @return mixed sting|int
 */
function sc_get_catalog_page( $id = true ) {

	// get the catalog settings
	$options = get_option( 'sc_catalog_general' );

	// set the catalog page
	$catalog_page = 'catalog';

	// if the setting is set to another page get that page ID
	if ( ! empty( $options['sc_catalog_archive_id'] ) ) {
		if ( $id ) {
			// set catalog_page to the page ID
			$catalog_page = $options['sc_catalog_archive_id'];
		}
		else {
			// get the slug from the page ID
			$catalog_page = get_post( intval( $options['sc_catalog_archive_id'] ) )->post_name;
		}
	}

	return $catalog_page;
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

		$catalog_page = sc_get_catalog_page();

		if ( is_single() && get_post_type() == 'sc-catalog' ) {

			// check for the single-sc-catalog.php template in the theme
			$single_catalog = locate_template( array( 'sc-catalog/single-sc-catalog.php' ), false );

			if ( '' != $single_catalog ) {
				return $single_catalog;
			} else {
				return plugin_dir_path( dirname( __FILE__ ) ) . 'templates/single-sc-catalog.php';
			}

		} elseif ( is_post_type_archive( 'sc-catalog' ) || is_page( $catalog_page ) ) {

			// check theme for the archive-sc-catalog.php template 
			$archive_catalog = locate_template( array( 'sc-catalog/archive-sc-catalog.php' ), false );
			
			if ( '' != $archive_catalog ) {
				return $archive_catalog;
			} else {
				return plugin_dir_path( dirname( __FILE__ ) ) . 'templates/archive-sc-catalog.php';
			}

		} elseif ( is_tax( 'sc-catalog-categories' ) ) {

			// check theme for the taxonomy-sc-catalog-categories.php template 
			$tax_catalog = locate_template( array( 'sc-catalog/taxonomy-sc-catalog-categories.php' ), false );
			
			if ( '' != $tax_catalog ) {
				return $tax_catalog;
			} else {
				return plugin_dir_path( dirname( __FILE__ ) ) . 'templates/taxonomy-sc-catalog-categories.php';
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