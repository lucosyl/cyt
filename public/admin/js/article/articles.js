/*
* @Author: Administrator
* @Date:   2018-04-18 09:45:30
* @Last Modified by:   Administrator
* @Last Modified time: 2018-04-18 09:45:39
*/
  $(document).ready(function () {

            	//表单渲染
                var table = $('#dataTables-example').DataTable({
        			"ajax": "/admin/article/getList",
                	'order' : ['0','aesc'],
			        "processing": true,
                	'columnDefs' :[{
                		'targets':-1,
                		'data':null,
                		"defaultContent":"<button class='btn btn-danger delete'>删除</button> <button class='btn btn-info  details'>编辑</button>",
                	},{
                		'targets':4,
                		"render":function(data,type,row) {
                			if(data == 1){
                				return " <select class='form-control is_show'  style='background:#449d44;color:white;'><option value='0'>隐藏</option><option value='1' selected>显示</option></select>"
                			}else{
                				return " <select class='form-control is_show'  style='background:#f0ad4e;color:white;'><option value='0' selected>隐藏</option><option value='1' >显示</option></select>"
                			}
                		}
                	}],
	        		"language": {
	                        "lengthMenu": "每页 _MENU_ 条记录",
	                        "zeroRecords": "没有找到记录",
	                        "info": "第 _PAGE_ 页 ( 总共 _PAGES_ 页 )",
	                        "infoEmpty": "无记录",
	                        "infoFiltered": "(从 _MAX_ 条记录过滤)",
	                    },
         			"lengthMenu": [[10, 30, 50, -1], [10, 30, 50, "All"]],
                });
               	//删除
               	$('#dataTables-example').on('click','.delete',function(){
               		if ( confirm('确认删除这篇文章？') ){
	               		$(this).parents('tr').addClass('selected');
	               		_id  = $(this).parents('tr').children('td').eq(0).text();
	               		$.post('/admin/article/deleting',{id:_id},function(data){
	               			if(data.code==200){
	               				table.row('.selected').remove().draw(false);
	               			}

	               		})

					}

               	})

                //编辑跳转
                $('#dataTables-example').on('click','.details',function(){
                	_id  = $(this).parents('tr').children('td').eq(0).text();
                	window.location.href="/addArt?id="+_id;
                })

                //更改状态
                $('#dataTables-example').on('change','.is_show',function(){
                	_val = $(this).val();
                	_id  = $(this).parents('tr').children('td').eq(0).text();
                	showToggle(_id,_val);
                	if(_val === '1'){
                		$(this).css('background','#449d44');
                	}else{
                		$(this).css('background','#f0ad4e');
                	}
                })


                function showToggle(id,val){
                	$.post('/admin/article/showToggle',{id:id,is_show:val},function(data){
                		console.log(data);
                	})
                }
            });