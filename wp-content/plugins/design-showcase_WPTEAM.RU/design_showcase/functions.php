<?php
/*
Attention: all functions within this file are developed by Christian "Kriesi" Budschedl
You are allowed to use them in non-commercial projects as well as in commercial projects. What you are not allowed to do is to redistribute the functions or part of them (eg in wordpress templates)

Contact: office@kriesi.at or at http://www.kriesi.at/contact
*/
global $kriesi_options;
$kriesi_options  = get_option('kriesi_options');

function kriesi_exclude($query_string) {
global $kriesi_options;
if ($kriesi_options['com_cat'] != ""){
	$exclude = $kriesi_options['com_cat'];
	$query = $query_string ."&cat=-$exclude";
	query_posts($query);
	}
}


class simple_breadcrumb{
	var $options;
	
function simple_breadcrumb(){
	
	$this->options = array( 	//change this array if you want another output scheme
	'before' => '<span> ',
	'after' => ' </span>',
	'delimiter' => '&raquo;'
	);
	
	$markup = $this->options['before'].$this->options['delimiter'].$this->options['after'];
	
	global $post;
	echo '<p class="breadcrumb"><span class="breadcrumb_1st">Вы здесь: <a href="'.get_option('home').'">';
		bloginfo('name');
		echo "</a></span>";
		if(!is_front_page()){echo $markup;}
				
		$output = $this->simple_breadcrumb_case($post);
		
		echo "<span class='current_crumb'>";
		if ( is_page() || is_single()) {
		the_title();
		}else{
		echo $output;
		}
		echo " </span></p>";
	}
	
function simple_breadcrumb_case($der_post){
	$markup = $this->options['before'].$this->options['delimiter'].$this->options['after'];
	if (is_page()){
		 if($der_post->post_parent) {
			 $my_query = get_post($der_post->post_parent);			 
			 $this->simple_breadcrumb_case($my_query);
			 $link = '<a href="';
			 $link .= get_permalink($my_query->ID);
			 $link .= '">';
			 $link .= ''. get_the_title($my_query->ID) . '</a>'. $markup;
			 echo $link;
		  }	
	return;			 	
	} 
			
			
	if(is_single()){
		$category = get_the_category();
		if (is_attachment()){
		
			$my_query = get_post($der_post->post_parent);			 
			$category = get_the_category($my_query->ID);
			$ID = $category[0]->cat_ID;

			echo get_category_parents($ID, TRUE, $markup, FALSE );
			previous_post_link("%link $markup");
			
		}else{
			$ID = $category[0]->cat_ID;
			echo get_category_parents($ID, TRUE, $markup, FALSE );

		}
	return;
	}
	
	if(is_category()){
		$category = get_the_category(); 
		$i = $category[0]->cat_ID;
		$parent = $category[0]-> category_parent;
		
		if($parent > 0 && $category[0]->cat_name == single_cat_title("", false)){
			echo get_category_parents($parent, TRUE, $markup, FALSE);
		}
	return single_cat_title('',FALSE);
	}
	
	
	if(is_author()){
		$curauth = get_userdatabylogin(get_query_var('author_name'));
		return "Автор: ".$curauth->nickname;
	}
	if(is_paged()){global $paged; return $markup. "Страница ". $paged;}
	
	if(is_tag()){ return "Тег: ".single_tag_title('',FALSE); }
	
	if(is_404()){ return "404 - Страница не Найдена"; }
	
	if(is_search()){ return "Поиск"; }	
	
	if(is_year()){ return get_the_time('Y'); }
	
	if(is_month()){
	$k_year = get_the_time('Y');
	echo "<a href='".get_year_link($k_year)."'>".$k_year."</a>".$markup;
	return get_the_time('F'); }
	
	if(is_day() || is_time()){ 
	$k_year = get_the_time('Y');
	$k_month = get_the_time('m');
	$k_month_display = get_the_time('F');
	echo "<a href='".get_year_link($k_year)."'>".$k_year."</a>".$markup;
	echo "<a href='".get_month_link($k_year, $k_month)."'>".$k_month_display."</a>".$markup;

	return get_the_time('jS (l)'); }
	
	}

}


