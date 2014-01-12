<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Test Smart Agent</title>
</head>

<body>
		<form action="#" method="get">
        	
             <?php  $lectors  = wp_dropdown_users( array('name'=>'lector',  ))?>
			
            
   			 <?php $location = wp_dropdown_categories('hierarchical=1&show_option_none=select location&taxonomy=event-categories&hide_empty=0&name=location1'); ?>
             <?php $location = wp_dropdown_categories('hierarchical=1&show_option_none=select location&taxonomy=event-categories&hide_empty=0&name=location2'); ?>
             <?php $location = wp_dropdown_categories('hierarchical=1&show_option_none=select location&taxonomy=event-categories&hide_empty=0&name=location3'); ?>
             
             <?php $kind_of_event = wp_dropdown_categories('hierarchical=1&show_option_none=select kind_of_event&taxonomy=kind-of-event&hide_empty=0&name=kind-of-event'); ?>
			
    		<input name="Send" type="submit" value="Success" />
       </form> 
       
<?php

$user_id = get_current_user_id();
$i = 1; 
	if ( $user_id )
			{
				
			
						 if ( $_GET["Send"]=='Success')
							 {		
								//*********************PREFFER LECTORS***********************//
										$meta_key = 'sa_lector';
										$new_value = $_GET["lector"];
										
										update_user_meta( $user_id, $meta_key, $new_value );
										
								 //*********************LOCATION***********************//
										while($i<=3)
											{
												//echo "555".$i;
												$meta_key = 'sa_location';
												$new_value = $_GET["location".$i];
												
												update_user_meta( $user_id, $meta_key, $new_value );
																			
												
									//// so check and make sure the stored value matches $new_value
									//			if ( get_user_meta($user_id,  $meta_key, true ) != $new_value )
									//				echo ('An error occurred Location');
									//			if ( get_user_meta($user_id,  $meta_key, true ) == $new_value )
									//				echo ('Good job Location');
												$i++;	
											}
								//*********************KIND OF EVENT***********************//
												
												$meta_key = 'sa_kind-of-event';
												$new_value = $_GET["kind-of-event"];
												
												update_user_meta( $user_id, $meta_key, $new_value );
								
								//*********************CATEGORY***********************//			
									
										
												$meta_key = 'sa_categories';
												$new_value = '15';
												echo 1;
												
												// will return false if the previous value is the same as $new_value
												update_user_meta( $user_id, $meta_key, $new_value );
												echo 2;
												// so check and make sure the stored value matches $new_value
												//if ( get_user_meta($user_id,  $meta_key, true ) != $new_value )
												//	wp_die('An error occurred Category');
												//if ( get_user_meta($user_id,  $meta_key, true ) == $new_value )
												//	wp_die('Good job Category ');
							}
		}					
	else
		{
			echo 'please, login';
		}
		
//usermeta -> sa_categories -> int 
//
//
//usermeta -> sa_kind-of-event  -> int     
//postmeta -> cf_kind_event = dayly
//
//usermeta -> sa_location -> int
//postmeta -> cf_event_place -> Haifa
//
//
//usermeta ->  sa_lector -> int
//postmeta -> cf_name_event_speaker -> user1

$infoofcurrentuser = $wpdb->get_results("SELECT * FROM teamwise_usermeta WHERE user_id = 1");

foreach ($infoofcurrentuser as $user)
		{
			$userKey[] = $user->meta_key;
		}
foreach ($infoofcurrentuser as $user)
		{
			$userValue[] = $user->meta_value;	
		}		
	
		$i = 0;
		echo $count=count($userKey);
		while ($i < $count)
		 {
			 	echo 1;
			if ($userKey[$i] == 'sa_categories')
				{
					echo 2;
					$categories = $userValue[$i];
					
				}
			if ($userKey[$i] == 'sa_kind-of-event')
				{
					echo 3;
					$kindEvent = $userValue[$i];
					
				}
			if ($userKey[$i] =='sa_location')
				{
					echo 4;
					$location = $userValue[$i];
					
				}
			if ($userKey[$i] == 'sa_lector')
				{
					echo 5;
					$Lector = $userValue[$i];
					
				}			
			$i++; 
		 }
		 ?></br><?

 


$arg = array( 
);


$query = new WP_Query( array(
        'author' => get_current_user_id(),	
		'post_type'	=> 'event',
		'post_status' => 'published',
		'posts_per_page' => $number_of_post,
		'category__in' => $categories,		
		) 
	);
	
//var_dump($query);

    if ( ! $query->have_posts() ){
		echo $content = 'No posts;';
		return $content;
	}
	
    $content .= '<h3>All Events</h3>';
    $content .= '<ul>'; 
	
	$table_row.='<table>';

		 while ( $query->have_posts() ) :
		echo 11111;
        $query->the_post();
        $content .= '<li>'.get_the_title().'</li>';		
		//echo '<pre>';
//		var_dump($post);
//		echo '</pre>';
		
 /************************************TABLE ROW*******************************************/
			$post_id = $post->ID;	
			$table_row .= '<tr>';
			$table_row .= '<td>'.$custom_fields["cf_name_event_speaker"][0].'</td>';
			$table_row .= '<td>'.$custom_fields["cf_event_place"][0].'</td>';
			$table_row .= '<td>'.get_the_title().'</td>';
			$table_row .= '</tr>';	
						 
/********************************END TABLE ROW******************************************/	
			
    endwhile;
	
	$table_row.='</table>';
    $content .= '</ul>';
    // Importent
	echo $content;
	echo $table_row;
		 
    wp_reset_postdata();
?>

</body>
</html>
