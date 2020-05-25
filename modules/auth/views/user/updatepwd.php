<?php

use yii\helpers\Html;
use lemon\bootstrap4\ActiveForm;
use kartik\password\PasswordInput;

/* @var $this yii\web\View */
/* @var $model common\models\AdminUser */

?>

<div class="admin-user-form">
	<?php $form = ActiveForm::begin([
		'options' => ['class'=>'mcch-table reset_password'],
		'enableClientValidation'=>true,
		'fieldConfig'=>[
			'template'=>'{input}{error}',
			'options' => ['class' => ''],
		]
	]); ?>
	
	<?= $form->field($model, 'old_pwd')->passwordInput(['placeholder' =>'请输入原密码']) ?>
	
	<?= $form->field($model, 'new_pwd')->widget(PasswordInput::classname(), [
		'options' => ['placeholder' => '请输入新密码',
			'type' => 'password',
			'class'=>'form-control', 
			'autocomplete' => 'new-password', 
			'pluginOptions' => ['toggleMask' => false],]
		]);
	?>
	<p>大写字母、小写字母、数字、特殊字符，四种包括三种，长度8~30</p>
	
	<?= $form->field($model, 'confirm_pwd')->passwordInput(['placeholder' =>'请再次输入新密码']) ?>
	
	<div class="form-group text-center btns-line">
		<br><br>
		<?= Html::submitButton('确认', ['class' => 'btn btn-primary']) ?>
	</div>
	
	<?php ActiveForm::end(); ?>
</div>