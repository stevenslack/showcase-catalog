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
			// get the options
			$options = get_option( 'sc_catalog_general' );

			if ( ! empty( $options['sc_catalog_archive_id'] ) ) {
				$page_title = get_the_title( intval( $options['sc_catalog_archive_id'] ) );
			} elseif ( ! empty( $options['sc_catalog_archive_title'] ) ) {
				$page_title = sprintf( __( '%s', 'sc-catalog' ), $options['sc_catalog_archive_title'] );
			} else {
				$page_title = __( 'Catalog', 'sc-catalog' );
			}

		}

		$page_title = apply_filters( 'sc_catalog_page_title', $page_title );

		if ( $echo ) {
			echo $page_title;
		} else {
			return $page_title;
		}
	}
}


if ( ! function_exists( 'get_sc_catalog_description' ) ) {
	/**
	 * Get the Catalog Description from the selected catalog page
	 * or the settings description
	 *
	 * @return html sting
	 */
	function get_sc_catalog_description() {

		$options = get_option( 'sc_catalog_general' );

		$catalog_desc = '';

		// if the catalog page is set grab the post content from that page
		if ( ! empty( $options['sc_catalog_archive_id'] ) ) {
			// get the post object
			$catalog_page = get_post( intval( $options['sc_catalog_archive_id'] ) );
			// get the post content
			$catalog_desc = apply_filters( 'the_content', $catalog_page->post_content );

		}

		return $catalog_desc;

	}

}

if ( ! function_exists( 'sc_catalog_description' ) ) {
	/**
	 * The HTML for the catalog description
	 * @return string
	 */
	function sc_catalog_description() {

		// do not display the description if it is paged
		if ( is_paged() ) {
			return;
		}
		?>
			<div class="entry-content catalog-desc"><?php echo get_sc_catalog_description(); ?></div><!--/.catalog-desc -->
		<?php
	}

}


