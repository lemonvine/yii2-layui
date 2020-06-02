<?php
namespace melon\widgets;

use melon\web\ActiveForm;
use yii\helpers\Html;

class SearchForm extends ActiveForm
{
	public $fields;
	public $method = 'get';
	public $layout = self::LAYOUT_INLINE;
	public $options = ['class'=>'form-search'];
	public $fieldConfig=[
		'template'=>'{label}<div class="layui-input-inline">{input}</div>',
		//'options' => ['class' => 'layui-form-item layui-inline layui-col-lg3 layui-col-md4 layui-col-sm4 layui-col-xs6'],
		'options' => ['class' => 'layui-inline '],
	];
	
	
	
	public function run()
	{
		if (!empty($this->_fields)) {
			throw new \Exception('Each beginField() should have a matching endField() call.');
		}
		
		$content = ob_get_clean();
		//$html = Html::beginForm($this->action, $this->method, $this->options);
		//$html .= $content;
		$html='';
		$html .= $this->render('search', ['content'=>$content]);
		
		if ($this->enableClientScript) {
			$this->registerClientScript();
		}
		
		//$html .= Html::endForm();
		
		return $html;
	}
}