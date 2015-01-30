<?php 
/**
 * Content for the single item view in No Cart
 */

?>

	<?php do_action( 'no_cart_before_single_item' ); ?>

	<div id="item-<?php the_ID(); ?>" <?php post_class(); ?>>

		<?php 
			/**
			 * Output the featured image
			 * 
			 * @hooked nc_single_image()
			 */
			do_action( 'no_cart_single_image' );
		?>

		<div class="item-details">

			<?php 
				/**
				 * Output for the item details
				 * 
				 * @hooked nc_item_single_title()
				 * @hooked nc_item_get_price()
				 */
				do_action( 'no_cart_item_details' );
			?>

		</div><!-- /.item-details -->

		<?php
			/**
			 * No Cart Item Content
			 * 
			 * @hooked nc_item_content()
			 */
			do_action( 'no_cart_item_content' );
		?>

	</div><!-- .entry-content -->

	<?php do_action( 'no_cart_after_single_item' ); ?>