function kriesi_no_generator($query_string) { return ''; }  
add_filter('the_generator','kriesi_no_generator');


function kriesi_pagination($query_string){
global $posts_per_page, $paged;
$my_query = new WP_Query($query_string ."&posts_per_page=-1");
$total_posts = $my_query->post_count;
if(empty($paged))$paged = 1;
$prev = $paged - 1;							
$next = $paged + 1;	
$range = 2; // only edit this if you want to show more page-links
$showitems = ($range * 2)+1;

$pages = ceil($total_posts/$posts_per_page);
if(1 != $pages){
	echo "<div class='pagination'>";
	echo ($paged > 2 && $paged+$range+1 > $pages && $showitems < $pages)? "<a href='".get_pagenum_link(1)."'>&laquo;</a>":"";
	echo ($paged > 1 && $showitems < $pages)? "<a href='".get_pagenum_link($prev)."'>&lsaquo;</a>":"";
	
		
	for ($i=1; $i <= $pages; $i++){
	if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems )){
	echo ($paged == $i)? "<span class='current'>".$i."</span>":"<a href='".get_pagenum_link($i)."' class='inactive' >".$i."</a>"; 
	}
	}
	
	echo ($paged < $pages && $showitems < $pages) ? "<a href='".get_pagenum_link($next)."'>&rsaquo;</a>" :"";
	echo ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) ? "<a href='".get_pagenum_link($pages)."'>&raquo;</a>":"";
	echo "</div>\n";
	}
}


// Widget Settings

if ( function_exists('register_sidebar') )
	register_sidebar(array(
		'name' => 'Footer',
		'before_widget' => '<li id="%1$s" class="widget %2$s">', 
	'after_widget' => '</li>', 
	'before_title' => '<h3 class="widgettitle">', 
	'after_title' => '</h3>', 
	));
	
if ( function_exists('register_sidebar') )
	register_sidebar(array(
	'name' => 'Right Sidebar Autotabs',
	'before_widget' => '<li id="%1$s" class="widget %2$s">', 
	'after_widget' => '</li>', 
	'before_title' => '<h3 class="widgettitle">', 
	'after_title' => '</h3>', 
	));
	

if ( function_exists('register_sidebar') )
	register_sidebar(array(
		'name' => 'Right Sidebar Top',
		'before_widget' => '<li id="%1$s" class="widget %2$s">', 
	'after_widget' => '</li>', 
	'before_title' => '<h3 class="widgettitle">', 
	'after_title' => '</h3>', 
	));
	
if ( function_exists('register_sidebar') )
	register_sidebar(array(
		'name' => 'Right Sidebar Bottom',
		'before_widget' => '<li id="%1$s" class="widget %2$s">', 
	'after_widget' => '</li>', 
	'before_title' => '<h3 class="widgettitle">', 
	'after_title' => '</h3>', 
	));
	
################ admin

global $fields, $fieldsname;

$fields[0]= "small_preview";
$fields[1]= "big_preview";
$fields[2]= "directlink";
$fieldsname[0]= "Маленькое Превью Изображение (220px x 150px)";
$fieldsname[1]= "Большое Превью Изображение (477px x 170px)";
$fieldsname[2]= "Прямая Ссылка";
function kriesi_create_form(){
global $fields, $fieldsname;
$loop = count($fields);

if(isset($_GET['post'])){
$post_id = $_GET['post'];
}

?>

 
<div class="postbox closed" id="projektsdiv">
<h3>Design Showcase Изображения</h3>
<div class="inside">
<?php 

for ($i=0; $i<$loop; $i++){
	if ($post_id != ""){
		$current_field = $fields[$i];
		$value = get_post_meta($post_id, $current_field, true);
	}
	
	echo "<p class='extra_$i'><label for='".$fields[$i]."'>".$fieldsname[$i].": </label><input id='".$fields[$i]."' name='".$fields[$i]."' type='text' value='$value'></p>";

	
} ?>
</div></div>



<?php }
	
