<?php 
/**
 * Content for the archive view in Showcase Catalog
 */
?>

	<?php do_action( 'sc_catalog_before_item' ); ?>

	<div id="item-<?php the_ID(); ?>" <?php post_class( 'catalog-item' ); ?>>

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

	<?php do_action( 'sc_catalog_after_item' ); ?>