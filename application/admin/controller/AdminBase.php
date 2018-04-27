<?php
namespace app\admin\controller;
use think\request;
use think\Session;
/**
 * @Author: Administrator
 * @Date:   2018-04-14 14:15:25
 * @Last Modified by:   Administrator
 * @Last Modified time: 2018-04-26 08:57:38
 */

/**
* 后台基本控制器
*/
class AdminBase
{
	private $needLogin = array(
							'index',
							'logOut',
							'addArt',
							'articles',
							'category',
							'promotion',
							'setting',
								);

	private $withoutLogin = array(
							'logining',
							'registering',
							'login',
								);

	private $needLoginC   = array(
						'Article',
						'Category',
						'Promotion',
					);

	function _initialize()
	{
		# code...
	}

	public function loginAuthority()
	{
		$request = Request::instance();
		$action = $request->action();
		$controller = $request->controller();

		$this->userInfo = Session::get('userInfo');
		// session::delete('userInfo');

		//登录后才能访问的页面，无权限跳转登录
		if( in_array($action, $this->needLogin) && in_array($controller, $this->needLoginC)){
			if( !$this->userInfo && $this->userInfo == null){
				redirect('/login');die;
			}
		}


		//未登录允许访问的页面及功能，无权限跳转后台首页
		if( in_array($action, $this->withoutLogin )){
			if( $this->userInfo && $this->userInfo !== null){
				redirect('/homes');die;
			}
		}

	}


}