<?php


    $v_proc = $_GET['show'] ; 


    if ( $v_proc == "showcase-sort"){ //----- Sort Update -----//    

        if ( !$_SESSION['hplugins_pgallery_session'] || $_SESSION['hplugins_pgallery_session'] == "")  {  // 그냥 나감 
            
            
        } else {

            // 세션 취소시킴 : 중복전송 방지 
            $_SESSION['hplugins_pgallery_session'] = "";
        

            $v_cno_arr     = $_POST["cno"] ;

            global $wpdb;


            for ( $oi =0 ; $oi < count($v_cno_arr); $oi++ ){


                $wpdb->update('wp_hplugin_product_gallery_showcase',
            
                array( 
                    'sort' => ($oi+1)                    
                ),
                array(
                    'no'=>$v_cno_arr[$oi]
                ),
                array(
                    '%d'
                ),
                array(
                    '%d'
                )

                );

            }
            
            
            
    
            $return_url = "alert('순서가 변경되었습니다.');
                jQuery(location).attr('href','/wp-admin/admin.php?page=hplugin-product-gallery-showcase-menu');";
    
        }

    }  else  if ( $v_proc == "showcase-update"){ //----- pageurl Update -----//    

        if ( !$_SESSION['hplugins_pgallery_session'] || $_SESSION['hplugins_pgallery_session'] == "")  {  // 그냥 나감 
            
            
        } else {

            // 세션 취소시킴 : 중복전송 방지 
            $_SESSION['hplugins_pgallery_session'] = "";
        

            $v_pageurl     = $_POST["pageurl"] ;
            $v_cid         = $_POST["cid"] ;

            global $wpdb;
            

            $wpdb->update('wp_hplugin_product_gallery_showcase',
            
                array( 
                    'viewurl' => $v_pageurl
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

            $return_url = "alert('연결주소가  변경되었습니다.');
                jQuery(location).attr('href','/wp-admin/admin.php?page=hplugin-product-gallery-showcase-menu');";

        }


    } else  if ( $v_proc == "showcase-delete"){ //----- showcase delete -----//    

        if ( !$_SESSION['hplugins_pgallery_session'] || $_SESSION['hplugins_pgallery_session'] == "")  {  // 그냥 나감 
            
            
        } else {

            // 세션 취소시킴 : 중복전송 방지 
            $_SESSION['hplugins_pgallery_session'] = "";
        

            $v_cid         = $_POST["cid"] ;

            global $wpdb;
            

            $wpdb->delete('wp_hplugin_product_gallery_showcase',
            
                array(
                    'no'=>$v_cid
                ),
                array(
                    '%d'
                )

            );

            $return_url = "alert('진열목록에서 삭제되었습니다.'');
                jQuery(location).attr('href','/wp-admin/admin.php?page=hplugin-product-gallery-showcase-menu');";

        }

    }


?>


<script>
<?php print $return_url ;?>
</script>


