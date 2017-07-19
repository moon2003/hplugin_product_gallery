<?php

    // Creation Session to block duplpicate form seding  
    $_SESSION['hplugins_pgallery_session'] = date(U);    ;


    global $wpdb ;

    $v_cid = $_GET["cid"];

    $sql_query = sprintf("SELECT no, catename  FROM wp_hplugin_product_gallery_cate WHERE no=%d",
                    (int)$v_cid);

    $c_fd = $wpdb->get_results($sql_query);



    foreach( $c_fd as $c_arr){

        $a_cat_name = $c_arr->catename;

        if ( $c_arr->no  < 10 ){

            $a_cate_code = "0".$c_arr->no;
        } else {
            $a_cate_code = $c_arr->no;
        }        

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
            <li ><a href="/wp-admin/admin.php?page=hplugin-product-gallery-cate-menu">카테고리목록</a></li>
            <li class="active"><a href="/wp-admin/admin.php?page=hplugin-product-gallery-cate-menu&show=cate-input">카테고리생성</a></li>           
        </ul>       
    </div>
                
    <div class="both_clear" style="height:30px;"></div>

    
    <table class="table table-striped">
        <form id="frm_in_id" name="frm_in" action="/wp-admin/admin.php?page=hplugin-product-gallery-cate-menu&show=cate-update" method="post" enctype="multipart/form-data">       
         <tbody> 


            <tr>
                <td class="active">코드</td>
                <td><?php print $a_cate_code ; ?></td>
            </tr>

            <tr>
                <td class="active">카테고리명</td>
                <td><input type="text" id="cat_name" name="cat_name" size="60" value="<?php print stripslashes($a_cat_name) ; ?>" >
            </tr>   
         
           
          </tbody> 
          <input type="hidden" name="cid" id="frm_schedule_rid_no" value="<?php print $v_cid; ?>">              
        </form>     
    </table>


    <div class="ht_room_admin_local_menu">    
    <span class="label label-primary htobbs_btn" onclick="javascript:hpluginproductgallery_cateUpdate();" >카테고리 업데이트</span>
    <!--span class="label label-danger htobbs_btn" onclick="javascript:hpluginproductgallery_cateDelete(<?php print $v_cid; ?>);" >카테고리 삭제</span-->
    </div>
    
    <div class="both_clear" style="height:30px;"></div>
    
    
    
</div>

