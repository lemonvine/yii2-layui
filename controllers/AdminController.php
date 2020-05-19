<?php
namespace melon\controllers;

use yii\web\Controller;

/*
 * 后台管理员控制器基类
 */
class AdminController extends Controller
{
	public $layout='@vendor/lemonvine/yii2-layui/layouts/layui-main';
	public $u;
	public $m='';
	public $user_id=0;
	public $operate= 1;
	public $message="";
	public $primary=''; //当前页面首次打开时的路径，用于查询提交
	public $referer=''; //跳转源，用于返回按钮
	public $deliver=[];
	public $submit_type='';

}