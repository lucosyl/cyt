<?php

/**
 * @Author: Administrator
 * @Date:   2018-04-16 13:39:58
 * @Last Modified by:   Administrator
 * @Last Modified time: 2018-04-17 16:59:41
 */
namespace app\admin\model;
use think\Model;
use think\Session;
use think\Db;
/**
* 用户操作跟踪
*/
class Article extends Model
{

	public function add($data)
	{
		$a = new Article;
		if(!isset($data['id'])){
			$data['createtime'] = date('Y-m-d H:i:s');
			$data['uid'] = Session::get('userInfo.id');
			if ( $a->save($data) ) return true;
		}else{
			$data['updatetime'] = date('Y-m-d H:i:s');
			$where['id']=$data['id'];
			$res = $a->where($where)->update($data);
			if($res) return true;
		}

		return false;
	}

	public function getDetail($id){
		$a = Db::table('cyt_article');
		$data = $a->where('id',$id)->field('id,title,label,is_show,category,author,click_num,content,source')->find();
		return $data?$data:false;
	}

	public function deleting($id){
		$a = Db::table('cyt_article');
		$res = $a->where('id',$id)->delete();
		if( $res ){
			return true;
		}
		return false;
	}

}