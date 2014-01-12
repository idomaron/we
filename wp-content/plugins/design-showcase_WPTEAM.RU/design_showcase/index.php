<?php global $kriesi_options; ?>
<?php get_header(); ?>


	<?php 
	
	if ($kriesi_options['com_cat']){
query_posts($query_string . "&cat=-".$kriesi_options['com_cat']);
}

	if (have_posts()) : $postnumber = 1; ?>
		<?php while (have_posts()) : the_post(); 
		
		$smallpic = get_post_meta($post->ID, "small_preview", true); 
		$bigpic = get_post_meta($post->ID, "big_preview", true); 
		$direktlink = get_post_meta($post->ID, "directlink", true); 
		?>
		<div class="entry <?php if($postnumber % 2 == 1){echo "left_side";} ?>">		
				<h2 id="post-<?php the_ID(); ?>">
                	<a href="<?php the_permalink() ?>" rel="bookmark" title="Постоянная Ссылка для <?php the_title(); ?>"><?php the_title(); ?></a>
                </h2>
                <div class="prev_image">
                    <a href="<?php echo $direktlink; ?>" rel="<?php echo $bigpic; ?>">
                    <img src="<?php echo $smallpic; ?>" alt ="" />
                    </a>
                </div>
				
					
		 <!--<?php trackback_rdf(); ?>-->
                 <span class="edit_link"><?php edit_post_link('E', '', ''); ?></span>
				<span class="meta"><?php comments_popup_link('(0)', '(1)', '(%)');?></span>
        <?php
		if($kriesi_options['enable_fav_post']){
					if (function_exists(mfp_the_link)){ 
					mfp_the_link("add_link=<span class='add_fav'>Добавить в избранное</span>&remove_link=<span class='rem_fav'>Удалить из избранных</span>");						} 
					}
					
		 if(function_exists('the_ratings')) { the_ratings(); }  			
					
		?>
		</div>	
		<?php 
		$postnumber++;
		 endwhile; ?>

    <?php kriesi_pagination($query_string); ?>
    <div class="clearboth"></div>
		
	<?php else : ?>

		<p>Ничего Не найдено.<br/>
		Извините, но ничего не найдено по вашему запросу.</p>
		<?php include (TEMPLATEPATH . "/searchform.php"); ?>
	<?php endif; ?>
    
<?php get_sidebar(); ?>

<?php get_footer(); ?>