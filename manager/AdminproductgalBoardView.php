<?php

    // Creation Session to block duplpicate form seding  
    $_SESSION['hplugins_pgallery_session'] = date(U);    ;   
  

    $v_cid = $_GET["cid"];

    global $wpdb ;

    // Get Main Data
    $sql_query = sprintf( "SELECT no, r_no, title, subtitle, contents, contents2, catecode, price FROM wp_hplugin_product_gallery WHERE status='Y' AND no=%d", $v_cid );
    $gal_fd = $wpdb->get_results($sql_query);

    foreach( $gal_fd as $gal_data){

        $a_title = $gal_data->title;
        $a_subtitle = $gal_data->subtitle;
        $a_contents = $gal_data->contents;
        $a_contents2 = $gal_data->contents2;
        $a_catecode_arr = explode(",", $gal_data->catecode)  ; 
        $a_price = $gal_data->price;

    }




    // Get Category 
    $sql_query = "SELECT no, catename FROM wp_hplugin_product_gallery_cate ORDER by no asc ";

    $cate_fd = $wpdb->get_results ($sql_query ) ;   
    
    // category Data fetch
    $a_catecode_str = ""; 
    $a_cateloop = 0 ;  

    foreach ( $cate_fd as $cate_arr ) { 

        // Check selected catecode 

        $a_cate_checked = "";

        if( in_array($cate_arr->no , $a_catecode_arr) ) {
            $a_cate_checked = "checked";
        }

        if( $a_cateloop > 0) $a_catecode_str .="<br>";
        $a_catecode_str .= "<input type=\"checkbox\" name=\"catecode[]\" value=\"".$cate_arr->no."\"  ".$a_cate_checked." >".$cate_arr->catename; 
        $a_cateloop++;

    }


    // option Data fetch 
    $sql_query = "SELECT no, name, value, type, iconurl, sort, status FROM wp_hplugin_product_gallery_opt_set WHERE status='Y' ORDER by SORT asc";
    $opt_fd = $wpdb->get_results ($sql_query ) ;   

    $a_opt_str = "";
    $a_loopcnt = 0; 
    foreach ( $opt_fd as $opt_arr){


        // Get option set data 
        $sql_query = sprintf("SELECT no, c_no, name, value, status, reg_date FROM wp_hplugin_product_gallery_opt WHERE c_no=%d and name=%s ", $v_cid, $opt_arr->no) ;
        $optsave_fd = $wpdb->get_results ($sql_query ) ;


        $a_opt_str .= "<div style=\"clear:both;margin:2px 0 2px 0; min-height:32px;\">
            <div style=\"float:left;width:10%\"><span class=\"label label-default\" style=\"padding:3px;\">".$opt_arr->name."</span><input type=\"hidden\" name=\"opt_info_".$a_loopcnt."\" value=\"".$opt_arr->no."\"></div>
            <div style=\"float:left:width:88%\">";

        switch($opt_arr->type){

            case "I" : 
                
                $v_optsetval = "";
                foreach( $optsave_fd as $optsave_arr ){
                    $v_optsetval = $optsave_arr->value;
                }

                $a_opt_str .= "<input type=\"text\" name=\"opt_".$a_loopcnt."\" value=\"".$v_optsetval."\" style=\"width:70%\">";
                $a_loopcnt++; 
                break;
            case "C" : 

                $a_opt_val_arr = explode("__##__", $opt_arr->value);
                $optcnt = count($a_opt_val_arr);

                $a_optval_loop = 0 ; 
                $v_optsetval_arr = array(); 

                foreach( $optsave_fd as $optsave_arr ){
                    $v_optsetval_arr[$a_optval_loop] = trim($optsave_arr->value);
                    $a_optval_loop++;
                }

                for($pi=0; $pi < $optcnt ; $pi++){

                    $a_optset_checked = "";
                    if( in_array(  trim($a_opt_val_arr[$pi]) , $v_optsetval_arr ) ){ $a_optset_checked = "checked"; }

                    $a_opt_str .= "<input type=\"checkbox\" name=\"opt_".$a_loopcnt."[]\" value=\"".$a_opt_val_arr[$pi]."\" ".$a_optset_checked."  > ".$a_opt_val_arr[$pi]."&nbsp;";    
                }
                
                $a_loopcnt++;  
                break;

            case "R" : 

                $a_opt_val_arr = explode("__##__", $opt_arr->value);
                $optcnt = count($a_opt_val_arr);


                $a_optval_loop = 0 ; 
                $v_optsetval_arr = array(); 

                foreach( $optsave_fd as $optsave_arr ){
                    $v_optsetval_arr[$a_optval_loop] = trim($optsave_arr->value);
                    $a_optval_loop++;
                }


                for($pi=0; $pi < $optcnt ; $pi++){


                    $a_optset_checked = "";
                    if( in_array(  trim($a_opt_val_arr[$pi]) , $v_optsetval_arr ) ){ $a_optset_checked = "checked"; }

                    $a_opt_str .= "<input type=\"radio\" name=\"opt_".$a_loopcnt."\" value=\"".$a_opt_val_arr[$pi]."\" ".$a_optset_checked." > ".$a_opt_val_arr[$pi]."&nbsp;";    
                }
                
                $a_loopcnt++;  
                break;

            case "S" :

                $a_opt_val_arr = explode("__##__", $opt_arr->value);
                $optcnt = count($a_opt_val_arr);

                $a_optval_loop = 0 ; 
                $v_optsetval_arr = array(); 

                foreach( $optsave_fd as $optsave_arr ){
                    $v_optsetval_arr[$a_optval_loop] = trim($optsave_arr->value);
                    $a_optval_loop++;
                }


                $a_opt_str .="<select name=\"opt_".$a_loopcnt."\"\">";
                for($pi=0; $pi < $optcnt ; $pi++){

                    $a_optset_checked = "";
                    if( in_array(  trim($a_opt_val_arr[$pi]) , $v_optsetval_arr ) ){ $a_optset_checked = "selected"; }

                    $a_opt_str .= "<option value=\"".$a_opt_val_arr[$pi]."\" ".$a_optset_checked." >".$opt_val_arr[$pi]."</option>";    
                }                
                $a_loopcnt++;  
                break;

                $a_opt_str .="</select>";

            default : 


        }


        $a_opt_str .= "<div></div>";        
    }

    $a_opt_str .= "<input type=\"hidden\" name=\"optcnt\" value=\"".$a_loopcnt."\">";




    // image load 
    $sql_query = sprintf("SELECT no, c_no, title, imgurl, sort, mark FROM wp_hplugin_product_gallery_img WHERE c_no=%d order by sort asc ", $v_cid);;
    $img_fd = $wpdb->get_results ($sql_query ) ;

    $a_img_str = "";

    $iloopcnt = 0 ;

    foreach( $img_fd as $img_arr ){


        $a_img_no = $img_arr->no;
        $a_img_title = $img_arr->title;
        $a_img_url = $img_arr->imgurl;
        $a_img_sort = $img_arr->sort ; 
        $a_img_sort = $img_arr->mark;


        $a_img_str .= "
                    <div style=\"clear:both;margin-bottom:30px;\" id=\"img_upload_".$iloopcnt."\">
                        <div style=\"float:left;min-width:250px;min-height:100px; margin-bottom:20px;\">
                        <input type=\"hidden\" name=\"imgsortno[]\" value=\"".$a_img_no."\">
                        <img src=\"".HPLUGIN_PRODUCT_GALLERY__CONTENT_URL.$a_img_url."\" id=\"upload_img_xx_id\" border=\"1px\" style=\"width:240px;\" ></div>
                        <div style=\"float:left;\">
                        <span class=\"label label-danger\" style=\"padding:3px;cursor:pointer;\" onclick=\"javascript:hplugin_product_gallery_imgdel( ".$a_img_no." , ".$v_cid." );\">이미지 삭제</span>&nbsp;
                        <span class=\"label label-info\" style=\"padding:3px;cursor:pointer;\" onclick=\"javascript:hplugin_product_gallery_set_img( ".$a_img_no." , ".$v_cid."  ,'T' );\">썸네일 지정</span>&nbsp;
                        <span class=\"label label-primary\" style=\"padding:3px;cursor:pointer;\" onclick=\"javascript:hplugin_product_gallery_set_img( ".$a_img_no." , ".$v_cid." ,'R' );\">View 대표지정</span>

                            <br><br><i class=\"glyphicon glyphicon-arrow-up\" style=\"cursor:pointer;color:red\" onclick=\"javascript:hplugin_product_gallery_image_sort('U',".$iloopcnt.");\"></i> 
                            <i class=\"glyphicon glyphicon-arrow-down\" style=\"cursor:pointer;color:blue\" onclick=\"javascript:hplugin_product_gallery_image_sort('D',".$iloopcnt.");\" /></i>
                        </div>                        
                    </div>
                ";

        $iloopcnt++;

    }



    // Get Thumbnail image 
    $sql_query = sprintf("SELECT no, imgurl FROM wp_hplugin_product_gallery_img WHERE c_no=%d AND status='Y' AND mark='T' limit 1", $v_cid) ;
    $timg_fd = $wpdb->get_results ($sql_query ) ;

    $a_thumbimg_str = HPLUGIN_PRODUCT_GALLERY__PLUGIN_URL."images/hplugin_product_gallery_noimage.png";

    foreach( $timg_fd as $timg_arr){
        $a_thumbimg_str = HPLUGIN_PRODUCT_GALLERY__CONTENT_URL.$timg_arr->imgurl;
    }

    // Get Present image 
    $sql_query = sprintf("SELECT no, imgurl FROM wp_hplugin_product_gallery_img WHERE status='Y' AND mark2='R' limit 1", $v_cid);
    $rimg_fd = $wpdb->get_results ($sql_query ) ;

    $a_repreimg_str = HPLUGIN_PRODUCT_GALLERY__PLUGIN_URL."images/hplugin_product_gallery_noimage.png";

    foreach( $rimg_fd as $rimg_arr){
        $a_repreimg_str = HPLUGIN_PRODUCT_GALLERY__CONTENT_URL.$rimg_arr->imgurl;
    }    



