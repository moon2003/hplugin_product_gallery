<?php 

	global $wpdb; 


    require_once("Mobile_Detect.php");
    // check Mobile device
    $detect_obj = new Mobile_Detect();
	// GET Design Template file 
	$tpl_html = file_get_contents( HPLUGIN_PRODUCT_GALLERY__PLUGIN_DIR."hplugin_product_gallery_showcase.tpl" );

	// Split Loop design 
	/**
	// 추후적용 
	$first_pos = strpos($tpl_html, "<!--SHOWCASE LOOP-->");
	$tpl_html_first = substr( $tpl_html , 0 , $first_pos);

	$tpl_html_tmp = strpos($tpl_html, $first_pos + strlen("<!--SHOWCASE LOOP-->") ) ;

	$second_pos = strpos($tpl_html_tmp, "<!--SHOWCASE LOOP-->");
	$tpl_html_loop = substr( $tpl_html_tmp , 0 ,  $second_pos );
	$tpl_html_second = substr( $tpl_html_tmp ,  $second_pos + strlen("<!--SHOWCASE LOOP-->")  );
	**/
    

	//---- GET DATA 


	$sql_query = "SELECT a.no no , a.title title, a.subtitle subtitle, a.catecode catecode, a.price price, a.status status
	  FROM wp_hplugin_product_gallery a ,
	  wp_hplugin_product_gallery_showcase b 
	  	WHERE a.status='Y' AND a.no = b.c_no 
	  	ORDER by a.no desc ";
  							 
	$data_fd = $wpdb->get_results($sql_query ) ;
	

	$Cnt = 0 ;	
	$body_str = "";

	// Data fetch
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


		$a_cno 			=  $data_arr->no; 
		$a_subtitle 	=  $data_arr->subtitle; 
		$a_title 		=  $data_arr->title;
		$a_price 		=  $data_arr->price;

        $a_catecode     =  $data_arr->catecode ; 

		$a_subtitle_str = "";
		if ( $a_subtitle ){
			//$a_subtitle_str = "<div class=\"p_detail_1\">".$a_subtitle_str."</div>";
            $a_subtitle_str = $a_subtitle;
		}


		// $viewlink; 
		$a_linkurl = get_permalink();		
		if( strpos( $a_linkurl, "?") ){
			$a_linkurl .= "&";
		} else {
			$a_linkurl .= "?";
		}


        $a_link_page = "3325";
        if( $a_catecode == 2){                
            $a_link_page = "3327";
        }


		$a_linkurl .= "page_id=".$a_link_page."&mode=view&cid=".$a_cno;


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
  						$a_manufactor_logo .="<img src=\"http://www.fics.co.kr/wp-content/uploads/2017/08/logo_oki.png\" height=17 id=\"slick_img_icon\">";
  						break;
  					case "후지 제록스" : 
  						$a_manufactor_logo .="<img src=\"http://www.fics.co.kr/wp-content/uploads/2017/08/logo_fuji_zerox.png\" height=17 id=\"slick_img_icon\">";
  						break;
  					case "신도리코" : 
  						$a_manufactor_logo .="<img src=\"http://www.fics.co.kr/wp-content/uploads/2017/08/logo_shidoh.png\" height=17 id=\"slick_img_icon\">";
  						break;	
  					case "코니카 미놀타" : 
  						$a_manufactor_logo .="<img src=\"http://www.fics.co.kr/wp-content/uploads/2017/07/logo_konica_minolta.png\" height=17 id=\"slick_img_icon\">";
  						break;		
					case "삼성전자" : 
  						$a_manufactor_logo .="<img src=\"http://www.fics.co.kr/wp-content/uploads/2017/08/logo_samsung.png\" height=17 id=\"slick_img_icon\">";
  						break;		  						
  				}


  			}


  			// Option val 

  			if( $a_optname == "지원용지"){

  				switch($a_optvalue){

  					case "A4" : 
  						$a_paper_opt .="<img src=\"http://www.fics.co.kr/wp-content/uploads/2017/07/icon_a4.png\" height=35 id=\"slick_img_icon\"> ";
  						break;
  					case "A3" : 
  						$a_paper_opt .="<img src=\"http://www.fics.co.kr/wp-content/uploads/2017/07/icon_a3.png\" height=35 id=\"slick_img_icon\"> ";
  						break;
  				}

  			}   			
  			else if ( $a_optname == "출력색상"){


  				switch($a_optvalue){

  					case "칼라" : 
  						$a_color_opt .="<img src=\"http://www.fics.co.kr/wp-content/uploads/2017/07/icon_01.png\" height=35 id=\"slick_img_icon\"> ";
  						break;
  					case "흑백" : 
  						$a_color_opt .="<img src=\"http://www.fics.co.kr/wp-content/uploads/2017/07/icon_02.png\" height=35 id=\"slick_img_icon\"> ";
  						break;
  				}

  			}
  			else if ( $a_optname == "네트워크"){


  				switch($a_optvalue){

  					case "와이파이" : 
  						$a_network_opt .="<img src=\"http://www.fics.co.kr/wp-content/uploads/2017/07/icon_wifi.png\" height=35 id=\"slick_img_icon\"> ";
  						break;
  					case "네트워크" : 
  						$a_network_opt .="<img src=\"http://www.fics.co.kr/wp-content/uploads/2017/07/icon_network.png\" height=35 id=\"slick_img_icon\"> ";
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

         // if ( !$detect_obj->isMobile()  ){

		      $body_str_pc .="<div class=\"hgplugin_slide_col\">
          <ul class=\"hto_product_list\" id=\"hto_product_list_slider_item_id\">

              <li class=\"hto_product_item\" id=\"hto_product_list_slider_item_id\">
                <a href=\"".$a_linkurl."\">
                    <div class=\"p_image\"><img src=\"".$thumb_img_url."\" height=\"180\" id=\"slick_img\" /></div>
                    <div class=\"p_logo\">".$a_manufactor_logo."</div>
                    <div class=\"p_name p_name_home\">".$a_title."</div>
                    <div class=\"p_detail_1\">".$a_subtitle_str."</div>
                    <div class=\"p_price p_price_home\">월 ".number_format($a_price)."원</div>
                    <div class=\"p_icon\">".$a_option_icon_str."</div>
                </a>
              </li>
            </ul>
        </div>";

        //} else { 


          if( $Cnt < 4 ){
                $body_str_mobile .="
            
              <li class=\"hto_product_item\" >
                <a href=\"".$a_linkurl."\">
                    <div class=\"p_image\"><img src=\"".$thumb_img_url."\" height=\"180\" id=\"slick_img\" /></div>
                    <div class=\"p_logo\">".$a_manufactor_logo."</div>
                    <div class=\"p_name p_name_home\">".$a_title."</div>
                    <div class=\"p_detail_1\">".$a_subtitle_str."</div>
                    <div class=\"p_price p_price_home\">월 ".number_format($a_price)."원</div>
                    <div class=\"p_icon\">".$a_option_icon_str."</div>
                </a>
              </li>
            ";
          }
       // }



		$Cnt++;
	}
	



    // 결과값이 없을때 
    if( $Cnt == 0 ) {

        $body_str = "<div class=\"hplugin_product_gallery_no_list\">
                    등록된 게시물이 없습니다.
                </div>";
        
    } 



    //if ( !$detect_obj->isMobile()  ){
        $body_str_pc = "<div class=\"hplugin_main_slider\" id=\"hplugin_main_slider_id\" >".$body_str_pc."</div>";
        $body_str_mobile = "<div class=\"hto_product hplugin_main_mobile\" style=\"margin-bottom:0;margin-top:-20px;\"><ul class=\"hto_product_list\" >".$body_str_mobile."</ul></div>";
    //} 

    $hplugin_product_gallery_showcase_str = $body_str_pc.$body_str_mobile;



?>