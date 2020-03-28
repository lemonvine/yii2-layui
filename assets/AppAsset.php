<?php

namespace lemon\assets;

use Yii;
use yii\web\AssetBundle;

class AppAsset extends AssetBundle
{
	public static $path = '@vendor/lemonvine/yii2-layui/dist';
	
	public $depends = [
		'yii\web\JqueryAsset',
	];
	
	public function init()
	{
		$this->sourcePath = self::$path;
		$postfix = YII_DEBUG ? '' : '.min';
		$version = Yii::$app->params['admin_version'];
		
		$this->js[] = "layui/layui{$postfix}.js?v=v{$version}";
		
		$this->css[] = "layui/css/layui{$postfix}.css?v=v{$version}";
		
		parent::init();
	}
	
	
	public static function loadModule($view, $modules){
		$directoryAsset = Yii::$app->assetManager->getPublishedUrl(self::$path);
		$postfix = YII_DEBUG ? '' : '.min';
		$version = Yii::$app->params['admin_version'];
		$depend = 'lemon\web\AdminlteAsset';
		$js = [];
		$css = [];
		$needs = [];
		if(!is_array($modules)){
			$needs[] = $modules;
		}
		else{
			$needs = $modules;
		}
		foreach ($needs as $module){
			switch ($module){
				case 'bootstraptable':
					$css[] = "plugins/bootstrap-table{$postfix}.css?v=v{$version}";
					$js[] = "plugins/bootstrap-table{$postfix}.js?v=v{$version}";
					break;
				case 'icheck':
					$css[] = "plugins/icheck-bootstrap{$postfix}.css?v=v{$version}";
					break;
				case 'handlebar':
					$js[] = "plugins/handlebars{$postfix}.js?v=v{$version}";
					break;
				case 'viewer':
					$css[] = "viewer/viewer{$postfix}.css?v=v{$version}";
					$js[] = "viewer/viewer{$postfix}.js?v=v{$version}";
					break;
				case 'datepicker':
					$js[] = "laydate/laydate{$postfix}.js?v=v{$version}";
					break;
				case 'ztree':
					$css[] = "ztree/css/ztree/ztree{$postfix}.css?v=v{$version}";
					$js[] = "ztree/js/jquery.ztree.all-3.5{$postfix}.js?v=v{$version}";
					break;
				case 'gallery':
					$css[] = "gallery/gallery{$postfix}.css?v=v{$version}";
					$js[] = "gallery/gallery{$postfix}.js?v=v{$version}";
					break;
				default:
					if(substr($module,0,2)=='js'){
						$js[] = "{$module}{$postfix}.js?v=v{$version}";
					}
					elseif(substr($module,0,3)=='css'){
						$css[] = "{$module}{$postfix}.js?v=v{$version}";
					}
					break;
			}
		}
		
		foreach ($css as $file){
			$view->registerCssFile($directoryAsset.DIRECTORY_SEPARATOR.$file, ['depends' => $depend]);
		}
		
		foreach ($js as $file){
			$view->registerJsFile($directoryAsset.DIRECTORY_SEPARATOR.$file, ['depends' => $depend]);
		}
		
	}
	
}
