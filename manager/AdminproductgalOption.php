<?php 
    // Creation Session to block duplpicate form seding  
    $_SESSION['hplugins_pgallery_session'] = date(U);    ;   

    global $wpdb ;

?>    
<script src="<?php print HPLUGIN_PRODUCT_GALLERY__PLUGIN_URL; ?>js/hplugin_product_gallery_admin.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?php print HPLUGIN_PRODUCT_GALLERY__PLUGIN_URL; ?>hplugin_product_gallery_admin.css" />
        
<div id="hplugin_admin_body" >

    <div class="hplugin_admin_local_menu">
        <ul class="nav nav-tabs" role="tablist">
            <li class="active"><a href="/wp-admin/admin.php?page=hplugin-product-gallery-option-menu">옵션목록</a></li>
            <li ><a href="/wp-admin/admin.php?page=hplugin-product-gallery-option-menu&show=option-input">신규옵션생성</a></li>           
        </ul>       
    </div>
                
    <div class="both_clear" style="height:30px;"></div>
                    

    <!-- Reserve List -->       
    <form name="frm_in" id="frm_in_id" action="/wp-admin/admin.php?page=hplugin-product-gallery-option-menu&show=option-sortupdate" method="post"> 
    <table class="table table-striped">
         <thead>
            <th ><strong>선택</strong></th>
            <th ><strong>옵션명</strong></th>
            <th ><strong>옵션타입</strong></th>             
            <th ><strong>옵션값</strong></th>
            <th ><strong>순서&nbsp;<span id="hplugin_product_gallery_sort_status" style="display:none" class="label label-danger">순서변경됨<span></strong></th>
            <th ><strong>검색적용</strong></th>
            <th ><strong>사용여부</strong></th>
            <th ><strong>기능</strong></th>
         </thead>       
         <tbody>
                        

<?php


    global $wpdb; 


    $cpage = $_GET['cpage'];
    //$v_ym = $_GET['ym'];
    
    
    // Get list count
    $sql_query = "SELECT count(no) FROM wp_hplugin_product_gallery_opt_set WHERE status in ('Y','N') " ;  

    $tot = $wpdb->get_var( $sql_query);
  
  
    // Initializing List 
    $max_rows = 100;
    $max_page = 10;

    $tot_page = ceil($tot/$max_rows);
    $tot_group = ceil($tot_page/$max_page);
    if($tot_page < 1)
        $tot_page = 1;
    if($tot_group < 1)
        $tot_group = 1;


    if(!$cpage || $cpage < 1)
        $cpage =1;
    if($cpage > 1 && $cpage > $tot_page)
        $cpage = $tot_page;

    $c_group = ceil($cpage/$max_page);

    if($c_group > 1) {
        $ppp = ($c_group - 1) * $max_page;
    //  $p_navi = "<a href=$PHP_SELF?cpage=$ppp class='c2'><img src=admin/image/previous_button.gif width=71 height=10></a>";
    }
    if($c_group < $tot_group) {
        $nnn = ($c_group) * $max_page + 1;
    //  $n_navi = "<a href=$PHP_SELF?cpage=$nnn class='c2'><img src=admin/image/next_button.gif width=48 height=10></a>";
    }

    $start_page = ($c_group -1)*$max_page +1;
    $end_page = $c_group * $max_page;
    if($end_page > $tot_page)
        $end_page = $tot_page;

    //paging
    $paging_str = "";
    for($i=$start_page; $i<=$end_page; $i++) {
        if($i == $cpage)
            $paging_str .= "<b>[".$i."]</b>";
        else
            $paging_str .= "<a class='c2' href=$PHP_SELF?cpage=$i>[".$i."]</a>";
    }

    $limit = ($cpage-1)*$max_rows;
  
    $sql_query = sprintf("SELECT no, name, value, iconurl, type, sort, status, reg_date, sgubun FROM wp_hplugin_product_gallery_opt_set  WHERE status in ('Y','N') ORDER BY sort asc, no desc  LIMIT %d, %d ",
                $limit,
                $max_rows) ;
                             
    $data_fd = $wpdb->get_results ($sql_query ) ;   
    

    $Cnt = 0 ;  
    
    // Data fetch
    foreach ( $data_fd as $data_arr ) { 


        if ( $data_arr->no  < 10 ){

            $a_cate_code = "0".$data_arr->no;
        } else {
            $a_cate_code = $data_arr->no;
        }
    
        $a_date_arr = explode(" ",$data_arr->reg_date ) ;


        $a_opt_type_str = "";

        switch( $data_arr->type){
            case "I" : 
                $a_opt_type_str = "<span>INPUT</span>";
                break;
            case "R" : 
                $a_opt_type_str = "<span>RADIO</span>";
                break;
            case "C" :
                $a_opt_type_str = "<span>CHECKBOX</span>";
                break;
            case "S" : 
                $a_opt_type_str = "<span>SELECT</span>";
                break;
            default  :
                $a_opt_type_str = "<span>INPUT</span>";
                break;
        }
        

        $a_value_str = "";

        if( $data_arr->type != "I") {
            $a_value_arr = explode("__##__",$data_arr->value);
        
            for( $vi =0; $vi < count($a_value_arr) ; $vi++){
                $a_value_str .= "<span class=\"label label-success\" style=\"margin:3px;\">".$a_value_arr[$vi]."</span>";
            }
        } 


        $v_status_str = "";
        $v_class_status = "";

        if( $data_arr->status == "N"  ){

            $v_status_str = "<span class=\"label label-warning\">미사용</span>";
            $v_class_status = "style=\"background-color:#FAAC58\"";
        }


        $a_search_apply = "<span style=\"color:orange\">미적용</span>";

        if( $data_arr->sgubun == "Y" && $data_arr->type != "I" ){ 
            $a_search_apply = "<span style=\"color:blue\" >적용</span>";
        } 


        print "

        <tr class=\"active\" id=\"optionval_".$Cnt."\" >
            <td $v_class_status><input type=\"checkbox\" name=\"selno[]\" value=\"".$data_arr->no."\"><input type=\"hidden\" name=\"optno[]\" value=\"".$data_arr->no."\"></td>
            <td $v_class_status><a href=\"/wp-admin/admin.php?page=hplugin-product-gallery-option-menu&show=option-view&cid=".$data_arr->no."\">".$data_arr->name."</a></td>            
            <td $v_class_status>".$a_opt_type_str."</td>
            <td $v_class_status>".$a_value_str."</td>
            <td $v_class_status><i class=\"glyphicon glyphicon-arrow-up\" style=\"cursor:pointer;color:red\" onclick=\"javascript:hplugin_product_gallery_opt_sort('U',".$Cnt.");\"></i> 
                <i class=\"glyphicon glyphicon-arrow-down\" style=\"cursor:pointer;color:blue\" onclick=\"javascript:hplugin_product_gallery_opt_sort('D',".$Cnt.");\" /></i>
                </td>
            <td $v_class_status>".$a_search_apply."</td> 
            <td $v_class_status>".$v_status_str."</td>    
            <td $v_class_status>
                <button type=\"button\" class=\"btn btn-xs btn-danger\" onclick=\"javascript:hplugin_product_gallery_optionDelete(".$data_arr->no.")\">삭제</button>
            </td>
        </tr>";
    
        

        $Cnt++;
    }
    

    // 결과값이 없을때 
    if( $tot == 0 ) {

        print "
        <tr class=\"warning\">
            <td colspan=\"7\"><center>생성된 옵션이 없습니다.</center></td>
        </tr>";        
        
    } 
    
