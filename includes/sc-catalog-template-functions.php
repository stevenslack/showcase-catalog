<?php
/**
 * Showcase Catalog Template Functions
 * 
 * These functions can be overritten with actions / filters
 *
 * @version     1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


/**
 * Get Showcase Catalog Item
 * 
 * @return object the Showcase Catalog Item
 */
function get_sc_catalog_item() {

	global $post;

	return new SC_Catalog_Item( $post->ID );

}


if ( ! function_exists( 'sc_catalog_page_title' ) ) {

	/**
	 * sc_catalog_page_title function.
	 *
	 * @param  boolean $echo
	 * @return string
	 */
	function sc_catalog_page_title( $echo = true ) {

		if ( is_search() ) {
			$page_title = sprintf( __( 'Search Results: &ldquo;%s&rdquo;', 'sc-catalog' ), get_search_query() );

		} elseif ( is_tax() ) {

			$page_title = single_term_title( "", false );

		} else {

			$options = get_option( 'sc_catalog_general' );

			if ( ! empty( $options['sc_catalog_archive_id'] ) ) {
				$page_title = get_the_title( intval( $options['sc_catalog_archive_id'] ) );
			} else {
				$page_title = __( 'Catalog', 'sc-catalog' );
			}

		}

		$page_title = apply_filters( 'sc_catalog_page_title', $page_title );

		if ( $echo )
			echo $page_title;
		else
			return $page_title;
	}
}

if ( ! function_exists( 'get_sc_catalog_description' ) ) {

	function get_sc_catalog_description() {

		$options = get_option( 'sc_catalog_general' );

		$catalog_desc = '';

		if ( ! empty( $options['sc_catalog_archive_id'] ) ) {
			$catalog_page = get_post( intval( $options['sc_catalog_archive_id'] ) );

			$catalog_desc = apply_filters( 'the_content', $catalog_page->post_content );

		}

		return $catalog_desc;

	}

}

if ( ! function_exists( 'sc_catalog_description' ) ) {

	function sc_catalog_description() {

		if ( is_paged() )
			return;
		?>
			<div class="entry-content catalog-desc"><?php echo get_sc_catalog_description(); ?></div>
		<?php
	}

}


if ( ! function_exists( 'sc_catalog_wrap_open' ) ) {

	/**
	 * Output the start of the page wrapper.
	 */
	function sc_catalog_wrap_open() {
		?>
		<div id="main" class="site-main sc-catalog-wrap catalog-items" role="main">
		<?php
	}
}

if ( ! function_exists( 'sc_catalog_pagination' ) ) {

	/**
	 * Output the start of the page wrapper.
	 */
	function sc_catalog_pagination() {

		the_posts_pagination();

	}
}


if ( ! function_exists( 'sc_catalog_wrap_close' ) ) {

	/**
	 * Output the start of the page wrapper.
	 */
	function sc_catalog_wrap_close() {

		?>
		</div><!-- /.catalog-items -->
		<?php
	}
}


if ( ! function_exists( 'sc_catalog_content_wrap_open' ) ) {

	/**
	 * Output the start of the page wrapper.
	 */
	function sc_catalog_content_wrap_open() {
		?>
		<div id="main" class="site-main sc-catalog-wrap" role="main">
		<?php
	}
}


if ( ! function_exists( 'sc_catalog_content_wrap_close' ) ) {

	/**
	 * Output the start of the page wrapper.
	 */
	function sc_catalog_content_wrap_close() {
		?>
		</div><!-- /.sc-catalog-wrap -->
		<?php
	}
}


if ( ! function_exists( 'sc_catalog_single_image' ) ) {

	/**
	 * The single-content-item featured image
	 * @return string
	 */
	function sc_catalog_single_image() {

		if ( has_post_thumbnail() ) {
		?>
		<div class="item-image">
			<?php the_post_thumbnail( 'sc_catalog_single' ); ?>
		</div>
		<!-- /.item-image -->
		<?php
		}

	}
}


if ( ! function_exists( 'sc_catalog_image' ) ) {

	/**
	 * The catalog featured image
	 * @return string
	 */
	function sc_catalog_image() {

		if ( has_post_thumbnail() ) {
		?>
		<div class="catalog-item-image">
			<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_post_thumbnail( 'sc_catalog' ); ?></a>
		</div>
		<!-- /.item-image -->
		<?php
		}

	}
}


if ( ! function_exists( 'sc_catalog_item_title' ) ) {

	/**
	 * Output the items title
	 * 
	 * @return string
	 */
	function sc_catalog_item_title() {
		
		the_title( sprintf( '<h1 class="sc-catalog-item-title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' );

	}

}


if ( ! function_exists( 'sc_catalog_item_single_title' ) ) {

	/**
	 * Output the items title
	 * 
	 * @return string
	 */
	function sc_catalog_item_single_title() {
		
		?>
		<h1 itemprop="name" class="sc-catalog-item-title entry-title"><?php the_title(); ?></h1>
		<?php

	}

}


if ( ! function_exists( 'sc_catalog_html_price' ) ) {

	/**
	 * The Showcase Catalog Item HTML Price
	 * 
	 * @return string html 
	 */
	function sc_catalog_html_price() {

		$product = get_sc_catalog_item();

		echo $product->adjusted_price();

	}
}


if ( ! function_exists( 'sc_catalog_the_sku' ) ) {

	/**
	 * The Showcase Catalog item SKU
	 * @return string
	 */
	function sc_catalog_the_sku() {

		$product = get_sc_catalog_item();
		$sku = $product->get_sku();

		if ( ! $sku )
			return;

		printf( '<div class="sc-catalog-sku">%1$s: %2$s</div>', __( 'SKU', 'sc-catalog' ), $sku );
		
	}

}


if ( ! function_exists( 'sc_catalog_item_content' ) ) {
	
	/**
	 * Showcase Catalog Item Content
	 * 
	 * @return string the_content
	 */
	function sc_catalog_item_content() {
		?>
		<div class="sc-catalog-item-description"><?php the_content(); ?></div><!-- /.nc-item-description -->
		<?php
	}
}



if ( ! function_exists( 'sc_catalog_content' ) ) {


	function sc_catalog_content() {

		$args = array(
			'post_type' => 'sc-catalog',
		);

		$catalog = new WP_Query( $args );

		if ( $catalog->have_posts() ) :
	 
			/**
			 * Showcase Catalog Main Content Before
			 * 
			 * @hooked sc_content_wrap_open - 10
			 */
			do_action( 'sc_catalog_archive_before' ); 
		?>

			<?php while ( $catalog->have_posts() ) : $catalog->the_post(); ?>

				<?php sc_catalog_get_template_part( 'content', 'item' ); ?>

			<?php endwhile; // end of the loop. ?>

		<?php
			/**
			 * Showcase Catalog Main After
			 * 
			 * @hooked sc_catalog_pagination - 5
			 * @hooked sc_catalog_wrap_close - 10
			 */
			do_action( 'sc_catalog_archive_after' ); 

		endif;

	// Reset Post Data
	wp_reset_postdata();
		
	}
}
