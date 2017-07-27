<?php
	

	global $wpdb; 

	//if ( $a_admin_chk == "Y" ){
		$v_cid = $_GET["cid"];
	//}
	
	

  // Get Main Data
    $sql_query = sprintf( "SELECT no, r_no, title, subtitle, contents, contents2, catecode, price FROM wp_hplugin_product_gallery WHERE status='Y' AND no=%d", $v_cid );
    $gal_fd = $wpdb->get_results($sql_query);

    foreach( $gal_fd as $gal_data){

        $a_title = stripslashes($gal_data->title);
        $a_subtitle = stripslashes($gal_data->subtitle);
        $a_contents = stripslashes($gal_data->contents);
        $a_contents2 = stripslashes($gal_data->contents2);
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

  		}



		$hplugin_product_gallery_view_str = "


  		<div class=\"hto_content_box\">
            <h2 class=\"hto_content_title\">".$a_title."</h2>
            <div class=\"hto_content\">
                <div class=\"hto_product_detail\">
                    <ul class=\"hto_product_view\">
                        <li><img src=\"".$main_img_url."\" width=\"100%\"></li>
                        <li class=\"info_basic\">
                            <div><span class=\"info_basic_title\">기 본 료</span> 월 ".number_format($a_price)."원</div>
                            <div><span class=\"info_basic_title\">보 증 금</span> ".number_format($a_depot_price)."원 <span class=\"info_basic_etc\">(계약만료시 환급)</span></div>
                            <div><span class=\"info_basic_title\">약정기간</span> ".$a_contact_period."년 <span class=\"info_basic_etc\">(조정가능, 최소 1년)</span></div>
                            <div><span class=\"info_basic_title\">제 조 사</span> ".$a_manufactor_name."</div>
                            <div><span class=\"info_basic_title\">모 델 명</span> ".$a_model_name."</div>
                            <div><span class=\"info_basic_title info_basic_char\">특 장 점</span></div>
                            <div class=\"info_basic_char_detail\">".$a_special."</div>
                            <p> <a href=\"#\" class=\"avia-button  avia-icon_select-no-left-icon avia-color-theme-color avia-size-large avia-position-right \"><span class=\"avia_iconbox_title\">임대문의</span></a>
                        </li>

                        <!-- body -->

                        ".$a_contents."
                        ".$a_contents2."
                        
                        <!--li class=\"clear\"></li>
                        <li class=\"info_row2\">
                            <h3>안정적인 성능과 뛰어난 작업효율의 컬러 복합기</h3>
                            <div><img src=\"http://www.fics.co.kr/wp-content/uploads/2017/07/pd101.png\" width=\"100%\"></div>
                        </li>
                        <li class=\"info_row2\" id=\"detail\">
                            <div class=\"info_item_title\">
                                <div>코니카미놀타 bizhub C225</div>
                                <div class=\"on\"><a href=\"#detail\">상세정보</a></div>
                                <div class=\"off\"><a href=\"#specs\">제품사양</a></div>
                                </p>
                            </div>
                            <div class=\"clear\"></div>
                            <div>
                                <img src=\"http://www.fics.co.kr/wp-content/uploads/2017/07/pd1.png\" width=\"100%\"><img src=\"http://www.fics.co.kr/wp-content/uploads/2017/07/pd2.png\" width=\"100%\"><img src=\"http://www.fics.co.kr/wp-content/uploads/2017/07/pd3.png\" width=\"100%\"><img src=\"http://www.fics.co.kr/wp-content/uploads/2017/07/pd4.png\" width=\"100%\"><img src=\"http://www.fics.co.kr/wp-content/uploads/2017/07/pd5.png\" width=\"100%\"><img src=\"http://www.fics.co.kr/wp-content/uploads/2017/07/pd6.png\" width=\"100%\">
                            </div>
                        </li>
                        <li class=\"info_row3\" id=\"specs\">
                            <div class=\"info_item_title\">
                                <div>코니카미놀타 bizhub C225</div>
                                <div class=\"off\"><a href=\"#detail\">상세정보</a></div>
                                <div class=\"on\"><a href=\"#specs\">제품사양</a></div>
                                </p>
                            </div>
                            <div class=\"clear\"></div>
                            <div>
                                <img src=\"http://www.fics.co.kr/wp-content/uploads/2017/07/pd11.png\" width=\"100%\"><img src=\"http://www.fics.co.kr/wp-content/uploads/2017/07/pd12.png\" width=\"100%\"><img src=\"http://www.fics.co.kr/wp-content/uploads/2017/07/pd13.png\" width=\"100%\">
                            </div>
                        </li-->

                        <!-- body -->

                    </ul>
                </div>
                </p>
            </div>
        </div>


    	";


?>

