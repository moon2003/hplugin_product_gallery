<?php 

    // Creation Session to block duplpicate form sending  
    $_SESSION['hplugins_pgallery_session'] = date(U);    

    global $wpdb ;

    //$v_rid = $_GET["rid"];


    //Get setting Value 
    $a_product_gallert_set_arr = hplugin_product_gallery_getSetvalue();

    $a_adminemail = $a_product_gallert_set_arr['adminemail'];
    $a_auth_key   = $a_product_gallert_set_arr['auth_key'];

    $a_cate_no    = $a_product_gallert_set_arr['catecode'] ;
    $a_listrow_no = $a_product_gallert_set_arr['listrownum'] ; 
    $a_gallery_type = $a_product_gallert_set_arr['gtype'];
    $a_display_mode = $a_product_gallert_set_arr['displaymode'];

    $a_viewurl = $a_product_gallert_set_arr['viewurl'];

    //$a_banner_thumbchk = $a_product_gallert_set_arr['banner_thumbnail'];


    

?>
<script src="<?php print HPLUGIN_PRODUCT_GALLERY__PLUGIN_URL; ?>js/hplugin_product_gallery_admin.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?php print HPLUGIN_PRODUCT_GALLERY__PLUGIN_URL; ?>hplugin_product_gallery_admin.css" />

<div id="hplugin_admin_body" >

    <div class="hplugin_admin_local_menu">
        <ul class="nav nav-tabs" role="tablist">
            <li class="active"><a href="/wp-admin/admin.php?page=hplugin-ebook-setting-menu">Product Gallery 환경설정 </a></li>            
        </ul>       
    </div>
                
    <div class="both_clear" style="height:30px;"></div>

    
    <div>
    <table class="table table-striped">
        <form id="frm_in" name="frm_in" action="/wp-admin/admin.php?page=hplugin-product-gallery-setting-menu&show=set-update" method="post" enctype="multipart/form-data">       
         <tbody>                         

                
            <tr>
                <td class="active">관리자이메일</td>
                <td><input type="text" value="<?php print $a_adminemail; ?>" name="adminemail"  id="adminemail_id" ></td>
            </tr>            

            <tr>
                <td class="active">AuthKey</td>
                <td><input type="text" value="<?php print $a_auth_key; ?>" name="auth_key" id="auth_key_id" >
                    <button type="button" class="btn btn-xs btn-default" onclick="javascript:hplugin_product_gallery_keyreset();">기본키발급</button> 
                    ※ authkey가 없으면 동작하지 않습니다.                     

                </td> 
            </tr>
<?php
    $a_gallery_type_arr = array("" , ""); 
    switch( $a_gallery_type) {

        case 'A' : 
            $a_gallery_type_arr[0] ="checked" ;
            break;
        case 'B' :
            $a_gallery_type_arr[1] ="checked" ;
            break;

        default :
            $a_gallery_type_arr[1] ="checked" ;
            break;


    }

?>
            <tr>
                <td class="active">Gallery Type</td>
                <td><input type="radio" value="A" id="etype_id" name="etype" <?php print $a_gallery_type_arr[0]; ?> > 타입A  &nbsp;&nbsp;
                    <input type="radio" value="B" id="etype_id" name="etype" <?php print $a_gallery_type_arr[1]; ?> > 타입B (Default)
                    </td>
            </tr> 


<?php
    $a_display_mode_arr = array("" , ""); 
    switch( $a_display_mode) {

        case 'P' : 
            $a_display_mode_arr[0] ="checked" ;
            break;
        case 'V' :
            $a_display_mode_arr[1] ="checked" ;
            break;
        default :
            $a_display_mode_arr[1] ="checked" ;
            break;


    }

?>
            <tr>
                <td class="active">Display Mode </td>
                <td><input type="radio" value="P" id="etype_id" name="display_mode" <?php print $a_display_mode_arr[0]; ?> > Popup   &nbsp;&nbsp;
                    <input type="radio" value="V" id="etype_id" name="display_mode" <?php print $a_display_mode_arr[1]; ?> > View
                    </td>
            </tr> 
<?php
    
    //$a_listrowcnt_arr[$a_listrowcnt] = "selected";
    $a_listrow_str = "";
    for($lcnt= 0; $lcnt < 30 ; $lcnt++){
        if ( $a_listrow_no == ($lcnt+1) ) {            
            $a_listrow_str .= "<option value=\"".($lcnt+1)."\" selected >".($lcnt+1)."</option>\n";
        } else {
            $a_listrow_str .= "<option value=\"".($lcnt+1)."\" >".($lcnt+1)."</option>\n";
        }
    }


