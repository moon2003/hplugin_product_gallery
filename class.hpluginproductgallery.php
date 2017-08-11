<?php

	require_once(HPLUGIN_PRODUCT_GALLERY__PLUGIN_DIR.'lib/functions.php');


	//----- Add Admin Menu -----//
	add_action('init','hplugin_product_gallery_header_add');
	add_action( 'admin_menu','hplugin_product_gallery_menu_initp' );

	//----- Filter Page's Short Code -----//
	add_filter('the_content','hplugin_product_gallery_ui');

	//----- Script Add -----//
	add_action('wp_footer','hplugin_product_gallery_script_add');




	//--- User Function Start --//
	function hplugin_product_gallery_ui($text){

        $v_step = $_GET["step"];

        $contents_str = "";


		$shortCnt = strpos($text, "[HPLUGIN-PRODUCT-GALLERY=") ;
		$shortCntE = strpos($text, "]" ,  $shortCnt );


        if ( $shortCnt > 0 ) {
        	
        	$v_board_var = substr($text, $shortCnt + strlen("[HPLUGIN-PRODUCT-GALLERY=") , $shortCntE -  ($shortCnt +  strlen("[HPLUGIN-PRODUCT-GALLERY=") ) ); 


        	$v_board_var_arr =explode("&#038;", $v_board_var);
        	$v_rid = $v_board_var_arr[0];


        	$v_cat = "";
        	if( count($v_board_var_arr) > 1 )  {

        		$v_board_cat_arr = explode("=",$v_board_var_arr[1] );  	
        		$v_cat = $v_board_cat_arr[1]; 

        		//$cat_str = "&#038;CAT=".$v_cat;
        		$cat_str = "&#038;CAT=".$v_cat;
        	}                       
        	

       		switch( $v_step){

            	case 'save':                         
                	//require('hpluginebookProc.php');
                	//break;
            	default :            		
           			require('hpluginproductgallerybase.php');           		
                	break;

        	}

        	$text =  str_replace("[HPLUGIN-PRODUCT-GALLERY=".$v_rid.$cat_str."]",$contents_str, $text)  ;
 

		} else { 


        	// 메인진열대 or  기본게시판  연결
        	$showcasetCnt = strpos($text, "[HPLUGIN-PRODUCT-GALLERY-SHOWCASE]") ;
        	
        	if( $showcasetCnt > 0 ){
        		require('hpluginproductgalleryshowcase.php'); 
				$text = str_replace( "<p>","", str_replace("</p>","", str_replace("[HPLUGIN-PRODUCT-GALLERY-SHOWCASE]",trim($contents_str), $text) ) ) ;
        	} else {
           		require('hpluginproductgallerybase.php'); 
        		$text = str_replace("[HPLUGIN-PRODUCT-GALLERY]",$contents_str, $text) ;
        	}

		}


        return $text;
	}

	//--- User Function End--//

	function hplugin_product_gallery_menu_initp(){	

		$icon = HPLUGIN_PRODUCT_GALLERY__PLUGIN_URL . "images/hplugin_product_gallery_icon.png";
		
		add_menu_page('H-plugin-product-gallery', 'H-Product-Gallery', 'manage_options', 'hplugin_product_gallery', 'hplugin_product_gallery_plugiun_optionsp', $icon) ;

		add_submenu_page( 'hplugin_product_gallery','Gallery Manager', 'Gallery Manager', 'manage_options', 'hplugin-product-gallery-menu','hplugin_product_gallery_optionsp')  ; 
		add_submenu_page( 'hplugin_product_gallery','Showcase Manager', 'Showcase Manager', 'manage_options', 'hplugin-product-gallery-showcase-menu','hplugin_product_gallery_showcasesp')  ; 
		add_submenu_page( 'hplugin_product_gallery','Option Set', 'Option Set', 'manage_options', 'hplugin-product-gallery-option-menu','hplugin_product_gallery_option_optionsp')  ;
		add_submenu_page( 'hplugin_product_gallery','Category', 'Category', 'manage_options', 'hplugin-product-gallery-cate-menu','hplugin_product_gallery_cate_optionsp')  ;
	  	add_submenu_page( 'hplugin_product_gallery','Setting', 'Setting', 'manage_options', 'hplugin-product-gallery-setting-menu','hplugin_product_gallery_setting_optionsp')  ;
	  		
		add_options_page( 'hplugin_product_gallery','Gallery Manager', 'Gallery Manager', 'manage_options', 'hplugin-product-gallery-menu','hplugin_product_gallery_optionsp')  ; 
		add_options_page( 'hplugin_product_gallery','Showcase Manager', 'Showcase Manager', 'manage_options', 'hplugin-product-gallery-showcase-menu','hplugin_product_gallery_showcasesp')  ; 
		add_options_page( 'hplugin_product_gallery','Option Set', 'Option Set', 'manage_options', 'hplugin-product-gallery-option-menu','hplugin_product_gallery_option_optionsp')  ; 	  
		add_options_page( 'hplugin_product_gallery','Category', 'Category', 'manage_options', 'hplugin-product-gallery-cate-menu','hplugin_product_gallery_cate_optionsp')  ; 	  
	  	add_options_page( 'hplugin_product_gallery','Setting', 'Setting', 'manage_options', 'hplugin-product-gallery-setting-menu','hplugin_product_gallery_setting_optionsp')  ; 	  
	}


	//--- Script Add ---//

	function hplugin_product_gallery_script_add(){

		$script_str = "
		<link rel=\"stylesheet\" type=\"text/css\" href=\"".HPLUGIN_PRODUCT_GALLERY__PLUGIN_URL."hplugin_product_gallery_user.css\" />
		<script src=\"".HPLUGIN_PRODUCT_GALLERY__PLUGIN_URL."js/hplugin_product_gallery.js\"></script>
		";

		print $script_str ;
	}



	function hplugin_product_gallery_header_add(){

		if ( !session_id() ){
			session_start();					// For CAPTCHA
		}
		session_set_cookie_params( 0,'/' ,'.'.$_SERVER['HTTP_HOST']);		// For SSL domain session.
	}



	function hplugin_product_gallery_setting_optionsp(){

?>
<div <?php body_class(); ?>  id="hplugin_admin_content_body" > 

 <h2>H-Product-gallery Plugin Settings</h2>
 <p>플러그인의 기본 환경을 설정합니다.  </p>

<?php
	if ($_GET['show']=="set") {			
 			require('manager/AdminproductgalSet.php'); 		 			 	
 	} else if ($_GET['show']=="set-update") {
 			require('manager/AdminproductgalSetProc.php'); 		 			 	
 	} else { 		
 			require('manager/AdminproductgalSet.php'); 		 			 	
 	}
 	
?> 
 </div>


<?php

	}	


	function hplugin_product_gallery_cate_optionsp(){

?>
<div <?php body_class(); ?>  id="hplugin_admin_content_body" > 

 <h2>H-Product-gallery 카테고리 설정</h2>
 <p>카케고리를 설정추가/수정/삭제 합니다.  </p>

<?php
	if ($_GET['show']=="set") {			
 			require('manager/AdminproductgalCate.php'); 		 			 	
 	} else if ($_GET['show']=="cate-update" || $_GET['show']=="cate-save" || $_GET['show']=="cate-delete"  ) {
 			require('manager/AdminproductgalCateProc.php'); 		 			 	
	} else if ($_GET['show']=="cate-input") {
 			require('manager/AdminproductgalCateInput.php'); 		 			 	 			
	} else if ($_GET['show']=="cate-view") {
 			require('manager/AdminproductgalCateView.php'); 		 			 	 			
 	} else { 		
 			require('manager/AdminproductgalCate.php'); 		 			 	
 	}
 	
?> 
 </div>



<?php

	}	


	function hplugin_product_gallery_showcasesp(){

?>
<div <?php body_class(); ?>  id="hplugin_admin_content_body" > 

 <h2>H-Product-gallery 진열목록 설정</h2>
 <p>사이트 메인 페이지에 나오는 목록을 수정/삭제 합니다.  </p>

<?php
	if ($_GET['show']=="showcase-sort") {			
 			require('manager/AdminproductgalShowcaseProc.php'); 
 	} else if ($_GET['show']=="showcase-update") {			
 			require('manager/AdminproductgalShowcaseProc.php'); 
	} else if ($_GET['show']=="showcase-delete") {			
 			require('manager/AdminproductgalShowcaseProc.php'); 
	} else if ($_GET['show']=="cate-view") {
 			require('manager/AdminproductgalCateView.php'); 		 			 	 			
 	} else { 		
 			require('manager/AdminproductgalShowcase.php'); 		 			 	
 	}
 	
?> 
 </div>



<?php

	}	








	function hplugin_product_gallery_option_optionsp(){

?>
<div <?php body_class(); ?>  id="hplugin_admin_content_body" > 

 <h2>H-Product-gallery 옵션필드 설정</h2>
 <p>옵션필드를 설정추가/수정/삭제 합니다.  </p>

<?php
	if ($_GET['show']=="set") {			
 			require('manager/AdminproductgalOption.php'); 		 			 	
 	} else if ($_GET['show']=="option-update" || $_GET['show']=="option-save" || $_GET['show']=="option-delete"  || $_GET['show']=="option-sortupdate" ) {
 			require('manager/AdminproductgalOptionProc.php'); 		 			 	
	} else if ($_GET['show']=="option-input") {
 			require('manager/AdminproductgalOptionInput.php'); 		 			 	 			
	} else if ($_GET['show']=="option-view") {
 			require('manager/AdminproductgalOptionView.php'); 		 			 	 			
 	} else {
 			require('manager/AdminproductgalOption.php'); 		 			 	
 	}
 	
?> 
 </div>


<?php

	}	





	function hplugin_product_gallery_plugiun_optionsp(){
?>
 <link rel="stylesheet" type="text/css" href="<?php print HPLUGIN_PRODUCT_GALLERY__PLUGIN_URL; ?>hplugin_product_gallery_admin.css" />
 <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
 <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
 <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
 <div <?php body_class(); ?>  id="hplugin_admin_content_body" > 
 	
 	<h2>About H-Product Gallery Plugin </h2>
    <div class="panel panel-primary hplugin_plugin_info">  
	<p>
	<br>
	워드프레스용 제품소개형식 갤러리 플러그인입니다.<br>	<Br>
	<br>    
   	<br>
 	본 플러그인은 (주)에이치티오에서 개발하였습니다.<br> 
 	프로그램에 대한 문의사항에 대해서는 아래 연락처로 문의 바랍니다.<br>
 	이메일 : moon2003@thehto.com / 전화 : 02-6925-5544  <br>
	<br>
 	플러그인을 이용해주셔서 감사합니다.<br>
 	<br>
 	<i>2017. 7. 13.   Chang Moon / System Engineer. HTO Co., Ltd.</i><br>
 	<i><a href="http://www.thehto.com" target="_blank"</a>http://www.thehto.com</a></i>
 	<br><br>
 	</p>
	</div>

	<br>

	<div class="panel panel-warning hplugin_plugin_useinfo">
		<div class="panel-heading"> 
		<b>플러그인 사용법</b>
		</div>
		<div class="panel-body hplugin_plugin_info" id="hplugin_plugin_useinfo_body">

  		 아래 문자와 같은 Shortcode를 복사하여 페이지, 포스트에 넣으시면 사용하실수 있습니다. <br><br>
 		- 갤러리 연결 &nbsp;&nbsp;<b>[HPLUGIN-PRODUCT-GALLERY]</b> <br> 
 		- 갤러리 카테고리지정 연결 &nbsp;&nbsp;<b>[HPLUGIN-PRODUCT-GALLERY=CATECODE]</b> <br> 
 		- 메인진열대 연결 &nbsp;&nbsp;<b>[HPLUGIN-PRODUCT-GALLERY-SHOWCASE]</b> <br> 
		<br>
 		- User Design CSS file &nbsp;&nbsp;<b>[PLUGIN DIRECTORY]/hplugin_product_gallery_user.css </b><br>
 		- Showcase Design file &nbsp;&nbsp;<b>[PLUGIN DIRECTORY]/hplugin_product_gallery_showcase.tpl </b>
 		<br>
 		</div>
	</div>

	<br>


 </div>		
<?php		
		
	}	


	function hplugin_product_gallery_optionsp(){
?>
<link rel="stylesheet" type="text/css" href="<?php print HPLUGIN_PRODUCT_GALLERY__PLUGIN_URL; ?>hplugin_product_gallery_admin.css" />
 <div <?php body_class(); ?>  id="hplugin_admin_content_body" > 
 <h2>H-Product Gallery 관리</h2>
 <p>게시물을 등록/수정/삭제 관리하는 메뉴입니다.</p><br>
 <?php 
 
	if ($_GET['show']=="board-input") {	// 글쓰기 [관리자]
 			require('manager/AdminproductgalBoardInput.php');  			
 	} else if ($_GET['show']=="board-save" ) {		// 게시판 글 저장 [관리자]
 			require('manager/AdminproductgalBoardProc.php'); 			
 	} else if ($_GET['show']=="board-view") { 	// 게시판 글보기  [관리자]
 			require('manager/AdminproductgalBoardView.php');  		
 	} else if ($_GET['show']=="board-delete") {	// 게시판 글 삭제 [관리자]
 			require('manager/AdminproductgalBoardProc.php');  		
 	} else if ($_GET['show']=="board-update") {	// 게시판 글 수정저장 [관리자]
 			require('manager/AdminproductgalBoardProc.php');  	 					 	 			 			
	} else if ($_GET['show']=="image-delete") { 	// 이미지 개별 삭제 [관리자]
 			require('manager/AdminproductgalBoardProc.php');  					 	 			 			
	} else if ($_GET['show']=="image-sort") { 	// 이미지 순서적용 [관리자]
 			require('manager/AdminproductgalBoardProc.php');  					 	 			 			 			
	} else if ($_GET['show']=="image-set") { 	// 이미지 썸네일지정 [관리자]
 			require('manager/AdminproductgalBoardProc.php');  					 	 			 			 			 			
	} else if ($_GET['show']=="showcase-set") { 	//  진열대 지정 [관리자]
 			require('manager/AdminproductgalBoardProc.php');  					 	 			 			 			 			 			
 	} else {
 		 	require('manager/AdminproductgalBoardList.php');				//  리스트 [관리자]
 	}?>
 </div>		
<?php		
		
	}



	/** Class define  **/



	class Hpluginproductgallery {
	


		// init DB and function 
		public static function plugin_activate(){
		
			Hpluginproductgallery::hplugin_db_init();
		  
		}

	
	
		public static function plugin_deactivate($v_msg){

			print("$v_msg");			
	
		}

	

		public static function hplugin_tableExist_check($v_check_table_name){
			global $wpdb;
			
			$a_result = "Y";
			
			if($wpdb->get_var("SHOW TABLES LIKE '".$v_check_table_name."' ") != $v_check_table_name )
			{
				$a_result = "N";	
			}
			
			return $a_result;		//Exist :Y / Non-Exist : N
		
		}
	
	
		public static function hplugin_db_init(){

			
		
			global $wpdb;


			$ht_tables_arr = array ( 'wp_hplugin_hplugin_product_gallary', 
									'wp_hplugin_hplugin_product_gallert_opt',
									'wp_hplugin_hplugin_product_gallert_img',
									'wp_hplugin_hplugin_product_gallert_cate',
									'wp_hplugin_hplugin_product_gallert_opt_set',
									'wp_hplugin_hplugin_product_gallert_set'									
									);


			/** No need Require table. this plugin is working independent  **/
			/**		
			$required_tables_arr = array( 

									'wp_hto_board',											
											'wp_hto_board_attach',
											'wp_hto_board_comment',
											'wp_hto_board_cat',
											'wp_hto_board_option',
											'wp_hto_board_set'
					);
			**/



			// Check Table exist;			
			$tbl_count = 0; 
			
			for ( $i=0; $i<count( $ht_tables_arr ) ; $i++ ) {
				if (  Hpluginproductgallery::hplugin_tableExist_check($ht_tables_arr[$i]) == "Y" ) {
						$tbl_count++;
				}				
			}
			

			// Check H-BBS Tables 
			/**
			$req_tbl_count = 0; 
			
			for ( $ri=0; $ri<count( $required_tables_arr ) ; $ri++ ) {
				if (  Hpluginebook::hplugin_tableExist_check($required_tables_arr[$ri]) == "Y" ) {
						$req_tbl_count++;
				}				
			}
			**/


			if ( $tbl_count == count( $ht_tables_arr ) ) 
			{ 
			 //if tables are all exist, use tables data 

						print("기존 사용했던 테이블이 존재합니다.");
						Hpluginebook::plugin_deactivate($err_msg);
						exit;
				
			} else if ( $tbl_count > 0  )   {
			// tables already exist for other plugins.
						
						$err_msg = "기존 사용했던 테이블이 존재하거나 다른 플러그인이 같은 이름의 테이블명을 사용중입니다.";
						Hpluginebook::plugin_deactivate($err_msg);						
						exit;			

			} else	 {
				
				// Create Database ; 			
							
				$ht_sql = "CREATE TABLE wp_hplugin_product_gallery(
      	no int(10) not null primary key AUTO_INCREMENT, 
      	r_no int(10),
      	title varchar(200),     
      	subtitle varchar(200),
      	contents text ,     
      	contents2 text, 	
      	contents3 text, 	
      	catecode varchar(100),
      	price int(10) default 0,
      	userid varchar(100),
      	cnt int default 0,
      	status char(1) not null default 'Y' , 
      	reg_date datetime        
				)	; ";

				$wpdb->query( $ht_sql );
				
				$ht_sql = "CREATE TABLE wp_hplugin_product_gallery_opt(
      	no int(8) NOT null PRIMARY key AUTO_INCREMENT ,       
      	c_no int(8) ,     	      	
      	name varchar(200),       
      	value varchar(200), 
      	status char(1) not null default 'Y',
      	reg_date datetime        
				);";         
				
				$wpdb->query( $ht_sql );				



				$ht_sql = "CREATE TABLE wp_hplugin_product_gallery_cate(
      	no int(8) NOT null PRIMARY key AUTO_INCREMENT ,       
      	catecode varchar(20) ,     	      	
      	catename varchar(200),             	
      	status char(1) not null default 'Y',
      	reg_date datetime        
				);";         
				
				$wpdb->query( $ht_sql );		


				$ht_sql = "CREATE TABLE wp_hplugin_product_gallery_opt_set(
      	no int(8) NOT null PRIMARY key AUTO_INCREMENT ,       
      	name varchar(20) ,     	      	
      	value varchar(200),             	
      	type char(1) not null default 'I',			
      	iconurl varchar(50),
      	sgubun char(1) default 'N', 
      	sort int default 0 ,       	
      	status char(1) not null default 'Y',
      	reg_date datetime 
				);";         
				
				$wpdb->query( $ht_sql );		




				$ht_sql = "CREATE TABLE wp_hplugin_product_gallery_showcase(
      	no int(8) NOT null PRIMARY key AUTO_INCREMENT ,       
      	c_no int(8),     	      	
      	viewurl varchar(100),      	
      	sort int default 0 , 
      	status char(1) not null default 'Y',
      	reg_date datetime 
				);";         
				
				$wpdb->query( $ht_sql );	



				$ht_sql = "CREATE TABLE wp_hplugin_product_gallery_img(
      	no int(8) NOT null PRIMARY key AUTO_INCREMENT ,       
      	c_no int(8) ,     	      	
      	title varchar(200),       
      	imgurl varchar(200), 
      	sort int(8) default 0 ,
      	mark char(1),
      	mark2 char(1),
      	status char(1) not null default 'Y',
      	reg_date datetime        
				);";         
				
				$wpdb->query( $ht_sql );	



				$ht_sql = "CREATE TABLE wp_hplugin_product_gallery_set(
      	no int(8) not null primary key AUTO_INCREMENT, 
      	name varchar(50),
      	value varchar(100),
      	status char(1) not null default 'Y',     
      	reg_date datetime
				) ; " ; 				

			

				$wpdb->query($ht_sql);



				$ht_query_arr = array(

				
					array ( 'name'=>'adminemail', 'value'=>'admin@yourmail.com', 'status'=>'Y'  ) ,			//관리자 Email 
					array ( 'name'=>'auth_key' , 'value'=>'hpluginebooklimited', 'status'=>'Y'  ) ,			// key
					array ( 'name'=>'catecode' , 'value'=>'', 'status'=>'Y'  )	,		// catecode
					array ( 'name'=>'listrownum' , 'value'=>'9', 'status'=>'Y'  )	, 
					array ( 'name'=>'etype' , 'value'=>'B', 'status'=>'Y'  )	, 
					array ( 'name'=>'displaymode' , 'value'=>'P', 'status'=>'Y'  )	
					

				);


				$ht_sql = "INSERT INTO wp_hplugin_ebook_set(name, value,  status) VALUES " ;

				foreach ( $ht_query_arr as $set_items ){

					$ht_sql .= $wpdb->prepare (
						"(%s , %s, %s ),",
						$set_items['name'] , $set_items['value'],  $set_items['status']
					);
				}
				


				$ht_sql = rtrim($ht_sql, ',' ).";";

				$wpdb->query($ht_sql);



			}  // End Create database 

	
	}
	
	
	public static function customerMailSend( $msg_subject, $msg , $mailr, $gubun ) {

		global $wpdb ;




		$sql_query = "SELECT name, value FROM wp_hplugin_board_appv_set WHERE name='adminemail' ";
		$ms_fd = $wpdb->get_results($sql_query);

		$emailfrom = "";
		$emailto ="";

		foreach( $ms_fd as $ms_arr){

			if ( !!$ms_arr->name ){


				if( $gubun =="A" ) {

					$emailfrom = $ms_arr->value ; 
					$emailto = $mailr ;
				//	print "A : ".$mailr." ".$emailto."<br>"; 
				} else {

					$emailfrom = $mailr ;
					$emailto =  $ms_arr->value ; 
				//	print "B : ".$mailr." ".$emailfrom."<br>";

				}

				$subject = $msg_subject;
				$content = $msg ; 


				$header  = 'MIME-Version: 1.0' . "\r\n";
				$header .= "Content-type: text/html; charset=utf-8\r\n";
				$header .= "From: ".$emailfrom."\r\n";
				$header .= "To: ".$emailto."\r\n";
				

				$result = mail($emailto, $subject, $content , $header);

				if (!$result){

					print "메일발송 에러";
				} else {

					

					//print $msg_subject." ".$receiver ;
				}


			}

		}


	}


	public static function page_loading_ready( $waitingtime  ) {


		$display_str = "
		<script>
			jQuery(document).ready(function(){
				jQuery('#pageloading').fadeOut(3000);
			});

		</script>
		";
		
		print $display_str ; 


	}


}
?>