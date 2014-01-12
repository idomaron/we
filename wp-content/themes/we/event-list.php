<?php 

	
	$mybookingevents = $wpdb->get_results("SELECT event_id FROM teamwise_em_bookings WHERE person_id =  $user");
		//var_dump ($mybookingevents);
		
		foreach ($mybookingevents as $event)
			{
					$eventId[] = $event->event_id;
			}
			
	$strEventsIds =  implode(', ', $eventId);
	$postIdforEvent = $wpdb->get_results("SELECT post_id FROM teamwise_em_events WHERE event_id IN ($strEventsIds)");
		echo '</br></br></br></br>';
		
		foreach ($postIdforEvent as $post)
			{
					$postId[] = $post->post_id;
			}
			
		echo '</br></br></br></br>';

//var_dump($postId);
$query = new WP_Query( array(
        'author' => get_current_user_id(),	
		'post_type'	=> 'event',
		'post_status' => 'published',
		'posts_per_page' => $number_of_post,
		'post__in' => $postId
		) 
	);


//var_dump($query);

    if ( ! $query->have_posts() ){
		echo 'no post Event</br>';
		return $content;
	}
	
    $content .= '<h3>All Events</h3>';
    $content .= '<ul>'; 
	
	$table_row.='<table>';

		 while ( $query->have_posts() ) :
//var_dump($content);
        $query->the_post();
        $content .= '<li>'.get_the_title().'</li>';		
//		echo '<pre>';
//		var_dump($post);
//		echo '</pre>';
		
 /************************************TABLE ROW*******************************************/
			echo $post_id = $post->ID;	
			//$table_row .= '<tr>';
			//$table_row .= '<td>'.$custom_fields["cf_name_event_speaker"][0].'</td>';
			//$table_row .= '<td>'.$custom_fields["cf_event_place"][0].'</td>';
			//$table_row .= '<td>'.get_the_title().'</td>';
			//$table_row .= '</tr>';	
				 
/********************************END TABLE ROW******************************************/	
			
    endwhile;
	
	$table_row.='</table>';
    $content .= '</ul>';
    // Importent
	echo $content;
	echo $table_row;
		 
    wp_reset_postdata();
?>