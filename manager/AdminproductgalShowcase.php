<?php 
    // Creation Session to block duplpicate form seding  
    $_SESSION['hplugins_pgallery_session'] = date(U);    ;   

    global $wpdb ;


    //Get setting Value 
    $a_product_gallert_set_arr = hplugin_product_gallery_getSetvalue();
    $a_viewurl = $a_product_gallert_set_arr['viewurl'];




?>    
<script src="<?php print HPLUGIN_PRODUCT_GALLERY__PLUGIN_URL; ?>js/hplugin_product_gallery_admin.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?php print HPLUGIN_PRODUCT_GALLERY__PLUGIN_URL; ?>hplugin_product_gallery_admin.css" />
        
<div id="hplugin_admin_body" >

    <div class="hplugin_admin_local_menu">
        <ul class="nav nav-tabs" role="tablist">
            <li class="active"><a href="/wp-admin/admin.php?page=hplugin-product-gallery-shpwcase-menu">진열목록</a></li>
            <!--li ><a href="/wp-admin/admin.php?page=hplugin-product-gallery-option-menu&show=option-input">신규옵션생성</a></li-->
        </ul>       
    </div>
                
    <div class="both_clear" style="height:30px;"></div>
                    

    <!-- Reserve List -->       
    <form name="frm_in" id="frm_in_id" action="/wp-admin/admin.php?page=hplugin-product-gallery-showcase-menu&show=showcase-sort" method="post"> 
    <table class="table table-striped">
         <thead>
            <th style="width:5%" ><strong>선택</strong></th>
            <th style="width:15%"><strong>이미지</strong></th>
            <th style="width:40%"><strong>제목/연결주소</strong></th>
            <th ><strong>순서&nbsp;<span id="hplugin_product_gallery_sort_status" style="display:none" class="label label-danger">순서변경됨<span></strong></th>            
            <th ><strong>기능</strong></th>
         </thead>       
         <tbody>
                        

<?php


    global $wpdb; 


    $cpage = $_GET['cpage'];
    //$v_ym = $_GET['ym'];
    
    
    // Get list count
    $sql_query = "SELECT count(no) FROM wp_hplugin_product_gallery_showcase WHERE status in ('Y','N') " ;  

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
  
    //$sql_query = sprintf("SELECT no, c_no, viewurl, sort, reg_date FROM wp_hplugin_product_gallery_showcase  WHERE status in ('Y','N') ORDER BY sort asc, no desc  LIMIT %d, %d ",
    //            $limit,
    //            $max_rows) ;

    $sql_query = "SELECT a.no no ,
                        a.c_no c_no, 
                        a.viewurl viewurl, 
                        a.sort sort,
                        b.title title 
                        FROM wp_hplugin_product_gallery_showcase a,
                            wp_hplugin_product_gallery b

                        WHERE b.no = a.c_no 
                            ORDER by a.sort asc 
    ";

                             
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


        $a_pageurl ="";
        //viewlink url 
        if( !$data_arr->viewurl || $data_arr->viewurl == "" ){
            $a_pageurl = $a_viewurl."&cid=".$data_arr->no;
        } else {
            $a_pageurl =$data_arr->viewurl;
        }

        // Get Show image 
        $sql_query = sprintf( "SELECT no , title, imgurl FROM wp_hplugin_product_gallery_img WHERE c_no=%d AND mark='T' ", $data_arr->c_no ) ;
        $img_fd = $wpdb->get_results ($sql_query ) ; 

        $thumbimg = HPLUGIN_PRODUCT_GALLERY__PLUGIN_URL."images/hplugin_product_gallery_noimage.png";
        foreach ($img_fd as $img_arr) {
            $thumbimg = HPLUGIN_PRODUCT_GALLERY__CONTENT_URL.$img_arr->imgurl;
        }

        print "

        <tr class=\"active\" id=\"showcase_".$Cnt."\" >
            <td $v_class_status><input type=\"checkbox\" name=\"selno[]\" value=\"".$data_arr->no."\"><input type=\"hidden\" name=\"cno[]\" value=\"".$data_arr->no."\"></td>
            <td $v_class_status><img src=\"".$thumbimg."\" class=\"hplugin_product_gallery_list_thumb\"></td>
            <td $v_class_status>
                <a href=\"/wp-admin/admin.php?page=hplugin-product-gallery-option-menu&show=option-view&cid=".$data_arr->no."\">".$data_arr->title."</a><br>
                <input type=\"text\" name=\"viewurl\" id=\"viewurl_".$Cnt."\" value=\"".$a_pageurl."\" style=\"width:500px;\">
            </td>                        
            <td $v_class_status><i class=\"glyphicon glyphicon-arrow-up\" style=\"cursor:pointer;color:red\" onclick=\"javascript:hplugin_product_gallery_showcase_sort('U',".$Cnt.");\"></i> 
                <i class=\"glyphicon glyphicon-arrow-down\" style=\"cursor:pointer;color:blue\" onclick=\"javascript:hplugin_product_gallery_showcase_sort('D',".$Cnt.");\" /></i>
            </td>            
            <td $v_class_status>
                <button type=\"button\" class=\"btn btn-xs btn-primary\" onclick=\"javascript:hplugin_product_gallery_showcase_update(".$data_arr->no." , ".$Cnt.");\">연결주소업데이트</button>&nbsp;
                <button type=\"button\" class=\"btn btn-xs btn-danger\" onclick=\"javascript:hplugin_product_gallery_showcase_del(".$data_arr->no.")\">삭제</button>
            </td>
        </tr>";
    
        

        $Cnt++;
    }
    

    // 결과값이 없을때 
    if( $tot == 0 ) {

        print "
        <tr class=\"warning\">
            <td colspan=\"5\"><center>진열 목록이 없습니다.</center></td>
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

            <div id="hplugin_product_gallery_showcase_sort_btn" class="btn btn-lg btn-primary" onclick="javascript:hplugin_product_gallery_opt_sortUpdate();" style="display:none;cursor:pointer;">순서적용하기</div>

            <input type="hidden" name="cpage" id="frm_cpage" value="<?php print $cpage;?>">
            <input type="hidden" name="cid" id="cid_id" value="">
            <input type="hidden" name="proc" id="frm_schedule_proc" value="">
            <input type="hidden" name="pageurl" id="pageurl_id" value="">

            </form>


            
</div>                  