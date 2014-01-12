<?php
/**
 * The template for displaying Author archive pages
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */

get_header();?>

	<section id="primary" class="content-area" >
		<div id="content" class="site-content" role="main">
			
            
			<?php 
			echo 'name: ';
			the_author_meta('display_name');
			echo '<br>';
			echo 'location: ';
			the_author_meta('location');
			echo '<br>';

				?>

		</div><!-- #content -->
	</section><!-- #primary -->

<?php
get_sidebar( 'content' );
get_sidebar();
get_footer();
