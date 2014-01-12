<?php //get the user_meta(current user) and set the initial (default) value of the select)  ?>

		<?php  if ( $_GET['link'] == 'SA'){ ?>
        
        <form action="#" method="get">
        	
             <?php  $available_users  = wp_dropdown_users( array('name'=>'sa_followed_users',  ))?>
			
   			 <?php $location = wp_dropdown_categories('hierarchical=1&show_option_none=select location1&taxonomy=event-categories&hide_empty=0&name=location1'); ?>
             <?php $location = wp_dropdown_categories('hierarchical=1&show_option_none=select location2&taxonomy=event-categories&hide_empty=0&name=location2'); ?>
             <?php $location = wp_dropdown_categories('hierarchical=1&show_option_none=select location3&taxonomy=event-categories&hide_empty=0&name=location3'); ?>
             
             <?php $event_types = wp_dropdown_categories('hierarchical=1&show_option_none=select event_type&taxonomy=event_type&hide_empty=0&name=event_type'); ?>
			
    		<input name="Send" type="submit" value="Success" />
       </form>
       <?php } ?>        
<?php

$user_id = get_current_user_id();
$i = 1; 
	if ( $user_id )
			{
				
			
						 if ( $_GET["Send"]=='Success')
							 {		
								//*********************PREFFER LECTORS***********************//
										
										$meta_key = 'sa_followed_users';
										$new_value = $_GET["sa_followed_users"];
										
										update_user_meta( $user_id, $meta_key, $new_value );
										
								 //*********************LOCATION***********************//
										
										while($i<=3)
											{
												$meta_key = 'sa_location'.$i;
												$new_value = $_GET["location".$i];
												
												update_user_meta( $user_id, $meta_key, $new_value );
								
												$i++;	
											}
								//*********************KIND OF EVENT***********************//
												
												$meta_key = 'sa_event_type';
												$new_value = $_GET["event_type"];
												
												update_user_meta( $user_id, $meta_key, $new_value );
								
								//*********************CATEGORY****************************//			
										
												$meta_key = 'sa_categories';
												$new_value = '15';
												
												update_user_meta( $user_id, $meta_key, $new_value );
							}
		}					
	else
		{
			echo 'please, login';
		}
		

$arrUserData = get_metadata('user', $user_id);

$arrFollowedUsers=$arrUserData['sa_followed_users'];

$arrCategoriesIds = $arrUserData['sa_categories'];

$arrEventTypeId = $arrUserData['sa_event_type'];

$arrLocationsIds = array($arrUserData['sa_location1'][0],$arrUserData['sa_location2'][0],$arrUserData['sa_location3'][0]);
foreach($arrLocationsIds as $key=>$value){
	if($value == -1){
		unset($arrLocationsIds[$key]);	
	}	
}

//show($arrLocationsIds);
if ( is_array($arrFollowedUsers))
	{
		$arrFollowedUsers = implode($arrFollowedUsers);
	}
	

$args = array(
	'author' => $arrFollowedUsers,	
	'post_type'	=> 'event',
	'posts_per_page' => $number_of_post,
	'category__in' => $arrCategoriesIds,		
	'tax_query' => array(
		'relation' => 'AND',
		array(
				'taxonomy'=>'event-categories',
				'field'=>'id',
				'terms'=>$arrLocationsIds
			 ),
		array(
				'taxonomy'=>'event_type',
				'field'=>'id',

				'terms'=> $arrEventTypeId,
			 ) 
	)
					
);

//show($args);


$query = new WP_Query( $args );
	
//var_dump($query);

    if ( ! $query->have_posts() ){
		show('ido');
		echo 'no post SA</br>';
		return $content;
	}
	
    $content .= '<h3>All Events</h3>';
    $content .= '<ul>'; 
	
	$table_row.='<table>';

		while ( $query->have_posts() ) :
			$query->the_post();
			$content .= '<li>'.get_the_title().'</li>';		

		
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
