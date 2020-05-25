<?php


/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();
$nameAttribute = $generator->getNameAttribute();

echo "<?php\n";
?>

use yii\helpers\Html;
use yii\helpers\Url;
use <?= $generator->indexWidgetType === 'grid' ? "yii\\grid\\GridView" : "yii\\widgets\\ListView" ?>;
<?= $generator->enablePjax ? 'use yii\widgets\Pjax;' : '' ?>
use lemon\bootstrap4\ActiveForm;
use common\widgets\btns\ButtonGroup;

/* @var $this yii\web\View */
<?= !empty($generator->searchModelClass) ? "/* @var \$searchModel " . ltrim($generator->searchModelClass, '\\') . " */\n" : '' ?>
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php if(!empty($generator->searchModelClass)): ?>

<div class="card card-default">
	<div class="card-header"><i class="fas fa-search"></i> 查询</div>
	<div class="card-body">
		<?= "<?php " ?>$form = ActiveForm::begin([
			'action' => ['index'],
			'method' => 'get',
			'options' => ['class'=>'retrieval',<?php if ($generator->enablePjax): ?>'data-pjax' => 1,<?php endif; ?>],
			'fieldConfig'=>[
				'template'=>'<div class="flex">{label}{input}</div>',
				'options' => ['class' => 'form-group col-lg-3 col-md-4 col-sm-4 col-xs-6'],
			]]);
			?>
			<div class="container-fluid">
				<div class="row">
<?php
$count = 0;
foreach ($generator->getColumnNames() as $attribute) {
	if (++$count < 100) {
		echo "					<?= " . $generator->generateActiveSearchField($attribute) . " ?>\n";
	} else {
		echo "					<?php // echo " . $generator->generateActiveSearchField($attribute) . " ?>\n";
	}
}
?>
					<?= "<?= " ?>ButtonGroup::SearchAddButton() ?>
				</div>
			</div>

		<?= "<?php " ?>ActiveForm::end(); ?>
	</div>
</div>
<?php endif; ?>
<?= $generator->enablePjax ? "	<?php Pjax::begin(); ?>\n" : '' ?>

<?php if ($generator->indexWidgetType === 'grid'): ?>
<?= "<?= " ?>GridView::widget([
	'dataProvider' => $dataProvider,
	'pager' => ['class'=>'yii\bootstrap4\LinkPager'],
	'tableOptions' => ['class' => 'table table-striped table-bordered table-head-fixed'],
	<?= !empty($generator->searchModelClass) ? "'columns' => [\n" : "'columns' => [\n"; ?>
<?php
$count = 0;
if (($tableSchema = $generator->getTableSchema()) === false) {
	foreach ($generator->getColumnNames() as $name) {
		if (++$count < 100) {
			echo "		'" . $name . "',\n";
		} else {
			echo "		//'" . $name . "',\n";
		}
	}
} else {
	foreach ($tableSchema->columns as $column) {
		$format = $generator->generateColumnFormat($column);
		if (++$count < 100) {
			echo "		'" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
		} else {
			echo "		//'" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
		}
	}
}
?>
		['class' => 'yii\grid\ActionColumn','template'=>'{update} {delete}','header' => '操作','buttons' => [
			'update' => function($url,$model,$key){
				return Html::a('编辑', 'javascript:;', ['class' => 'btn btn-outline-primary modaldialog', 'data-url' => $url, 'data-title' => '编辑']);
			},
			'delete' => function($url,$model,$key){
				return Html::a('删除', 'javascript:;', ['class'=>'btn btn-outline-danger confirmdialog', 'data-title' => '删除', 'data-way' => 'post', 'data-word' => '确定要删除吗？', 'data-url'=>$url]);
			}
		]]
	],
]); ?>
<?php else: ?>
	<?= "<?= " ?>ListView::widget([
		'dataProvider' => $dataProvider,
		'itemOptions' => ['class' => 'item'],
		'itemView' => function ($model, $key, $index, $widget) {
			return Html::a(Html::encode($model-><?= $nameAttribute ?>), ['view', <?= $urlParams ?>]);
		},
	]) ?>
<?php endif; ?>
<?= $generator->enablePjax ? "	<?php Pjax::end(); ?>\n" : '' ?>