function kriesi_save_data($post_id){
global $fields;
$loop = count($fields);

	for ($i=0; $i<$loop; $i++){
		$current_field = $fields[$i];
		kriesi_insert_data($current_field, $post_id);		
		}
}

function kriesi_insert_data($current_field, $post_id){
global $fields;
$new_value = $_POST[$current_field];
		$value = get_post_meta($post_id, $current_field, true);
		
		if ($new_value == ""){
					if ($value != ""){
						delete_post_meta($post_id, $current_field, $value);
					}
		
				} else{
					if ($value == ""){
						add_post_meta($post_id, $current_field, $new_value, true);
					}else if ($value != $new_value ){
						update_post_meta($post_id, $current_field, $new_value, $value);	
					}
				}
			}


function kriesi_append_stylesheet(){?>
<link rel='stylesheet' href='<?php echo bloginfo('template_url'); ?>/admin.css' type='text/css' /><?php }

add_action('admin_head','kriesi_append_stylesheet');
add_action('edit_page_form','kriesi_create_form',1);
add_action('edit_form_advanced','kriesi_create_form',1);
add_action('save_post','kriesi_save_data');




#####################################################################
function kriesi_advert_widget($args) {
#####################################################################
          extract($args);
		$options  = get_option('kriesi_advert_widget');
		$add1_link = attribute_escape($options['add1_link']);
		$add2_link = attribute_escape($options['add2_link']);
		$add3_link = attribute_escape($options['add3_link']);
		
		$add1_img = empty( $options['add1_img'] ) ? '' : "<img src='".$options['add1_img']."' alt='' />";
		$add2_img = empty( $options['add2_img'] ) ? '' : "<img src='".$options['add2_img']."' alt='' />";
		$add3_img = empty( $options['add3_img'] ) ? '' : "<img src='".$options['add3_img']."' alt='' />";
		
		
      ?>
              <?php echo $before_widget; ?>
		<ul>
        <li class="ka_1"><a href="<?php echo $add1_link;?>"><?php echo $add1_img;?></a></li>
        <li class="ka_2"><a href="<?php echo $add2_link;?>"><?php echo $add2_img;?></a></li>
        <li class="ka_3"><a href="<?php echo $add3_link;?>"><?php echo $add3_img;?></a></li>
        </ul>               
              <?php echo $after_widget; ?>
      <?php
      }
	  
function kriesi_advert_admin(){
$options = $newoptions = get_option('kriesi_advert_widget');
	if ( $_POST['kriesi-advert-submit'] ) {
		$newoptions['add1_img'] = strip_tags(stripslashes($_POST['makemoney-add1_img']));
		$newoptions['add1_link'] = strip_tags(stripslashes($_POST['makemoney-add1_link']));


		$newoptions['add2_img'] = strip_tags(stripslashes($_POST['makemoney-add2_img']));
		$newoptions['add2_link'] = strip_tags(stripslashes($_POST['makemoney-add2_link']));

		$newoptions['add3_img'] = strip_tags(stripslashes($_POST['makemoney-add3_img']));
		$newoptions['add3_link'] = strip_tags(stripslashes($_POST['makemoney-add3_link']));

	}
		if ( $options != $newoptions ) {
		$options = $newoptions;
		update_option('kriesi_advert_widget', $options);
		}
		
		$add1_img = attribute_escape($options['add1_img']);
		$add1_link = attribute_escape($options['add1_link']);
		$add2_img = attribute_escape($options['add2_img']);
		$add2_link = attribute_escape($options['add2_link']);
		$add3_img = attribute_escape($options['add3_img']);
		$add3_link = attribute_escape($options['add3_link']);


?>
<p>
<input id="kriesi-advert-submit" type="hidden" value="1" name="kriesi-advert-submit"/>
<label for="makemoney-add1_img">Реклама: 1 Изображение: (125px x 125px)</label>
<input id="makemoney-add1_img" class="widefat" type="text" value="<?php echo $add1_img; ?>" name="makemoney-add1_img"/>
<label for="makemoney-add1_link">Реклама: 1 URL Ссылка:</label>
<input id="makemoney-add1_link" class="widefat" type="text" value="<?php echo $add1_link; ?>" name="makemoney-add1_link"/>
</p>

<p>
<label for="makemoney-add2_img">Реклама: 2 Изображение: (125px x 125px)</label>
<input id="makemoney-add2_img" class="widefat" type="text" value="<?php echo $add2_img; ?>" name="makemoney-add2_img"/>
<label for="makemoney-add2_link">Реклама: 2 URL Ссылка:</label>
<input id="makemoney-add2_link" class="widefat" type="text" value="<?php echo $add2_link; ?>" name="makemoney-add2_link"/>
</p>

<p>
<label for="makemoney-add3_img">Реклама: 3 Изображение: (125px x 125px)</label>
<input id="makemoney-add3_img" class="widefat" type="text" value="<?php echo $add3_img; ?>" name="makemoney-add3_img"/>
<label for="makemoney-add3_link">Реклама: 3 URL Ссылка:</label>
<input id="makemoney-add3_link" class="widefat" type="text" value="<?php echo $add3_link; ?>" name="makemoney-add3_link"/>
</p>

<?
}	  
	  
	  
      register_sidebar_widget('Advertise Widget', 'kriesi_advert_widget');
	  register_widget_control('Advertise Widget', 'kriesi_advert_admin');


