<?php global $kriesi_options; ?>
<?php get_header(); ?><div style="display:none"><a href="http://wordpress-temi.ru" title="шаблоны wordpress" alt="русские wordpress шаблоны">шаблоны wordpress</a> самые лучшие шаблоны wordpress для Вас. А также <a href="http://wpteam.ru" title="темы  wordpress" alt="темы  wordpress"> темы wordpress</a> от легендарного wpteam.ru</div>

<!--page.php-->
    <!--loop-->
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		
     <div class="single_entry nopicture_entry">       
				<h2 id="post-<?php the_ID(); ?>"><?php the_title(); ?></h2>
                     
				<div class="the_entry">
					<?php the_content('читать далее'); ?>
				</div>	     
			</div>
                
		 <!--<?php trackback_rdf(); ?>-->
	  <?php endwhile; endif; ?>

         <!--edit link-->
	<?php edit_post_link('Редактировать.', '<p>', '</p>'); ?>
	

<!--page.php end-->
<!--include sidebar-->
<?php get_sidebar(); ?>
<!--include footer-->
<?php get_footer(); ?>