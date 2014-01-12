<?php
/*
Template Name: My Events
*/
?>
<?php 

echo $user = get_current_user_id();
$post_id = $post->ID;
	if ( $post_id == 89)
				{
						echo $post_id;
						echo EM_Events::output(array('owner'=>$user));
			
							echo '</br></br></br></br>';
				}
				
	elseif ( $post_id == 88)
			{				
				echo $post_id;
				$number_of_post = -1; //  all posts		
				include 'smart-agent.php';		
			}
	elseif ( $post_id == 92)
			{
				echo $post_id;
				$number_of_post = -1; //  all posts
				include 'event-list.php';
			}
	elseif ( $post_id == 81)
			{
				echo $post_id;
				$number_of_post = 3; //3 first lines
		
						
						echo EM_Events::output(array('owner'=>$user, 'limit'=> $number_of_post));
		
						echo '</br></br></br></br>';
						include "event-list.php";
						include 'smart-agent.php';
			}
							
?>