#####################################################################
#####################################################################







#####################################################################
function widget_com_news_init(){
#####################################################################
	if ( !function_exists('register_sidebar_widget') ) {
		return;
	}
	function com_news_control_display_widget(){
	$options = $newoptions = get_option('com_news_display_widget');
	
	if ( $_POST['com_news-submit'] ) {
		$newoptions['com_news_title'] = strip_tags(stripslashes($_POST['com_news_title']));
		$newoptions['com_news_cat'] = strip_tags(stripslashes($_POST['com_news_cat']));
		$newoptions['com_news_number'] = strip_tags(stripslashes($_POST['com_news_number']));
		}
		
	if ( $options != $newoptions ) {
		$options = $newoptions;
		update_option('com_news_display_widget', $options);
		}
	
	?><p>
    <input id="com_news-submit" type="hidden" value="1" name="com_news-submit"/>
<label for="com_news_title">Название</label>
<input id="com_news_title" class="widefat" type="text" value="<?php echo $newoptions['com_news_title']; ?>" name="com_news_title"/>
</p>

<p>
<label for="com_news_cat">Категория</label>
<input id="com_news_cat" class="widefat" type="text" value="<?php echo $newoptions['com_news_cat']; ?>" name="com_news_cat"/>
</p>

<p>
<label for="com_news_number">Количество записей <small>(по умолчанию "5")</small></label>
<input id="com_news_number" class="widefat" type="text" value="<?php echo $newoptions['com_news_number']; ?>" name="com_news_number"/>
</p>
<?php	
	
	}
	
	function com_news_display_widget($args){
		 extract($args);
		$options  = get_option('com_news_display_widget');
		$title = empty( $options['com_news_title'] ) ? 'Community News' : $options['com_news_title'];
		$cat = empty( $options['com_news_cat'] ) ? '1' : $options['com_news_cat'];
		$showposts = empty( $options['com_news_number'] ) ? 5 : $options['com_news_number'];
	
		echo $before_widget;
  		echo $before_title;
		echo $title;			
		echo $after_title;
		
		$my_widget_query = new WP_Query("showposts=$showposts&cat=$cat");
		while ($my_widget_query->have_posts()) : $my_widget_query->the_post();
		?>
		
    	<h4 class="sidebar-post" id="sidebar-post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="Постоянная ссылка для <?php the_title(); ?>"><?php the_title(); ?></a></h4>
    		<div class="community_entry">
            <?php the_content(); ?>
            <span class="meta">Опубликовал: <?php the_author_posts_link(); ?> дата: <?php the_time('F jS, Y') ?><?php edit_post_link('Edit',' | ', '' ); ?></span></div>
	<?php 
	 endwhile;
		
  		echo $after_widget;
	}
	
	
register_sidebar_widget('Sidebar News Widget', 'com_news_display_widget');
register_widget_control('Sidebar News Widget', 'com_news_control_display_widget');	
}

