<?php 

	global $wpdb; 

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

		$a_subtitle_str = "";
		if ( $a_subtitle ){
			$a_subtitle_str = "<div class=\"p_detail_1\">".$a_subtitle_str."</div>";
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


  		}


  		$a_option_icon_str = $a_color_opt.$a_paper_opt.$a_network_opt;


		$body_str .="

    	<div>
        	<ul class=\"hto_product_list\">
                <li class=\"hto_product_item\">
                    <a href=\"".$a_linkurl."\" class=\"p_item\"></p>
                        <div class=\"p_image\"><img src=\"".$thumb_img_url."\" height=180></div>
                        <div class=\"p_logo\">".$a_manufactor_logo."</div>
                        <div class=\"p_name\">".$a_title."</div>
                        <div class=\"p_icon\">
                            <!--img src=\"http://www.fics.co.kr/wp-content/uploads/2017/07/icon_01.png\" height=35> 
                            <img src=\"http://www.fics.co.kr/wp-content/uploads/2017/07/icon_02.png\" height=35> 
                            <img src=\"http://www.fics.co.kr/wp-content/uploads/2017/07/icon_a4.png\" height=35> 
                            <img src=\"http://www.fics.co.kr/wp-content/uploads/2017/07/icon_a3.png\" height=35> 
                            <img src=\"http://www.fics.co.kr/wp-content/uploads/2017/07/icon_wifi.png\" height=35> 
                            <img src=\"http://www.fics.co.kr/wp-content/uploads/2017/07/icon_network.png\" height=35-->
                            ".$a_option_icon_str."
                        </div>
                        ".$a_subtitle_str."
                        ".$a_print_speed."
                        ".$a_max_weight."
                        <div class=\"p_price\">월 ".number_format($a_price)."원</div>
                        <p>
                    </a>
                </li>
            </ul>
        </div>

		";



		$Cnt++;
	}
	



    // 결과값이 없을때 
    if( $Cnt == 0 ) {

        $body_str = "
                <div class=\"hplugin_product_gallery_no_list\">
                    등록된 게시물이 없습니다.
                </div>		";
        
    } 


    $hplugin_product_gallery_showcase_str = $body_str;



?>