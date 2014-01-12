<?php 

echo 5;

echo get_current_user_id();
$user_id = 15;
if ( $user_id )
	{
		$meta_key = 'wpmem_reg_url';
		$new_value = 'כלכלה';
		echo 1;
		
		// will return false if the previous value is the same as $new_value
		update_user_meta( $user_id, $meta_key, $new_value );
		echo 2;
		
		// so check and make sure the stored value matches $new_value
		if ( get_user_meta($user_id,  $meta_key, true ) != $new_value )
			wp_die('An error occurred');
		if ( get_user_meta($user_id,  $meta_key, true ) == $new_value )
			wp_die('Good job');
	}
else
 	{
		echo 'please, login';
	}





