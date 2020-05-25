<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

/* @var $model \yii\db\ActiveRecord */
$model = new $generator->modelClass();
$safeAttributes = $model->safeAttributes();
if (empty($safeAttributes)) {
	$safeAttributes = $model->attributes();
}

echo "<?php\n";
?>

use yii\helpers\Html;
use lemon\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */

$this->title = $model->isNewRecord ? '添加' : '编辑';
$this->params['breadcrumbs'][] = ['label' => <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>, 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container-fluid">
	<?= "<?php " ?>$form = ActiveForm::begin([
			'id' => 'form-<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>',
			'layout' => 'horizontal'
			
		]); 
	?>

<?php foreach ($generator->getColumnNames() as $attribute) {
	if (in_array($attribute, $safeAttributes)) {
		echo "	<?= " . $generator->generateActiveField($attribute) . " ?>\n";
	}
} ?>

	<div class="popup-btns fixed text-center">
		<?= "<?= " ?>Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
	</div>
	<?= "<?php " ?>ActiveForm::end(); ?>
</div>