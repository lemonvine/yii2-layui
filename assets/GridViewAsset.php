<?php

namespace melon\assets;

use yii\web\AssetBundle;

class GridViewAsset extends AssetBundle
{
	public $sourcePath = '@vendor/lemonvine/yii2-layui/dist';
	public $js = [
		'js/melon.gridview.js',
	];
	public $depends = [
		'melon\assets\AppAsset',
	];
}
