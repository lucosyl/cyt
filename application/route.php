<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\Route;
//后台
Route::rule('/login','admin/admin/login');
Route::rule('/homes','admin/admin/index');
Route::rule('/logOut','admin/admin/logOut');
Route::rule('/articles','admin/admin/articles');
Route::rule('/addArt','admin/admin/addArt');
Route::rule('/category','admin/admin/category');
Route::rule('/setting','admin/admin/setting');
Route::rule('/promotion','admin/admin/promotion');
Route::rule('/addC','admin/category/addC');

//前台
Route::rule('/index','index/index/index');

