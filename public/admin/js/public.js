	$(document).ready(function(){
		$('body').append('<div id="alerting" style="display: none;position: fixed;border-radius: 10px;text-align: center;left: 50%;margin-left: -60px;line-height: 50px;color:white;top: 230px;padding: 0 50px;height: 50px;background-color: rgba(0,0,5,0.5);"></div>')
	})

	
	//提醒功能
	function alerting(text){
		$('#alerting').css('z-index','999');
		$('#alerting').stop();
		$('#alerting').text(text);
		$('#alerting').fadeIn(100);
		$('#alerting').fadeOut(3000);
	}


	//邮箱判断
	function isEmail(str){ 
		var reg = /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/; 
		return reg.test(str); 
	} 

	//号码判断
	function isPhone(poneInput){
        var myreg=/^[1][3,4,5,7,8][0-9]{9}$/;
        if (!myreg.test(poneInput)) {
            return false;
        } else {
            return true;
        }
    }

    //输入框检查
    function inputCheck(name){
        if ( $('input[name="'+name+'"]').val() =='' || $('input[name="'+name+'"]').val() == null){
            $('input[name="'+name+'"]').focus();
            alerting('当前输入框必填');
            return false;
        }
        return true;

    }

    //summernote上传文件
	function sendFile(file, editor, url) {
        var filename = false;  
        try {  
            filename = file['name'];  
        } catch (e) {  
            filename = false;  
        }  
        if (!filename) {  
            $(".note-alarm").remove();  
        } 
        var data = new FormData();  
        data.append("ajaxTaskFile", file); 
        $.ajax({  
            data : data,  
            type : "POST",  
            url : url, //图片上传url，返回的是图片上传后的路径，http格式  
            cache : false,  
            contentType : false,  
            processData : false,  
            dataType : "json",  
            success: function(data) { 
                editor.summernote('insertImage', data.message, filename);  
            },  
            error:function(){  
                alert("上传失败");  
            }  
        });  
    }
	//回车提交
	function keySubmit(){
		$(document).keydown(function(event){
	　　　　if(event.keyCode == 13){
				$('.submit').click();
	　　　　}
　　　　});

	}


    function getNow() {
        var date = new Date();
        var seperator1 = "-";
        var seperator2 = ":";
        var month = date.getMonth() + 1;
        var strDate = date.getDate();
        if (month >= 1 && month <= 9) {
            month = "0" + month;
        }
        if (strDate >= 0 && strDate <= 9) {
            strDate = "0" + strDate;
        }

        H = date.getHours();
        M = date.getMinutes()
        I = date.getSeconds()
        if (H >= 0 && H <= 9) H = "0" + H;
        if (M >= 0 && M <= 9) M = "0" + M;
        if (I >= 0 && I <= 9) I = "0" + I;
        
        var currentdate = date.getFullYear() + seperator1 + month + seperator1 + strDate
                + " " + H+ seperator2 + M
                + seperator2 + I;
        return currentdate
    }