<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

get_header( 'sc-catalog' ); ?>

	<h1 class="page-title"><?php sc_catalog_page_title(); ?></h1>

	<?php
		global $wp_query;
		// get the total number of posts per each page
		$total = $wp_query->post_count;
	?>

	<?php
		/**
		 * Before Taxonomy page
		 *
		 * @hooked sc_category_description - 5
		 * @hooked sc_sub_categories - 10
		 */
		do_action( 'sc_catalog_tax_before' );
	?>

	<?php
		/**
		 * Showcase Catalog Main Content Before
		 *
		 * @hooked sc_catalog_description - 5
		 * @hooked sc_content_wrap_open - 10
		 */
		do_action( 'sc_catalog_archive_before' );

		$i = -1; // set the count to -1
	?>

		<?php while ( have_posts() ) : the_post(); ?>

		<?php $i++; // increase count by 1 ?>

		<?php
			/**
			 * Before Each Item
			 */
			sc_row_output( $i, $total, 'start' );
			do_action( 'sc_catalog_before_item' );
		?>

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


			<?php
				/**
				 * Showcase Catalog Item Content
				 *
				 * @hooked sc_catalog_item_content()
				 */
				// do_action( 'sc_catalog_item_content' );
			?>

		</div><!-- /.catalog-item -->

		<?php
			do_action( 'sc_catalog_after_item' );
			// end row
			sc_row_output( $i, $total, 'end' );
		?>

		<?php endwhile; // end of the loop. ?>

	<?php
		/**
		 * Showcase Catalog Main After
		 *
		 * @hooked sc_catalog_pagination - 5
		 * @hooked sc_catalog_wrap_close - 10
		 */
		do_action( 'sc_catalog_archive_after' );
	?>

<?php get_footer( 'sc-catalog' ); ?>
