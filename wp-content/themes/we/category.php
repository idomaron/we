<?php get_header(); ?>

	<section id="primary" class="content-area">
		<div id="category-page" class="site-content" role="main">    
        		
				<header class="archive-header">
					<h1 class="archive-title"><?php single_cat_title();?></h1>
				</header><!-- .archive-header -->
			<?php 		
			
				if( isset($_GET['view']) ){	
							
					$categoryPage = $_GET['view'];
					include "header-category.php";						
						switch ($_GET['view']) {
													
							case 'hazon':
								
							break;
							
							case 'sirtonim-ve-meda':
								echo '<article class = "one-colomn block">';
									showPostsCategory( -1, 'video_and_info', $category ); 
								echo '</article>';
			
							break;
							
							case 'irgunim':
								echo '<article class = "one-colomn block">';
									 
								echo '</article>';
					
							break;
							
							case 'to-do':
								echo '<article class = "one-colomn block">';
									showPostsCategory( 1, 'solution', $category ); 
								echo '</article>';
							
							break;
							
							case 'events':
								echo '<article class = "one-colomn block">';
									showPostsCategory( -1, 'event', $category ); 
								echo '</article>';
							
							break;
							
							case 'forum':
								echo '<article class = "one-colomn block">';
									 
								echo '</article>';
								
							break;
						}
					}
					else{ 
                    	include "header-category.php";
						include "main-category.php";?>                   
			<?php	}
			?>	
           	
		</div><!-- #content -->
	</section><!-- #primary -->

<?php
//get_sidebar( 'content' );
get_sidebar();
get_footer();