<?php
/**
 * This is the template for generating a CRUD controller class file.
 */

use yii\db\ActiveRecordInterface;
use yii\helpers\StringHelper;


/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$controllerClass = StringHelper::basename($generator->controllerClass);
$modelClass = StringHelper::basename($generator->modelClass);
$searchModelClass = StringHelper::basename($generator->searchModelClass);
if ($modelClass === $searchModelClass) {
	$searchModelAlias = $searchModelClass . 'Search';
}

/* @var $class ActiveRecordInterface */
$class = $generator->modelClass;
$pks = $class::primaryKey();
$urlParams = $generator->generateUrlParams();
$actionParams = $generator->generateActionParams();
$actionParamComments = $generator->generateActionParamComments();

echo "<?php\n";
?>

namespace <?= StringHelper::dirname(ltrim($generator->controllerClass, '\\')) ?>;

use Yii;
use backend\controllers\AdminController;
use <?= ltrim($generator->modelClass, '\\') ?>;
<?php if (!empty($generator->searchModelClass)): ?>
use <?= ltrim($generator->searchModelClass, '\\') . (isset($searchModelAlias) ? " as $searchModelAlias" : "") ?>;
<?php else: ?>
use yii\data\ActiveDataProvider;
<?php endif; ?>

/**
 * 
 * auto-generate <?=date('Y-m-d')."\n" ?>
 *
 */
class <?= $controllerClass ?> extends AdminController
{
	public function actionIndex()
	{
<?php if (!empty($generator->searchModelClass)): ?>
		$searchModel = new <?= isset($searchModelAlias) ? $searchModelAlias : $searchModelClass ?>();
		$params = Yii::$app->request->queryParams;
		$dataProvider = $searchModel->search(params);

		return $this->render('index', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);
<?php else: ?>
		$dataProvider = new ActiveDataProvider([
			'query' => <?= $modelClass ?>::find(),
		]);

		return $this->render('index', [
			'dataProvider' => $dataProvider,
		]);
<?php endif; ?>
	}

	public function actionCreate()
	{
		$this->turnToDialog();
		$model = new <?= $modelClass ?>();

		try{
			if(Yii::$app->request->isPost){
				$post = Yii::$app->request->post();
				$model->load($post);
				$result = $model->save();
				if(!$result){
					throw new \Exception(array_values($model->getFirstErrors())[0]);
				}
				return $this->modelSaveSuccess();
			}
		}
		catch (\Exception $ex){
			$this->message = $ex->getMessage();
		}
		return $this->render('create', [
			'model' => $model,
		]);
	}

	public function actionUpdate(<?= $actionParams ?>)
	{
		$this->turnToDialog();
		$model = <?= $modelClass ?>::findOne(<?= $actionParams ?>);

		try{
			if(Yii::$app->request->isPost){
				$post = Yii::$app->request->post();
				$model->load($post);
				$result = $model->save();
				if(!$result){
					throw new \Exception(array_values($model->getFirstErrors())[0]);
				}
				return $this->modelSaveSuccess();
			}
		}
		catch (\Exception $ex){
			$this->message = $ex->getMessage();
		}
		return $this->render('create', [
			'model' => $model,
		]);
	}

	public function actionDelete(<?= $actionParams ?>)
	{
		<?= $modelClass ?>::deleteAll([<?= $actionParams ?>])

		return $this->redirect(['index']);
	}
}
