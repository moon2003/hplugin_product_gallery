<?php

    // Creation Session to block duplpicate form seding  
    $_SESSION['hplugins_pgallery_session'] = date(U);    ;   
    
?>
<script src="<?php print HPLUGIN_PRODUCT_GALLERY__PLUGIN_URL; ?>js/hplugin_product_gallery_admin.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?php print HPLUGIN_PRODUCT_GALLERY__PLUGIN_URL; ?>hplugin_product_gallery_admin.css" />
        
        
<div id="hplugin_admin_body" >

    <div class="hplugin_admin_local_menu">
        <ul class="nav nav-tabs" role="tablist">
            <li ><a href="/wp-admin/admin.php?page=hplugin-product-gallery-option-menu">옵션목록</a></li>
            <li class="active"><a href="/wp-admin/admin.php?page=hplugin-product-gallery-option-menu&show=option-input">신규옵션생성</a></li>           
        </ul>       
    </div>
                
    <div class="both_clear" style="height:30px;"></div>

    
        <form id="frm_in_id" name="frm_in" action="/wp-admin/admin.php?page=hplugin-product-gallery-option-menu&show=option-save" method="post" enctype="multipart/form-data"> 
        <table class="table table-striped">
       
         <tbody> 

            <tr>
                <td class="active">옵션명</td>
                <td><input type="text" id="opt_name_id" name="opt_name" size="60"></td>
            </tr>            

            <tr>
                <td class="active">옵션타입</td>
                <td>
                    <input type="radio"  name="opt_type" id="opt_type_id" value="I" checked onclick="javascript:hplugin_product_gallery_opttype('C');" >INPUT &nbsp;
                    <input type="radio"  name="opt_type" id="opt_type_id" value="R" onclick="javascript:hplugin_product_gallery_opttype('S');">RADIO &nbsp;
                    <input type="radio"  name="opt_type" id="opt_type_id" value="C" onclick="javascript:hplugin_product_gallery_opttype('S');">CHECKBOX &nbsp;
                    <input type="radio"  name="opt_type" id="opt_type_id" value="S" onclick="javascript:hplugin_product_gallery_opttype('S');">SELECT
                </td>
            </tr>                       

            <tr>
                <td class="active">옵션값 &nbsp; <span class="label label-warning" onclick="javascript:hplugin_product_gallery_opt_add();" style="cursor:pointer">필드추가</span></td>
                <td id="hplugin_product_gallery_opt_field_id"> 
                    <div id="opt_field_00_id" style="margin-top:12px;" ><input type="text" id="opt_value_id" name="opt_value[]" size="60">
                    <span class="label label-danger" onclick="javascript:hplugin_product_gallery_opt_del('00');" style="cursor:pointer">X</span></div>
    
                </td>
            </tr>                       

            <tr>
                <td class="active">필수구분</td>
                <td>
                    <input type="radio" name="nessesary" value="Y" checked > <span class="label label-primary">필수필드</span>
                    <input type="radio" name="nessesary" value="N"> <span class="label label-success">비필필드</span>
                </td>
            </tr>                       

          </tbody>               
 
    </table>
    </form>    

    <div class="ht_room_admin_local_menu">    
    <span class="label label-primary htobbs_btn" onclick="javascript:hplugin_product_gallery_optionSave();" >옵션 생성</span>
    </div>
    
    <div class="both_clear" style="height:30px;"></div>
    
    
</div>