?>

    </tbody>
    </table>
     
    
    <!-- page nav -->
    <!--div style="text-align:center;">
        <ul class="pagination" >
            

<?php

    $sP = $start_page;
    $eP = $end_page;
    
    $divSp = ($sP/$max_page) +1 ;
    
    if ( $divSp == 0 )
        $divSp = 1;
    
    $sP = $divSp * $max_page;
    
    if  ( $sP > $max_page ){
        print  "<li><a href='/wp-admin/admin.php?page=hplugin-product-gallery-cate-menu&cpage=".( ($sP-$max_page)-1 ) ."&stype=".$stype."&svalue=".$svalue."&roomnum=".$roomnum."' class=dir>&laquo</a></li>";
    } 
    
    
    for($sP = $start_page ; $sP<=$eP ; $sP++){
        if ( $sP == $cpage ){
            print "<li class=\"active\"><a href='/wp-admin/admin.php?cpage=".$sP."&stype=".$stype."&svalue=".$svalue."' class=dir>".$sP."</a></li>";

        } else {
            print "<li><a href='/wp-admin/admin.php?page=hplugin-product-gallery-cate-menu&cpage=".$sP."&stype=".$stype."&svalue=".$svalue."' class=dir>".$sP."</a></li>";

        }
    }
    
    if ( $eP < $tot_page ) {
        print "<li ><a href='/wp-admin/admin.php?page=hplugin-product-gallery-cate-menu&cpage=".$sP."&stype=".$stype."&svalue=". $svalue."' class=dir>&raquo</a></li>";

    } else {
        print "<li class=\"disabled\"><a href='/wp-admin/admin.php?page=hplugin-product-gallery-cate-menu&cpage=".$sP."&stype=".$stype."&svalue=". $svalue."' class=dir>&raquo</a></li>";
    }





        
?>  
        </ul>
        </div-->
       <!-- page nav -->
                <!-- Room List -->

    <div class="btn btn-lg btn-primary" onclick="javascript:hplugin_product_gallery_opt_sortUpdate();" style="cursor:pointer;">순서적용하기</div>

            <input type="hidden" name="cpage" id="frm_cpage" value="<?php print $cpage;?>">
            <input type="hidden" name="cid" id="frm_schedule_rid_no" value="">
            <input type="hidden" name="proc" id="frm_schedule_proc" value="">
            </form>


            
</div>                  