add_action('widgets_init', 'widget_com_news_init');


#####################################################################
#####################################################################

// FAV POSTS PLUGIN
global $table_name, $plugin_version;

$table_name = $wpdb->prefix . 'fav_me';
$plugin_version = "1.1.1";


add_action ( 'switch_theme', 'mfp_install'); // starts the installation of the database if the plugin is activated
add_action('init', 'mfp_modify_database'); // calls function mfp_modify_database() at the initialisation of each page


# ----------------------------------
function mfp_install() {
# ----------------------------------
global $wpdb, $version, $table_name;

if (!(current_user_can('switch_themes'))){ // if the user is no admin stop the function here
  return;
};

$table_name = $wpdb->prefix . 'fav_me';

if ($wpdb->get_var("show tables like '$table_name'") != $table_name) { // creates Databse only if a database with this name doesnt exist
  # Create DB table
  $sql = "CREATE TABLE $table_name ("
       ." id int(11) UNSIGNED NOT NULL AUTO_INCREMENT,"
	   ." user_id MEDIUMINT NOT NULL,"
	   ." post_id TEXT NOT NULL,"
	   ." UNIQUE KEY id (id)"
	   ." ) TYPE = MYISAM;";
  require_once(ABSPATH.'wp-admin/upgrade-functions.php');
  dbDelta($sql);
}
# ----------------------------------
} # end mfp_install
# ----------------------------------


# ----------------------------------
function mfp_the_link($var="") { // function to display the "add post to favs" link in front end
# ----------------------------------
if (current_user_can('level_0')){ // if the user is logged in
global $user_ID, $post, $wpdb, $table_name; // get current user id and current post id

//variables we are looking for
$defaults = array(
		'add_link' => 'Добавьте эту запись в ваши избранные записи', 
		'remove_link' => 'Удалите эту запись с ваших избранных записей'
	);

	$endvar = wp_parse_args( $var, $defaults );	
	extract( $endvar, EXTR_SKIP );
	$post_ID = $post->ID; 
	$mod_url = mfp_create_link_url();
	
	$data = $wpdb->get_var("SELECT post_id FROM $table_name WHERE user_id = '$user_ID'");
		if (!(preg_match("/(^".$post_ID.",|,".$post_ID."$|^".$post_ID."$|,".$post_ID.",)/",$data))){
			echo "<a title='Добавьте эту запись в ваши избранные записи' href='".$mod_url."favorite-post=$post_ID'>".$endvar['add_link']."</a>"; // creates a link for adding the post to the database
		} else{
			echo "<a title='Удалите эту запись с ваших избранных записей' href='".$mod_url."remove-post=$post_ID'>".$endvar['remove_link']."</a>"; // creates a link for removing the post to the database
		}
	}
# ----------------------------------
} # end mfp_the_link
# ----------------------------------


# ----------------------------------
function mfp_create_link_url(){
# ----------------------------------

	$current_url = $_SERVER['REQUEST_URI'];
	if(preg_match("/(\?|&)?(remove-post=|favorite-post=)[0-9]+$/",$current_url)){
		$current_url = preg_replace("/(\?|&)?(remove-post=|favorite-post=)[0-9]+/","",$current_url);
	} else{
		$current_url = preg_replace("/(remove-post=|favorite-post=)[0-9]+&?/","",$current_url);
	}
	preg_match("/\?/", $current_url) == 0 ? $mod_url= $current_url."?" :  $mod_url= $current_url."&amp;"; // checks if there is a ? in the URL
	return $mod_url;
	
# ----------------------------------
} # end mfp_the_link
# ----------------------------------


