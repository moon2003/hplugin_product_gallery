<?php

    // Creation Session to block duplpicate form seding  
    $_SESSION['hplugins_pgallery_session'] = date(U);    ;   
  


    // Get Category 
    global $wpdb ;

    $sql_query = "SELECT no, catename FROM wp_hplugin_product_gallery_cate ORDER by no asc ";

    $cate_fd = $wpdb->get_results ($sql_query ) ;   
    
    // category Data fetch
    $a_catecode_str = ""; 
    $a_cateloop = 0 ;  

    foreach ( $cate_fd as $cate_arr ) { 

        if( $a_cateloop > 0) $a_catecode_str .="<br>";
        $a_catecode_str .= "<input type=\"checkbox\" name=\"catecode[]\" value=\"".$cate_arr->no."\" >".$cate_arr->catename; 
        $a_cateloop++;
    }


    // option Data fetch 

    $sql_query = "SELECT no, name, value, type, iconurl, sort, status FROM wp_hplugin_product_gallery_opt_set WHERE status='Y' ORDER by SORT asc";
    $opt_fd = $wpdb->get_results ($sql_query ) ;   

    $a_opt_str = "";
    $a_loopcnt = 0; 
    foreach ( $opt_fd as $opt_arr){


        $a_opt_str .= "<div style=\"clear:both;margin:2px 0 2px 0; min-height:32px;\">
            <div style=\"float:left;width:10%\"><span class=\"label label-default\" style=\"padding:3px;\">".$opt_arr->name."</span><input type=\"hidden\" name=\"opt_info_".$a_loopcnt."\" value=\"".$opt_arr->no."\"></div>
            <div style=\"float:left:width:88%\">";

        switch($opt_arr->type){

            case "I" : 
                $a_opt_str .= "<input type=\"text\" name=\"opt_".$a_loopcnt."\" value=\"\" style=\"width:70%\">";
                $a_loopcnt++; 
                break;
            case "C" : 

                $a_opt_val_arr = explode("__##__", $opt_arr->value);
                $optcnt = count($a_opt_val_arr);

                for($pi=0; $pi < $optcnt ; $pi++){

                    $a_opt_str .= "<input type=\"checkbox\" name=\"opt_".$a_loopcnt."[]\" value=\"".$a_opt_val_arr[$pi]."\"> ".$a_opt_val_arr[$pi]."&nbsp;";    
                }
                
                $a_loopcnt++;  
                break;

            case "R" : 

                $a_opt_val_arr = explode("__##__", $opt_arr->value);
                $optcnt = count($a_opt_val_arr);

                for($pi=0; $pi < $optcnt ; $pi++){
                    $a_opt_str .= "<input type=\"radio\" name=\"opt_".$a_loopcnt."\" value=\"".$a_opt_val_arr[$pi]."\"> ".$a_opt_val_arr[$pi]."&nbsp;";    
                }
                
                $a_loopcnt++;  
                break;

            case "S" :

                $a_opt_val_arr = explode("__##__", $opt_arr->value);
                $optcnt = count($a_opt_val_arr);

                $a_opt_str .="<select name=\"opt_".$a_loopcnt."\">";
                for($pi=0; $pi < $optcnt ; $pi++){
                    $a_opt_str .= "<option value=\"".$a_opt_val_arr[$pi]."\"> ".$a_opt_val_arr[$pi]."</option>";    
                }                
                $a_loopcnt++;  

                $a_opt_str .="</select>";
                
                break;



        }


        $a_opt_str .= "<div></div>";        
    }

    $a_opt_str .= "<input type=\"hidden\" name=\"optcnt\" value=\"".$a_loopcnt."\">";

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

    
        <form id="frm_in_id" name="frm_in" action="/wp-admin/admin.php?page=hplugin-product-gallery-menu&show=board-save" method="post" enctype="multipart/form-data"> 
        <table class="table table-striped">
       
         <tbody> 

            <tr>
                <td class="active">제목</td>
                <td><input type="text" id="title_id" name="title" size="120"></td>
            </tr>            

            <tr>
                <td class="active">부제목</td>
                <td><input type="text" id="subtitle_id" name="subtitle" size="120"></td>
            </tr>                        


            <tr>
                <td class="active">본문[HTML가능]</td>
                <td><textarea id="contents_id" name="contents" style="width:700px;height:400px;"></textarea></td>
            </tr>            



            <tr>
                <td class="active">본문2[HTML가능]</td>
                <td><textarea id="contents2_id" name="contents2" style="width:700px;height:200px;"></textarea></td>
            </tr>            



            <tr>
                <td class="active">카테고리지정</td>
                <td>
                <?php echo $a_catecode_str ;?>
                </td>
            </tr>            


            <tr>
                <td class="active">임대가격</td>
                <td><input type="text" id="price_id" name="price" style="width:150px; text-align:right">원</td>
                </td>
            </tr> 



            <tr>
                <td class="active">출력 옵션값선택</td>
                <td>
                        <?php echo $a_opt_str ;?>
                </td>
            </tr>                       

            <tr>
                <td class="active">이미지업로드  &nbsp; <span class="label label-warning" onclick="javascript:hplugin_product_gallery_img_add('<?php print HPLUGIN_PRODUCT_GALLERY__PLUGIN_URL; ?>');" style="cursor:pointer">이미지추가</span> </td>
                <td id="hplugin_product_gallery_img_id">
                    
                    <div style="clear:both;margin-bottom:10px;" id="img_field_00_id">
                        <div style="float:left;min-width:250px;min-height:100px;"><img src="<?php print HPLUGIN_PRODUCT_GALLERY__PLUGIN_URL; ?>images/hplugin_product_gallery_noimage.png" id="upload_img_00_id" border="1px" style="width:240px;" ></div>
                        <div style="float:left;"><input type="file" name="upload_img[]" onChange="javascript:hplugin_product_gallery_image_select( this, 'upload_img_00_id' );"></div>                        
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
    </form>    

    <div class="ht_room_admin_local_menu">    
    <span class="label label-primary htobbs_btn" onclick="javascript:hplugin_product_gallery_boardSave();" >저장하기</span>
    </div>
    
    <div class="both_clear" style="height:30px;"></div>
    
    
</div>

