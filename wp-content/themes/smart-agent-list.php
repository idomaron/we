<?
//**************Add Parameter to WP-Query*****************************//	

$query = new WP_Query( $args );
	
//var_dump($query);

    if ( ! $query->have_posts())
		{		
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
