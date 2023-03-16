<?php
	function wedo_users() {

		$user_id = wp_update_user( 
					array( 
							'ID' 			=> '1',
							'first_name' 	=> 'Ben',
							'last_name'		=> 'Hudson',
							'display_name'	=> 'Ben Hudson'
						) 
					);	

	}
?>
