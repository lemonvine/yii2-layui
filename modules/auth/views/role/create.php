<?php

use yii\helpers\Html;
use lemon\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\auth\models\AuthItem */

$this->title = '';
$this->params['breadcrumbs'][] = ['label' => '角色列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="auth-item-form">

	<?php $form = ActiveForm::begin([
			'id' => 'form-auth-item',
			'layout' => 'horizontal'
			
		]); 
	?>

	<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

	<?= $form->field($model, 'description')->textarea() ?>

	<div class="form-group text-center">
		<?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
	</div>

	<?php ActiveForm::end(); ?>

</div>
