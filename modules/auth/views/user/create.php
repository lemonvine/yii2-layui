<?php

use yii\helpers\Url;
use yii\helpers\Html;
use lemon\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\auth\models\AuthUser */

$this->title = '';
?>
<div class="container-fluid">
	<?php $form = ActiveForm::begin([
		'id' => 'main-form',
		'options' => ['class'=>'form-dash'],
		'layout' => 'horizontal'
		
	]);
	?>
	<?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
	<?= $form->field($model, 'password', [
		'addon' => [
			'append' => [
				'content' => Html::button('生成', ['class'=>'btn btn-primary', 'onclick'=>'onMakePwd()']), 
				'asButton' => true
			]
		]
	])->label('密码')->textInput(['maxlength' => true, 'id'=>'std_password']) ?>
	<?= $form->field($model, 'real_name')->textInput(['maxlength' => true]) ?>
	<?= $form->field($model, 'nick_name')->textInput(['maxlength' => true]) ?>
	<?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
	<?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
	<div class="form-group form-btns">
		<?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
	</div>
	<?php ActiveForm::end(); ?>
</div>
<script type="text/javascript">
function onMakePwd(){
	$.ajax({url:"<?=Url::toRoute(['/site/password'])?>", success: function(redata){
		if(redata.status==201){
			$("#std_password").val(redata.data);
		}
	}});
}
</script>