# ----------------------------------
function mfp_modify_database(){
# ----------------------------------
if (current_user_can('level_0') && (isset($_GET['favorite-post']) || isset($_GET['remove-post']))){

		global $user_ID, $wpdb, $table_name;
		
		$post_ID = $wpdb->escape($_GET['favorite-post']);
		$remove_post_ID = $wpdb->escape($_GET['remove-post']);
		
	if(preg_match("/^[0-9]+$/",$post_ID) || preg_match("/^[0-9]+$/",$remove_post_ID)){
		$data = $wpdb->get_var("SELECT post_id FROM $table_name WHERE user_id = '$user_ID'");
		if ($post_ID != ""){ // if the user wants to add a post
			if ($data == ""){
				$wpdb->query("INSERT INTO $table_name (user_id, post_id) VALUES ('$user_ID','$post_ID')"); 
			}else{
				if (!(preg_match("/(^".$post_ID.",|,".$post_ID."$|^".$post_ID."$|,".$post_ID.",)/",$data))){
					$data .= ",".$post_ID;
					$wpdb->query("UPDATE $table_name SET post_id ='$data' WHERE user_id='$user_ID'");
				}
			}
		}
	
		if ($remove_post_ID != "" && $data != ""){ // if the user wants to remove a post
			if ($data == $remove_post_ID){
				$wpdb->query("DELETE FROM $table_name WHERE user_id = '$user_ID'");
			} else {
				$data = preg_replace("/(^".$remove_post_ID.",|,".$remove_post_ID."$|^".$remove_post_ID."$)/","", $data);
				$data = preg_replace("/,".$remove_post_ID.",/",",", $data);
				$wpdb->query("UPDATE $table_name SET post_id ='$data' WHERE user_id='$user_ID'");
			}
		}
	}
}
# ----------------------------------
} # end mfp_modify_database
# ----------------------------------


# ----------------------------------
function mfp_display($var,$show_user=""){
# ----------------------------------
global $wpdb, $user_ID, $table_name;

if($show_user == ""){
	$query_user = $user_ID;
}else{
	$query_user = $show_user;
}






if (current_user_can('level_0') || $show_user != ""){
$table_name2 = $wpdb->prefix . 'posts';



$sql = "";
$fav_post ="";

$defaults = array(
		'title' => '', 
		'display' => 'list',
		'remove_link' => 'remove',
		'class' => 'mfp_favorites',
		'link_class' => 'mfp_link',
		'remove_link_class' => 'mfp_remove_link',
		'order_by' => 'ID'
	);

$data = $wpdb->get_var("SELECT post_id FROM $table_name WHERE user_id = '$query_user'");

if ($data == ""){
	if($show_user == ""){
echo "<p>Вы авторизовались, можете начинать понравившиеся записи в ваш избранный список записей.</p>";
	}else{
echo "<p>Этот пользователь не выбрал еще избранных записей.</p>";	
	}
}else{

	$dataarray = explode(',',$data);
		foreach ($dataarray as $entry){
							$sql .= "OR ID = '$entry' ";
						}	
						
		$endvar = wp_parse_args( $var, $defaults );
		extract( $endvar, EXTR_SKIP );
						
		$sql = preg_replace("/^OR./","", $sql);	
		$order = $endvar['order_by'];
		$my_posts = $wpdb->get_results("SELECT * FROM $table_name2 WHERE $sql ORDER BY $order");
		$mod_url = mfp_create_link_url();
		
		
		
		if ($endvar['display'] == "list"){
		$wrap_before = "<ul class='".$endvar['class']."'>";
		$wrap_after = "</ul>";
		$entry_before = "<li>";
		$entry_after = "</li>";
		} else if ($endvar['display'] == "div"){
		$wrap_before = "<div class='".$endvar['class']."'>";
		$wrap_after = "</div>";
		$entry_before = "<p>";
		$entry_after = "</p>";
		}
		
		foreach ($my_posts as $entry){
			$fav_post .= $entry_before."<a href='".get_permalink($entry->ID)."' title='".$entry->post_title."' class='".$endvar['link_class']."'>".$entry->post_title."</a>";
			if($show_user == "" || $show_user == $user_ID){
			$fav_post .= "<a title='Удалите эту запись с ваших избранных записей' href='".$mod_url."remove-post=".$entry->ID."' class='".$endvar['remove_link_class']."'>".$endvar['remove_link']."</a>".$entry_after;
			}
		}
		
		
		//ausgabe
		echo $title;
		echo $wrap_before;
		echo $fav_post;
		echo $wrap_after;
	}
}
# ----------------------------------
} # end mfp_display
# ----------------------------------


