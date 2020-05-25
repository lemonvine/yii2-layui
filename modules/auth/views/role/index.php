<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use lemon\bootstrap4\ActiveForm;
use common\widgets\ButtonGroup;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\auth\models\AuthItemQuery */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '角色列表';

$this->params['breadcrumbs'][] = $this->title;
?>

<div class="card card-default">
	<div class="card-header"><i class="fa fa-search"></i> 查询</div>
	<div class="card-body">
	<?php $form = ActiveForm::begin([
		'action' => ['index'],
		'method' => 'get',
		'options' => ['class'=>'form-search'],
		'fieldConfig'=>[
				'template'=>'<div class="flex">{label}{input}</div>',
				'options' => ['class' => 'form-group col-lg-3 col-md-4 col-sm-4 col-xs-6'],
		]
	]); ?>
		<div class="container-fluid">
			<div class="row">
				<?= $form->field($searchModel, 'name') ?>
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
		['attribute'=>'name', 'label'=>'角色编号'],
		['attribute'=>'description', 'label'=>'角色名称'],
		['attribute'=>'created_at','format'=>['date','php:Y-m-d']],
		['class' => 'yii\grid\ActionColumn','template'=>'{update} {privilage}',
			'buttons' => [
				'update' => function($url, $model, $key){
					$options = ['class' => 'btn btn-primary modaldialog', 'data-url' => $url, 'data-title' => '编辑',];
					return Html::a('编辑', 'javascript:;', $options);
				 },
				 'privilage' => function($url, $model, $key){
					$options = ['class' => 'btn btn-info modaldialog', 'data-url' => $url, 'data-title' => '角色权限'];
					return Html::a('<i class="glyphicon glyphicon-cog"></i> 权限', 'javascript:;', $options);
				}
			]
		],
	],
]); ?>




