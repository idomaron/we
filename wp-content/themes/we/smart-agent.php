<?php //get the user_meta(current user) and set the initial (default) value of the select)  ?>
<?php 

$user_id = get_current_user_id();
$arrUserData = get_metadata('user', $user_id); 
	
 if ($_GET['link'] == 'SA'){ ?>
        
<form action="#" method="get">
        
<?php  	
/**********************************************************************************************************************************************/
	
				if ($arrUserData['sa_followed_users'][0] != -1){
					$user = $arrUserData['sa_followed_users'][0];
					//$userdata = get_userdata( $user );
					//$selected_user = $userdata->display_name;
					$available_users  = wp_dropdown_users('name=sa_followed_users&selected='.$user);
				}
				else{
					$available_users  = wp_dropdown_users('name=sa_followed_user');
				}          
				
/**********************************************************************************************************************************************/
			 
			 $k = 1;
			 while($k<=3){	
				if ($arrUserData['sa_location'.$k][0] != -1){
					
					$type_id = $arrUserData['sa_location'.$k][0];
					$taxonomy = 'event-categories';
					//$term = get_term( $type_id, $taxonomy );
					//$selected_type = $term->name;				
					$location = wp_dropdown_categories('hierarchical=1&selected='.$type_id.'&taxonomy=event-categories&hide_empty=0&name=location'.$k);  
				}
				else{
                	$location = wp_dropdown_categories('hierarchical=1&show_option_none=select location'.$k.'&taxonomy=event-categories&hide_empty=0&name=location'.$k);  
				}
				$k ++;
			 }	
				
/**********************************************************************************************************************************************/

				if ($arrUserData['sa_event_type'][0] != -1){
					
					$type_id = $arrUserData['sa_event_type'][0];
					//$taxonomy = 'event_type';
					//$term = get_term( $type_id, $taxonomy );
					//$selected_type = $term->name;
					$event_types = wp_dropdown_categories('hierarchical=1&selected='.$type_id.'&taxonomy=event_type&hide_empty=0&name=event_type'); 
				}
				else{
                	$event_types = wp_dropdown_categories('hierarchical=1&show_option_none=select event_type&taxonomy=event_type&hide_empty=0&name=event_type'); 
				}
				
/**********************************************************************************************************************************************/
				
				$categories = get_categories('hide_empty=0&hierarchical=1&show_option_none'); 
				echo '<div style="width: 95%; min-height: 250px; display: inline-block;">';
				
				foreach ($categories as $cat){
					$printed = true; 
					if ( is_array($arrUserData['sa_categories']) ){
							$arrCategoriesIds = explode("," , $arrUserData['sa_categories'][0]);

							$checkedValue = $cat->term_id;
							foreach ($arrCategoriesIds as $checked){
								if( $checked == $checkedValue){
									$printed = false;
									echo '<div style="float:right; border: 1px solid #363636; padding:10px; margin: 20px; width: 150px;">
									<input checked="checked" type="checkbox" name="categories[]" value="'.$cat->term_id.'">
									<span style="padding: 0 5px;">'.$cat->name.'</span></div>';
								}	
							}
								if($printed){		
									echo '<div style="float:right; border: 1px solid #363636; padding:10px; margin: 20px; width: 150px;">
									<input type="checkbox" name="categories[]" value="'.$cat->term_id.'">
									<span style="padding: 0 5px;">'.$cat->name.'</span></div>';
								}
					}
					else{
						echo '<div style="float:right; border: 1px solid #363636; padding:10px; margin: 20px; width: 150px;">
						<input type="checkbox" name="categories[]" value="'.$cat->term_id.'">
						<span style="padding: 0 5px;">'.$cat->name.'</span></div>';
					}
				}
				
				echo '</div>';	 
/**********************************************************************************************************************************************/
?>              
	<input name="Send" type="submit" value="Success" />
</form>

<?php 	}         

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
												$new_value = $_GET["categories"];				 
												$new_value = implode($new_value, ",");

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
$arrCategoriesIds = explode("," , $arrUserData['sa_categories'][0]);

$arrEventTypeId = $arrUserData['sa_event_type'];

$arrLocationsIds = array($arrUserData['sa_location1'][0],$arrUserData['sa_location2'][0],$arrUserData['sa_location3'][0]);
foreach($arrLocationsIds as $key=>$value){
	if($value == -1){
		unset($arrLocationsIds[$key]);	
	}	
}

//show($arrCategoriesIds); die;
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
		//show('ido');
		echo 'no post SA</br>';
		return $content;
	}
	
    $content .= '<h3>All Events</h3>';
   // $content .= '<ul>'; 
	
	$table_row.='<table>';

		while ( $query->have_posts() ) :
			$query->the_post();
			//$content .= '<li>'.get_the_title().'</li>';		

		
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
    //$content .= '</ul>';
    // Importent
	echo $content;
	echo $table_row;
		 
    wp_reset_postdata();
	
?>
