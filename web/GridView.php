<?php

namespace melon\web;

use Yii;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;

class GridView extends \yii\grid\GridView
{
	public $toolbar='<button class="layui-btn layui-btn-sm data-add-btn"> 添加 </button>';
	public $tableLayData=['page'=>'{limit: 5, count: 50}'];
	public $dataColumnClass="melon\web\DataColumn";
	public $tableOptions = ['class' => 'layui-table'];
	//public $headerRowOptions = ['lay-data'=>"{field:'username', width:100}"];
	//lay-data="{height:315, url:'/demo/table/user/', page:true, id:'test'}"
	public function init(){
		parent::init();
		$view = $this->getView();
		$view->layuis[]='table';
	}
	
	public function run()
	{
		if ($this->showOnEmpty || $this->dataProvider->getCount() > 0) {
			$content = preg_replace_callback('/{\\w+}/', function ($matches) {
				$content = $this->renderSection($matches[0]);
				
				return $content === false ? $matches[0] : $content;
			}, $this->layout);
		} else {
			$content = $this->renderEmpty();
		}
		echo $content;
		//$options = $this->options;
		//$tag = ArrayHelper::remove($options, 'tag', 'div');
		//echo Html::tag($tag, $content, $options);
	}
	/**
	 * Runs the widget.
	 */
	public function run0()
	{
		//$this->initColumns();
		$view = $this->getView();
		//GridViewAsset::register($view);
		$id = $this->options['id'];
		//$options = Json::htmlEncode(array_merge($this->getClientOptions(), ['filterOnFocusOut' => $this->filterOnFocusOut]));
		//$view->registerJs("jQuery('#$id').yiiGridView($options);");
		$js=<<<JS
JS;
		$view->registerJs($js);
		
		if ($this->showOnEmpty || $this->dataProvider->getCount() > 0) {
			$content = preg_replace_callback('/{\\w+}/', function ($matches) {
				$content = $this->renderSection($matches[0]);
				
				return $content === false ? $matches[0] : $content;
			}, $this->layout);
		} else {
			$content = $this->renderEmpty();
		}
		echo $content;
		/*
		$options = $this->options;
		$tag = ArrayHelper::remove($options, 'tag', 'div');
		echo Html::tag($tag, $content, $options);
		*/
		//parent::run();
	}
	
	
	/**
	 * Renders the data models for the grid view.
	 * @return string the HTML code of table
	 */
	public function renderItems()
	{
		/*
		$caption = $this->renderCaption();
		$columnGroup = $this->renderColumnGroup();
		$tableHeader = $this->showHeader ? $this->renderTableHeader() : false;
		$tableBody = $this->renderTableBody();
		
		$tableFooter = false;
		$tableFooterAfterBody = false;
		
		if ($this->showFooter) {
			if ($this->placeFooterAfterBody) {
				$tableFooterAfterBody = $this->renderTableFooter();
			} else {
				$tableFooter = $this->renderTableFooter();
			}
		}
		
		$content = array_filter([
			$caption,
			$columnGroup,
			$tableHeader,
			$tableFooter,
			$tableBody,
			$tableFooterAfterBody,
		]);
		*/
		$id = $this->options['id'];
		$this->tableOptions['id']=$id;
		if(!empty($this->toolbar)){
			$this->tableLayData['toolbar'] = Html::tag('div', $this->toolbar, ['class'=>'layui-btn-container']);
		}
		$this->tableLayData['url']='http://localhost:8082/auth/rule/data.html?m=MENU_3';
		//var_dump(Json::encode($this->tableLayData));die;
		$this->tableOptions['lay-data']=Json::encode($this->tableLayData);
		//var_dump($this->tableOptions);die;
		return parent::renderItems();
	}
}