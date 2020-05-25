<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\auth\models\LogOperate */

$this->title = '详情';
$this->params['breadcrumbs'][] = ['label' => 'Log Operates', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-operate-view">
	
	<?php  echo Html::a('返回', Yii::$app->request->getReferrer(), [
			'class' => 'btn btn-default btn-sm',
		]); ?>

	<?= DetailView::widget([
		'model' => $model,
		'attributes' => [
			'id',
			'type',
			'content',
			'operator_id',
			'create_at',
		],
	]) ?>

</div>
