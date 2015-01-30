<?php
/**
 * No Cart Core Functionality
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

add_filter( 'template_include', 'nc_template_loader', 99 );
/**
 * No Cart Template loader
 *
 * Load our own templates instead of the themes.
 *
 * Templates are in the 'templates' folder. No Cart will look for theme
 * overrides in /theme/no-cart/ by default
 *
 * @param mixed $template
 * @return string
 */
function nc_template_loader( $template ) {

		if ( is_single() && get_post_type() == 'no-cart' ) {

			// check for the single-no-cart.php template in the theme
			$single_nocart = locate_template( array( 'no-cart/single-no-cart.php' ), false );

			if ( '' != $single_nocart ) {
				return $single_nocart;
			} else {
				return plugin_dir_path( dirname( __FILE__ ) ) . 'templates/single-no-cart.php';
			}

		} elseif ( is_post_type_archive( 'no-cart' ) ) {

			// check theme for the archive-no-cart.php template 
			$archive_nocart = locate_template( array( 'no-cart/archive-no-cart.php' ), false );
			
			if ( '' != $archive_nocart ) {
				return $archive_nocart;
			} else {
				return plugin_dir_path( dirname( __FILE__ ) ) . 'templates/archive-no-cart.php';
			}
		}

	return $template;

}


/**
 * Get template part for no cart template parts
 *
 * @param mixed $slug
 * @param string $name (default: '')
 * @return void
 */
function nc_get_template_part( $slug, $name = '' ) {
	$template = '';

	// Look in yourtheme/no-cart/slug-name.php
	if ( $name ) {
		$template = locate_template( array( "no-cart/{$slug}-{$name}.php" ) );
	}

	// Get default slug-name.php
	if ( ! $template && $name && file_exists( plugin_dir_path( dirname( __FILE__ ) ) . "templates/{$slug}-{$name}.php" ) ) {
		$template = plugin_dir_path( dirname( __FILE__ ) ) . "templates/{$slug}-{$name}.php";
	}

	// If template file doesn't exist, look in yourtheme/no-cart/slug.php
	if ( ! $template ) {
		$template = locate_template( array( "no-cart/{$slug}.php" ) );
	}

	// Allow 3rd party plugin filter template file from their plugin
	$template = apply_filters( 'nc_get_template_part', $template, $slug, $name );

	if ( $template ) {
		load_template( $template, false );
	}
}