<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\auth\models\LogOperateQuery */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-operate-index">
	<?=  $this->render('_search', ['model' => $searchModel]); ?>

	<?= GridView::widget([
		'dataProvider' => $dataProvider,
		'pager' => ['class'=>'yii\bootstrap4\LinkPager'],
		'tableOptions' => ['class' => 'table table-striped table-bordered table-head-fixed'],
		'columns' => [

			'id',
			'type:logoperate',
			'content:omit10',
				['attribute'=>'real_name', 'label'=>'操作人'],
				['attribute'=>'create_at', 'format'=>['date', 'php:Y-m-d H:i:s']],

			['class' => 'yii\grid\ActionColumn','template'=>'{view}','header' => '操作','buttons' => [
				'view' => function($url,$model,$key){
				
					return Html::a('详情',
						'javascript:;', [
								'class' => 'js-open-window mcch-color-red',
								'onclick' => 'openDialog(this)',
								'data-content' => $model->content
						]);
				},
			]]
		],
	]); ?>
</div>
<script type="text/javascript">
	function openDialog(obj){
		var _content = $(obj).data('content');
		layer.alert(_content,{
			title:"操作详情", 
			skin:'layer-alert-reson', 
			area: ['800px', '400px'],
			resize: false,
			move: false});
	}
</script>