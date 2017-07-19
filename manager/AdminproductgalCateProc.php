<?php


    $v_proc = $_GET['show'] ; 


    if ( $v_proc == "cate-save"){ //----- Cate Save  -----//    

        if ( !$_SESSION['hplugins_pgallery_session'] || $_SESSION['hplugins_pgallery_session'] == "")  {  // 그냥 나감 
            
            
        } else {

            // 세션 취소시킴 : 중복전송 방지 
            $_SESSION['hplugins_pgallery_session'] = "";
        
            global $wpdb;

            $v_cat_name = $_POST["cat_name"];
            
            //-- Category data input 
            $wpdb->insert('wp_hplugin_product_gallery_cate',
                array( 
                        'catename' => $v_cat_name,
                        'status' => 'Y',
                        'reg_date' => current_time('mysql', 1) 
                ),
                array(
                    '%s',
                    '%s',
                    '%s'
                )
                    
            ) ;



            $return_url = "alert('카테고리가 입력되었습니다.'); 
            jQuery(location).attr('href','/wp-admin/admin.php?page=hplugin-product-gallery-cate-menu');";
                    
    
        }

    }  else  if ( $v_proc == "cate-update"){ //----- Cate update  -----// 


        if ( !$_SESSION['hplugins_pgallery_session'] || $_SESSION['hplugins_pgallery_session'] == "")  {  // 그냥 나감 
            
            
        } else {

            // 세션 취소시킴 : 중복전송 방지 
            $_SESSION['hplugins_pgallery_session'] = "";
        
            global $wpdb;

            $v_cid = $_POST["cid"];

            $v_cat_name = $_POST["cat_name"];


            $wpdb->update('wp_hplugin_product_gallery_cate',
            
            array( 
                'catename'=> $v_cat_name
            ),
            array(
                'no'=>$v_cid

            ),
            array(
                '%s'
            ),
            array(
           
                '%d'
            )

            );

        

            $return_url = "alert('카테고리 정보가  업데이트되었습니다.');
            jQuery(location).attr('href','/wp-admin/admin.php?page=hplugin-product-gallery-cate-menu&show=cate-view&cid=".$v_cid."');";


        }

    }  else if ( $v_proc == "cate-delete"){    //----- Category Delete -----//  


        if ( !$_SESSION['hplugins_pgallery_session'] || $_SESSION['hplugins_pgallery_session'] == "")  {  // 그냥 나감 
            
            
        } else {

            // 세션 취소시킴 : 중복전송 방지 
            $_SESSION['hplugins_pgallery_session'] = "";


            global $wpdb;

            $v_cid = $_POST["cid"];


            $wpdb->delete('wp_hplugin_product_gallery_cate',
                array(
                'no'=>$v_cid
                ),
                array(
                '%d'
                ) 
            ) ;



            $return_url = "alert('카테고리 정보가 삭제되었습니다.');
            jQuery(location).attr('href','/wp-admin/admin.php?page=hplugin-product-gallery-cate-menu');";



        }


    }





?>


<script>
<?php print $return_url ;?>
</script>


