<?php
/**
 * This is the template for generating CRUD search class of the specified model.
 */

use yii\helpers\StringHelper;


/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$modelClass = StringHelper::basename($generator->modelClass);
$searchModelClass = StringHelper::basename($generator->searchModelClass);
if ($modelClass === $searchModelClass) {
	$modelAlias = $modelClass . 'Model';
}
$rules = $generator->generateSearchRules();
$labels = $generator->generateSearchLabels();
$searchAttributes = $generator->getSearchAttributes();
$searchConditions = $generator->generateSearchConditions();

echo "<?php\n";
?>

namespace <?= StringHelper::dirname(ltrim($generator->searchModelClass, '\\')) ?>;

use yii\data\ActiveDataProvider;

/**
 * 
 * auto-generate <?=date('Y-m-d')."\n" ?>
 * 
 */
class <?= $searchModelClass ?> extends <?= isset($modelAlias) ? $modelAlias : $modelClass ?>

{
	public function rules()
	{
		return [
			<?= implode(",\n			", $rules) ?>,
		];
	}

	public function search($params)
	{
		$query = <?= isset($modelAlias) ? $modelAlias : $modelClass ?>::find();

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
		]);
		$dataProvider->setSort(false);

		$this->load($params);

		if (!$this->validate()) {
			$query->where('0=1');
			return $dataProvider;
		}

		<?= implode("\n		", $searchConditions) ?>

		return $dataProvider;
	}
}
