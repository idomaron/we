<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other 'pages' on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */

get_header(); 
?>
	
<div id="main-content" class="main-content">

<?php /*?><?php
	if ( is_front_page() && twentyfourteen_has_featured_posts() ) {
		// Include the featured content template.
		get_template_part( 'featured-content' );
	}
?><?php */?>
	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">
	
<?php
		if($user_ID == 0){ 
			echo "<a href=".site_url()."/wp-admin style='margin:50px; font-size: 50px;'>Please, Log In</a>";
			}
		else{
?>
<div class="two-colomns">









	
<?php /*********************************************************************************************************/
$i = 1;
while($i <= 4){
	$post_object = get_field('articles-'.$i);
	 
		if( $post_object ): 
		 
			// override $post
			$post = $post_object;
			setup_postdata( $post ); 
		 
			?>
			<div class="block">
				<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
				<p ><?php the_excerpt();?></p>
			</div>
			<?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly 
			 endif; 	
	$i ++;
}
/*********************************************************************************************************/
?>
</div>
<div class="two-colomns">
<?php 
	$video = the_field('video'); 
		if ($video){
			echo $video;
		}
		
	$event_object = get_field('event');
	 
		if( $event_object ): 
		 
			// override $post
			$post = $event_object;
			setup_postdata( $post ); 
		 
			?>
			<div class="block">
				<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
				<p ><?php the_excerpt();?></p>
			</div>
			<?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly 
			 endif; 
?>				



<?php /*********************************************************************************************************/
$i = 1;
while($i <= 2){
	$post_object = get_field('articles-'.$i);
	 
		if( $post_object ): 
		 
			// override $post
			$post = $post_object;
			setup_postdata( $post ); 
		 
			?>
			<div class="block">
				<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
				<p ><?php the_excerpt();?></p>
			</div>
			<?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly 
			 endif; 	
	$i ++;
}
/*********************************************************************************************************/
} ?>

</div>		

	
		</div><!-- #content -->
	</div><!-- #primary -->
</div><!-- #main-content -->

<?php
get_sidebar();
get_footer();
