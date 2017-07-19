<?php

    // Creation Session to block duplpicate form seding  
    $_SESSION['hplugins_pgallery_session'] = date(U);   

    global $wpdb;

    $v_cid = $_GET["cid"];

    $sql_query = sprintf("SELECT no, name, value, iconurl, type, sort, status  FROM wp_hplugin_product_gallery_opt_set WHERE no=%d",
                    (int)$v_cid);

    $op_fd = $wpdb->get_results($sql_query);



    foreach( $op_fd as $op_arr){

        $a_opname = $op_arr->name;
        $a_opvalue = $op_arr->value;
        $a_opiconurl = $op_arr->ioconurl;
        $a_optype = $op_arr->type;
        $a_opsort = $op_arr->sort;
        $a_status = $op_arr->status;
    }


    
    $a_optype_arr = array("","","","");

    switch($a_optype){

        case "I" :
            $a_optype_arr[0] = "checked";
            break;
        case "R" :
            $a_optype_arr[1] = "checked";
            break; 
        case "C" : 
            $a_optype_arr[2] = "checked";
            break;
        case "S" :
            $a_optype_arr[3] = "checked";
            break;
        default :
            $a_optype_arr[4] = "checked";
            break;

    }


    $a_optval_str = ""; 

    if( $a_optype != "I"){ 

        $a_optval_arr = explode("__##__", $a_opvalue) ; 
        $a_optcnt = count($a_optval_arr);

        $a_ramdom_str = key_generateRandomString();

        for($pi =0 ; $pi < $a_optcnt; $pi++){            
            $a_optval_str .= "<div id=\"opt_field_".$a_ramdom_str."_id\" style=\"margin-top:12px;\" ><input type=\"text\" id=\"opt_value_".$a_ramdom_str."+id\" name=\"opt_value[]\" size=\"60\" value=\"".$a_optval_arr[$pi]."\" > <span class=\"label label-danger\" onclick=\"javascript:hplugin_product_gallery_opt_del('".$a_ramdom_str."');\" style=\"cursor:pointer\">X</span></div>";
        }


        if( $pi == 0 ){
            $a_optval_str = "div id=\"opt_field_00_id\" style=\"margin-top:12px;\" ><input type=\"text\" id=\"opt_value_00_id\" name=\"opt_value[]\" size=\"60\"> <span class=\"label label-danger\" onclick=\"javascript:hplugin_product_gallery_opt_del('00');\">X</span></div>";
        }
    } else {
        $a_optval_str = "<input type=\"text\" id=\"opt_value_id\" name=\"opt_value[]\" size=\"60\" disabled >"; 
    }


    $a_status_arr = array("","");
    switch( $a_status){
        case "Y" :
            $a_status_arr[0]="checked";
            break;
        case "N" :
            $a_status_arr[1]="checked";
            break; 
        default : 
            $a_status_arr[0]="checked";
            break;
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
            <li ><a href="/wp-admin/admin.php?page=hplugin-product-gallery-option-menu">옵션목록</a></li>
            <li class="active"><a href="/wp-admin/admin.php?page=hplugin-product-gallery-option-menu&show=option-input">신규옵션생성</a></li>           
        </ul>       
    </div>
                
    <div class="both_clear" style="height:30px;"></div>

    
    <form id="frm_in_id" name="frm_in" action="/wp-admin/admin.php?page=hplugin-product-gallery-option-menu&show=option-update" method="post" enctype="multipart/form-data">       
    <table class="table table-striped">    
         <tbody> 

            <tr>
                <td class="active">옵션명</td>
                <td><input type="text" id="opt_name_id" name="opt_name" value="<?php echo $a_opname;?>" size="60"></td>
            </tr>            

            <tr>
                <td class="active">옵션타입</td>
                <td>
                    <input type="radio"  name="opt_type" id="opt_type_id" value="I" <?php echo $a_optype_arr[0];?> onclick="javascript:hplugin_product_gallery_opttype('C');" >INPUT &nbsp;
                    <input type="radio"  name="opt_type" id="opt_type_id" value="R" <?php echo $a_optype_arr[1];?> onclick="javascript:hplugin_product_gallery_opttype('S');">RADIO &nbsp;
                    <input type="radio"  name="opt_type" id="opt_type_id" value="C" <?php echo $a_optype_arr[2];?> onclick="javascript:hplugin_product_gallery_opttype('S');">CHECKBOX &nbsp;
                    <input type="radio"  name="opt_type" id="opt_type_id" value="S" <?php echo $a_optype_arr[3];?> onclick="javascript:hplugin_product_gallery_opttype('S');">SELECT
                </td>
            </tr>                       

            <tr>
                <td class="active">옵션값 &nbsp; <span class="label label-warning" onclick="javascript:hplugin_product_gallery_opt_add();" style="cursor:pointer">필드추가</span></td>
                <td id="hplugin_product_gallery_opt_field_id"> 
                    <!--input type="text" id="opt_value_id" name="opt_value[]" size="60"-->
                    <?php echo $a_optval_str;?>
                </td>
            </tr>                       

          
            <tr>
                <td class="active">필수구분</td>
                <td>
                    <input type="radio" name="nessesary" value="Y" checked > <span class="label label-primary">필수필드</span>
                    <input type="radio" name="nessesary" value="N"> <span class="label label-success">비필필드</span>
                </td>
            </tr>          


            <tr>
                <td class="active">사용여부</td>
                <td>
                    <input type="radio" name="usage" value="Y"  <?php echo $a_status_arr[0];?> > <span class="label label-primary">사용</span>
                    <input type="radio" name="usage" value="N"  <?php echo $a_status_arr[1];?> > <span class="label label-warning">미사용</span>
                </td>
            </tr> 


          </tbody>               
           
    </table>

    <input type="hidden" name="cid" value="<?php echo $v_cid;?>">
    </form>   


    <div class="ht_room_admin_local_menu">        
    <span class="label label-primary htobbs_btn" onclick="javascript:hplugin_product_gallery_optionSave();" >업데이트</span>
    </div>
    
    <div class="both_clear" style="height:30px;"></div>
    
    
</div>

