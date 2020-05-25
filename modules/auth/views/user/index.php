<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use lemon\bootstrap4\ActiveForm;
use common\repository\Pattern;
use common\widgets\ButtonGroup;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\auth\models\AuthUserQuery */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '用户管理';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="card card-default">
	<div class="card-header"><i class="fa fa-search"></i> 查询</div>
	<div class="card-body">
		<?php $form = ActiveForm::begin([
		'action' => ['index'],
		'method' => 'get',
		'options' => ['class'=>'form-search', 'role'=>'form'],
		'fieldConfig'=>[
			'template'=>'<div class="flex">{label}{input}</div>',
			'options' => ['class' => 'form-group col-lg-3 col-md-4 col-sm-4 col-xs-6'],
		]]);?>
		<div class="container-fluid">
			<div class="row">
				<?= $form->field($searchModel, 'username') ?>
				<?= $form->field($searchModel, 'real_name') ?>
				<?= $form->field($searchModel, 'status')->dropDownList(Pattern::$CODE['status'], ['prompt'=>'全部']) ?>
				<?= ButtonGroup::SearchAddButton()?>
			</div>
		</div>
		<?php ActiveForm::end(); ?>
	</div>
</div>
<?= GridView::widget([
	'dataProvider' => $dataProvider,
	'pager' => ['class'=>'yii\bootstrap4\LinkPager'],
	'tableOptions' => ['class' => 'table table-striped table-bordered table-head-fixed'],
	'columns' => [
		'username',
		'real_name',
		'nick_name',
		['attribute' => 'status', 'format' => ['pattern', 'status']],
		['attribute' => 'created_at', 'format' => ['date', 'php:Y-m-d']],

		['class' => 'yii\grid\ActionColumn','template'=>'{update} {delete} {roles}', 'header' => '操作', 'buttons' => [
			'update' => function($url,$model,$key){
				$options = ['class' => 'btn btn-outline-primary modaldialog', 'data-url' => $url, 'data-title' => '编辑'];
				return Html::a('编辑', 'javascript:;', $options);
			},
			'delete' => function($url,$model,$key){
			$options = ['class' => 'btn btn-outline-danger confirmdialog', 'data-url' => $url, 'title' => '关闭', 'data-action' => 'post', 'data-word' => '您确定要关闭此用户吗？'];
				return Html::a('关闭', 'javascript:;', $options);
			},
			'roles' => function($url,$model,$key){
				$options = ['class' => 'btn btn-outline-success modaldialog', 'data-url' => $url, 'data-title' => '角色'];
				return Html::a('角色', 'javascript:;', $options);
			},
		]]
	],
]);?>