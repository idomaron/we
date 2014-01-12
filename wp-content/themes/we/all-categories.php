<?php
/*
Template Name: All categories
*/	
					get_header(); ?>

	<section id="primary" class="content-area">
		<div id="content" class="site-content" role="main">    
			

			<header class="archive-header">
				<h1 class="archive-title"><?php the_title(); ?></h1>
			</header><!-- .archive-header -->

			
				<div class="all-categories-text">
				<?php		if(get_field('all-category-text'))
							{
								echo '<p>' . get_field('all-category-text') . '</p>';
							}
				?>
				</div>		
				<div class="all-categories-video">	
				<?php			if(get_field('video'))
							{
								echo '<p>' . get_field('video') . '</p>';
							}
				?>
				</div>
                <div>
                	<h2 class="all-categories-subtitle">נושאי עולם חדש</h2>
                    <?php 
					$argsCategoriesPosts = array(
						'type'                     => 'post',
						'parent'                   => 0,
						'orderby'                  => 'name',
						'order'                    => 'ASC',
						'hide_empty'               => 0,
						'taxonomy'                 => 'category',
						'pad_counts'               => false 
					); 
					$argsCategoriesEvents = array(
						'type'                     => 'event',
						'parent'                   => 0,
						'orderby'                  => 'name',
						'order'                    => 'ASC',
						'hide_empty'               => 0,
						'taxonomy'                 => 'category',
						'pad_counts'               => false 
					);
					$categoriesInitions = array(
						'type'                     => 'inition',
						'parent'                   => 0,
						'orderby'                  => 'name',
						'order'                    => 'ASC',
						'hide_empty'               => 0,
						'taxonomy'                 => 'category',
						'pad_counts'               => false 
					);
				
					$categoriesPosts = get_categories( $argsCategoriesPosts );
					$categoriesEvents = get_categories( $argsCategoriesEvents );
					 ?>
                   <ul id="all-categories-menu"> 
				<?php	foreach ( $categoriesEvents as $category ){
							$categoryEvents[] = $category->count;
						}
						foreach ( $categoriesInitions as $category ){
							$categoryInitions[] = $category->count;
						}	
						$i = 0;
						
						foreach ( $categoriesPosts as $category ){
                        echo '<li class="each-category" ><a class="category-title" href="' . get_category_link( $category->term_id ) . '">' . $category->name . '</a>';
						echo '<p class="counter-of-posts">Post Count: '. $categoryInitions[$i] . '</p>';
						echo '<p class="counter-of-posts">Post Count: '. $categoryEvents[$i] . '</p>';
						echo '<p class="counter-of-posts">Post Count: '. $category->count . '</p></li>';
						$i++;
						}
						
				 ?>
                  </ul>
                </div>
			
		</div><!-- #content -->
	</section><!-- #primary -->

<?php
//get_sidebar( 'content' );
get_sidebar();
get_footer();
