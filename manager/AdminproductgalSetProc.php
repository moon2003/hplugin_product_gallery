<?php


    $v_proc = $_GET['show'] ; 


    if ( $v_proc == "set-update"){ //----- Setting Update -----//    

        if ( !$_SESSION['hplugins_pgallery_session'] || $_SESSION['hplugins_pgallery_session'] == "")  {  // 그냥 나감 
            
            
        } else {

            // 세션 취소시킴 : 중복전송 방지 
            $_SESSION['hplugins_pgallery_session'] = "";
        

            $v_adminemail   = $_POST["adminemail"] ;
            $v_authkey      = $_POST["auth_key"] ;
            $v_etype        = $_POST["etype"];        
            $v_listrowcnt   = $_POST["listrowcnt"];
            $v_catecode     = $_POST["catecode"];
            $v_display_mode = $_POST["display_mode"] ;             
            $v_banner_slide = $_POST["banner_slide"];

            $v_catecode = rtrim ( ltrim ( $v_catecode , ',' ) , ',' ) ;

            global $wpdb;

            // Delete Setting value before insert new value ;

            $wpdb->delete( 'wp_hplugin_product_gallery_set',
                        array('status'=>'Y' ),
                        array('%s' )

            );
    
        
            // Insert board option information
            $sql_query_arr = array(                

                        array ( 'name'=>'adminemail', 'value'=>$v_adminemail , 'status'=>'Y'  ) ,         //관리자 Email 
                        array ( 'name'=>'auth_key' , 'value'=>$v_authkey ,  'status'=>'Y'  ) ,         // key
                        array ( 'name'=>'catecode' , 'value'=>$v_catecode , 'status'=>'Y'  )  ,       // catecode
                        array ( 'name'=>'listrownum' , 'value'=>$v_listrowcnt , 'status'=>'Y'  )   , 
                        array ( 'name'=>'etype' , 'value'=>$v_etype, 'status'=>'Y'  )    , 
                        array ( 'name'=>'displaymode' , 'value'=>$v_display_mode , 'status'=>'Y'  ) , 
                        array ( 'name'=>'banner_thumbnail' , 'value'=>$v_banner_slide , 'status'=>'Y'  )  // Banner slide check 
    
                    );
    
            
            print $v_banner_slide; 
            $ht_sql = "INSERT INTO wp_hplugin_product_gallery_set( name, value,  status) VALUES " ;
    
            foreach ( $sql_query_arr as $set_items ){
    
                $ht_sql .= $wpdb->prepare (
                            "( %s , %s, %s ),",
                            $set_items['name'] , $set_items['value'],  $set_items['status']
                );
            }
                    
    
    
            $ht_sql = rtrim($ht_sql, ',' ).";";
            $wpdb->query($ht_sql);
                    
            
            
    
            $return_url = "alert('설정값이 변경되었습니다.');
                jQuery(location).attr('href','/wp-admin/admin.php?page=hplugin-product-gallery-setting-menu');";
    
        }

    }

?>


<script>
<?php print $return_url ;?>
</script>


