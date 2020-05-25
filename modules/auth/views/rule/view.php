<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\auth\models\AuthRule */

$this->title = $model->menu_name;
$this->params['breadcrumbs'][] = ['label' => '菜单管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-rule-view">
	
	<?php echo Html::a('返回', Yii::$app->request->getReferrer(), [
			'class' => 'btn btn-default btn-sm',
		]); ?>
	
	<h1><?= Html::encode($this->title) ?></h1>

	<?= DetailView::widget([
		'model' => $model,
		'attributes' => [
			'rule_id',
			'name',
			'data',
			'description',
			['attribute' => 'parent_id','value' => $model->Parent_desc],
			'menu_name',
			['attribute'=>'is_display','value'=>$model->is_display == 1 ?'显示':'不显示'],
			'sort_number',
			'uri_path',
			'icon',
			['attribute'=>'created_at','value'=>date('Y-m-d H:i:s',$model->created_at)],
			['attribute'=>'updated_at','value'=>date('Y-m-d H:i:s',$model->updated_at)],
		],
	]) ?>

</div>
