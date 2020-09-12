<?php

namespace melon\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class FrontAsset extends AssetBundle
{
	public $sourcePath = '@vendor/lemonvine/yii2-layui/dist';
	
	public $css = [
		'css/front.css',
		'css/flaticon.css'
	];
	public $js = [
		'bootstrap/bootstrap.bundle.js'
	];
	public $depends = [
		'yii\web\YiiAsset',
		'yii\bootstrap4\BootstrapAsset',
	];
}
