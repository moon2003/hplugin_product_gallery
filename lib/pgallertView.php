<?php
	

	global $wpdb; 

	//if ( $a_admin_chk == "Y" ){
		$v_cid = $_GET["cid"];
	//}
	

    // Get Referer 
    $a_ses_cpage = "";
    $a_ses_optval = "";

    $v_referer =  $_SERVER['HTTP_REFERER'];  
    $a_reftmp  = explode("?", $v_referer ) ; 

    if( count($a_reftmp) > 1 ) { 

        $a_reftmp2 = explode( "&" , $a_reftmp[1]);
      
        for($fi = 0 ; $fi < count($a_reftmp2) ; $fi++){

            $a_ref_arr = explode("=", $a_reftmp2[$fi]);

            switch($a_ref_arr[0]){

                case "cpage" :
                    $a_ses_cpage = $a_ref_arr[1];
                    break;
                case "optval" : 
                    $a_ses_optval = $a_ref_arr[1];
                    break;
                case "rid" : 

            }

        }
 
    }
	
    // Save Session 
    $_SESSION['hplugins_pgallery_cpage'] = $a_ses_cpage ; 
    $_SESSION['hplugins_pgallery_optval'] = $a_ses_optval ;


    


    // Get Main Data
    $sql_query = sprintf( "SELECT no, r_no, title, subtitle, contents, contents2, contents3, catecode, price FROM wp_hplugin_product_gallery WHERE status='Y' AND no=%d", $v_cid );
    $gal_fd = $wpdb->get_results($sql_query);

    foreach( $gal_fd as $gal_data){

        $a_title = stripslashes($gal_data->title);
        $a_subtitle = stripslashes($gal_data->subtitle);
        $a_contents = stripslashes($gal_data->contents);
        $a_contents2 = stripslashes($gal_data->contents2);
        $a_contents3 = stripslashes($gal_data->contents3);
        $a_catecode_arr = explode(",", $gal_data->catecode)  ; 
        $a_price = $gal_data->price;

    }




	// GET Image 

	$sql_query = "SELECT no, title, imgurl FROM wp_hplugin_product_gallery_img WHERE mark2='R' and c_no=".$v_cid;
	$timg_fd = $wpdb->get_results ($sql_query ) ;	

	$main_img_url = HPLUGIN_PRODUCT_GALLERY__PLUGIN_URL."images/hplugin_product_gallery_noimage.png";
	foreach( $timg_fd as $timg_arr) {
		$main_img_url =HPLUGIN_PRODUCT_GALLERY__CONTENT_URL.$timg_arr->imgurl;
	}





    // View Memeory Seesion 
    $a_cururl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    $_SESSION['hplugins_pgallery_view_cid'] = $v_cid ; 
    $_SESSION['hplugins_pgallery_view_url'] = $a_cururl ;
    $_SESSION['hplugins_pgallery_view_img'] = $main_img_url ;
    $_SESSION['hplugins_pgallery_view_title'] = $a_title ;



	// GET Option 
	//----- Get option value   [이부분으 바른렌탈에만 적용됨 ]

	$sql_query = "SELECT a.name name, a.value value
  					,b.name optname
					FROM 
  						wp_hplugin_product_gallery_opt a,
  						wp_hplugin_product_gallery_opt_set b
  
  					WHERE a.c_no=".$v_cid." AND b.no = a.name order by a.name asc ";

  	$opt_fd = $wpdb->get_results ($sql_query ) ;


  	$a_paper_opt = "";
  	$a_wifi_opt = "";
  	$a_network_opt = "";
  	$a_color_opt = "";

  	$a_print_speed = "";
  	$a_max_weight = "";

  	$a_manufactor_logo = "";
  	$a_manufactor_name = "";
  	$a_model_name = "";

  	$$a_special = "";

  	$a_depot_price = 0;

    $a_deliprice = "";


  		foreach($opt_fd as $opt_arr){

  			$a_optno 	= $opt_arr->name;
  			$a_optname 	= $opt_arr->optname ; 
  			$a_optvalue = $opt_arr->value ; 


  			// Logo Select 
  			if( $a_optname == "제조사"){

  				$a_manufactor_name = $a_optvalue;

  				switch($a_optvalue){

  					case "OKI" : 
  						$a_manufactor_logo .="<img src=\"http://www.fics.co.kr/wp-content/uploads/2017/07/logo_konica_minolta.png\" height=17>";  						
  						break;
  					case "후지 제록스" : 
  						$a_manufactor_logo .="<img src=\"http://www.fics.co.kr/wp-content/uploads/2017/07/logo_konica_minolta.png\" height=17>";
  						break;
  					case "신도리코" : 
  						$a_manufactor_logo .="<img src=\"http://www.fics.co.kr/wp-content/uploads/2017/07/logo_konica_minolta.png\" height=17>";
  						break;	
  					case "코니카 미놀타" : 
  						$a_manufactor_logo .="<img src=\"http://www.fics.co.kr/wp-content/uploads/2017/07/logo_konica_minolta.png\" height=17>";
  						break;		
					case "삼성전자" : 
  						$a_manufactor_logo .="<img src=\"http://www.fics.co.kr/wp-content/uploads/2017/07/logo_konica_minolta.png\" height=17>";
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

			else if ( $a_optname == "보증금"){
  				$a_depot_price = $a_optvalue;
  			}


			else if ( $a_optname == "약정기간"){
  				$a_contact_period = $a_optvalue;
  			}

			else if ( $a_optname == "모델명"){
  				$a_model_name = $a_optvalue;
  			}

			else if ( $a_optname == "특장점"){
  				$a_special = $a_optvalue;
  			}

            else if ( $a_optname == "기본매수"){
                $a_defaultprint = $a_optvalue;
            }
            else if ( $a_optname == "배송/설치비"){
                $a_deliprice = $a_optvalue;
                if( !$a_deliprice || $a_deliprice == "" ){
                    $a_deliprice = "무료";
                }
            }

  		}






		$hplugin_product_gallery_view_str = "<div class=\"hto_content_box\" style=\"padding:0 0 50px 0 ;\">
            <h2 class=\"hto_content_title\">".$a_title."</h2>            
            <div class=\"hto_content\">
                <div class=\"hto_product_detail\">
                    <ul class=\"hto_product_view\">
                        <li id=\"product_top\"><img src=\"".$main_img_url."\" width=\"100%\"></li>
                        <li id=\"product_detail\" class=\"info_basic\">
                            <div><span class=\"info_basic_title\">약정기간</span> ".$a_contact_period."년 <span class=\"info_basic_etc\">(조정가능, 최소 1년)</span></div>
                            <div><span class=\"info_basic_title\">보 증 금</span> ".number_format($a_depot_price)."원 <span class=\"info_basic_etc\">(계약만료시 환급)</span></div>
                            <div><span class=\"info_basic_title\">기본매수</span> <span class=\"info_basic_etc\">".$a_defaultprint."</span></div>                            
                            <div><span class=\"info_basic_title\">월 렌탈료</span> 월 ".number_format($a_price)."원</div>
                            <div><span class=\"info_basic_title\">배송/설치비</span> ".$a_deliprice."</div>                            

                            <div class=\"view_btn_set\">
                              <a href=\"/?page_id=3279\" class=\"avia-button  avia-icon_select-no-left-icon avia-color-theme-color avia-size-large \"><span class=\"avia_iconbox_title\">렌탈상담<br>신청</span></a>
                              <a href=\"/?page_id=3279\" class=\"avia-button  avia-icon_select-no-left-icon avia-color-theme-color avia-size-large \"><span class=\"avia_iconbox_title\">렌탈상담/신청 전화<br>02-715-1256</span></a>
                            </div>
                        </li>      


                        <li class=\"info_row1\" >
                            <div class=\"info_item_title\">
                                <div  id=\"h-info-7\" name=\"h-info-7\" >".$a_title."</div>
                                <div class=\"on\"><a href=\"#h-info-7\">상품안내</a></div>
                                <div class=\"off\"><a href=\"#detail\">상품설명</a></div>
                                <div class=\"off\"><a href=\"#specs\">상세사양</a></div>
                            </div>
                          <div class=\"clear\"></div>

                          <div><img src=\"/wp-content/uploads/2017/08/pd111.png\"></div>

                          <div>
                              ".$a_contents."                            
                          </div>
                        </li>

                        <li class=\"info_row1\">
                            <div><img src=\"/wp-content/uploads/2017/08/pd113.png\"></div>
                        </li>


                        <li class=\"info_row2\" id=\"detail\">
                            <div class=\"info_item_title\">
                                <div>".$a_title."</div>
                                <div class=\"off\"><a href=\"#h-info-7\">상품안내</a></div>
                                <div class=\"on\"><a href=\"#detail\">상품설명</a></div>
                                <div class=\"off\"><a href=\"#specs\">상세사양</a></div>
                            </div>
                            <div class=\"clear\"></div>
                            <div>
                            ".$a_contents2."
                            </div>
                        </li>
                        <li class=\"info_row3\" id=\"specs\">
                            <div class=\"info_item_title\">
                                <div>".$a_title."</div>
                                <div class=\"off\"><a href=\"#h-info-7\">상품안내</a></div>
                                <div class=\"off\"><a href=\"#detail\">상품설명</a></div>
                                <div class=\"on\"><a href=\"#specs\">상세사양</a></div>
                            </div>
                            <div class=\"clear\"></div>
                            <div>
                             ".$a_contents3."
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div><style> #content_page_title_id{display:none} ; </style>";


?>

