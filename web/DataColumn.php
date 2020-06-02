<?php

namespace melon\web;

use Yii;
use yii\helpers\Json;

class DataColumn extends \yii\grid\DataColumn
{
	public $width;
	public $sort;
	
	/**
	 * Renders the header cell.
	 */
	public function renderHeaderCell()
	{
		$layui=['field'=>$this->attribute];
		if(!empty($this->width)){
			$layui['width']=$this->width;
		}
		if(!empty($this->sort)){
			$layui['sort']=$this->sort;
		}
		$headerOptions = array_merge(['lay-data'=>Json::encode($layui)], $this->headerOptions);
		return Html::tag('th', $this->renderHeaderCellContent(), $headerOptions);
	}
	
	public function getLabel(){
		return $this->renderHeaderCellContent();
	}
	
}