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
	public $layuis=[];
	
	public $searchFieldConfig=[
		'template'=>'<div class="flex">{label}{input}</div>',
		'options' => ['class' => 'layui-form-item layui-col-lg3 layui-col-md4 layui-col-sm4 layui-col-xs6'],
	];
	
	public function init(){
		$this->layuis[]='element';
		$this->layuis[]='layer';
		$this->layuis[]='layuimini';
		parent::init();
	}
	
	protected function renderBodyEndHtml($ajaxMode)
	{
		$lines = [];
		
		if (!empty($this->jsFiles[self::POS_END])) {
			$lines[] = implode("\n", $this->jsFiles[self::POS_END]);
		}
		
		if ($ajaxMode) {
			$scripts = [];
			if (!empty($this->js[self::POS_END])) {
				$scripts[] = implode("\n", $this->js[self::POS_END]);
			}
			if (!empty($this->js[self::POS_READY])) {
				$scripts[] = implode("\n", $this->js[self::POS_READY]);
			}
			if (!empty($this->js[self::POS_LOAD])) {
				$scripts[] = implode("\n", $this->js[self::POS_LOAD]);
			}
			if (!empty($scripts)) {
				$lines[] = Html::script(implode("\n", $scripts));
			}
		} else {
			if (!empty($this->js[self::POS_END])) {
				$lines[] = Html::script(implode("\n", $this->js[self::POS_END]));
			}
			if (!empty($this->js[self::POS_READY])) {
				$layuis = array_unique($this->layuis);
				$modules = "";
				$vars = "var $ = layui.jquery, ";
				foreach ($layuis as $layui){
					$seprate = ',';
					if(empty($modules)){
						$seprate = '';
					}
					$modules .= "{$seprate}'{$layui}'";
					$vars .= "{$seprate}{$layui}=layui.{$layui}";
				}
				$js = "layui.use([$modules], function(){
					$vars;
					".implode("\n", $this->js[self::POS_READY])."
				
				});";
				//$js = "jQuery(function ($) {\n" . implode("\n", $this->js[self::POS_READY]) . "\n});";
				$lines[] = Html::script($js, ['type'=>'text/javascript']);
			}
			if (!empty($this->js[self::POS_LOAD])) {
				$js = "jQuery(window).on('load', function () {\n" . implode("\n", $this->js[self::POS_LOAD]) . "\n});";
				$lines[] = Html::script($js);
			}
		}
		
		return empty($lines) ? '' : implode("\n", $lines);
		
	}
}

