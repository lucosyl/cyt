<?php

/**
 * @Author: Administrator
 * @Date:   2018-04-26 08:46:36
 * @Last Modified by:   Administrator
 * @Last Modified time: 2018-04-26 09:59:33
 */
namespace app\admin\controller;
use think\Db;
use think\Request;
use think\Session;

/**
*推广页管理
*/
class Promotion extends AdminBase
{
	function __construct()
	{
		$this->loginAuthority();
	}


	public function newLink()
	{
		$user = 'admin';
		$pass = 'cs5680com';
		$submit = '立即登录';
		$post_fields = "user_name={$user}&user_password={$pass}&submit={$submit}";
		$res =postCurl("http://yc.jasrui.com/admin/login.php",$post_fields);
		dump($res);die;


		$url ="http://yc.jasrui.com/admin/index.php?act=add";
		$data = array(
				'type'=> 3,
				'www_url' => "http://www.baidu.com",
				'e_time'  =>  date('Y-m-d'),
				'text'    =>  'jam',
				'submit'  =>  '提交'
				);

		$res = postCurl($url,$data);
		dump($res);die;

   	}
	

}