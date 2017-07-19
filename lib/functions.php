<?php



	function hplugin_product_gallery_getSetvalue(){

		global $wpdb;

		$sql_query = "SELECT name , value FROM wp_hplugin_product_gallery_set";
		$set_fd = $wpdb->get_results($sql_query);

		$ret_arr = array();

		$scnt = 0; 
		foreach( $set_fd as $set_data ){

			$ret_arr[ $set_data->name ]  = $set_data->value;
			$scnt++ ;

		}

		return $ret_arr ;
	}




	function key_generateRandomString($length = 15) {

    	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    	$charactersLength = strlen($characters);
    	$randomString = '';
    	for ($i = 0; $i < $length; $i++) {
        	$randomString .= $characters[rand(0, $charactersLength - 1)];
    	}
    	return $randomString;
	}


?>