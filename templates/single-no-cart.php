<?php
/**
 * The Template for displaying all No Cart Items
 *
 * Override this template by copying it to yourtheme/no-cart/single-no-cart.php
 *
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

get_header( 'no-cart' ); ?>

	<?php 
		/**
		 * No Cart Main Content Before
		 * 
		 * @hooked nc_content_wrap_open - 10
		 */
		do_action( 'no_cart_before' ); 
	?>

		<?php while ( have_posts() ) : the_post(); ?>

			<?php nc_get_template_part( 'content', 'single-item' ); ?>

		<?php endwhile; // end of the loop. ?>

	<?php
		/**
		 * No Cart Main After
		 * 
		 * @hooked nc_content_wrap_close - 10
		 */
		do_action( 'no_cart_after' ); 
	?>

<?php get_footer( 'no-cart' ); ?>