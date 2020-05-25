<?php
namespace melon\web;

/**
 * 继承View,增加常用代码归置
 * @author shaodd
 *
 */
class View extends \yii\web\View
{
	public $breadcrumbs= [];
	
	public $searchFieldConfig=[
		'template'=>'<div class="flex">{label}{input}</div>',
		'options' => ['class' => 'layui-form-item layui-col-lg3 layui-col-md4 layui-col-sm4 layui-col-xs6'],
	];
}

