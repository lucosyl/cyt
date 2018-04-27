<?php
namespace app\index\controller;
use Think\request;
use think\Session;

/**
* 前台基类控制器
*/
class IndexBase 
{
	
	 function __construct()
	{

	}

	function actData()
	{
		$d = model('Act_data');
		$d->add();
	}
}


