/*
* @Author: Administrator
* @Date:   2018-04-17 10:49:48
* @Last Modified by:   Administrator
* @Last Modified time: 2018-04-18 15:09:27
*/
	$('#summernote').summernote({
        lang: 'zh-CN',
        height: 300,
        callbacks: {  
            onImageUpload: function (files) {
                var editor = $('#summernote');
                sendFile(files[0], editor,'/admin/article/uploadImg');  
            }
        }
    });
	$('.note-editable').html('');
	if( $('input[name="id"]').length ){
		content = $('#summernote').html();
		$('.note-editable').html(content);
	}

	$('button[type="reset"]').click(function(){
		$('.note-editable').html('');
	})

	$('button[type="submit"]').click(function(e){
        e.preventDefault();
		if ( !formCheck() ) return false;
		$(this).attr('disabled','disabled');
		data = $('form').eq(0).serialize();
		data = data+'&content='+$('#summernote').summernote('code');
		$.post('/admin/article/adding',data,function(jsonData){
			console.log(jsonData);
			if( jsonData.code == 200 ){
				alerting('添加成功，返回列表页');
				setTimeout("window.location.href='/articles'",1000);
			}
		})
	})

	$("input[name='title'],input[name='label']").blur(function(){
			if( $(this).val() == null ||  $(this).val() == '' ){
				$(this).addClass('wrongInput');
				return false;
			}else{
				$(this).removeClass('wrongInput');
			} 
	})

	function formCheck(){

		if ( !inputCheck('title') || !inputCheck('label')) return false;
        if ( $('.note-editable').html() == '' || $('.note-editable').html() == null){
            alerting('文章详情不可为空');
            return false;
        }
        return true;

	}



