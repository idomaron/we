<?php
/*
Template Name: Private Zone
*/	
					get_header(); ?>

	<div id="private-zone" class="content-area">
		<div id="content" class="site-content" role="main">
        	<h1><?php the_title(); ?></h1>
            
	<?php
					$args=array(
						'menu'=>'private_zone_menu',
						'theme_location'=>''
						
					);

					$user = get_current_user_id();
					if (!$user){
						echo "Please, login!";	
					}
					//HACK:

					if( !isset($_GET['link']) ){
						$_GET['limit']=3;
						$number_of_post = 3; //3 first lines										

						echo '<h2>אירועים שיצרתי</h2>';
						echo EM_Events::output(array('owner'=>$user, 'limit'=> $number_of_post));

						echo '<h2>אירועים שנרשמתי</h2>';
						do_shortcode('[my_bookings limit=3]');

						echo '<h2>אירועים של הסוכן החכם</h2>';
						include 'smart-agent.php';
					}
					elseif( $_GET['link'] == 'created'){
						echo '<h1>אירועים שיצרתי</h1>';
						echo EM_Events::output(array('owner'=>$user));	
						echo '</br></br></br></br>';
					}
					elseif ( $_GET['link'] == 'booked'){
						echo '<h1>אירועים שנרשמתי אליהם</h1>';
						do_shortcode('[my_bookings]');
						echo '</br></br></br></br>';
					}
					elseif ( $_GET['link'] == 'SA'){				
						echo '<h1>אירועים שהסוכן המליץ עליהם</h1>';
						$number_of_post = -1; //  all posts		
						include 'smart-agent.php';		
					}		
?>


		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>