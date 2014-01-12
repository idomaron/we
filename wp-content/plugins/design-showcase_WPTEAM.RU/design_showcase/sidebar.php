<?php global $kriesi_options; ?>
    </div><!-- end content-->
<div class="sidebar"> 
 <ul id="block1" class="tablist">  
<?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('Right Sidebar Top') ) : ?> </ul><?php else : ?>
			<li></li></ul>

			<?php endif; ?> 

<ul class="widget_block tablist">
<?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('Right Sidebar Autotabs') ) : ?> </ul><?php else : ?>
		<li class="nowidget">
            <ul>
            <li class="nowidgettitle"><h3>Страницы</h3></li>
            <?php wp_list_pages('title_li=' ); ?>
            </ul>
    
            <ul class="widget_recent_archives">
            <li class="nowidgettitle"><h3>Архивы</h3></li>
            <?php wp_get_archives('type=monthly'); ?>
            </ul>
                
            <ul>
            <li class="nowidgettitle"><h3>Категории</h3></li>
            <?php wp_list_cats('sort_column=name&optioncount=1&hierarchical=0'); ?>
            </ul>
    
            <ul>
            <li class="nowidgettitle"><h3>Блогролл</h3></li>
            <?php wp_list_bookmarks('title_li=&categorize=0'); ?>
            </ul>
        </li>
			<?php endif; ?> 
            
            

 <ul id="block2" class="tablist">  
<?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('Right Sidebar Bottom') ) : ?> </ul><?php else : ?>
			<li></li></ul>
			<?php endif; ?> 
	</div><!-- end sidebar -->
