<?php 
/**
 * Content for the single item view in Showcase Catalog
 */

?>

	<?php do_action( 'sc_catalog_before_single_item' ); ?>

	<div id="item-<?php the_ID(); ?>" <?php post_class(); ?>>

		<?php 
			/**
			 * Output the featured image
			 * 
			 * @hooked sc_catalog_single_image()
			 */
			do_action( 'sc_catalog_single_image' );
		?>

		<div class="item-details">

			<?php 
				/**
				 * Output for the item details
				 * 
				 * @hooked sc_catalog_item_single_title()
				 * @hooked sc_catalog_item_get_price()
				 */
				do_action( 'sc_catalog_item_details' );
			?>

		</div><!-- /.item-details -->

		
		<?php
			/**
			 * Showcase Catalog Item Content
			 * 
			 * @hooked sc_catalog_item_content()
			 */
			do_action( 'sc_catalog_item_content' );
		?>

	</div><!-- .entry-content -->

	<?php do_action( 'sc_catalog_after_single_item' ); ?>