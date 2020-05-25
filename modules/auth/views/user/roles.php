<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */

$this->title = '分配角色';

$all_role = $this->context->deliver['all_role'];
$self_role = $this->context->deliver['self_role'];
?>
<style>
	#li_role_list label{
		min-width: 250px;
		padding-left: 20px;
		min-height: 30px;
	}
</style>

<div class="container-fluid">
	<div class="row" id="li_role_list">
		<?php $form = ActiveForm::begin([
			'id' => 'main_form',
			'options' => ['class'=>'form-dash']
		]);?>
		<?= Html::checkboxList('userrole', $self_role, $all_role);?>
		<div class="form-btns">
		<?= Html::submitButton('保存', ['class' => 'btn btn-success','name' => 'success_save','value'=>'保存' ]) ?>
		</div>
		<?php ActiveForm::end();?>
	</div>
</div>