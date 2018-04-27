<?php

/**
 * @Author: Administrator
 * @Date:   2018-04-18 15:25:24
 * @Last Modified by:   Administrator
 * @Last Modified time: 2018-04-26 08:57:33
 */
namespace app\admin\controller;
use Think\Session;
use Think\Request;
use think\Db;
/**
* 分类，配置控制器
*/
class Category extends AdminBase
{

	function __construct()
	{
		$this->loginAuthority();
	}

	//站点设置
	public function siteSetting()
	{
		header('Access-Control-Allow-Methods:POST');
        header("Access-Control-Allow-Origin:*");
        $data = $_POST;
        if ( !basicCheck('9001,9002,9003,9004,9005',$data)) process(400,'参数错误');
				$c = model('Category');

        foreach ($data as $k => $v) {
        	$add['id'] =$k;
        	$add['category'] = $v;
        	$c->add($add);
        }
        process(200);
	}


	//更新分类
	public function update()
	{
		header('Access-Control-Allow-Methods:POST');
        header("Access-Control-Allow-Origin:*");
        $data = $_POST;
        if( !basicCheck('id,category,pid,has_child',$data)) process(400,'参数错误');
        $c = model('Category');	

        if ( $c->add($data) ) process(200);

        process(500,'网络错误');

	}

	//更新分类
	public function addC()
	{
		header('Access-Control-Allow-Methods:POST');
        header("Access-Control-Allow-Origin:*");
        $data = $_POST;
        $c = model('Category');	
        
        if( !basicCheck('category,pid,has_child',$data)) process(400,'参数错误');
        $d = Db::table('cyt_category')->where('pid',$data['pid'])->order('id desc')->find();
        if(!$d) process(400,'非法访问');
        $data['id'] = $d['id']+1;

        if ( $c->add($data) ) process(200);

        process(500,'网络错误');

	}



	//删除分类
	public function delete()
	{
		header('Access-Control-Allow-Methods:POST');
        header("Access-Control-Allow-Origin:*");
        $data = $_POST;
        if( !basicCheck('id',$data)) process(400,'参数错误');
        $c = model('Category');
        
        if (!$c->where('id',$data['id'])->count() ) process(401,'非法访问');

        if ( $c->deleteC($data['id']) ) process(200);

        process(500,'网络错误');

	}




	//站点图片上传处理	
	public function logo()
	{
		header('Access-Control-Allow-Methods:POST');
        header("Access-Control-Allow-Origin:*");
		if(isset($_FILES['logo'])){
			$file = request()->file('logo');
			if($file){
				$info = $file->move(ROOT_PATH.'public'.DS.'uploads');
				if($info){

					$url = 'http://'.$_SERVER['HTTP_HOST'].'/uploads/'.date('Ymd',time()).'/'.$info->getFilename();
					$data['id'] = '9006';
					$data['category']= $url;
					$c = model('Category');
					if ( !$c->add($data) ) process(500,'网络错误');

					process(200,$url);
				}
			}
		}else if(isset($_FILES['qrcode'])){
			$file = request()->file('qrcode');
			if($file){
				$info = $file->move(ROOT_PATH.'public'.DS.'uploads');
				if($info){

					$url = 'http://'.$_SERVER['HTTP_HOST'].'/uploads/'.date('Ymd',time()).'/'.$info->getFilename();
					$data['id'] = '9007';
					$data['category']= $url;
					$c = model('Category');
					if ( !$c->add($data) ) process(500,'网络错误');

					process(200,$url);
				}
			}
		}
		
		process(500,'网络错误');
	}
}