?>

            <tr>
                <td class="active">출력리스트갯수  </td>
                <td><select name="listrowcnt">
                <?php print $a_listrow_str; ?>
                </select></td>
            </tr>


            <tr>
                <td class="active">진열목록 BASE PAGE URL</td>
                <td><input type="text" value="<?php print $a_viewurl; ?>" name="viewurl"  id="viewurl_id" style="width:400px;" placeholder="http://www.domain.com?page_id=xx" ></td>
            </tr>            



<?php 

    $sql_query = sprintf("SELECT no, catename FROM wp_hplugin_product_gallery_cate WHERE no in ( %s ) ", 
                    $a_cate_no);
 

    $ct_fd = $wpdb->get_results($sql_query);

    $ctvCtn = 0 ; 
    $a_cat_btn_str = "";

    foreach( $ct_fd as $ct_arr ){

            if($ctvCtn > 0){
                $a_cat_btn_str .="&nbsp;";
            }

            $a_cat_btn_str .= "<button type=\"button\" class=\"btn btn-xs btn-primary\">".$ct_arr->catename."</button>";
            $ctvCtn++;
    }

    if($ctvCtn > 0 ){

        $a_cat_btn_str .= "&nbsp;&nbsp;<button type=\"button\" class=\"btn btn-xs btn-warning\" onclick=\"javascript:hplugin_product_gallery_cateClear();\">Clear</button>";
    }
            
?>  

            <tr>
                <td class="active">카테고리</td>
                <td><button id="category_pop" class="btn btn-xs btn-default" type="button" data-toggle="modal" data-target="#myModal" title="카테고리" >카테고리선택</button>&nbsp; <span id="catename_layer"><?php print $a_cat_btn_str;?></span></td>
            </tr> 

           
          </tbody>
            
    </table>
    </div>

<?php


    $sql_query = "SELECT no, catename FROM wp_hplugin_product_gallery_cate order by catename asc";
        
    $c_fd = $wpdb->get_results($sql_query);
        
    
    $a_cate_str = "";  
    $catCnt = 0;

    foreach($c_fd as $c_arr){
    
        if ($catCnt == 0 ){    
            //$a_cate_str = "<button type=\"button\" class=\"btn btn-xs btn-info\" onclick=\"javascript:applyCate('".$c_arr->cat_name."','".$c_arr->no."');\">".$c_arr->cat_name."</button>" ;
            $a_cate_str = "<button id=\"catbtn_".$catCnt."\" type=\"button\" class=\"btn btn-xs btn-primary\" data-toggle=\"button\" value=\"".$c_arr->catename."|".$c_arr->no."\">".$c_arr->catename."</button>" ;
        } else {                
            //$a_cate_str .= "&nbsp;<button type=\"button\" class=\"btn btn-xs btn-info\" onclick=\"javascript:applyCate('".$c_arr->cat_name."','".$c_arr->no."');\">".$c_arr->cat_name."</button>" ;
            $a_cate_str .= "&nbsp;<button id=\"catbtn_".$catCnt."\" type=\"button\" class=\"btn btn-xs btn-primary\" data-toggle=\"button\" value=\"".$c_arr->catename."|".$c_arr->no."\">".$c_arr->catename."</button>" ;
        }


        $catCnt++;
                         
    }
        

?>  

<!-- category_popup -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">카테고리설정</h4>
      </div>
      <div class="modal-body">
        
      <?php print $a_cate_str; ?>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="javascript:hplugin_product_gallery_applyCate();">Apply</button>        
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>        
      </div>
    </div>
  </div>
</div>



    <div class="ht_room_admin_local_menu">    
        <button type="button" id="saveboard" class="btn btn-sm btn-primary" onclick="javascript:hplugin_product_gallery_setdUpdate();">적용하기</button>        
    </div>
    
    <div class="both_clear" style="height:30px;"></div>
      
    <input type="hidden" name="rid" id="rid_id" value="<?php print $v_rid;?>">
    <input type="hidden" name="catecode" id="catecode" value="<?php print $a_cate_no; ?>">        
       <input type="hidden" name="catcnt" id="catcnt" value="<?php print $catCnt;?>" >     
    </form> 

</div>