?>
<script src="<?php print HPLUGIN_PRODUCT_GALLERY__PLUGIN_URL; ?>js/hplugin_product_gallery_admin.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?php print HPLUGIN_PRODUCT_GALLERY__PLUGIN_URL; ?>hplugin_product_gallery_admin.css" />
        
        
<div id="hplugin_admin_body" >

    <div class="hplugin_admin_local_menu">
        <ul class="nav nav-tabs" role="tablist">
            <li ><a href="/wp-admin/admin.php?page=hplugin-product-gallery-menu">게시물목록</a></li>
            <li class="active" ><a href="/wp-admin/admin.php?page=hplugin-product-gallery-menu&show=board-input">게시물생성</a></li>            
        </ul>       
    </div>
                
    <div class="both_clear" style="height:30px;"></div>

    
        <form id="frm_in_id" name="frm_in" action="/wp-admin/admin.php?page=hplugin-product-gallery-menu&show=board-update" method="post" enctype="multipart/form-data"> 
        <table class="table table-striped">
       
         <tbody> 

            <tr>
                <td class="active">제목</td>
                <td><input type="text" id="title_id" name="title" size="120" value="<?php echo $a_title;?>"></td>
            </tr>            

            <tr>
                <td class="active">부제목</td>
                <td><input type="text" id="subtitle_id" name="subtitle" size="120" value="<?php echo $a_subtitle;?>"></td>
            </tr>                        


            <tr>
                <td class="active">본문[HTML가능]</td>
                <td><textarea id="contents_id" name="contents" style="width:700px;height:400px;"><?php echo $a_contents;?></textarea></td>
            </tr>            



            <tr>
                <td class="active">본문2[HTML가능]</td>
                <td><textarea id="contents2_id" name="contents2" style="width:700px;height:200px;"><?php echo $a_contents2;?></textarea></td>
            </tr>            



            <tr>
                <td class="active">카테고리지정</td>
                <td>
                <?php echo $a_catecode_str ;?>
                </td>
            </tr>            


            <tr>
                <td class="active">임대가격</td>
                <td><input type="text" id="price_id" name="price" style="width:150px; text-align:right" value="<?php echo $a_price;?>">원</td>
                </td>
            </tr> 



            <tr>
                <td class="active">출력 옵션값선택</td>
                <td>
                        <?php echo $a_opt_str ;?>
                </td>
            </tr>                       


            <tr>
                <td class="active">썸네일 / View 대표 이미지 </td>
                <td>

                        

                    <div style="clear:both;margin-bottom:10px;" id="img_thumb_id">                    
                        <div style="float:left;min-width:230px;min-height:100px; margin:10px 20px 10px 10px;">
                            <div class="alert alert-info">썸네일 이미지</div>
                            <img src="<?php echo $a_thumbimg_str;?>" id="upload_img_00_id" border="1px" style="width:240px;" >
                            <br>
                            <span class="btn btn-warning btn-xs" style="margin-top:15px;" onclick="javascript:hplugin_product_gallery_set_img( '' , <?php echo $v_cid;?>  ,'T' );">Clear</span>
                        </div>
                        <div style="float:left;min-width:230px;min-height:100px; margin:10px 20px 10px 10px;">
                            <div class="alert alert-info">View 대표 이미지</div>
                            <img src="<?php echo $a_repreimg_str;?>" id="upload_img_00_id" border="1px" style="width:240px;" >
                            <br>
                            <span class="btn btn-warning btn-xs" style="margin-top:15px;" onclick="javascript:hplugin_product_gallery_set_img( '' , <?php echo $v_cid;?>  ,'R' );">Clear</span>
                        </div>                        
                    </div>                        


                </td>
            </tr>                       




            <tr>
                <td class="active">이미지업로드  &nbsp; <span class="label label-warning" onclick="javascript:hplugin_product_gallery_img_add('<?php print HPLUGIN_PRODUCT_GALLERY__PLUGIN_URL; ?>');" style="cursor:pointer">이미지추가</span> </td>
                <td id="hplugin_product_gallery_img_id">
                    
                    <div id="hplugin_product_gallery_sort_info" style="display:none;clear:both;height:30px;">
                        <span style="color:red">* 이미지 순서가 변경되었습니다. 옆의 버튼을 누르면 반영됩니다. </span> &nbsp;&nbsp;
                        <span class="btn btn-primary btn-xs" onclick="javascript:hplugin_product_gallery_image_sortsave(<?php echo $v_cid;?>);">순서적용반영</span>
                    </div>

                    <?php echo $a_img_str;?>

                    <div style="clear:both;margin-bottom:10px;" id="img_field_00_id">
                        <div style="float:left;min-width:250px;min-height:100px;"><img src="<?php print HPLUGIN_PRODUCT_GALLERY__PLUGIN_URL; ?>images/hplugin_product_gallery_noimage.png" id="upload_img_00_id" border="1px" style="width:240px;" ></div>
                        <div style="float:left;"><input type="file" name="upload_img[]"></div>                        
                    </div>
                    
                </td>
            </tr>      





            <!--tr>
                <td class="active">옵션값 &nbsp; <span class="label label-warning" onclick="javascript:hplugin_product_gallery_opt_add();" style="cursor:pointer">필드추가</span></td>
                <td id="hplugin_product_gallery_opt_field_id"> 
                    <div id="opt_field_00_id" style="margin-top:12px;" ><input type="text" id="opt_value_id" name="opt_value[]" size="60">
                    <span class="label label-danger" onclick="javascript:hplugin_product_gallery_opt_del('00');" style="cursor:pointer">X</span></div>
    
                </td>
            </tr-->                       
                

          </tbody>               
 
    </table>

    <input type="hidden" name="cid" value="<?php echo $v_cid;?>">
    </form>    

    <div class="ht_room_admin_local_menu">    
    <span class="label label-primary htobbs_btn" onclick="javascript:hplugin_product_gallery_boardSave();" >업데이트 하기</span>
    </div>
    
    <div class="both_clear" style="height:30px;"></div>
    
    
</div>

