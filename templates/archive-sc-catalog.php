<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

get_header( 'sc-catalog' ); ?>

	<?php 
		/**
		 * Showcase Catalog Main Content Before
		 * 
		 * @hooked sc_catalog_content_wrap_open - 10
		 */
		do_action( 'sc_catalog_before' ); 

	?>

		<?php while ( have_posts() ) : the_post(); ?>

			<?php sc_catalog_get_template_part( 'content', 'single-item' ); ?>

		<?php endwhile; // end of the loop. ?>

	<?php
		/**
		 * Showcase Catalog Main After
		 * 
		 * @hooked sc_catalog_content_wrap_close - 10
		 */
		do_action( 'sc_catalog_after' ); 
	?>

<?php get_footer( 'sc-catalog' ); ?>