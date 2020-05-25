<?php

use yii\helpers\Html;
use lemon\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\auth\models\LogOperate */
/* @var $form lemon\bootstrap4\ActiveForm */

?>

<div class="log-operate-form">

	<?php $form = ActiveForm::begin([
			'id' => 'form-log-operate',
			'layout' => 'horizontal'
			
		]); 
	?>

	<?= $form->field($model, 'type')->textInput() ?>

	<?= $form->field($model, 'content')->textInput(['maxlength' => true]) ?>

	<?= $form->field($model, 'operator_id')->textInput() ?>

	<?= $form->field($model, 'create_at')->textInput() ?>

	<div class="form-group text-right btn_zone">
		<?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
	</div>

	<?php ActiveForm::end(); ?>

</div>
