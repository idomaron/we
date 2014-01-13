<?php
/* 
Template Name: Donors
*/
get_header(); ?>

<div id="main-content" class="main-content">
	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">

<?php
			$query = new WP_Query; 
			$query->query('post_type=donors');
			
			if($query->have_posts()){
				while($query->have_posts()){
					$query->the_post(); ?>
					<div  class ="donors">
						<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
						<?php //the_content(); 
						echo get_the_post_thumbnail();?>
					</div>                        
<?php				}
                }
			else {
					echo "No Donors";
				}
				/* Restore original Post Data */
			wp_reset_postdata();
?>

		</div><!-- #content -->
	</div><!-- #primary -->
</div><!-- #main-content -->

<?php
get_footer();
