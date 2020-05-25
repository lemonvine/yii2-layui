<?php

namespace backend\modules\auth\controllers;

use Yii;
use backend\modules\auth\models\LogOperate;
use backend\modules\auth\models\LogOperateQuery;
use backend\controllers\AdminController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * OperationController implements the CRUD actions for LogOperate model.
 */
class OperationController extends AdminController
{
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return [
			'verbs' => [
				'class' => VerbFilter::className(),
				'actions' => [
					'delete' => ['POST'],
				],
			],
		];
	}

	/**
	 * Lists all LogOperate models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$searchModel = new LogOperateQuery();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

		return $this->render('index', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}

	/**
	 * Displays a single LogOperate model.
	 * @param string $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionView($id)
	{
		return $this->render('view', [
			'model' => $this->findModel($id),
		]);
	}

	/**
	 * Creates a new LogOperate model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$this->turnToDialog();
		$model = new LogOperate();

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

	/**
	 * Updates an existing LogOperate model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param string $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionUpdate($id)
	{
		$this->turnToDialog();
		$model = $this->findModel($id);

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
		return $this->render('update', [
			'model' => $model,
		]);
	}

	/**
	 * Deletes an existing LogOperate model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param string $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionDelete($id)
	{
		$this->findModel($id)->delete();

		return $this->redirect(['index']);
	}

	/**
	 * Finds the LogOperate model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param string $id
	 * @return LogOperate the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = LogOperate::findOne($id)) !== null) {
			return $model;
		}

		throw new NotFoundHttpException('The requested page does not exist.');
	}
}
