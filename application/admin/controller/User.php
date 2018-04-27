<?php
namespace app\admin\controller;
/**
 * @Author: Administrator
 * @Date:   2018-04-14 16:33:35
 * @Last Modified by:   Administrator
 * @Last Modified time: 2018-04-16 17:26:00
 */
/**
* 用户控制器
*/
class User extends AdminBase
{
	
	public function _initialize()
	{
		$this->loginAuthority();
	}

	
	public function registering()
	{
        	header('Access-Control-Allow-Methods:POST');
                header("Access-Control-Allow-Origin:*");
                $data = $_POST;
                if($data['rpassword'] == '' || $data['crsf'] == '' || $data['name'] == '' || $data['email'] == ''|| $data['phone'] == '') process(400,'参数错误');
                $u = model('User');
                if( !confirmCrsf($data['crsf']) ) process(401,'当前页面停留时间过长,请刷新页面后提交');

                if( $u->where('name',$data['name'])->find()) process(402,'当前账户已存在');

                $data['pwd'] = $data['rpassword'];
                unset($data['rpassword']);
                if ( $u->add($data) ) process(200);
                process(500,'网络错误');
	}

	public function logining()
	{
		header('Access-Control-Allow-Methods:POST');
                header("Access-Control-Allow-Origin:*");
                $data = $_POST;
                if($data['lpassword'] == '' || $data['crsf'] == '' || $data['username'] == '') process(400,'参数错误');
                if( !confirmCrsf($data['crsf']) ) process(401,'当前页面停留时间过长,请刷新页面后提交');
                $u = model('User');
                $where['name']= $data['username'];
        		$user = $u->where($where)->find();
                if( !$user ) process(402,'账户错误');
                if( !encrypt($data['lpassword'],$user['pwd']) )process(402,'密码错误');
                $arr['id'] = $user['id'];
                if( $u->add($arr) ) process(200);
                process(500,'网络错误');


	}

}