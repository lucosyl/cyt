<?php
namespace app\admin\model;

/**
 * @Author: Administrator
 * @Date:   2018-04-17 14:29:20
 * @Last Modified by:   Administrator
 * @Last Modified time: 2018-04-26 16:57:47
 */
use think\Model;
use think\Session;
use think\Db;
/**
* 分类模型
*/
class Category extends Model
{

	public function add($data){
		$c = new Category;
		$exist = $c->where('id',$data['id'])->count();

		if($exist){
			$data['updatetime'] = date('Y-m-d H:i:s');

			$res = $c->where('id',$data['id'])->update($data);
		}else{
			$data['createtime'] = date('Y-m-d H:i:s');
			$data['updatetime'] = date('Y-m-d H:i:s');

			$res = $c->save($data);
		}
		if( $res ) return true;
		return false;
	}

	public function getSec($id){
		$c = Db::table('cyt_category');
		$where['pid'] =$id;
		$data = $c->where($where)->field('id,category')->select();
		$res  = array();
		foreach ($data as $k => $v) {
			$res[$v['id']] = $v['category'];
		}
		return $res?$res:false;
	}

	public function getList($id,$onlyFirst='false'){
		$c = Db::table('cyt_category');
		
		$res = $c->where('pid',$id)->field('id,pid,category,updatetime,has_child,order,attach')->order('id asc')->select();
		$arr = array();
		

		if($onlyFirst == 'true'){
			$arr = $res;
		}else{
			if( $res ){
			foreach ($res as $k => $v) {
					$arr[] = $v;
					$arr = $this->getDown($v['id'],$arr);
				}
			}
		}
		return $arr?$arr:false;
	}

	//获取添加分类时的select
	public function getSelect($id)
	{
		$c   = Db::table('cyt_category');
		$where['has_child'] = '1';
		$where['pid']  = $id;
		$res = $c->where($where)->order('id asc')->select();
		$arr = array();
		foreach ($res as $k => $v) {
			//系统设置不在此列
			if($v['id'] !== 9){
				$arr[$v['id']] = $v['category'];
			}
		}
		return $arr?$arr:false;
	}




	private function getDown($id,$arr){
		$data =Db::table('cyt_category')->where('pid',$id)->field('id,pid,category,updatetime,has_child')->order('id asc')->select();
		if( $data ){
					foreach ($data as $key => $value) {
						$id = $value['id'];
						$value['id'] = $id;
						$arr[] = $value;
						$arr   = $this->getDown($id,$arr);
					}
		}
		return $arr;
	}

	public function deleteC($id){
		$c = new Category;
		$res = $c->where('id',$id)->delete();
		return $res?true:false;	
	}
}
