<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace melon\web;

use Yii;
use yii\base\InvalidConfigException;

class ActiveForm extends \yii\widgets\ActiveForm
{
	/**
	 * Default form layout
	 */
	const LAYOUT_DEFAULT = 'default';
	/**
	 * Horizontal form layout
	 */
	const LAYOUT_HORIZONTAL = 'horizontal';
	/**
	 * Inline form layout
	 */
	const LAYOUT_INLINE = 'inline';

	/**
	 * @var string the default field class name when calling [[field()]] to create a new field.
	 * @see fieldConfig
	 */
	public $fieldClass = 'melon\web\ActiveField';
	/**
	 * @var array HTML attributes for the form tag. Default is `[]`.
	 */
	public $options = [];
	/**
	 * @var string the form layout. Either [[LAYOUT_DEFAULT]], [[LAYOUT_HORIZONTAL]] or [[LAYOUT_INLINE]].
	 * By choosing a layout, an appropriate default field configuration is applied. This will
	 * render the form fields with slightly different markup for each layout. You can
	 * override these defaults through [[fieldConfig]].
	 * @see \yii\bootstrap4\ActiveField for details on Bootstrap 4 field configuration
	 */
	public $layout = self::LAYOUT_DEFAULT;
	/**
	 * @var string the CSS class that is added to a field container when the associated attribute has validation error.
	 */
	public $errorCssClass = 'is-invalid';
	/**
	 * {@inheritdoc}
	 */
	public $successCssClass = 'is-valid';
	/**
	 * {@inheritdoc}
	 */
	public $errorSummaryCssClass = 'alert alert-danger';
	/**
	 * {@inheritdoc}
	 */
	public $validationStateOn = self::VALIDATION_STATE_ON_INPUT;


	/**
	 * {@inheritdoc}
	 * @throws InvalidConfigException
	 */
	public function init()
	{
		if (!in_array($this->layout, [self::LAYOUT_DEFAULT, self::LAYOUT_HORIZONTAL, self::LAYOUT_INLINE])) {
			throw new InvalidConfigException('Invalid layout type: ' . $this->layout);
		}

		if ($this->layout === self::LAYOUT_INLINE) {
			Html::addCssClass($this->options, 'form-inline');
		}
		
		parent::init();
		
		if (isset($this->options['class'])) {
			$this->options['class'] = 'layui-form '.$this->options['class'];
		}else{
			$this->options['class'] = 'layui-form';
		}
	}

	/**
	 * {@inheritdoc}
	 * @return \yii\widgets\ActiveField
	 */
	public function field($model, $attribute, $options = [])
	{
		return parent::field($model, $attribute, $options);
	}
}
