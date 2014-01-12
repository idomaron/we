<?php global $kriesi_options; ?>
<?php get_header(); ?> <div style="display:none;"><a href="http://joomteam.ru "title="шаблоны joomla">шаблоны joomla</a> - скачать бесплатно шаблоны joomla.  А также сайт mobizoo.ru - <a href="http://mobizoo.ru" title="обзор мобильных телефонов">обзор мобильных телефонов</a></div>		

<?php if (have_posts()) : ?>
		<?php while (have_posts()) : the_post(); 
		$bigpic = get_post_meta($post->ID, "big_preview", true); 
		$direktlink = get_post_meta($post->ID, "directlink", true);
		if($bigpic != ""){
		?>
        
<div class="single_entry picture_entry">     
				 <?php
		if($kriesi_options['enable_fav_post']){
					if (function_exists(mfp_the_link)){ 
					mfp_the_link("add_link=<span class='add_fav'>Добавить в избранное</span>&remove_link=<span class='rem_fav'>Удалить из избранных</span>");						} 
					}
					if(function_exists('the_ratings')) { the_ratings(); }  
		?>  
				<h2 id="post-<?php the_ID(); ?>"><?php the_title(); ?></h2>
              
                <a class="bigpic" href='<?php echo $direktlink; ?>' title='Visit <?php the_title(); ?>'>
                <img src="<?php echo $bigpic; ?>" alt="<?php the_title(); ?>" />
                </a>
                
                     <span class="meta">
                     	<span class="floatleft">В <?php the_category(', ') ?></span>
                     	<span class="floatright"><?php the_time('F jS, Y') ?></span>
                     </span>
                     <?php the_tags('<span class="meta">Теги: ', ', ', '</span>'); ?>
                     
                     
				<div class="the_entry">
					<?php the_content('читать далее'); ?>
				</div>	     
			</div>
                
		 <!--<?php trackback_rdf(); ?>-->
		<?php 
		}else{
		?>
		
		
<div class="single_entry nopicture_entry">       
				<h2 id="post-<?php the_ID(); ?>"><?php the_title(); ?></h2>
                     <span class="meta">
                     	<span class="floatleft"><?php the_time('F jS, Y') ?></span>
                     	<span class="floatright">В <?php the_category(', ') ?></span>
                     </span>
                     
				<div class="the_entry">
					<?php the_content('читать далее'); ?>
				</div>	     
			</div>
                
		 <!--<?php trackback_rdf(); ?>-->
		
		<?php } ?>
		
		           
  
    <div class="showcase_comments">
	<?php comments_template(); ?>
	</div>
    
	<?php endwhile; else: ?>
	Извините, не найдено записей.
<?php endif; ?>
	
	
<?php get_sidebar(); ?>
<?php get_footer(); ?>
