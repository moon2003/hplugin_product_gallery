


	function hplugin_product_gallery_keyreset(){


		// Get the default key from HTO plugin server 
		authkeyVal = "hplugineproductgallerylimited";
		jQuery("#auth_key_id").attr("value",authkeyVal);

		alert("기본키가 입력 되었습니다.");


	}



	function hplugin_product_gallery_setdUpdate(){



		errno = 0;
		errno2 = 0 ;

		errMsg = "";
		errMsg2 = "";



		if ( !jQuery("#adminemail_id").attr("value") ) {

			errMsg = "관리자메일";
			errno++;


		} else if ( fieldmaxlen(  100,  jQuery("#adminemail_id").attr("value")   )  === false ) {

			errMsg2 = "관리자메일";
			errno2++;
		}



		if ( !jQuery("#auth_key_id").attr("value") ) {
		
			if ( errno > 0 ) errMsg += ", ";

			errMsg = "Auth Key";
			errno++;

		} else if ( fieldmaxlen(  100,  jQuery("#auth_key_id").attr("value")   )  === false ) {

			if ( errno2 > 0 ) errMsg2 += ", ";
			errMsg2 = "Auth Key";
			errno2++;	

		}




		if ( errno >0 || errno2 > 0) {


			emsg = "";

			if ( errno > 0 ){

				emsg +='다음 사항이 입력되지 않았습니다.\n'+errMsg+'\n\n';

			}



			if ( errno2 > 0 ) {

				emsg +='다음 사항의  길이가  너무 깁니다.\n'+errMsg2;

			}

			alert(emsg);
			return false ;

		} else {

			jQuery('#frm_in').submit();		

		}


	}




	function hplugin_product_gallery_applyCate(){



		catCnt = parseInt(jQuery("#catcnt").attr("value") );

		catDisplaystr = '';
		catValuestr = '';

		for(ci=0; ci < catCnt ; ci++){

		
			if (  jQuery("#catbtn_"+ci).hasClass('active') === true	 ){

				tmpstr = jQuery("#catbtn_"+ci).attr("value");		
				tmpstr_arr = tmpstr.split("|");

				console.log( tmpstr );

				if ( ci > 0 ) {
					catDisplaystr += '&nbsp;';	
					catValuestr +=',';
				} 

				catDisplaystr += '<button type="button" class="btn btn-xs btn-primary">'+tmpstr_arr[0]+'</button>';
				catValuestr += tmpstr_arr[1];

			}


		}

		catDisplaystr += '&nbsp;&nbsp;<button type="button" class="btn btn-xs btn-warning" onclick="javascript:hplugin_product_gallery_cateClear();">Clear</button>';
	
		jQuery("#catename_layer").html(catDisplaystr);
		jQuery("#catecode").attr("value",catValuestr);
		

	}


	function hplugin_product_gallery_cateClear(){

 		jQuery("#catename_layer").html("");
		jQuery("#catecode").attr("value","");
		jQuery("[id^=catbtn_]").removeClass("active");
	}


	function hpluginproductgallery_cateSave(){

		errcnt = 0 ; 
		errstr = '';
		
		errcnt2 = 0;
		errstr2 = '';
	

		if ( !jQuery("#cat_name").attr("value") ){
			errcnt++;
			errstr = '카테고리명';
		} else if ( fieldmaxlen(100, jQuery('#cat_name').attr('value') ) === false ) {

			errstr2 += '카테고리명';
			errcnt2++;

 		} 	


		if ( errcnt >0 || errcnt2 > 0) {

			emsg = '';

			if ( errcnt > 0 ){
				emsg +='다음 사항이 입력되지 않았습니다.\n'+errstr+'\n\n';
			}


			if ( errcnt2 > 0 ) {
				emsg +='다음 사항의  길이가  너무 깁니다.\n'+errstr2;
			}

			alert(emsg);

		} else {

			//jQuery('#frm_in').submit();
			document.frm_in.submit();

		}


	}



	function hpluginproductgallery_cateUpdate(){


		errcnt = 0 ; 
		errstr = '';
		
		errcnt2 = 0;
		errstr2 = '';
		
	
		if ( !jQuery("#cat_name").attr("value") ){
			errcnt++;
			errstr = '카테고리명';
		} else if ( fieldmaxlen(100, jQuery('#cat_name').attr('value') ) === false ) {
	
			errstr2 += '카테고리명';
			errcnt2++;
	
	 	} 	
	
	
		if ( errcnt >0 || errcnt2 > 0) {
	
			emsg = '';
	
			if ( errcnt > 0 ){
				emsg +='다음 사항이 입력되지 않았습니다.\n'+errstr+'\n\n';
			}
	
	
			if ( errcnt2 > 0 ) {
				emsg +='다음 사항의  길이가  너무 깁니다.\n'+errstr2;
			}
	
			alert(emsg);
	
		} else {
	
			//jQuery('#frm_in').submit();
			document.frm_in.submit();
	
		}
	

	}


	function hpluginproductgallery_cateDelete(rnum){

		conf = confirm("카테고리를 삭제하시겠습니까?\n\n게시판에서 삭제된 카테고리는 [미지정]으로 표시됩니다.");

		if ( conf === true) {
			jQuery("#frm_in").attr("action","/wp-admin/admin.php?page=hplugin-product-gallery-cate-menu&show=cate-delete");
			jQuery("#frm_schedule_rid_no").attr("value", rnum );

			//jQuery("#frm_in").submit();
			document.frm_in.submit();
		}

	}





	function hplugin_product_gallery_opt_add(){

		// Check radio status 

		var rvalue = jQuery(':radio[name="opt_type"]:checked').val();

		if( rvalue != "I" ){ 

			var add_field_str = "<br/>\n<input type=\"text\" name=\"opt_value[]\" size=\"60\" style=\"margin-top:12px;\">";
			jQuery("#hplugin_product_gallery_opt_field_id").append(add_field_str);

		} else {
			alert("INPUT 타입은 옵션값을 설정할수 없습니다.");
		}

	}



	function hplugin_product_gallery_optionSave(){

		errcnt = 0 ; 
		errstr = '';
		
		errcnt2 = 0;
		errstr2 = '';
		

		if ( !jQuery("#opt_name_id").attr("value") ){
			errcnt++;
			errstr = "옵션명";
		} else if ( fieldmaxlen(100, jQuery('#opt_name_id').attr('value') ) === false ) {
	
			errstr2 += "옵션명";
			errcnt2++;
	
	 	} 	
	
	
		if ( errcnt >0 || errcnt2 > 0) {
	
			emsg = '';
	
			if ( errcnt > 0 ){
				emsg +='다음 사항이 입력되지 않았습니다.\n'+errstr+'\n\n';
			}
	
	
			if ( errcnt2 > 0 ) {
				emsg +='다음 사항의  길이가  너무 깁니다.\n'+errstr2;
			}
	
			alert(emsg);
	
		} else {
	
			//jQuery('#frm_in_id').submit();
			//document.frm_in.submit();
			//jQuery('#frm_in_id').serialize();
 	   		jQuery('#frm_in_id').submit();


	
		}



		 //alert( jQuery("input[name='opt_value[]']").length);
	}





	function hplugin_product_gallery_optionDelete(rnum){

		conf = confirm("선택하신 옵션을 삭제하시겠습니까?\n\n기존 등록된 게시물의 옵션사항도 같이삭제되어지게 됩니다.");

		if ( conf === true) {
			jQuery("#frm_in").attr("action","/wp-admin/admin.php?page=hplugin-product-gallery-option-menu&show=option-delete");
			jQuery("#frm_schedule_rid_no").attr("value", rnum );

			//jQuery("#frm_in").submit();
			document.frm_in.submit();
		}

	}



	function hplugin_product_gallery_opttype(tgubun){

		var add_field_str = "<input type=\"text\" id=\"opt_value_id\" name=\"opt_value[]\" size=\"60\" style=\"margin-top:12px;\">";

		if( tgubun == "C" ){
			add_field_str = "<input type=\"text\" id=\"opt_value_id\" name=\"opt_value[]\" size=\"60\" style=\"margin-top:12px;\" disabled>";
		} 

		jQuery("#hplugin_product_gallery_opt_field_id").html(add_field_str);
	}


	function fieldmaxlen( mlen, chkstr){

		if ( chkstr.length > mlen){
			return false ;
		} else {
			return true;
		}


	}	


