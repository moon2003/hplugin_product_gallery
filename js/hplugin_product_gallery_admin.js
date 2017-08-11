


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

			var randomstr = key_randomString();

			var add_field_str = "<div id=\"opt_field_"+randomstr+"_id\" style=\"margin-top:12px;\" ><input type=\"text\" id=\"opt_value_"+randomstr+"_id\" name=\"opt_value[]\" size=\"60\" >  <span class=\"label label-danger\" onclick=\"javascript:hplugin_product_gallery_opt_del('"+randomstr+"');\" style=\"cursor:pointer\" >X</span><div>";    
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
	
			jQuery('#frm_in_id').submit();
			//document.frm_in.submit();
	
		}



	}





	function hplugin_product_gallery_optionDelete(rnum){

		conf = confirm("선택하신 옵션을 삭제하시겠습니까?\n\n기존 등록된 게시물의 옵션사항도 같이 삭제 됩니다.");

		if ( conf === true) {
			jQuery("#frm_in_id").attr("action","/wp-admin/admin.php?page=hplugin-product-gallery-option-menu&show=option-delete");
			jQuery("#frm_schedule_rid_no").attr("value", rnum );

			//jQuery("#frm_in").submit();
			document.frm_in.submit();
		}

	}


	function hplugin_product_gallery_opt_del(opno){

		jQuery("#opt_field_"+opno+"_id").remove();
	}




	function hplugin_product_gallery_opt_sort( act , rowno ){

    
        //var val = [];
        //console.log( act + " | "+optno );

        // Up일때 
        if( act == "U"){

        	if( rowno == 0){
        		alert("이미 최상입니다.");
        	} else {

        		// 본인 Layyer 읽어옴 
        		var selfhtml = jQuery("#optionval_"+rowno).html();
        		// 상단 Layer 읽어옴 
        		var uphtml = jQuery("#optionval_"+(parseInt(rowno,10)-1) ).html();
        		
        		console.log(selfhtml + "\n\n"+uphtml);

        		
        		// 순서변경 
        		selfhtml = selfhtml.replace("hplugin_product_gallery_opt_sort('U',"+rowno+")", "hplugin_product_gallery_opt_sort('U',"+(parseInt(rowno,10)-1)+")" );
        		selfhtml = selfhtml.replace("hplugin_product_gallery_opt_sort('D',"+rowno+")", "hplugin_product_gallery_opt_sort('D',"+(parseInt(rowno,10)-1)+")" );
        		uphtml = uphtml.replace("hplugin_product_gallery_opt_sort('U',"+(parseInt(rowno,10)-1)+")" , "hplugin_product_gallery_opt_sort('U',"+rowno+")");
        		uphtml = uphtml.replace("hplugin_product_gallery_opt_sort('D',"+(parseInt(rowno,10)-1)+")" , "hplugin_product_gallery_opt_sort('D',"+rowno+")");

        		// 상단에 현제값 적용 
        		jQuery("#optionval_"+rowno).html( "" );
        		jQuery("#optionval_"+rowno).append( uphtml );
        		// 본인에 상단값  적용 
        		jQuery("#optionval_"+(parseInt(rowno,10)-1) ).html( "" );
        		jQuery("#optionval_"+(parseInt(rowno,10)-1) ).append( selfhtml );

        		jQuery("#hplugin_product_gallery_sort_status").fadeIn(300);

        	}

        } else if( act =="D"){

        	var downhtml = jQuery("#optionval_"+(parseInt(rowno,10)+1) ).html() ; 

        	if( !downhtml || downhtml == "" ){
        		alert("이미 최하입니다.");
        	} else {

        		// 본인 Layyer 읽어옴 
        		var selfhtml = jQuery("#optionval_"+rowno).html();
        		// 하단 Layer 읽어옴 
        		downhtml = jQuery("#optionval_"+(parseInt(rowno,10)+1) ).html();
        		
        		console.log(selfhtml + "\n\n"+downhtml);

        		
        		// 순서변경 
        		selfhtml = selfhtml.replace("hplugin_product_gallery_opt_sort('U',"+rowno+")", "hplugin_product_gallery_opt_sort('U',"+(parseInt(rowno,10)+1)+")" );
        		selfhtml = selfhtml.replace("hplugin_product_gallery_opt_sort('D',"+rowno+")", "hplugin_product_gallery_opt_sort('D',"+(parseInt(rowno,10)+1)+")" );
        		downhtml = downhtml.replace("hplugin_product_gallery_opt_sort('U',"+(parseInt(rowno,10)+1)+")" , "hplugin_product_gallery_opt_sort('U',"+rowno+")");
        		downhtml = downhtml.replace("hplugin_product_gallery_opt_sort('D',"+(parseInt(rowno,10)+1)+")" , "hplugin_product_gallery_opt_sort('D',"+rowno+")");

        		// 하단에 현제값 적용 
        		jQuery("#optionval_"+rowno).html( "" );
        		jQuery("#optionval_"+rowno).append( downhtml );
        		// 본인에 상단값  적용 
        		jQuery("#optionval_"+(parseInt(rowno,10)+1) ).html( "" );
        		jQuery("#optionval_"+(parseInt(rowno,10)+1) ).append( selfhtml );

        		jQuery("#hplugin_product_gallery_sort_status").fadeIn(300);

        	}


		
		}


        // Down 일때 

        jQuery("input[name='optno[]']").each(function(){
          //val[i] = $(this).val();
          console.log( jQuery(this).val()  );
        });
    
 

	}



	function hplugin_product_gallery_opt_sortUpdate(){

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

			jQuery("#frm_in").attr("action","/wp-admin/admin.php?page=hplugin-product-gallery-option-menu&show=option-sortupdate");
			//jQuery("#frm_in").submit();
			document.frm_in.submit();
		}


	}




	function hplugin_product_gallery_opttype(tgubun){


		var randomstr = key_randomString();

		var add_field_str = "<input type=\"text\" id=\"opt_value_"+randomstr+"_id\" name=\"opt_value[]\" size=\"60\" style=\"margin-top:12px;\"> <span class=\"label label-danger\" onclick=\"javascript:hplugin_product_gallery_opt_del('"+randomstr+"');\">X</span>";

		if( tgubun == "C" ){
			add_field_str = "<input type=\"text\" id=\"opt_value_"+randomstr+"_id\" name=\"opt_value[]\" size=\"60\" style=\"margin-top:12px;\" disabled>";
		} 

		jQuery("#hplugin_product_gallery_opt_field_id").html(add_field_str);
	}




	//----- board function -----//
	function hplugin_product_gallery_img_add( pluginurl ){

		var randomstr = key_randomString();

		var add_field_str = "<div style=\"clear:both;margin-bottom:10px;\" id=\"img_field_"+randomstr+"_id\">";
        add_field_str += "<div style=\"float:left;min-width:250px;min-height:100px;\"><img src=\""+pluginurl+"images/hplugin_product_gallery_noimage.png\" id=\"upload_img_"+randomstr+"_id\" style=\"border:1px solid #e7e7e7\" ></div>";
        add_field_str += "<div style=\"float:left;\"><input type=\"file\" name=\"upload_img[]\" onChange=\"javascript:hplugin_product_gallery_image_select( this, 'upload_img_"+randomstr+"_id' );\"> ";
        add_field_str += "<span class=\"label label-danger\" onclick=\"javascript:hplugin_product_gallery_imgadd_del('"+randomstr+"');\">X</span></div> ";
        add_field_str += "</div>";



		jQuery("#hplugin_product_gallery_img_id").append(add_field_str).fadeIn(300);


	}



	function hplugin_product_gallery_imgadd_del(rno){
		jQuery("#img_field_"+rno+"_id").remove().fadeOut(300);
	}




	function hplugin_product_gallery_boardSave(){

		
		// Vaildataion 
		errcnt = 0 ; 
		errstr = '';
		
		errcnt2 = 0;
		errstr2 = '';
		
	
		if ( !jQuery("#title_id").attr("value") ){
			errcnt++;
			errstr = "제목";
		} else if ( fieldmaxlen(200, jQuery('#title_id').attr('value') ) === false ) {
			errstr2 += "제목";
			errcnt2++;
	 	} 	
	

		if ( !jQuery("#title_id").attr("value") ){
			errcnt++;
			errstr = "제목";
		} else if ( fieldmaxlen(200, jQuery('#title_id').attr('value') ) === false ) {
			errstr2 += "제목";
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
			// Submit 
			jQuery("#frm_in_id").submit();
		}


	}



	function hplugin_product_gallery_Delete(cno){


		var conf = confirm("해당 게시물을 삭제하시겠습니까?");

		if( conf === true) { 

			jQuery("#frm_in_id").attr("action","/wp-admin/admin.php?page=hplugin-product-gallery-menu&show=board-delete&cid="+cno);
			jQuery("#cid_id").val(cno);
			jQuery("#frm_in_id").submit();

		}


	}




	function hplugin_product_gallery_imgdel(ino , cno ){

		var conf = confirm("해당 이미지를 삭제하시겠습니까?");

		if( conf === true ){

			jQuery("#frm_in_id").attr("action","/wp-admin/admin.php?page=hplugin-product-gallery-menu&show=image-delete&cid="+cno+"&imgno="+ino);
			jQuery("#cid_id").val(cno);
			jQuery("#frm_in_id").submit();
		}

	}



	function hplugin_product_gallery_image_sort(act , rowno){


    // Up일때 
        if( act == "U"){

        	if( rowno == 0){
        		alert("이미 최상입니다.");
        	} else {

        		// 본인 Layyer 읽어옴 
        		var selfhtml = jQuery("#img_upload_"+rowno).html();
        		// 상단 Layer 읽어옴 
        		var uphtml = jQuery("#img_upload_"+(parseInt(rowno,10)-1) ).html();
        		
        		//console.log(selfhtml + "\n\n"+uphtml);

        		
        		// 순서변경 
        		selfhtml = selfhtml.replace("hplugin_product_gallery_image_sort('U',"+rowno+")", "hplugin_product_gallery_image_sort('U',"+(parseInt(rowno,10)-1)+")" );
        		selfhtml = selfhtml.replace("hplugin_product_gallery_image_sort('D',"+rowno+")", "hplugin_product_gallery_image_sort('D',"+(parseInt(rowno,10)-1)+")" );
        		uphtml = uphtml.replace("hplugin_product_gallery_image_sort('U',"+(parseInt(rowno,10)-1)+")" , "hplugin_product_gallery_image_sort('U',"+rowno+")");
        		uphtml = uphtml.replace("hplugin_product_gallery_image_sort('D',"+(parseInt(rowno,10)-1)+")" , "hplugin_product_gallery_image_sort('D',"+rowno+")");

        		// 상단에 현제값 적용 
        		jQuery("#img_upload_"+rowno).html( "" );
        		jQuery("#img_upload_"+rowno).append( uphtml );
        		// 본인에 상단값  적용 
        		jQuery("#img_upload_"+(parseInt(rowno,10)-1) ).html( "" );
        		jQuery("#img_upload_"+(parseInt(rowno,10)-1) ).append( selfhtml );

        		// 순서변경 사항 표시 
        		jQuery("#hplugin_product_gallery_sort_info").fadeIn(300);

        	}

        } else if( act =="D"){

        	var downhtml = jQuery("#img_upload_"+(parseInt(rowno,10)+1) ).html() ; 

        	if( !downhtml || downhtml == "" ){
        		alert("이미 최하입니다.");
        	} else {

        		// 본인 Layyer 읽어옴 
        		var selfhtml = jQuery("#img_upload_"+rowno).html();
        		// 하단 Layer 읽어옴 
        		downhtml = jQuery("#img_upload_"+(parseInt(rowno,10)+1) ).html();
        		
        		console.log(selfhtml + "\n\n"+downhtml);

        		
        		// 순서변경 
        		selfhtml = selfhtml.replace("hplugin_product_gallery_image_sort('U',"+rowno+")", "hplugin_product_gallery_image_sort('U',"+(parseInt(rowno,10)+1)+")" );
        		selfhtml = selfhtml.replace("hplugin_product_gallery_image_sort('D',"+rowno+")", "hplugin_product_gallery_image_sort('D',"+(parseInt(rowno,10)+1)+")" );
        		downhtml = downhtml.replace("hplugin_product_gallery_image_sort('U',"+(parseInt(rowno,10)+1)+")" , "hplugin_product_gallery_image_sort('U',"+rowno+")");
        		downhtml = downhtml.replace("hplugin_product_gallery_image_sort('D',"+(parseInt(rowno,10)+1)+")" , "hplugin_product_gallery_image_sort('D',"+rowno+")");

        		// 하단에 현제값 적용 
        		jQuery("#img_upload_"+rowno).html( "" );
        		jQuery("#img_upload_"+rowno).append( downhtml );
        		// 본인에 상단값  적용 
        		jQuery("#img_upload_"+(parseInt(rowno,10)+1) ).html( "" );
        		jQuery("#img_upload_"+(parseInt(rowno,10)+1) ).append( selfhtml );

        		// 순서변경 사항 표시 
        		jQuery("#hplugin_product_gallery_sort_info").fadeIn(300);

        	}


		
		}

	}


	function hplugin_product_gallery_image_sortsave(cno){

		jQuery("#frm_in_id").attr("action","/wp-admin/admin.php?page=hplugin-product-gallery-menu&show=image-sort&cid="+cno);
		jQuery("#cid_id").val(cno);
		jQuery("#frm_in_id").submit();

	}




	function hplugin_product_gallery_set_img( imgno , cno, iset){

		jQuery("#frm_in_id").attr("action","/wp-admin/admin.php?page=hplugin-product-gallery-menu&show=image-set&cid="+cno+"&imgno="+imgno+"&iset="+iset);
		jQuery("#cid_id").val(cno);
		jQuery("#frm_in_id").submit();

	}


	function hplugin_product_gallery_set_showcase(cno){

		jQuery("#frm_in_id").attr("action","/wp-admin/admin.php?page=hplugin-product-gallery-menu&show=showcase-set&cid="+cno);
		jQuery("#cid_id").val(cno);
		jQuery("#frm_in_id").submit();

	}






	function hplugin_product_gallery_showcase_sort(act , rowno){


    // Up일때 
        if( act == "U"){

        	if( rowno == 0){
        		alert("이미 최상입니다.");
        	} else {

        		// 본인 Layyer 읽어옴 
        		var selfhtml = jQuery("#showcase_"+rowno).html();
        		// 상단 Layer 읽어옴 
        		var uphtml = jQuery("#showcase_"+(parseInt(rowno,10)-1) ).html();
        		
        		//console.log(selfhtml + "\n\n"+uphtml);

        		
        		// 순서변경 
        		selfhtml = selfhtml.replace("hplugin_product_gallery_showcase_sort('U',"+rowno+")", "hplugin_product_gallery_showcase_sort('U',"+(parseInt(rowno,10)-1)+")" );
        		selfhtml = selfhtml.replace("hplugin_product_gallery_showcase_sort('D',"+rowno+")", "hplugin_product_gallery_showcase_sort('D',"+(parseInt(rowno,10)-1)+")" );
        		uphtml = uphtml.replace("hplugin_product_gallery_showcase_sort('U',"+(parseInt(rowno,10)-1)+")" , "hplugin_product_gallery_showcase_sort('U',"+rowno+")");
        		uphtml = uphtml.replace("hplugin_product_gallery_showcase_sort('D',"+(parseInt(rowno,10)-1)+")" , "hplugin_product_gallery_showcase_sort('D',"+rowno+")");

        		// 상단에 현제값 적용 
        		jQuery("#showcase_"+rowno).html( "" );
        		jQuery("#showcase_"+rowno).append( uphtml );
        		// 본인에 상단값  적용 
        		jQuery("#showcase_"+(parseInt(rowno,10)-1) ).html( "" );
        		jQuery("#showcase_"+(parseInt(rowno,10)-1) ).append( selfhtml );

        		// 순서변경 사항 표시 
        		jQuery("#hplugin_product_gallery_showcase_sort_btn").fadeIn(300);

        	}

        } else if( act =="D"){

        	var downhtml = jQuery("#showcase_"+(parseInt(rowno,10)+1) ).html() ; 

        	if( !downhtml || downhtml == "" ){
        		alert("이미 최하입니다.");
        	} else {

        		// 본인 Layyer 읽어옴 
        		var selfhtml = jQuery("#showcase_"+rowno).html();
        		// 하단 Layer 읽어옴 
        		downhtml = jQuery("#showcase_"+(parseInt(rowno,10)+1) ).html();
        		
        		console.log(selfhtml + "\n\n"+downhtml);

        		
        		// 순서변경 
        		selfhtml = selfhtml.replace("hplugin_product_gallery_showcase_sort('U',"+rowno+")", "hplugin_product_gallery_showcase_sort('U',"+(parseInt(rowno,10)+1)+")" );
        		selfhtml = selfhtml.replace("hplugin_product_gallery_showcase_sort('D',"+rowno+")", "hplugin_product_gallery_showcase_sort('D',"+(parseInt(rowno,10)+1)+")" );
        		downhtml = downhtml.replace("hplugin_product_gallery_showcase_sort('U',"+(parseInt(rowno,10)+1)+")" , "hplugin_product_gallery_showcase_sort('U',"+rowno+")");
        		downhtml = downhtml.replace("hplugin_product_gallery_showcase_sort('D',"+(parseInt(rowno,10)+1)+")" , "hplugin_product_gallery_showcase_sort('D',"+rowno+")");

        		// 하단에 현제값 적용 
        		jQuery("#showcase_"+rowno).html( "" );
        		jQuery("#showcase_"+rowno).append( downhtml );
        		// 본인에 상단값  적용 
        		jQuery("#showcase_"+(parseInt(rowno,10)+1) ).html( "" );
        		jQuery("#showcase_"+(parseInt(rowno,10)+1) ).append( selfhtml );

        		// 순서변경 사항 표시 
        		jQuery("#hplugin_product_gallery_showcase_sort_btn").fadeIn(300);

        	}


		
		}

	}


	function hplugin_product_gallery_showcase_sortUpdate(){


		jQuery("#frm_in_id").attr("action","/wp-admin/admin.php?page=hplugin-product-gallery-showcase-menu&show=showcase-sort");		
		jQuery("#frm_in_id").submit();

	}



	function hplugin_product_gallery_showcase_update( sno , loopcnt ){

		var pageinfo = jQuery("#viewurl_"+loopcnt).val();
		jQuery("#pageurl_id").val( pageinfo );
		jQuery("#cid_id").val( sno );

		jQuery("#frm_in_id").attr("action","/wp-admin/admin.php?page=hplugin-product-gallery-showcase-menu&show=showcase-update");		
		jQuery("#frm_in_id").submit();

	}	



	function hplugin_product_gallery_showcase_del(sno){

		var conf = confirm("해당 게시물을 진열목록에서 삭제하시겠습니까?");

		if( conf === true ){ 

			jQuery("#cid_id").val( sno );
			jQuery("#frm_in_id").attr("action","/wp-admin/admin.php?page=hplugin-product-gallery-showcase-menu");		
			jQuery("#frm_in_id").submit();
		}

	}




	function hplugin_product_gallery_image_select( fileinput,   eleID  ){

		var pfiles= fileinput.files;
		//alert( window.URL.createObjectURL(pfiles[0]) );
		jQuery("#"+eleID).attr("src", window.URL.createObjectURL(pfiles[0]) );
	
	}
	




	//----- Extra Commmon fucntion -----//



	function fieldmaxlen( mlen, chkstr){

		if ( chkstr.length > mlen){
			return false ;
		} else {
			return true;
		}


	}	





	function key_randomString() {
		var chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz";
		var string_length = 15;
		var randomstring = '';
		for (var i=0; i<string_length; i++) {
			var rnum = Math.floor(Math.random() * chars.length);
			randomstring += chars.substring(rnum,rnum+1);
		}		
		return randomstring;
	}