<?php get_header(); ?>

<div id="main-content" class="main-content">

	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">
        
<?php	
//echo $is_partial;
	if ( $is_partial)	{
		$number_of_post = 3;	
	}
	else	{
		$number_of_post = -1;
	}
	end;
    echo get_current_user_id();
	$query = new WP_Query( array(
        'author' => get_current_user_id(),	
		'post_type'	=> 'event',
		'post_status' => 'published',
		'posts_per_page' => $number_of_post,	
		) 
	);

    if ( ! $query->have_posts() ){
		return $content;
	}
	
    $content .= '<h3>All Events</h3>';
    $content .= '<ul>'; ?>
<table>
  <?php  while ( $query->have_posts() ) :
		
        $query->the_post();
        $content .= '<li>'.get_the_title().'</li>';		
		//echo '<pre>';
		//var_dump($post);
		//echo '</pre>';
		$post_id = $post->ID;
/************************************TABLE ROW*******************************************/	
			$table_row .= '<tr>';
			$custom_fields = get_post_custom($post_id);
			 
			$table_row .= '<td>'.$custom_fields["cf_name_event_speaker"][0].'</td>';
			$table_row .= '<td>'.$custom_fields["cf_event_place"][0].'</td>';
			$table_row .= '<td>'.get_the_title().'</td>';
			$table_row .= '</tr>';	
			echo $table_row;	 
/********************************END TABLE ROW******************************************/	
			
    endwhile;?>
</table>	
 <?php
    $content .= '</ul>';
    // Importent
	echo $content;
	
	 
	
    wp_reset_postdata();
?>

		</div><!-- #content -->
	</div><!-- #primary -->
	<?php get_sidebar( 'content' ); ?>
</div><!-- #main-content -->

<?php
get_sidebar();
get_footer();
