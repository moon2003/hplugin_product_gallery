<?php 
    // Creation Session to block duplpicate form seding  
    $_SESSION['hplugins_pgallery_session'] = date(U);   

	global $wpdb;

	//require_once(HTO_BBS__PLUGIN_DIR.'htobbssalt.php'); 	// SALT KEY ;

    //Get setting Value 
    $a_product_gallert_set_arr = hplugin_product_gallery_getSetvalue();

    $a_adminemail = $a_product_gallert_set_arr['adminemail'];
    $a_auth_key   = $a_product_gallert_set_arr['auth_key'];

    $a_cate_no    = $a_product_gallert_set_arr['catecode'] ;
    $a_listrow_no = $a_product_gallert_set_arr['listrownum'] ; 
    $a_gallery_type = $a_product_gallert_set_arr['gtype'];
    $a_display_mode = $a_product_gallert_set_arr['displaymode'];

    $a_viewurl = $a_product_gallert_set_arr['viewurl'];

	include(HPLUGIN_PRODUCT_GALLERY__PLUGIN_DIR."lib/mainShowcase.php");
	$contents_str = $hplugin_product_gallery_showcase_str; 


?>