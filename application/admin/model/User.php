<?php
namespace app\admin\model;
use think\Model;
use think\Session;

/**
 * @Author: Administrator
 * @Date:   2018-04-14 15:54:00
 * @Last Modified by:   Administrator
 * @Last Modified time: 2018-04-16 09:51:13
 */
/**
* 用户模型
*/
class User extends Model
{
	
	//自定义初始化
    protected function initialize()
    {
        //需要调用`Model`的`initialize`方法
        parent::initialize();
        //TODO:自定义的初始化
    }

	public function add($data)
	{
		$user = new User;
		if( isset($data['crsf']) ) unset( $data['crsf'] );
		
		$data['lastloginip'] = $_SERVER["REMOTE_ADDR"] ;

		if( isset($data['id']) && $data['id'] !== '' ){
			$data['lastlogintime'] = date('Y-m-d H:i:s',time());
			$where['id'] = $data['id'];
			if ( $user->where($where)->update($data) ){
				$userInfo = $user->where($where)->field('id,name,phone,email,lastloginip,lastlogintime')->find();
				Session::set('userInfo',$userInfo);
				return true;
			} 
		}else{
			$data['pwd'] = encrypt($data['pwd']);
			$data['createtime']  = date('Y-m-d H:i:s',time());
			if ( $user->save($data) ) return true;
		}
		return false;
	}
}