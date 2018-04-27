<?php
namespace app\admin\controller;
use Think\Session;
use Think\Request;
use think\Db;
/**
 * @Author: larsun
 * @Date:   2018-04-16 16:05:45
 * @Last Modified by:   Administrator
 * @Last Modified time: 2018-04-19 10:47:27
 */
/**
* 
*/
class Article extends AdminBase
{
	
	function __construct()
	{
		$this->loginAuthority();
	}

	//添加文章
	public function adding()
	{
		header('Access-Control-Allow-Methods:POST');
        header("Access-Control-Allow-Origin:*");
        $data = $_POST;
        if( !confirmCrsf($data['crsf']) || !isset($data['crsf']) ) process(400,'当前页面停留时间过长,请刷新后重新提交');
        if ( !basicCheck('title,label,content,crsf,category,is_show',$data) ) process(401,'提交参数错误');

        unset($data['crsf']);

        $a = model('Article');
        if ($a->add($data)) process('200');
        process(500,'网络错误');
	}

	public function deleting(){
		header('Access-Control-Allow-Methods:POST');
        header("Access-Control-Allow-Origin:*");
        $data = $_POST;
        if(!basicCheck('id',$data)) process(401,'提交参数错误');
        $a = model('Article');
        if ( !$a->where('id',$data['id'])->find()) process(402,'非法请求');
        if ( $a->deleting($data['id']) ) process(200);
        process(500,'网络错误');

	}


	//改变是否在显示状态
	public function showToggle()
	{
		header('Access-Control-Allow-Methods:POST');
        header("Access-Control-Allow-Origin:*");
        $data = $_POST;
        if(!basicCheck('id,is_show',$data)) process(401,'提交参数错误');
        $a = model('Article');
        if ( !$a->where('id',$data['id'])->find()) process(402,'非法请求');

        if ( $a->add($data) ) process(200);
        process(500,'网络错误');

	}


	//dataTable列表数据
	public function getList()
	{	
		$c   = model('category');
		$cate   = $c->getSec(1);
		$a   = Db::table('cyt_article');
		$res = array();
		$data = $a->field('id,title,label,category,is_show')->select();
			foreach ($data as $k => $v) {
				foreach ($v as $key => $val) {
					if( $key == 'category'){
						$val = $cate[$val];
					}
					$res['data'][$k][]=$val;

				}
			}

		header('Content-Type:application/json;charset=utf-8');

		die(json_encode($res));
	}


	//summerNote 上传图片;
	public function uploadImg()
	{
		header('Access-Control-Allow-Methods:POST');
        header("Access-Control-Allow-Origin:*");
		$file = request()->file('ajaxTaskFile');
	    if(!isset($_FILES['ajaxTaskFile'])){
	         process('403','非法请求');
	    }
	     if($file){
	        $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
	        if($info){
	            // 成功上传后 获取上传信息
	            // 输出 jpg
	            // echo $info->getExtension();
	            // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
	            // echo $info->getSaveName();
	            // 输出 42a79759f284b767dfcb2a0197904287.jpg
	            // echo $info->getFilename(); 
				process(200,'http://cyt.com/uploads/'.date('Ymd',time()).'/'.$info->getFilename());

	        }else{
	            // 上传失败获取错误信息
	            process(500,$file->getError());
	        }
	    }

	}
}