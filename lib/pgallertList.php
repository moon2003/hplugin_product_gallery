<?php
	

	global $wpdb; 


	require_once("Mobile_Detect.php");
    // check Mobile device
    $detect_obj = new Mobile_Detect();

	$v_cpage = $_GET["cpage"];
	
	// 검색어 
	$v_skey = $_GET["skey"]	;
	$v_stype = $_GET["stype"];


	// 옵션사항 필드 
	$v_opt_str = base64_decode($_GET["optval"]); 


	$v_opt_arr = explode("_#_", $v_opt_str);

	$a_opt_cnt = count($v_opt_arr);

	$a_opt_name = array();
	$a_opt_val = array();
	




	$a_optstr_cnt = 0 ; 

	// 옵션검색 
	$a_option_str_init = "";
	$a_option_search_str = "";
	$a_option_search_table = "";
	$a_option_str = "";

	$a_prev_no = 0 ; 
	$a_same_field_cnt = 0 ; 
	
	$a_option_str_tmp = "";

	for($opi = 0 ;$opi < ($a_opt_cnt - 1) ; $opi++){

		

		$a_opt_field_arr = explode("^^", $v_opt_arr[$opi]);

		$a_opt_name[$opi] = $a_opt_field_arr[0];
		$a_opt_val[$opi] = base64_decode($a_opt_field_arr[1]) ;

		//$a_option_str .= " ( name='".$a_opt_name[$opi]."' AND  value='".mb_convert_encoding ($a_opt_val[$opi],'UTF-8' ,'auto') ."') ";		

		if ( !!$a_opt_name[$opi] && !!$a_opt_val[$opi] ){ 


			if( $a_optstr_cnt == 0 ){ 
				$a_option_str_init .= " AND b.c_no = a.no AND ( ";
			} else {

				if ( $a_prev_no == $a_opt_name[$opi]) { 
						$a_option_str_tmp .= " OR " ;    // [옵션이 AND 인지 OR 인지 추후 문의후 변경함 ] //
				} 
				// 같은 필드명 일때는  or 로 묶음 
				// 다른 필드명 일때는  and 로 처리 
			}
			


			// 검색 필드가 바뀔때 적용 
			//echo $a_prev_no ." / ". $a_opt_name[$opi] ."<br>";
			//echo $a_same_field_cnt ." : ".$a_option_str_tmp."<Br>";

			if( $a_prev_no != $a_opt_name[$opi] && $a_prev_no > 0   ) { 

				if( $a_same_field_cnt == 0 ){
					$a_option_str .= "( ".$a_option_str_tmp." )";

					//if( $opi < ($a_opt_cnt -1 ) ) {					
						$a_option_str_tmp = "";							
					//}

				} else  {
					$a_option_str .= " AND ( ".$a_option_str_tmp." )";
					$a_option_str_tmp = "";
				}
				
				$a_same_field_cnt++ ; 			  
			} 

			$a_option_str_tmp .= " ( b.name='".$a_opt_name[$opi]."' AND  b.value='".$a_opt_val[$opi]."') ";	
			$a_optstr_cnt++ ; 	

			$a_prev_no = (int)$a_opt_name[$opi] ; 

		}

	}

	//echo $a_same_field_cnt ." ###  ".$a_prev_no ."<br><Br>";

	if( $a_same_field_cnt == 0  && $a_prev_no > 0  )  {
		$a_option_str .= " ( ".$a_option_str_tmp." )";
	} else if( $a_same_field_cnt > 0) {
		$a_option_str .= " AND  ( ".$a_option_str_tmp." )";
	}


	if( $a_optstr_cnt > 0 ){
		
		$a_option_str .= " ) ";

		$a_option_search_table = ", wp_hplugin_product_gallery_opt b ";	
		$a_option_str = $a_option_str_init . $a_option_str ; 

	}

	//echo 	"<br>".$a_option_str ."<br/><br>";  
	


   	
   	$sql_query = "SELECT no, name, value, type, iconurl, sort, status FROM wp_hplugin_product_gallery_opt_set WHERE status='Y' and sgubun='Y' and type in ('R','C','S') ORDER by SORT asc";
    $opt_fd = $wpdb->get_results ($sql_query ) ;   

    $a_loop_search_cnt = 0; 

    $a_opt_search_nama_arr = array();
    $a_opt_search_val_arr = array();

    foreach ( $opt_fd as $opt_arr){



    	if ( $a_loop_search_cnt == 0  ){ 
    		$a_option_search_str .= "<div class=\"hplugin_product_gallery_optsearch_layer\">";



    	} 

        $a_option_search_str .= "	
        <div class=\"hplugin_product_gallery_optsearch_row\">
            <div class=\"hplugin_product_gallery_optsearch_col1\">
            	<span class=\"hplugin_product_gallery_optsearch_name\">".$opt_arr->name."</span>
            	<input type=\"hidden\" name=\"opt_info_".$a_loopcnt."\" value=\"".$opt_arr->no."\">
            </div>
            <div class=\"hplugin_priduct_gallery_optsearch_col2\">";

        


        $a_opt_val_arr = explode("__##__", $opt_arr->value);
        $optcnt = count($a_opt_val_arr);

		for($pi=0; $pi < $optcnt ; $pi++){

			$a_checked = "";

			//echo "<br> opt ". $a_opt_val_arr[$pi]."<br>";

			if( in_array($opt_arr->no, $a_opt_name) &&  in_array( $a_opt_val_arr[$pi] , $a_opt_val) ){
				$a_checked = "checked";
			}

			$a_option_search_str .= "<input type=\"checkbox\" name=\"opt_".$a_loop_search_cnt."[]\" value=\"".$opt_arr->no."^^".base64_encode($a_opt_val_arr[$pi])."\" ".$a_checked." > ".$a_opt_val_arr[$pi]."&nbsp;";


		}
         

        $a_option_search_str .= "</div></div>";
                
		$a_loop_search_cnt++;  



        /**        
        switch($opt_arr->type){

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

		**/

                
    }


    if( $a_loop_search_cnt  > 0 ){
    	 $a_option_search_str .= "
    	 <div class=\"hplugin_product_gallery_optsearch_row\">
    	 	<a href=\"#\" onclick=\"javascript:hplugin_product_gallery_nav(1);\" class=\"btn btn-primary\">검색하기</a>
    	 </div>
    	 </div>";
    	 
    }

    $a_option_search_str .= "<input type=\"hidden\" id=\"optcnt_id\" name=\"optcnt\" value=\"".$a_loop_search_cnt."\">";



	//echo $a_option_search_str ; 


	if( $a_catecode ) { 

    	$sql_query = sprintf("SELECT no, catename FROM wp_hplugin_product_gallery_cate WHERE no in ( %s )",
                $a_catecode);


    	$c_fd = $wpdb->get_results($sql_query);
    
    	$a_cate_str = "미지정";
    	$catCnt = 0 ; 
    
    	foreach($c_fd as $c_arr){
        	if ($catCnt == 0 ){    
            	$a_cate_str = $c_arr->cat_name ;
        	} else {                
            	$a_cate_str .= ",".$c_arr->cat_name ;
			}
    	}                
	


	}



 	//$a_boardWriteURL = $a_boardListURL; 
 	//$a_boardWriteParam = sprintf( "mode=write&rid=%d" , (int)$v_rid );
 	//$a_boardWriteParam_add =	encrypt_param( $a_boardWriteParam , $hto_blue_salt);

 	//$write_str = sprintf( "PostWrite('%s%shtobbsparam=%s');", $a_cur_protocol , $a_boardWriteURL, $a_boardWriteParam_add);

 	//$write_str = "PostWrite('1');";
	//$write_str = "PostWrite('".encrypt_param("rid=".$v_rid , $hto_blue_salt)."');";
	//$delete_str = "PostAllDelete();";

	//$a_post_all_select_str ="";

	//if ( $a_admin_chk == "Y") {
	//	$write_str = "hplugin_ebook_adminPostdWrite(".$v_rid.");";
	//	$delete_str ="hplugin_ebook_adminPostAllDelete();";

	//	$a_post_all_select_str = "<input type=\"checkbox\" name=\"postall\" id=\"postall_id\" onclick=\"javascript:postAllSelect();\">";
	//} 


	// Create Search Query 
	//$a_search_query	= hplugins_board_searchQuery($v_search_key, $v_search_type);


	// search type selected
	/**
	$a_search_type_arr = array("","","","");
	switch( $v_search_type ){
		case 'T' :
			$a_search_type_arr[1] = "selected";
			break;
		case 'C' :
			$a_search_type_arr[2] = "selected";
			break;
		case 'N' :
			$a_search_type_arr[3] = "selected";
			break;				
		default :
			$a_search_type_arr[0] = "selected";
			$v_search_key = "";
			break;				

	}
	**/


	// Category Linmit 
	$a_cate_query_str = "";
	if ( !!$v_rid  ){

		$a_cate_query_str = sprintf( " AND FIND_IN_SET( '%d' , a.catecode ) ", (int)$v_rid);
	}

	$sql_query = sprintf("SELECT count(a.no) ncnt FROM wp_hplugin_product_gallery a %s WHERE a.status in ('Y','D')  %s   %s  %s " ,			
			$a_option_search_table, 
			$a_search_query,
			$a_cate_query_str,
			$a_option_str );  
	

	//echo $sql_query; 

  	$nd_fd = $wpdb->get_results($sql_query) ; 
  	
  	$tot = 0 ; 
  	foreach ($nd_fd as $ndata){
  		$tot = $ndata->ncnt;
  	}
  	
  	//echo "tot : ".$tot; 


	$max_rows = $a_listrow_no; 
	$max_page = 10;

	$tot_page = ceil($tot/$max_rows);
	$tot_group = ceil($tot_page/$max_page);
	if($tot_page < 1)
		$tot_page = 1;
	if($tot_group < 1)
		$tot_group = 1;


	$cpage = $v_cpage ; 
	if(!$cpage || $cpage < 1)
		$cpage =1;
	if($cpage > 1 && $cpage > $tot_page)
		$cpage = $tot_page;

	$c_group = ceil($cpage/$max_page);

	if($c_group > 1) {
		$ppp = ($c_group - 1) * $max_page;
	//	$p_navi = "<a href=$PHP_SELF?cpage=$ppp class='c2'><img src=admin/image/previous_button.gif width=71 height=10></a>";
	}
	if($c_group < $tot_group) {
		$nnn = ($c_group) * $max_page + 1;
	//	$n_navi = "<a href=$PHP_SELF?cpage=$nnn class='c2'><img src=admin/image/next_button.gif width=48 height=10></a>";
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


  	/**
	$sql_query = sprintf("SELECT a.no no , a.m_no m_no, a.title title, a.cnt cnt,  a.userid userid, a.reg_date reg_date, a.status status,
				
				( SELECT count(c.no) FROM wp_hplugin_ebook_opt c WHERE c.m_no=a.no AND c.name='filename' ) attach_cnt 
				FROM wp_hplugin_ebook a 
				WHERE a.m_no=%d and a.status in ('Y','D') %s %s ORDER BY a.no DESC LIMIT %d, %d ",
				(int)$v_rid,
				$a_search_query,
				$a_cate_query_str,
				$limit,
				$max_rows) ;
	**/

	$sql_query = "SELECT a.no no , a.title title, a.subtitle subtitle, a.catecode catecode, a.price price, a.status status
	  FROM wp_hplugin_product_gallery a ".$a_option_search_table." WHERE a.status='Y' ".$a_search_query." ".$a_cate_query_str." ".$a_option_str." ORDER by a.no desc LIMIT ".$limit.", ".$max_rows;


	//echo $sql_query ; 	
  							 
	$data_fd = $wpdb->get_results($sql_query ) ;
	

	$Cnt = 0 ;	
	$body_str = "";

	// Data fetch


	$a_etype = "B";


	foreach ( $data_fd as $data_arr ) { 


		
		$a_date_arr = explode(" ",$data_arr->reg_date ) ;
		
		switch($a_etype ){
			case 'A':
				$a_btype_name ="타입A";
				break;
			case 'B':
				$a_btype_name ="타입B";
				break;
			default :
				$a_btype_name ="타입A";
				break;
				
		}




		// GET Image 

		$sql_query = "SELECT no, title, imgurl FROM wp_hplugin_product_gallery_img WHERE mark='T' and c_no=".$data_arr->no;
		$timg_fd = $wpdb->get_results ($sql_query ) ;	

		$thumb_img_url = HPLUGIN_PRODUCT_GALLERY__PLUGIN_URL."images/hplugin_product_gallery_noimage.png";
		foreach( $timg_fd as $timg_arr) {
			$thumb_img_url =HPLUGIN_PRODUCT_GALLERY__CONTENT_URL.$timg_arr->imgurl;
		}



		// Get ebook Data

		/**
		$attach_info_arr = hplugin_ebook_getattachinfo($v_rid, $a_bno);
		$a_thumb_img = str_replace( HPLUGIN_EBOOK__CONTENT_DIR, "",  $attach_info_arr['attach_thumbimg'] ) ;
		$a_pdf = str_replace( HPLUGIN_EBOOK__CONTENT_DIR, "", $attach_info_arr['attach_pdf'] );
		$a_ebook = str_replace( HPLUGIN_EBOOK__CONTENT_DIR , "", $attach_info_arr['attach_ebook'] );


		
		if ( !!$a_thumb_img ){ 
			$thumb_img_url = "<img src=\"".HPLUGIN_EBOOK__CONTENT_URL.$a_thumb_img."\" class=\"hplugin_ebook_list_thumbnail\" border=\"0\">";
		} 
		**/


		$a_cno 			=  $data_arr->no; 
		$a_subtitle 	=  $data_arr->subtitle; 
		$a_title 		=  $data_arr->title;
		$a_price 		=  $data_arr->price;

		$a_subtitle_str = "";
		if ( $a_subtitle ){
			$a_subtitle_str = "<div class=\"p_detail_1\">".$a_subtitle."</div>";
		}


		// $viewlink; 
		$a_linkurl = get_permalink();		
		if( strpos( $a_linkurl, "?") ){
			$a_linkurl .= "&";
		} else {
			$a_linkurl .= "?";
		}

		$a_linkurl .= "mode=view&cid=".$a_cno;


		//----- Get option value   [이부분으 바른렌탈에만 적용됨 ]

		$sql_query = "SELECT a.name name, a.value value
  					,b.name optname
					FROM 
  						wp_hplugin_product_gallery_opt a,
  						wp_hplugin_product_gallery_opt_set b
  
  					WHERE a.c_no=".$a_cno." AND b.no = a.name order by a.name asc ";

  		$opt_fd = $wpdb->get_results ($sql_query ) ;


  		$a_paper_opt = "";
  		$a_wifi_opt = "";
  		$a_network_opt = "";
  		$a_color_opt = "";

  		$a_print_speed = "";
  		$a_max_weight = "";

  		$a_manufactor_logo = "";




  		foreach($opt_fd as $opt_arr){

  			$a_optno 	= $opt_arr->name;
  			$a_optname 	= $opt_arr->optname ; 
  			$a_optvalue = $opt_arr->value ; 


  			// Logo Select 
  			if( $a_optname == "제조사"){

  				switch($a_optvalue){
  					case "OKI" : 
  						$a_manufactor_logo .="<img src=\"http://www.fics.co.kr/wp-content/uploads/2017/08/logo_oki.png\" height=17 >";
  						break;
  					case "후지 제록스" : 
  						$a_manufactor_logo .="<img src=\"http://www.fics.co.kr/wp-content/uploads/2017/08/logo_fuji_zerox.png\" height=17 >";
  						break;
  					case "신도리코" : 
  						$a_manufactor_logo .="<img src=\"http://www.fics.co.kr/wp-content/uploads/2017/08/logo_shidoh.png\" height=17 >";
  						break;	
  					case "코니카 미놀타" : 
  						$a_manufactor_logo .="<img src=\"http://www.fics.co.kr/wp-content/uploads/2017/07/logo_konica_minolta.png\" height=17 >";
  						break;		
					case "삼성전자" : 
  						$a_manufactor_logo .="<img src=\"http://www.fics.co.kr/wp-content/uploads/2017/08/logo_samsung.png\" height=17 >";
  						break;		  						
  				}


  			}


  			// Option val 

  			if( $a_optname == "지원용지"){

  				switch($a_optvalue){

  					case "A4" : 
  						$a_paper_opt .="<img src=\"http://www.fics.co.kr/wp-content/uploads/2017/07/icon_a4.png\" height=35> ";
  						break;
  					case "A3" : 
  						$a_paper_opt .="<img src=\"http://www.fics.co.kr/wp-content/uploads/2017/07/icon_a3.png\" height=35> ";
  						break;
  				}

  			}   			
  			else if ( $a_optname == "출력색상"){


  				switch($a_optvalue){

  					case "칼라" : 
  						$a_color_opt .="<img src=\"http://www.fics.co.kr/wp-content/uploads/2017/07/icon_01.png\" height=35> ";
  						break;
  					case "흑백" : 
  						$a_color_opt .="<img src=\"http://www.fics.co.kr/wp-content/uploads/2017/07/icon_02.png\" height=35> ";
  						break;
  				}

  			}
  			else if ( $a_optname == "네트워크"){


  				switch($a_optvalue){

  					case "와이파이" : 
  						$a_network_opt .="<img src=\"http://www.fics.co.kr/wp-content/uploads/2017/07/icon_wifi.png\" height=35> ";
  						break;
  					case "네트워크" : 
  						$a_network_opt .="<img src=\"http://www.fics.co.kr/wp-content/uploads/2017/07/icon_network.png\" height=35> ";
  						break;
  				}

  			}

  			// direct print
  			else if ( $a_optname == "인쇄속도"){

  				$a_print_speed = "<div class=\"p_detail_2\">인쇄속도(분당): ".$a_optvalue."</div>";  				

  			}

			else if ( $a_optname == "최대용지무게"){

  				$a_max_weight = "<div class=\"p_detail_3\">최대 지원 용지 무게: ".$a_optvalue."g/㎡</div>";

  			}


  		}


  		$a_option_icon_str = $a_color_opt.$a_paper_opt.$a_network_opt;



		switch ( $a_etype ) { 		// Board type gubun 


			case 'A' :		//----- Gallery  A Start

				// thumbnail image
				/** 
				$title_img_arr = hplugin_board_getTitleimg( $v_rid, $a_bno);



				//$body_str .= hplugin_board_galleryA_display( $data_arr , $title_img_arr, $a_admin_chk, $a_delete_checkbox , $a_view_url ) ; 						
				

				
				if ( $title_img_arr[0]['type'] == "F" ){ 
					$thumb_img_url = "<img src=\"".HTO_BBS__CONTENT_URL."upload/".$title_img_arr[0]['path']."/".$title_img_arr[0]['name']."\" width=\"245\" height=\"245\" border=\"0\">";
				} else if ($title_img_arr[0]['type'] == "M" ) {
					$thumb_img_url = "<iframe src=\"".$title_img_arr[0]['name']."\" width=\"245\" height=\"245\" border=\"0\" ></iframe>";
				

				} else {
					$thumb_img_url = "<img src=\"".HTO_BBS__PLUGIN_URL."images/hto_icon_galA_noimage.png\" width=\"245\" height=\"245\" border=\"0\">";						
				}


					
				if ( $a_admin_chk == "Y" ) {		// 관리자일때 삭제용 checkbox 
					$a_admincheckbox_str = "<div class=\"hplugin_ebook_list_layer_admincheckbox\">".$a_delete_checkbox."</div>"; 
				}



				$body_str .= "
				<div class=\"hplugin_ebook_list_layer\" >
					".$a_admincheckbox_str."
					<div class=\"hplugin_ebook_list_layer_timg\" >".$thumb_img_url."</div>
					<div class=\"hplugin_ebook_list_layer_spacer\"> </div>
					<div class=\"hplugin_ebook_list_layer_info\" >
						<div class=\"hplugin_ebook_list_layer_title\"><span id=\"htobbs_gal_list_span_title\">".$banner_file_number.stripcslashes($data_arr->title)."</span></div>
						<div class=\"hplugin_ebook_list_layer_writer\"><span id=\"htobbs_gal_list_span_writer\">".stripcslashes($data_arr->userid)."</span></div>
						<div class=\"hplugin_ebook_list_layer_subtitle\"><span id=\"htobbs_gal_list_span_subtitle\">".stripcslashes($data_arr->sub_title)."</span></div>
					</div>
				</div>
				<div class=\"hplugin_ebook_list_layer_detail\"><a href=\"".$a_view_url."\"><img src=\"".HTO_BBS__PLUGIN_URL."images/hto_icon_gal_view_btn.png\" border=\"0\"></a></div>
				<div class=\"hplugin_ebook_list_layer_rowspacer\"></div>				

				";
				
				**/
				break;

			case 'B' :			//----- Gallery  B Start


				/**
				$body_str .="
            <ul class=\"hto_product_list\" id=\"hto_product_list_slider_item_id\">
              <li class=\"hto_product_item\" id=\"hto_product_list_slider_item_id\">
                <a href=\"".$a_linkurl."\">
                    <div class=\"p_image\"><img src=\"".$thumb_img_url."\" height=\"180\" id=\"slick_img\" /></div>
                    <div class=\"p_logo\">".$a_manufactor_logo."</div>
                    <div class=\"p_name p_name_home\">".$a_title."</div>
                    <div class=\"p_detail_1\">".$a_subtitle."</div>
                    <div class=\"p_price p_price_home\">월 ".number_format($a_price)."원</div>
                    <div class=\"p_icon\">".$a_option_icon_str."</div>
                </a>
              </li>
            </ul>";
				**/
	



				$body_str .="
				<ul class=\"hto_product_list\" id=\"hto_product_list_slider_item_id\">
                <li class=\"hto_product_item\">
                    <a href=\"".$a_linkurl."\" class=\"p_item\"></p>
                        <div class=\"p_image\"><img src=\"".$thumb_img_url."\" height=180></div>
                        <div class=\"p_logo\">".$a_manufactor_logo."</div>
                        <div class=\"p_name\">".$a_title."</div>
                        ".$a_subtitle_str."
                        <div class=\"p_icon\">
                            ".$a_option_icon_str."
                        </div>
                        ".$a_print_speed."
                        ".$a_max_weight."
                        <div class=\"p_price\">월 ".number_format($a_price)."원</div>
                        <p>
                    </a>
                </li></ul>";





				break;

	
		
		}

		$Cnt++;
	}
	



    // 결과값이 없을때 
    if( $tot == 0 ) {


        $body_str = "
                <div class=\"hplugin_product_gallery_no_list\">
                    등록된 게시물이 없습니다.
                </div>
		";

        
    } 
    


    //------ Page Navigation  -----//

	$sP = $start_page;
	$eP = $end_page;
	
	$divSp = ($sP/$max_page) +1 ;
	
	if ( $divSp == 0 )
		$divSp = 1;
	
	$sP = $divSp * $max_page;
	
	$page_nav_str = "";


	//page infomation for gallery 
	$page_info_for_gal = "Page ".$cpage." of ".  $tot_page  ;



	if  ( $sP > $max_page ){

		$a_boardListParam_str =$a_boardListParam."&cpage".( ($sP-$max_page)-1 ) .$a_search_str;
		if ($a_admin_chk != "Y") $a_boardListParam_str = "htobbsparam=".encrypt_param($a_boardListParam_str , $hto_blue_salt); 

		//$page_nav_str .=  "<li><a href='".$a_boardListURL.$a_boardListParam."&cpage".( ($sP-$max_page)-1 ) ."&stype=".$stype."&svalue=".$svalue."' class=dir>&laquo</a></li>";
		//$page_nav_str .=  "<li class=\"hplugin_ebook_pagenav_prev\"><a href='".$a_boardListURL.$a_boardListParam_str."#hplugin_ebook_outlayer_id' class=dir>&laquo</a></li>";
		//$page_nav_str .=  "<a class=\"pre\" href=\"".$a_boardListURL.$a_boardListParam_str."#htobbs_outlayer_id\"><img width=\"56\" height=\"27\" alt=\"이전\" src=\"http://static.naver.com/common/paginate/btn_page_prev.gif\"></a> ";
		$page_nav_str .=  "<a class=\"pre\" href=\"#\" onclick=\"javascript:hplugin_product_gallery_nav('".(($sP-$max_page)-1)."');\"><img width=\"56\" height=\"27\" alt=\"이전\" src=\"http://static.naver.com/common/paginate/btn_page_prev.gif\"></a> ";

	} 
	
    
	for($sP = $start_page ; $sP<=$eP ; $sP++){

		$a_boardListParam_str = $a_boardListParam."&cpage=".$sP.$a_search_str ;
		if ($a_admin_chk != "Y") $a_boardListParam_str = "htobbsparam=".encrypt_param($a_boardListParam_str , $hto_blue_salt); 

		if ( $sP == $cpage ){

			//$page_nav_str .= "<li class=\"active\"><a href='".$a_boardListURL.$a_boardListParam."&cpage=".$sP."&stype=".$stype."&svalue=".$svalue."' class=dir>".$sP."</a></li>";
			//$page_nav_str .= "<li class=\"active hplugin_ebook_pagenav_num_active\" ><a href='".$a_boardListURL.$a_boardListParam_str."#hplugin_ebook_outlayer_id' class=dir>".$sP."</a></li>";
			$page_nav_str .="<strong><span>".$sP."</span></strong>";

		} else {
			//$page_nav_str .= "<li><a href='".$a_boardListURL.$a_boardListParam."&cpage=".$sP."&stype=".$stype."&svalue=".$svalue."' class=dir>".$sP."</a></li>";
			//$page_nav_str .= "<li class=\"hplugin_ebook_pagenav_num\"><a href='".$a_boardListURL.$a_boardListParam_str."#hplugin_ebook_outlayer_id' class=dir>".$sP."</a></li>";
			//$page_nav_str .="<a href=\"".$a_boardListURL.$a_boardListParam_str."#htobbs_outlayer_id\"><span>".$sP."</span></a>";			
			$page_nav_str .="<a href=\"#\" onclick=\"javascript:hplugin_product_gallery_nav('".$sP."');\"><span>".$sP."</span></a>";			

		}
	}
	
	if ( $eP < $tot_page ) {
		$a_boardListParam_str = $a_boardListParam."&cpage=".$sP.$a_search_str;
		if ($a_admin_chk != "Y") $a_boardListParam_str = "htobbsparam=".encrypt_param($a_boardListParam_str , $hto_blue_salt); 

		//$page_nav_str .= "<li ><a href='".$a_boardListURL.$a_boardListParam_str."&cpage=".$sP."&stype=".$stype."&svalue=". $svalue."' class=dir>&raquo</a></li>";
		//$page_nav_str .= "<li class=\"hplugin_ebook_pagenav_next_active\"><a href='".$a_boardListURL.$a_boardListParam_str."&cpage=".$sP."&stype=".$stype."&svalue=". $svalue."#hplugin_ebook_outlayer_id' class=dir>&raquo</a></li>";
		//$page_nav_str .= "<a class=\"next\" href=\"".$a_boardListURL.$a_boardListParam_str."&cpage=".$sP."&stype=".$stype."&svalue=". $svalue."#htobbs_outlayer_id\"><img width=\"57\" height=\"27\" alt=\"다음\" src=\"http://static.naver.com/common/paginate/btn_page_next.gif\"></a>";
		$page_nav_str .= "<a class=\"next\" href=\"#\" onclick=\"javascript:hplugin_product_gallery_nav('".($sP+1)."');\"><img width=\"57\" height=\"27\" alt=\"다음\" src=\"http://static.naver.com/common/paginate/btn_page_next.gif\"></a>";

	} else {
		$a_boardListParam_str = $a_boardListParam."&cpage=".$sP.$a_search_str;
		if ($a_admin_chk != "Y") $a_boardListParam_str = "htobbsparam=".encrypt_param($a_boardListParam_str , $hto_blue_salt); 
		
	   // $page_nav_str .= "<li class=\"disabled\"><a href='".$a_boardListURL.$a_boardListParam."&cpage=".$sP."&stype=".$stype."&svalue=". $svalue."' class=dir>&raquo</a></li>";
		 //$page_nav_str .= "<li class=\"disabled hplugin_ebook_pagenav_next\" ><a href='".$a_boardListURL.$a_boardListParam_str."#hplugin_ebook_outlayer_id' class=dir>&raquo</a></li>";
		$page_nav_str .= "<a class=\"next\" href=\"#\"><img width=\"57\" height=\"27\" alt=\"다음\" src=\"http://static.naver.com/common/paginate/btn_page_next.gif\"></a>";
	}


	//------ Page Navigation  -----//

	switch ($a_etype ) {
		
		case 'A' :		//----- Gallery A 

			/**
			// Button create acorrding to Level 
			$board_btn_str = "";
			if ( $a_user_level >= $a_blevel) {
				if ( is_admin() ){

				$board_btn_str = "
			<div id=\"hplugin_ebook_control_btn\" class=\"col-md-4\" style=\"text-align:right\">
				<button type=\"button\" class=\"btn btn-sm btn-danger\" onclick=\"javascript:".$delete_str."\">삭제하기</button>
				<button type=\"button\" class=\"btn btn-sm btn-primary\" onclick=\"javascript:".$write_str."\">글쓰기</button>	
			</div>				
				";

				}	
			}



			$hto_list_str = "
<div id=\"hplugin_ebook_outlayer_id\">
	<div class=\"hplugin_ebook_layer\">
	<form name=\"htobbs_frm\" id=\"htobbs_frm\" method=\"post\">		
		<div class=\"hplugin_ebeook_body_layer\">".$body_str."</div>


		<div id=\"hplugin_ebook_split_line\"></div>
		<div id=\"hplugin_ebook_split_line_spacer\"></div>

		<!-- Page nav -->
		<div>
		<div id=\"hplugin_ebook_page_nav_pre\"></div>
		<div id=\"hplugin_ebook_page_nav\">
			<ul class=\"pagination\" >
			<li class=\"hplugin_ebook_pagenav_info\">".$page_info_for_gal."</li>		
			".$page_nav_str."
			</ul>
		</div>
		</div>
		<!-- Page nav -->

		<div style=\"clear:both\"></div>
		<!-- Search nav -->
		<div class=\"row\" id=\"search_layer_id\">
			<div class=\"col-md-8\">
			".$a_search_btn."
			</div>
			".$board_btn_str."
		</div>	
		<!-- Search nav -->
	<input type=\"hidden\" name=\"rid\" value=\"".$v_rid."\">
	<input type=\"hidden\" name=\"pmode\" id=\"pmode_id\" value=\"\">

	</form>
	</div>
</div>	

<script>
	jQuery('selectpicker').selectpicker({
		style : 'btn-info',
		size : 8

	});
</script>
				";

			**/
			break;



		case 'B' :		//----- Gallery B 


			// Button create acorrding to Level 
			$board_btn_str = "";
			if ( is_admin() ){

				$board_btn_str = "
			<div id=\"hplugin_ebook_control_btn\" class=\"col-md-4\" style=\"text-align:right\">
				<button type=\"button\" class=\"btn btn-sm btn-danger\" onclick=\"javascript:".$delete_str."\">삭제하기</button>
				<button type=\"button\" class=\"btn btn-sm btn-primary\" onclick=\"javascript:".$write_str."\">글쓰기</button>	
			</div>
				";
			}


			// 검색 메뉴 표시여부 
			if ( $a_searchchk == "Y" ){

				$a_search_btn = "
	<select class=\"selectpicker\" name=\"stype\"  id=\"search_type_id\">
		<option value=\"\" ".$a_search_type_arr[0].">---검색조건---</option>
		<option value=\"T\" ".$a_search_type_arr[1].">제목</option>
		<option value=\"C\" ".$a_search_type_arr[2].">본문</option>		
		<option value=\"N\" ".$a_search_type_arr[3].">이름</option>
	</select>
	<input type=\"text\" name=\"skey\" size=\"20\" id=\"search_type_key\" value=\"".$v_search_key."\"> 
	<button type=\"button\" class=\"btn  btn-xs btn-primary\" onclick=\"javascript:hplugins_bbs_search();\" >검색</button>
				";

			}


			// Return Page 
			$hplugin_product_gallery_list_str = "<form name=\"hpgfrm\" id=\"hpgfrm_id\" method=\"get\"  >
    <div class=\"hto_content\">
        <div class=\"hto_product\">
            <ul class=\"hto_product_list\" >
                ".$body_str."                
                <!-- Loop //-->
            </ul>
            <div class=\"clear\"></div>           
             <!-- UI Object -->            
            <div class=\"paginate\">
				".$page_nav_str."
            </div>            
             <!-- //UI Object -->    

           	<!-- Option search layer -->
            	".$a_option_search_str."
            <!-- Option search layer -->
        </div>        
    </div>
    <input type=\"hidden\" name=\"pageurl\" value=\"".get_permalink()."\" id=\"pageurl_id\" >
    </form>";


			break;


	
	}

?>

