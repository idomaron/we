<?php
function show($s, $varName='')
{
	echo '<pre>';
	echo $varName.'</br>';
	echo '===========</br>';
	var_dump($s);
	echo '</pre>';
}
function showPostsCategory($numberOfPost, $postType, $category)
	{	
		global $post;
		
		$args = array( 
			'posts_per_page' => $numberOfPost,
			'order'=> 'ASC',
			'orderby' => 'title',
			'category' => $category,
			'post_type' => $postType, );
			
		$postslist = get_posts( $args );

		foreach ( $postslist as $post ){
			
		 setup_postdata( $post ); ?> 
			<div>
				<?php the_date(); ?>
				<br />
				<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>   
				<?php the_excerpt(); ?>
			</div>
		<?php }
	}
	
function CreateCustomMenu($arrGet, $home, $extra, $class)
{				
	foreach ($arrGet as $Get => $Name){
				
				$Name = $arrGet[$Get];
							
				$extra .= '<li id="category-menu-item" class="'.$class.'">
							<a class="category-title" href='.$home.'?view='.$Get.'>
								'.($Name).' 					
							</a>
						</li>'; 
				}
	return $extra;
}


function add_personal_area_menu_item($items, $args) {
	$user = wp_get_current_user();
	// Make sure this is the Primary Menu.
	// You may need to modify this condition
	// depending on your theme.
	if ($args->theme_location == 'secondary') {
		// CSS class to use for <li> item.
		$class = 'menu-item';
		
		$home = get_site_url();
		
		if (is_user_logged_in()) {
			// User is logged in, link to welcome page.
			//.$user->data->user_login. display login name of current user
			$extra = 
				'				
				<li id="menu-item-personal-area" class="'.$class.'">
					<a href='.$home.'/all-user-events/booking>
						אירועים שנרשמתי
					</a>
				</li>
				<li id="menu-item-personal-area" class="'.$class.'">
					<a href='.$home.'/private-zone?link=SA>
						ניהול סוכן חכם והתראות
					</a>
				</li>
				<li id="menu-item-personal-area" class="'.$class.'">
					<a href='.$url.'>
						מאמרים מועדפים אין לינק עדיין
					</a>
				</li>
				<li id="menu-item-personal-area" class="'.$class.'">
					<a href='.$home.'/profile-user?a=edit>
						ניהול פרטים
					</a>
				</li>
				<li id="menu-item-personal-area" class="'.$class.'"> <a href="#">-------------</a></li>
				
				<li id="menu-item-personal-area" class="'.$class.'">
					<a href='.$home.'/private-zone?link=created>
						אירועים שיצרתי
					</a>
				</li>
				<li id="menu-item-personal-area" class="'.$class.'">
					<a href='.$home.'/aproved-page>
						ניהול נרשמים
					</a>
				</li>				
				';
		} else {
			// User is guest, link to login page.
			$extra = 
			'<li id="menu-item-logged-out-user" class="'.$class.'">
				<a href="/wp-login.php">
					'.__('Log in').'
				</a>
			</li>';	
		}

		// Add extra link to existing menu.
		$items = $items . $extra; 
	}
	elseif ($args->theme_location == 'category-menu' && is_category()) {
		// CSS class to use for <li> item.
		$class = 'category-menu';
		$myString = ($_SERVER['REQUEST_URI']); 
		$home = preg_replace('/^(.+?)(\?.*?)?(#.*)?$/', '$1$3', $myString);		
				
		//show(get_the_category($category->cat_name));
			$arrGet = array (
								'hazon' => 'חזון',
								'sirtonim-ve-meda' => 'סירטונים ומידע',
								'irgunim' => 'אירגונים', 
								'to-do' => 'מה אני יכול לעשות?</br>(פתרונות)', 
								'events' => 'אירועים', 
								'forum' => 'פורום');
			$extra = 
				'<li id="category-menu-item" class="'.$class.'">
					 <a class="category-title" href="' . $home . '"> ראשי</a>	
				</li>';
				
			$extra =  CreateCustomMenu($arrGet, $home, $extra, $class);
	
		// Add extra link to existing menu.
		$items = $items . $extra; 
	}
	// Return menu items.
	return $items;
} 
// Hook into wp_nav_menu_items.
add_filter( 'wp_nav_menu_items', 'add_personal_area_menu_item', 10, 2 );

function register_my_menus(){
	register_nav_menus	( array( 'category-menu' => 'category-menu'));
}
if (function_exists('register_nav_menus'))
{
	add_action( 'init', 'register_my_menus' );
}


?>