if ( ! function_exists( 'sc_category_descriptions' ) ) {
	/**
	 * The taxonomy description for catalog categories
	 */
	function sc_category_descriptions() {

		// do not display the description if it is paged
		if ( is_paged() )
			return;

		$term_desc = term_description();

		if ( $term_desc ) {
		?>
			<div class="category-description"><?php echo $term_desc; ?></div><!--/.catalog-desc -->
		<?php

		}
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

if ( ! function_exists( 'sc_catalog_products_header' ) ) {
	/**
	 * Output the Products page title
	 * @return string header tag
	 */
	function sc_catalog_products_header() {
		$options = get_option( 'sc_catalog_general' );
		$show = $options['sc_catalog_display'];

		if ( $show === 'both' && ! is_paged() ) :
		?>
		<h4 class="sc-catalog-all-products-title"><?php echo apply_filters( 'sc_products_header_text', __( 'All Catalog Items', 'sc-catalog' ) ); ?></h4>
		<?php
		endif;
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

		if ( ! $sku ) {
			return;
		}

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

/**
 * Get Image Sizes
 *
 * @param  string $image_size the name of the image size
 * @return array  parameters of the image size
 */
function sc_get_image_sizes( $image_size ) {

	if ( ! $image_size ) {
		return;
	} elseif ( $image_size === 'sc_catalog' ) {
		// get the catalog image sizes
		$image_params = sc_catalog()->image_sizes->get_catalog_image_size();

	} elseif ( $image_size === 'sc_catalog_single' ) {
		// get the single catalog image size
		$image_params = sc_catalog()->image_sizes->get_single_image_size();
	}

	return $image_params;

}

/**
 * Placeholder Image for Taxonomy Images
 *
 * @param  boolean $echo Echo or Return
 * @return string img tag with placeholder
 */
function sc_placeholder_image( $echo = true ) {

	$image_path = SC_URL . '/assets/img/catalog-placeholder.jpg';

	$image_html = sprintf( '<img src="%1$s" class="sc-image-placeholder">', $image_path );

	if ( $echo ) {
		// echo the image placeholder
		echo $image_html;

	} else {
		// return the image placeholder
		return $image_html;
	}

}

function sc_column_class() {
	// get the number of rows set on the options page
	$options = get_option( 'sc_catalog_general' );
	$rows    = $options['sc_catalog_columns'];

	if ( empty( $rows ) )
		$class = 'one-third';
	else {
		switch ( $rows ) {
			case 1:
				$class = 'sc-full';
				break;
			case 2:
				$class = 'sc-half';
				break;
			case 3:
				$class = 'sc-one-third';
				break;
			case 4:
				$class = 'sc-one-quarter';
				break;
			case 5:
				$class = 'sc-one-fifth';
				break;
			case 6:
				$class = 'sc-one-sixth';
				break;
			default:
				$class = 'sc-one-third';
				break;
		}
	}

	return $class;
}

/**
 * Item Classes
 *
 * @param  int     $count the counter
 * @param  string  $type | default = 'array' | type of return either array or string
 * @return array   the classes for the catalog items to be passed throught the post_class
 */
function sc_item_classes( $count, $type = 'array' ) {

	$options = get_option( 'sc_catalog_general' );
	$rows    = $options['sc_catalog_columns'];

	$column_class = sc_column_class();

	$classes = array( $column_class, 'catalog-item' );

	if( 0 == $count || 0 == $count % $rows ) {
		$classes[] = 'first';
	}
	// return either an array or a string
	if ( $type === 'string' ) {
		return implode( ' ', $classes );
	} elseif ( $type === 'array' ) {
		return $classes;
	}
}

/**
 * Get the category terms
 *
 * @return array
 */
function get_sc_categories() {

	$args = array(
	    'orderby'           => 'name',
	    'order'             => 'ASC',
	    'hide_empty'        => true,
	    'parent'			=> 0,
	);

	$terms = get_terms( 'sc-catalog-categories', $args );

	return $terms;
}


function sc_category_image( $count, $term ) {

	// Get the term options
	$term_options = get_option( 'catalog_term_images' );
	?>
	<div class="catalog-item-image catalog-category <?php echo sc_item_classes( $count, 'string' ); ?>">

		<a href="<?php echo esc_url( get_term_link( $term ) ); ?>">
		<?php
			if ( isset( $term_options[ $term->term_id ] ) ) {
				echo wp_get_attachment_image( $term_options[ $term->term_id ], 'sc_catalog' );
			} else {
				sc_placeholder_image();
			}
		?>
		</a>

		<h3>
			<a href="<?php echo esc_url( get_term_link( $term ) ); ?>" rel="bookmark">
				<?php echo esc_attr( $term->name ); ?>
			</a>
		</h3><!--/.sc-category-->

	</div><!--/.catalog-item-image -->
	<?php
}

function sc_category_term_output( $count, $term ) {

	// Get General Page Options
	$display = get_option( 'sc_catalog_general' );

	if ( $display['sc_category_images'] === 'show' ) :

		sc_category_image( $count, $term );

	elseif ( $display['sc_category_images'] === 'hide' ) : ?>

		<a class="sc-category-link" href="<?php echo esc_url( get_term_link( $term ) ); ?>" rel="bookmark"><?php echo esc_attr( $term->name ); ?></a>

	<?php endif;

}

/**
 * Out put the rows for the catalog
 * @param  int $count        the count iterator for each item
 * @param  int $total        the total number of items per page
 * @param  string $position  the position | start or end
 * @return string
 */
function sc_row_output( $count, $total, $position ) {

	// get the number of rows set on the options page
	$options = get_option( 'sc_catalog_general' );
	$rows    = $options['sc_catalog_columns'];

	if ( $position === 'start' ) {

		if ( $count === 0 ) {
			// the opening row
			echo '<div class="sc-product-row">';
		}

		if( $count % $rows == 0 && $count !== 0 ) {
			// close the last row and open a new one
			echo '</div><!-- /.sc-product-row --><div class="sc-product-row">';
		}

	} elseif ( $position === 'end' ) {

	    // output the closing tag if we are on the last item
	    if( $count === ( $total - 1 ) ) {
	        echo '</div><!-- /.sc-product-row -->';
	    }
	}
}


function sc_categories_list() {

	if ( is_paged() ) {
		return;
	}

	$terms = get_sc_categories();

	// count the terms for the total
	$total = count( $terms );

	if ( $terms ) {
		?>
		<div class="sc-category-list">
			<h4 class="sc-category-title"><?php _e( 'Categories', 'sc-catalog' ); ?>:</h4>
			<div class="category-nav">
			<?php
				$i = -1; // set the count to -1

				foreach ( $terms as $term ) {

					$i++; // increase count by 1

					sc_row_output( $i, $total, 'start' );

					// display the markup for each term
					sc_category_term_output( $i, $term );

					sc_row_output( $i, $total, 'end' );

				}
			?>
			</div>
			<!-- /.category-nav -->
		</div>
		<!-- /.sc-category-list -->
		<?php
	}
}


/**
 * Display Sub Categories
 * @return [type] [description]
 */
function sc_sub_categories() {

	if ( is_paged() ) {
		return;
	}

	// get the queried term
	// for use on taxonomy pages only
	$q_term = get_queried_object();

	// get the term children from the queried term
	$termchildren = get_term_children( $q_term->term_id, 'sc-catalog-categories' );

	// count the terms for the total
	$total = count( $termchildren );

	if ( $termchildren ) {
	?>
	<div class="sc-category-list">
		<h4 class="sc-category-title"><?php printf( __( '%s categories', 'sc-catalog' ), $q_term->name ); ?>:</h4>
		<div class="category-nav">
		<?php
			$i = -1; // set the count to -1

			foreach ( $termchildren as $child ) {

				$i++; // increase count by 1

				$term = get_term_by( 'id', $child, 'sc-catalog-categories' );

				sc_row_output( $i, $total, 'start' );

				sc_category_term_output( $i = 0, $term );

				sc_row_output( $i, $total, 'end' );

			}
		?>
		</div>
		<!-- /.category-nav -->
	</div>
	<!-- /.sc-category-list -->
	<?php
	} // end if termchildren
}


if ( ! function_exists( 'sc_catalog_content' ) ) {

	/**
	 * A function which pulls in the catalog
	 */
	function sc_catalog_content() {

		// get the display options
		$options = get_option( 'sc_catalog_general' );
		$display = $options['sc_catalog_display'];

		// catalog query args
		$args = array(
			'post_type' => 'sc-catalog',
			'paged'     => get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1,
		);

		$catalog = new WP_Query( $args );

		// get the total number of posts per each page
		$total = $catalog->post_count;

		if ( $catalog->have_posts() ) :

		$i = -1; // set the count to -1

		?>
			<h1 class="page-title"><?php sc_catalog_page_title(); ?></h1>
		<?php
			/**
			 * Showcase Catalog Main Content Before
			 *
			 * @hooked sc_content_wrap_open - 10
			 */
			do_action( 'sc_catalog_archive_before' );
		?>

			<?php while ( $catalog->have_posts() ) : $catalog->the_post(); ?>

			<?php $i++; // increase count by 1
			// start the row
	        sc_row_output( $i, $total, 'start' );

			?>

			<?php do_action( 'sc_catalog_before_item' ); ?>

			<div id="item-<?php the_ID(); ?>" <?php post_class( sc_item_classes( $i ) ); ?>>

				<?php
					/**
					 * Output the featured image
					 *
					 * @hooked sc_catalog_image()
					 */
					do_action( 'sc_catalog_item_image' );
				?>

				<div class="item-details">

					<?php
						/**
						 * Output for the item details
						 *
						 * @hooked sc_catalog_item_title()
						 * @hooked sc_catalog_item_get_price()
						 */
						do_action( 'sc_catalog_item_summary' );
					?>

				</div><!-- /.item-details -->

			</div><!-- /.catalog-item -->

			<?php do_action( 'sc_catalog_after_item' );
				// end the row
	        	sc_row_output( $i, $total, 'end' );

			?>

			<?php endwhile; // end of the loop. ?>

			<nav class="sc-nav-links">
				<span class="sc-previous-item"><?php previous_posts_link( 'Previous Items' ); ?></span>
				<span class="sc-next-item"><?php next_posts_link( 'Next Items', $catalog->max_num_pages ); ?></span>
			</nav>
			<!-- /.catalog-nav-links -->
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

