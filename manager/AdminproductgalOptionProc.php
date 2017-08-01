<?php


    $v_proc = $_GET['show'] ; 


    if ( $v_proc == "option-save"){ //----- Cate Save  -----//    

        if ( !$_SESSION['hplugins_pgallery_session'] || $_SESSION['hplugins_pgallery_session'] == "")  {  // 그냥 나감 
            
            
        } else {

            // 세션 취소시킴 : 중복전송 방지 
            $_SESSION['hplugins_pgallery_session'] = "";
        
            global $wpdb;

            $v_option_name = $_POST["opt_name"];
            $v_option_type = $_POST["opt_type"];
            $v_option_sgubun = $_POST["sgubun"];





            //타입확인 
            $v_option_value_str = "" ; 

            if( $v_option_type  != "I"){

                $v_option_value_arr = $_POST["opt_value"];
                $opcnt = count($v_option_value_arr ); 


                //error_log ("count ".print_r($_POST["opt_value"]) , 3, "/home/bareun/html/error_log");

                $loopcnt = 0 ; 

                for($oi = 0 ; $oi < $opcnt ; $oi++){ 
                //foreach ($_POST['opt_value'] as $key => $opt_value ) {
                    //if( $v_option_value_arr[$oi] != "" ){
                        
                        if( $loopcnt > 0 ){ 
                            $v_option_value_str .="__##__";
                        } 

                        $v_option_value_str .= $v_option_value_arr[$oi] ;    
                        $loopcnt++ ; 
                    //}                        
                }
                
                
            }

            
            // max sort val 
            $sql_query = "select ifnull( max(sort), 0 ) mcnt  from  wp_hplugin_product_gallery_opt_set";

            $max_fd = $wpdb->get_results($sql_query);
            $max_num_plus = 0 ; 
            foreach( $max_fd as $max_arr){
                $max_num_plus = (int)($max_arr->mcnt) + 1 ;                 
            }



            //-- Category data input 
            $wpdb->insert('wp_hplugin_product_gallery_opt_set',
                array( 
                        'name' => $v_option_name,
                        'value' => $v_option_value_str,
                        'type' => $v_option_type,
                        'sort' => $max_num_plus,     
                        'sgubun' => $v_option_sgubun,                   
                        'status' => 'Y',
                        'reg_date' => current_time('mysql', 1) 
                ),
                array(
                    '%s',
                    '%s',
                    '%s',
                    '%d',
                    '%d',
                    '%s',
                    '%s'
                )
                    
            ) ;



            $return_url = "alert('옵션값이 입력되었습니다.'); 
            jQuery(location).attr('href','/wp-admin/admin.php?page=hplugin-product-gallery-option-menu');";
                    
    
        }

    } else if( $v_proc == "option-update"){ //----- Cate update  -----// 


        if ( !$_SESSION['hplugins_pgallery_session'] || $_SESSION['hplugins_pgallery_session'] == "")  {  // 그냥 나감 
            
            
        } else {

            // 세션 취소시킴 : 중복전송 방지 
            $_SESSION['hplugins_pgallery_session'] = "";
        
            global $wpdb;

            $v_cid = $_POST["cid"];

            $v_option_name = $_POST["opt_name"];
            $v_option_type = $_POST["opt_type"];
            $v_option_sgubun = $_POST["sgubun"];
            $v_option_status = $_POST["usage"];





            //타입확인 
            $v_option_value_str = "" ; 

            if( $v_option_type  != "I"){

                $v_option_value_arr = $_POST["opt_value"];
                $opcnt = count($v_option_value_arr ); 


                //error_log ("count ".print_r($_POST["opt_value"]) , 3, "/home/bareun/html/error_log");

                error_log ("cid ".$v_cid , 3, "/home/bareun/html/error_log"); 
                $loopcnt = 0 ; 

                for($oi = 0 ; $oi < $opcnt ; $oi++){ 
                //foreach ($_POST['opt_value'] as $key => $opt_value ) {
                    //if( $v_option_value_arr[$oi] != "" ){
                        
                        if( $loopcnt > 0 ){ 
                            $v_option_value_str .="__##__";
                        } 

                        $v_option_value_str .= $v_option_value_arr[$oi] ;    
                        $loopcnt++ ; 
                    //}                        
                }
                
                
            }



            $wpdb->update('wp_hplugin_product_gallery_opt_set',
            
                array( 
                    'name' => $v_option_name,
                    'value' => $v_option_value_str,
                    'type' => $v_option_type,   
                    'sgubun'=> $v_option_sgubun,             
                    'status' => $v_option_status                                                
                ),
                array(
                    'no'=>$v_cid
                ),
                array(
                    '%s',
                    '%s',
                    '%s',
                    '%s',
                    '%s'
                ),
                array(
                    '%d'
                )

            );
        

            $return_url = "alert('옵션정보가 업데이트되었습니다.');
            jQuery(location).attr('href','/wp-admin/admin.php?page=hplugin-product-gallery-option-menu&show=option-view&cid=".$v_cid."');";


        }

    }  else if ( $v_proc == "option-delete"){    //----- Category Delete -----//  


        if ( !$_SESSION['hplugins_pgallery_session'] || $_SESSION['hplugins_pgallery_session'] == "")  {  // 그냥 나감 
            
            
        } else {

            // 세션 취소시킴 : 중복전송 방지 
            $_SESSION['hplugins_pgallery_session'] = "";


            global $wpdb;

            $v_cid = $_POST["cid"];


            $wpdb->delete('wp_hplugin_product_gallery_opt_set',
                array(
                'no'=>$v_cid
                ),
                array(
                '%d'
                ) 
            ) ;


            $return_url = "alert('옵션의 정보가 삭제되었습니다.');
            jQuery(location).attr('href','/wp-admin/admin.php?page=hplugin-product-gallery-option-menu');";



        }


    } else if ( $v_proc == "option-sortupdate"){
        

        if ( !$_SESSION['hplugins_pgallery_session'] || $_SESSION['hplugins_pgallery_session'] == "")  {  // 그냥 나감 
            
            
        } else {


            // 세션 취소시킴 : 중복전송 방지         
            $_SESSION['hplugins_pgallery_session'] = "";

            global $wpdb;

            // Get optiono 
            $v_optno_arr = $_POST["optno"];


            for ( $oi =0 ; $oi < count($v_optno_arr); $oi++ ){


                $wpdb->update('wp_hplugin_product_gallery_opt_set',
            
                array( 
                    'sort' => ($oi+1)                    
                ),
                array(
                    'no'=>$v_optno_arr[$oi]
                ),
                array(
                    '%d'
                ),
                array(
                    '%d'
                )

                );

            }
                


            $return_url = "alert('옵션의 순서가 업데이트 되었습니다.');
            jQuery(location).attr('href','/wp-admin/admin.php?page=hplugin-product-gallery-option-menu');";

        }


    }




?>


<script>
<?php print $return_url ;?>
</script>


