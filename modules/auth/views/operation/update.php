<?php

/* @var $this yii\web\View */
/* @var $model backend\modules\auth\models\LogOperate */

$this->title = '编辑';
$this->params['breadcrumbs'][] = ['label' => 'Log Operates', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="main_form" class="log-operate-update">

	<?= $this->render('_form', [
		'model' => $model,
	]) ?>

</div>
