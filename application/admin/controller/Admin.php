<?php
namespace app\admin\controller;
use Think\Session;
use Think\Request;
/**
 * @Author: larsun  后台
 * @Date:   2018-04-14 14:13:17
 * @Last Modified by:   Administrator
 * @Last Modified time: 2018-04-26 16:58:22
 */
/**
* 后台控制器
*/
class Admin extends AdminBase
{
	function __construct()
	{
		$this->loginAuthority();
	}

	public function index()
	{	
		$act = model('Index/ActData');
		$art = model("Admin/Article");
		$a['all'] = $act->count();
		$a['today'] =$act->whereTime('act_time','today')->count();
		$a['article'] = $art->count();
		$a['comment'] = '32';


		$view['title'] = '承御堂 | 后台首页';
		$view['css']   = array('index/morris','index/styles','index/cssCharts');
		$view['js']    = array('index/custom-scripts','index/easypiechart','index/easypiechart-data','index/jquery.chart','index/jquery.metisMenu','index/morris','index/raphael-2.1.0.min');
		$arr = setView($view);
		$arr['userInfo'] = Session::get('userInfo');
		$arr['data']     = $a;
		$arr['action']   = Request::instance()->action();
		return view('',$arr);
	}

	
	public function category()
	{
		//页面属性
		$view['css']     = array('index/styles','public','category/category');
		$view['js']      = array('article/custom-scripts','index/jquery.metisMenu','public');
		$arr = setView($view);
		$arr['title']    = '分类管理';
		$arr['action']   = Request::instance()->action();
		$arr['userInfo'] = Session::get('userInfo');
		$c = model('Category');
		$arr['article'] = $c->getList(1);
		$arr['product'] = $c->getList(2);
		$arr['navigator'] = $c->getList(3,true);
		// dump($arr);die;
		$arr['select']  = $c->getSelect(2);
		$arr['selecting']  = $c->getSelect(2001);

		return view('',$arr);
	}


	public function promotion()
	{
		//页面属性
		$view['css']     = array('index/styles','public');
		$view['js']      = array('article/custom-scripts','index/jquery.metisMenu','public');
		$arr = setView($view);
		$arr['title']    = '推广页管理';
		$arr['action']   = Request::instance()->action();
		$arr['userInfo'] = Session::get('userInfo');

		return view('',$arr);
	}

	public function setting()
	{
		//页面属性
		$view['css']     = array('index/styles','public');
		$view['js']      = array('article/custom-scripts','index/jquery.metisMenu','public','category/setting');
		$arr = setView($view);
		$arr['title']    = '网站配置';
		$arr['action']   = Request::instance()->action();
		$arr['userInfo'] = Session::get('userInfo');
		$arr['crsf']     = crsf();
		$c = model('Category');
		$arr['cate']     = $c->getSec(9);

		return view('',$arr);
	}


	public function articles()
	{
		//页面属性
		$view['css']     = array('index/styles','public','table/dataTables');
		$view['js']      = array('article/custom-scripts','index/jquery.metisMenu','public','table/jquery','table/dataTables','article/articles');
		$arr = setView($view);
		$arr['userInfo'] = Session::get('userInfo');
		$arr['title']    = '文章列表';
		$arr['action']   = Request::instance()->action();


		return view('',$arr);
	}

	public function addArt($id='')
	{	
		
		$view['css']   = array('index/morris','index/styles','index/cssCharts','article/summernote','public');
		$view['js']    = array('article/custom-scripts','index/jquery.metisMenu','article/summernote.min','article/summernote-zh-CN.min','public','article/add_art');
		$arr = setView($view);
		$arr['userInfo'] = Session::get('userInfo');
		$arr['title'] 	 = '添加文章';
		$arr['action']   = Request::instance()->action();
		$arr['crsf']     = crsf();
		//获取编辑文章
		$a = model('Article');
		if(isset($id) && $id!==''){
			$arr['edit'] = $a->getDetail($id);
		}
		//获取文章分类
		$c = model('Category');
		$arr['cate']     = $c->getSec(1);
		return view('',$arr);
	}

	public function login()
	{

		$view['css'] = array('login/style');
		$view['js'] = array('login/login');
		$arr = setView($view);
		$arr['crsf'] = crsf();
		return view('',$arr);
	}

	public function logOut()
	{
		Session::delete('userInfo');
		redirect('/login');
	}
}