<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\auth\models\AuthUser */

$this->title = '详情';
$this->params['breadcrumbs'][] = ['label' => '用户管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-user-view">
	
	<?php  echo Html::a('返回', Yii::$app->request->getReferrer(), [
			'class' => 'btn btn-default btn-sm',
		]); ?>

	<?= DetailView::widget([
		'model' => $model,
		'attributes' => [
			'id',
			'username',
			'auth_key',
			'password_hash',
			'password_reset_token',
			'real_name',
			'nick_name',
			'avatar',
			'email:email',
			'phone',
			'status',
			'created_at',
			'updated_at',
		],
	]) ?>

</div>
