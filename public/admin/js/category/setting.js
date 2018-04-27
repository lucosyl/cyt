/*
* @Author: Administrator
* @Date:   2018-04-18 16:53:46
* @Last Modified by:   Administrator
* @Last Modified time: 2018-04-25 15:43:05
*/

	$('.submit').click(function(e){
		e.preventDefault();
		if ( !inputCheck('9001') ) return false;
		if ( !inputCheck('9002') ) return false;
		if ( !inputCheck('9004') ) return false;
		if ( !inputCheck('9005') ) return false;
		if ( !inputCheck('9008') ) return false;
		if ( !inputCheck('9009') ) return false;
		$(this).attr('disabled','disabled');
		formData = $('#form').serialize();
		$.post('/admin/category/SiteSetting',formData,function(data){
			if(data.code == 200 ){
					uploadImg('logo',0);
					uploadImg('qrcode',1);
					alerting(data.message);
					$('.submit').attr('disabled',false);
			}else{
					alerting(data.code);
				}
		})

	})


	function getFileUrl(sourceId) {
	    var url;
	    if (navigator.userAgent.indexOf("MSIE")>=1) { // IE
	        url = sourceId.value;
	    } else if(navigator.userAgent.indexOf("Firefox")>0) { // Firefox
	        url = window.URL.createObjectURL(sourceId.files.item(0));
	    } else if(navigator.userAgent.indexOf("Chrome")>0) { // Chrome
	        url = window.URL.createObjectURL(sourceId.files.item(0));
	    }
	    return url;
	}


	function uploadImg(name,index){

		var formData = new FormData();
		file = $(".post-file")[index].files[0]
		if ( !file ){
			return false;
		}
		formData.append(name,file);
		$.ajax({ 
			url : '/admin/category/logo', 
			type : 'POST', 
			data : formData, 
			// 告诉jQuery不要去处理发送的数据
			processData : false, 
			// 告诉jQuery不要去设置Content-Type请求头
			contentType : false,
			beforeSend:function(){
			console.log("正在进行，请稍候");
			},
			success : function(responseStr) { 
				if(responseStr.code==200){
					return true;
				}else{
					return false;
				}
			}, 
			error : function(responseStr) { 
				console.log("error");
			} 
		});

	}
	/**
	*/
	function preImg(sourceId, targetId) {
	    var url = getFileUrl(sourceId);
	    targetId.src = url;

	}