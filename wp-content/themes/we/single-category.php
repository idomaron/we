<?php
/*
Template Name: Single Category
*/	
					get_header(); ?>

	<section id="primary" class="content-area">
		<div id="content" class="site-content" role="main">    
			
			<?php include "header-category.php"?>
			
		</div><!-- #content -->
	</section><!-- #primary -->

<?php
//get_sidebar( 'content' );
get_sidebar();
get_footer();
