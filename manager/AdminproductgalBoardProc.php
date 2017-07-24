<?php 

    if ( $_GET['show'] == "board-save"){ //----- input Save  -----//    

        if ( !$_SESSION['hplugins_pgallery_session'] || $_SESSION['hplugins_pgallery_session'] == "")  {  // 그냥 나감 
            
            
        } else {

            // 세션 취소시킴 : 중복전송 방지 
            $_SESSION['hplugins_pgallery_session'] = "";
        
            global $wpdb;



            $v_title = $_POST["title"];
            $v_subtitle = $_POST["subtitle"];
            $v_contents = $_POST["contents"];
            $v_contents2 = $_POST["contents2"];

            $v_catecode_arr = $_POST["catecode"];


            $v_optcnt = $_POST["optcnt"];

            $v_price = $_POST["price"];


            // Get Image File 

            echo "POST VAL IS ";
            print_r( $_POST );
            $return_url = "";






            // catecode array
            $v_catecode_str = "";
            for($ci = 0; $ci < count($v_catecode_arr) ; $ci++){
                if( $ci > 0 ) $v_catecode_str .=",";
                $v_catecode_str .= $v_catecode_arr[$ci];
            }

            
            // max no val 
            $sql_query = "select ifnull( max(no), 0 ) mcnt  from  wp_hplugin_product_gallery";

            $max_fd = $wpdb->get_results($sql_query);
            $max_num_plus = 0 ; 
            foreach( $max_fd as $max_arr){
                $max_num_plus = (int)($max_arr->mcnt) + 1 ;                 
            }



            //-- data input 
            
            $wpdb->insert('wp_hplugin_product_gallery',
                array(  'no' => $max_num_plus ,
                        'title' => $v_title , 
                        'subtitle' => $v_subtitle ,
                        'contents' => $v_contents, 
                        'contents2' => $v_contents2,
                        'catecode' => $v_catecode_str,
                        'price' => $v_price,                        
                        'status' => 'Y',
                        'reg_date' => current_time('mysql', 1) 
                ),
                array(
                    '%d',
                    '%s',
                    '%s',
                    '%s',
                    '%s',                                
                    '%s',                                
                    '%d',
                    '%s',
                    '%s'
                )
                    
            ) ;
            




            //-- option input 
            // Get option loop value 
            for( $oi = 0; $oi < $v_optcnt ; $oi++){

                
                $pst= (string)$oi;

                $v_optname = $_POST["opt_info_".$pst];


                //echo "<br>VAL NAME : opt_info_".$oi." /  ".$v_optname."<br>";  
                
                if( $v_optname != "" ){
                    
                    $v_optval_arr = $_POST["opt_".$pst];                    
                    $v_optarrcnt = count($v_optval_arr);


                    echo "<br>VAL NAME : opt_info_".$oi." /  ".$v_optname." ".$v_optval_arr." / ".$v_optarrcnt."<br>";   
                    
                    if( $v_optarrcnt == 1) { 


                        if( $v_optval_arr ){ 
                            $wpdb->insert('wp_hplugin_product_gallery_opt',
                                array(  'c_no' => $max_num_plus ,                        
                                'name' => $v_optname ,
                                'value' => $v_optval_arr,                                                                 
                                'status' => 'Y',
                                'reg_date' => current_time('mysql', 1) 
                            ),
                            array(
                            '%d',
                            '%s',                    
                            '%s',
                            '%s',
                            '%s'
                            )
                        
                            ) ;
                        }


                    } else {


                        for( $pi=0 ; $pi < $v_optarrcnt ; $pi++){


                            $wpdb->insert('wp_hplugin_product_gallery_opt',
                                array(  'c_no' => $max_num_plus ,                        
                                'name' => $v_optname ,
                                'value' => $v_optval_arr[$pi],                                                                 
                                'status' => 'Y',
                                'reg_date' => current_time('mysql', 1) 
                            ),
                            array(
                            '%d',
                            '%s',                    
                            '%s',
                            '%s',
                            '%s'
                            )
                    
                            ) ;


                        }


                    }
                                        

                }
                


            }



            //-- imageupload 

            $imgloopcnt = 0 ; 

            if( (isset($_FILES['upload_img']) ) ){ 

            foreach( $_FILES["upload_img"]['tmp_name'] as $key=>$tmpname   ){



                if( $_FILES["upload_img"]["size"][$key]  > 0 ){

                    if(  $imgloopcnt == 0 ) { 
                        $a_today = explode("-",date("Y-m-d") ) ;

                        $file_upload_path = HPLUGIN_PRODUCT_GALLERY__CONTENT_DIR.$a_today[0]."/".$a_today[1];
                        $save_path = $a_today[0]."/".$a_today[1];
    

                        // Create directory for upload files.
                        if( !is_dir($file_upload_path)){
                            mkdir($file_upload_path, 0755, true) ;
                        }
                    }
    



                    $a_filename  = $_FILES["upload_img"]["name"][$key] ;
                    $a_filetmp   = $_FILES["upload_img"]["tmp_name"][$key] ;
                    $a_filesize  = $_FILES["upload_img"]["size"][$key] ;




                    $a_uniq_tmp = uniqid();
                    $a_filename_tmp = explode(".", $a_filename );
    
                    $a_file_ext = "";
                    if ( count($a_filename_tmp)  > 0  ) { 
                        $a_file_ext = ".".$a_filename_tmp[ (count($a_filename_tmp) -1 )] ;
                    } 
    
    
                    $a_uniqfilename = $a_uniq_tmp.$a_file_ext;          
                
                    // FileSave ;
                    copy( $a_filetmp , $file_upload_path."/".$a_uniqfilename);           
                    


                    // DB insert 
                    $wpdb->insert('wp_hplugin_product_gallery_img',
                                array(  
                                'c_no' => $max_num_plus ,                        
                                'title' => '' ,
                                'imgurl' => $save_path .'/'.$a_uniqfilename  ,                                                                 
                                'sort' => $imgloopcnt ,
                                'mark' => '',
                                'status' => 'Y',
                                'reg_date' => current_time('mysql', 1) 
                            ),
                            array(
                            '%d',
                            '%s',                    
                            '%s',
                            '%d',
                            '%s',
                            '%s',
                            '%s'
                            )
                    
                    ) ;




                $imgloopcnt++;

                }


            }

            } else {

                echo "<Br><Br>NO FILE" ; 
            }




            $return_url = "alert('게시물이  입력되었습니다.'); 
            jQuery(location).attr('href','/wp-admin/admin.php?page=hplugin-product-gallery-menu');";
                    
            
        }

    } else if ( $_GET['show'] == "board-update"){ //----- input Update  -----//    

        if ( !$_SESSION['hplugins_pgallery_session'] || $_SESSION['hplugins_pgallery_session'] == "")  {  // 그냥 나감 
            
            
        } else {

        
            // 세션 취소시킴 : 중복전송 방지 
            $_SESSION['hplugins_pgallery_session'] = "";
        
            global $wpdb;


            $v_cid = $_POST["cid"];

            $v_title = $_POST["title"];
            $v_subtitle = $_POST["subtitle"];
            $v_contents = $_POST["contents"];
            $v_contents2 = $_POST["contents2"];

            $v_catecode_arr = $_POST["catecode"];


            $v_optcnt = $_POST["optcnt"];
            $v_price = $_POST["price"];


            // Get Image File 

            //echo "POST VAL IS ";
            print_r( $_POST );
            //$return_url = "";



            // catecode array
            $v_catecode_str = "";
            for($ci = 0; $ci < count($v_catecode_arr) ; $ci++){
                if( $ci > 0 ) $v_catecode_str .=",";
                $v_catecode_str .= $v_catecode_arr[$ci];
            }

        

            //-- data Update          
            $wpdb->update('wp_hplugin_product_gallery',
                array(  
                        'title' => $v_title , 
                        'subtitle' => $v_subtitle ,
                        'contents' => $v_contents, 
                        'contents2' => $v_contents2,
                        'catecode' => $v_catecode_str,
                        'price' => $v_price,                        

                ),
                array( 'no' => $v_cid ),

                array(
                    
                    '%s',
                    '%s',
                    '%s',
                    '%s',                                
                    '%s',                                
                    '%d',

                ),
                array( '%d')
                
            ) ;
            



            //-- Previous Option value delete 
            $wpdb->delete('wp_hplugin_product_gallery_opt',
                array(
                'c_no'=>$v_cid
                ),
                array(
                '%d'
                ) 
            ) ;



            //-- option input 
            // Get option loop value 
            for( $oi = 0; $oi < $v_optcnt ; $oi++){

                
                $pst= (string)$oi;

                $v_optname = $_POST["opt_info_".$pst];


                echo "<br>VAL NAME : opt_info_".$oi." /  ".$v_optname."<br>";  
                
                if( $v_optname != "" ){
                    
                    $v_optval_arr = $_POST["opt_".$pst];                    
                    $v_optarrcnt = count($v_optval_arr);


                    //echo "<br>VAL NAME : opt_info_".$oi." /  ".$v_optname." ".$v_optval_arr." / ".$v_optarrcnt."<br>";   
                    
                    if( $v_optarrcnt == 1) { 


                        if( $v_optval_arr ){ 
                            $wpdb->insert('wp_hplugin_product_gallery_opt',
                                array(  'c_no' => $v_cid ,                        
                                'name' => $v_optname ,
                                'value' => $v_optval_arr,                                                                 
                                'status' => 'Y',
                                'reg_date' => current_time('mysql', 1) 
                            ),
                            array(
                            '%d',
                            '%s',                    
                            '%s',
                            '%s',
                            '%s'
                            )
                        
                            ) ;
                        }


                    } else {


                        for( $pi=0 ; $pi < $v_optarrcnt ; $pi++){


                            $wpdb->insert('wp_hplugin_product_gallery_opt',
                                array(  'c_no' => $v_cid ,                        
                                'name' => $v_optname ,
                                'value' => $v_optval_arr[$pi],                                                                 
                                'status' => 'Y',
                                'reg_date' => current_time('mysql', 1) 
                            ),
                            array(
                            '%d',
                            '%s',                    
                            '%s',
                            '%s',
                            '%s'
                            )
                    
                            ) ;


                        }


                    }
                                        

                }
                


            }



            //-- imageupload 

            $imgloopcnt = 0 ; 

            if( (isset($_FILES['upload_img']) ) ){ 

                // Get Max sort value 
                $sql_query = sprintf( "SELECT ifnull( max(sort), 0 ) mcnt FROM wp_hplugin_product_gallery_img WHERE c_no=%d", $v_cid) ;
                $sort_fd = $wpdb->get_results($sql_query);

                $max_sort_plus = 0 ; 

                foreach( $sort_fd as $sort_arr){
                    $max_sort_plus = (int)($sort_arr->mcnt) + 1 ;                 
                }   


                foreach( $_FILES["upload_img"]['tmp_name'] as $key=>$tmpname   ){



                    if( $_FILES["upload_img"]["size"][$key]  > 0 ){

                        if(  $imgloopcnt == 0 ) { 
                            $a_today = explode("-",date("Y-m-d") ) ;

                            $file_upload_path = HPLUGIN_PRODUCT_GALLERY__CONTENT_DIR.$a_today[0]."/".$a_today[1];
                            $save_path = $a_today[0]."/".$a_today[1];
    

                            // Create directory for upload files.
                            if( !is_dir($file_upload_path)){
                                mkdir($file_upload_path, 0755, true) ;
                            }
                        }
    



                        $a_filename  = $_FILES["upload_img"]["name"][$key] ;
                        $a_filetmp   = $_FILES["upload_img"]["tmp_name"][$key] ;
                        $a_filesize  = $_FILES["upload_img"]["size"][$key] ;




                        $a_uniq_tmp = uniqid();
                        $a_filename_tmp = explode(".", $a_filename );
    
                        $a_file_ext = "";
                        if ( count($a_filename_tmp)  > 0  ) { 
                            $a_file_ext = ".".$a_filename_tmp[ (count($a_filename_tmp) -1 )] ;
                        } 
    
    
                        $a_uniqfilename = $a_uniq_tmp.$a_file_ext;          
                
                        // FileSave ;
                        copy( $a_filetmp , $file_upload_path."/".$a_uniqfilename);           
                    


                        // DB insert 
                        $wpdb->insert('wp_hplugin_product_gallery_img',
                                array(  
                                'c_no' => $v_cid ,                        
                                'title' => '' ,
                                'imgurl' => $save_path .'/'.$a_uniqfilename  ,                                                                 
                                'sort' => $max_sort_plus ,
                                'mark' => '',
                                'status' => 'Y',
                                'reg_date' => current_time('mysql', 1) 
                            ),
                            array(
                            '%d',
                            '%s',                    
                            '%s',
                            '%d',
                            '%s',
                            '%s',
                            '%s'
                            )
                    
                        ) ;



                        $max_sort_plus++;
                        $imgloopcnt++;

                    }    

                }


            } else {

                echo "<Br><Br>NO FILE" ; 
            }



            $return_url = "alert('게시물이  업데이트 되었습니다.'); 
            jQuery(location).attr('href','/wp-admin/admin.php?page=hplugin-product-gallery-menu&show=board-view&cid=".$v_cid."');";
                    
            
        }


    } else if ( $_GET['show'] == "board-delete"){ //----- delete   -----//    

        if ( !$_SESSION['hplugins_pgallery_session'] || $_SESSION['hplugins_pgallery_session'] == "")  {  // 그냥 나감 
            
            
        } else {

            // 세션 취소시킴 : 중복전송 방지 
            $_SESSION['hplugins_pgallery_session'] = "";
        
            global $wpdb;

            $v_cid = $_GET["cid"];
            if( !$v_cid) $v_cid = $_POST["cid"];


            // image file delete 
            $sql_query = sprintf("SELECT imgurl FROM wp_hplugin_product_gallery_img WHERE c_no=%d", $v_cid);

            $img_fd = $wpdb->get_results($sql_query);

            foreach( $img_fd as $img_arr){
                
                $a_imgurl = $img_arr->imgurl;

                if( $a_imgurl){
                    
                    $file_upload_path = HPLUGIN_PRODUCT_GALLERY__CONTENT_DIR.$a_imgurl;
                    if( file_exists($file_upload_path)){
                        @unlink( $file_upload_path );
                    }
                }
            }


            // Delete image db 
            $wpdb->delete('wp_hplugin_product_gallery_img',
                array(
                'c_no'=>$v_cid
                ),
                array(
                '%d'
                ) 
            ) ;

            // Delete option db 
            $wpdb->delete('wp_hplugin_product_gallery_opt',
                array(
                'c_no'=>$v_cid
                ),
                array(
                '%d'
                ) 
            ) ;


            // Delete  db 
            $wpdb->delete('wp_hplugin_product_gallery',
                array(
                'no'=>$v_cid
                ),
                array(
                '%d'
                ) 
            ) ;



            // 메인 정렬테이블에서 삭제함  [추후 추가]


            $return_url = "alert('게시물이  삭제되었습니다. '); 
            jQuery(location).attr('href','/wp-admin/admin.php?page=hplugin-product-gallery-menu');";



        }



    }
?>


<script>
<?php  print $return_url ;?>
</script>
