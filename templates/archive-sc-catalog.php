<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

get_header( 'sc-catalog' ); ?>

	<?php 
		/**
		 * Showcase Catalog Main Content Before
		 * 
		 * @hooked sc_content_wrap_open - 10
		 */
		do_action( 'sc_catalog_archive_before' ); 
	?>

		<?php while ( have_posts() ) : the_post(); ?>

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
	?>

<?php get_footer( 'sc-catalog' ); ?>