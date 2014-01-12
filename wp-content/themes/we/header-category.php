<nav  class="site-navigation primary-navigation category" role="navigation">
    <div class="menu-menu-container">
        <?php wp_nav_menu( array( 'theme_location' => 'category-menu' ) ); ?>
    </div>
</nav>
<?php 
		if ( $categoryPage == 'hazon' ) {?>
   
            <article class = "one-colomn block">
            	<?php showPostsCategory( 1, 'today', $category ); ?>
            </article>
            
            <article class = "one-colomn block">	
                <?php showPostsCategory( 1, 'vision', $category ); ?>
            </article>
           			
            <article class = "one-colomn block">
            	<?php showPostsCategory(3, 'solution', $category); ?>
            </article>
            
<?php 	} else { ?>
			<article class = "two-colomns block-right">
            	<?php showPostsCategory( 1, 'vision', $category ); ?>
            </article>
            <article class = "two-colomns block-left">
            	<?php showPostsCategory( 1, 'today', $category ); ?>
            </article>    
<?php 	}
wp_reset_postdata();
?>            