# ----------------------------------
#WIDGET SETTINGS
# ----------------------------------
function widget_mfp_init(){
	if ( !function_exists('register_sidebar_widget') ) {
		return;
	}
	
	function mfp_display_widget($args) {
			
			
          extract($args);
		  
		  echo $before_widget;
if (!(current_user_can('level_0'))){

			echo $before_title;
			echo "Логин";			
			echo $after_title; 
 ?>

 
<form action="<?php echo get_option('siteurl'); ?>/wp-login.php" method="post">

    <p><input class="input_text" type="text" name="log" id="log" value="<?php echo wp_specialchars(stripslashes($user_login), 1) ?>" size="20" /><label for="log">Логин</label></p>

    <p><input class="input_text" type="password" name="pwd" id="pwd" size="20" /><label for="pwd">Пароль</label></p>

    <p><input type="submit" name="submit" value="Логин" class="button-login" /></p>

    <p id="labelremember">
       <label for="rememberme" ><input name="rememberme" id="rememberme" type="checkbox" checked="checked" value="forever" /> Сохранить</label>
       <input type="hidden" name="redirect_to" value="<?php echo $_SERVER['REQUEST_URI']; ?>" />
    </p>
</form>

<a href="<?php echo get_option('siteurl'); ?>/wp-register.php">Регистрация</a>
<a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=lostpassword">Восстановить пароль</a>
<?php } else {
		  
		  
		  $options  = get_option('mfp_display_widget');
		  
		  $title = empty( $options['mfp_title'] ) ? '' : $options['mfp_title'];
		  $display = empty( $options['mfp_display'] ) ? '' : "display=".$options['mfp_display'];
		  $remove_link = empty( $options['mfp_remove_link'] ) ? '' : "&amp;remove_link=".$options['mfp_remove_link'];
		  $class = empty( $options['mfp_class'] ) ? '' : "&amp;class=".$options['mfp_class'];
		  $link_class = empty( $options['mfp_link_class'] ) ? '' : "&amp;link_class=".$options['mfp_link_class'];
		  $remove_link_class = empty( $options['mfp_remove_link_class'] ) ? '' : "&amp;remove_link_class=".$options['mfp_remove_link_class'];
		  $order_by = empty( $options['mfp_order_by'] ) ? '' : "&amp;order_by=".$options['mfp_order_by'];
		
  			echo $before_title;
			echo $title;			
			echo $after_title;
			mfp_display("title=&amp;".$display.$remove_link.$class.$link_class.$remove_link_class.$order_by);
			
			if(function_exists(wp_logout_url)){?>
				<p class="mfp_logout"><a href="<?php echo wp_logout_url(get_permalink()); ?>" title="Выйти из этого аккаунта">Выйти</a></p>
				<?php }else{
			?>
			<p class="mfp_logout"><a href="<?php echo wp_logout_url(get_permalink()); ?>" title="Выйти из этого аккаунта">Выйти</a></p>
			<?php }
	  }
	    			echo $after_widget;

}	  
	  
	  
	function mfp_control_display_widget(){
		$options = $newoptions = get_option('mfp_display_widget');
		
		if ( $_POST['mfp-submit'] ) {
		$newoptions['mfp_title'] = strip_tags(stripslashes($_POST['mfp_title']));
		$newoptions['mfp_display'] = strip_tags(stripslashes($_POST['mfp_display']));
		$newoptions['mfp_remove_link'] = strip_tags(stripslashes($_POST['mfp_remove_link']));
		$newoptions['mfp_class'] = strip_tags(stripslashes($_POST['mfp_class']));
		$newoptions['mfp_link_class'] = strip_tags(stripslashes($_POST['mfp_link_class']));
		$newoptions['mfp_remove_link_class'] = strip_tags(stripslashes($_POST['mfp_remove_link_class']));
		$newoptions['mfp_order_by'] = strip_tags(stripslashes($_POST['mfp_order_by']));
	

	}
		if ( $options != $newoptions ) {
		$options = $newoptions;
		update_option('mfp_display_widget', $options);
		}
		
		
		?>
        <p>Этот Виджет показывает список избранных записей пользователя, оно работает без никаких настроек.<br/>
        Вы можете узнать больше об этом виджете на <a href="http://www.kriesi.at/archives/wordpress-plugin-my-favorite-posts" title="plugin homepage">Kriesi.at</a>
        </p>
		<p>
<input id="mfp-submit" type="hidden" value="1" name="mfp-submit"/>

<label for="mfp_title">Название: <small> (по умолчанию - нет названия)</small></label>
<input id="mfp_title" class="widefat" type="text" value="<?php echo $newoptions['mfp_title']; ?>" name="mfp_title"/>
</p><p>
<label for="mfp_display">Вид: <small>(По умолчанию это "list" -> вы можете изменить на "div")</small></label>
<input id="mfp_display" class="widefat" type="text" value="<?php echo $newoptions['mfp_display'] ?>" name="mfp_display"/>
</p><p>
<label for="mfp_remove_link">Текст для удаления: <small>(по умолчанию "remove")</small></label>
<input id="mfp_remove_link" class="widefat" type="text" value="<?php echo $newoptions['mfp_remove_link']; ?>" name="mfp_remove_link"/>
</p><p>
<label for="mfp_class">Class для ul/div: <small>(по умолчанию  "mfp_favorites")</small></label>
<input id="mfp_class" class="widefat" type="text" value="<?php echo $newoptions['mfp_class']; ?>" name="mfp_class"/>
</p><p>
<label for="mfp_link_class">Class для ссылки на запись  <small>(по умолчанию "mfp_link")</small></label>
<input id="mfp_link_class" class="widefat" type="text" value="<?php echo $newoptions['mfp_link_class']; ?>" name="mfp_link_class"/>
</p><p>
<label for="mfp_remove_link_class">Class для удалающей ссылки: <small>(по умолчанию "mfp_remove_link")</small></label>
<input id="mfp_remove_link_class" class="widefat" type="text" value="<?php echo $newoptions['mfp_remove_link_class']; ?>" name="mfp_remove_link_class"/>
</p><p>
<label for="mfp_order_by">Порядок: <small>(по умолчанию это ID, Вы можете поменять на любое значение поля в wp_posts table: некоторые примеры "post_title", "post_author", "post_date")</small></label>
<input id="mfp_order_by" class="widefat" type="text" value="<?php echo $newoptions['mfp_order_by']; ?>" name="mfp_order_by"/>
</p>
        <p><br /><small>Внимание: Если вы хотите использовать html теги, вы должны сами включить функцию mfp_display() в файлы Вашей Темы</small></p>

		
<?php }	
	global $kriesi_options;  
	if($kriesi_options['enable_jquery']){
	   register_sidebar_widget('My Favorite Posts', 'mfp_display_widget');
	   register_widget_control('My Favorite Posts', 'mfp_control_display_widget');
}
}
	  add_action('widgets_init', 'widget_mfp_init');
	  
	  
	  
	  

add_action('admin_menu', 'kriesi_admin_panel');

function kriesi_admin_panel() {	
	if (!current_user_can('level_7')){
		return;
	}else{
	include('kriesioptions.php');
	add_theme_page ('Design Showcase Options', 'Design Showcase Настройки', 7, 'kriesioptions.php', 'k_generate');
	}
}
?>