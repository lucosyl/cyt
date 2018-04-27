<?php

/**
 * @Author: Administrator
 * @Date:   2018-04-16 11:30:30
 * @Last Modified by:   Administrator
 * @Last Modified time: 2018-04-16 13:44:55
 */
namespace app\index\model;
use think\Model;
use think\Session;
use think\Request;
/**
* 用户操作跟踪
*/
class ActData extends Model
{

	public function add()
	{
		$act  = new ActData;
		$user = Session::has('user');
		$request = Request::instance();
		$a = $request->action();
		$c = $request->controller();
		if ( $user ){
			$data['uid'] = Session::get('user.id');
		}
		$data['action']   = $c."/".$a;
		$data['act_time'] = date('Y-m-d H:i:s',time());
		$data['act_ip']   = $_SERVER['REMOTE_ADDR'];
		$res = $act->save($data);
		if( !$res ) proccess(500,'网络错误');
	}

}