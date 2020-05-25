<?php

use lemon\bootstrap4\ActiveForm;
use kartik\datecontrol\DateControl;
use backend\repository\Regular;
use common\widgets\btns\SearchBtns;

/* @var $this yii\web\View */
/* @var $model backend\modules\auth\models\LogOperateQuery */
/* @var $form yii\widgets\ActiveForm */

date_default_timezone_set('Asia/Shanghai');
?>

<div class="log-operate-search">

	<?php $form = ActiveForm::begin([
		'action' => ['index'],
		'method' => 'get',

		'options' => ['class'=>'form-search',],
		'fieldConfig'=>[
				'template'=>'{label}{input}',
				'options' => ['class' => 'form-group col-lg-3 col-md-4 col-sm-4 col-xs-6'],
		]]);
		?>

	
	<div class="card card-default">
		<div class="card-header">查询</div>
		<div class="card-body">
			<div class="row">
				<?= $form->field($model, 'type')->dropDownList(Regular::$CODE[''], ['prompt'=>'全部']) ?>
				<?= $form->field($model, 'create_at')->widget(DateControl::classname(), ['type' => DateControl::FORMAT_DATE, 'ajaxConversion' => true,'widgetOptions'=>['options'=>['placeholder'=>'操作日期']]]);?>
				
				<?= SearchBtns::widget()?>
			</div>
		</div>
	</div>

	<?php ActiveForm::end(); ?>

</div>
