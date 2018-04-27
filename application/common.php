<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: Larsun <larsun@qq.com>
// +----------------------------------------------------------------------
use think\config;
// 应用公共文件

	//表单令牌
	function crsf(){
		
		// $cacheCode = cache('formCode');
		// if( !$cacheCode){
			$safe = md5('larsun'.(time()/2));
			cache('formCode',$safe,1000);
		// }
		return (cache('formCode') );
	}

	function basicCheck($str,$data)
	{
		$arr = explode(',',$str);
		foreach ($arr as $k => $v) {
			if( !isset($data[$v]) || $data[$v] == ''){
				return false;
			}
		}
		return true;
	}

	function confirmCrsf($param)
	{
		if ( $param == cache('formCode') ){
			return true;
		}

		return false;
	}

	//密码加密规则
	function encrypt($str,$check='false')
	{
		
		$key = config::get('pwd_salt');;
		$str = substr(md5($str,1), 5, 8);
		$key = substr(md5($key,1), 10, 8);
		$res = password_hash($str.$key,1);
		if( $check !== 'false'){
			if ( password_verify($str.$key,$check) ){
				return true;
			}else{
				return  false;
			}
		}
		
		return $res;
	}

	//ajax 消息提示返回
	function process($code, $message='', $url="", $urlInfo="" )
	{
		if( $code == 200 && $message==''){
			$arr['code']    = 200;
			$arr['message'] = '操作成功';
		}else{
			$arr['code'] = $code;
			$arr['message'] = $message;
		}

		$arr['url'] = $url;
		$arr['urlInfo'] = $urlInfo;

		header('Content-Type:application/json;charset=utf-8');
        die( json_encode($arr) );
	}


	function provide($code, $data='', $extra="")
	{
		if( $code == 200 && $data==''){
			$arr['code']    = 200;
			$arr['data'] = '操作成功';
		}else{
			$arr['code'] = $code;
			$arr['data'] = $data;
		}

		$arr['extra'] = $extra;

		header('Content-Type:application/json;charset=utf-8');
        die( json_encode($arr) );
	}

	//链接跳转
	function redirect($url){
		echo "<script>location.href='".$url."'</script>";
	}


	//加载css,js 文件
	function setView($data=""){
		
		//公用js,css
		$view= array(
			'css' => array('font-awesome.min','bootstrap'),
			'js'  => array('jquery-1.11.1.min','public','bootstrap.min'),
		);

		//加入页面js,css
		if( isset( $data['js'] ) && is_array( $data ) )
		{
			$view['js'] = array_merge($view['js'],$data['js']);
		} 
		if( isset($data['css']) ){
			$view['css'] = array_merge( $view['css'], $data['css'] );
		}
		//拼装css
		$tempcss = '';
		
		foreach ($view['css'] as $k => $v) {
			$tempcss .= '<link rel="stylesheet" href="/admin/css/'.$v.'.css" />'.PHP_EOL;
		}

		//加上谷歌字体css
		$tempcss = $tempcss."<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Roboto+Condensed:400,300,300italic,400italic,700,700italic%27%20rel=%27stylesheet'>".PHP_EOL;

		$res['css'] = $tempcss;
		//设置页面标题
		if( isset($data['title']) ){
			$res['title'] = $data['title'];
		}
		//拼装js	

		$temjs = '';

		foreach ($view['js'] as $key => $value) {
			$temjs .= "<script src='/admin/js/".$value.".js' ></script>".PHP_EOL;
		}

		$res['js'] = $temjs;

		return $res;

	}


	function postCurl($url,$post_data)
	{
		$curl = curl_init();
		$strCookie="PHPSESSID=".$_COOKIE['PHPSESSID'];   
		session_write_close(); 
	    //设置抓取的url
        curl_setopt($curl, CURLOPT_URL, $url);
        //设置头文件的信息作为数据流输出
        // curl_setopt($curl, CURLOPT_HEADER, 1);

        curl_setopt($curl, CURLOPT_COOKIE, $strCookie);
        //设置获取的信息以文件流的形式返回，而不是直接输出。
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        //设置post方式提交
        curl_setopt($curl, CURLOPT_POST, 1);
       //设置post数据
 
    	curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
     	//执行命令
    	$data = curl_exec($curl);
     	//关闭URL请求
     	curl_close($curl);
     	echo $strCookie;  
     	//显示获得的数据
     	return ($data)?$data:false;
	}
