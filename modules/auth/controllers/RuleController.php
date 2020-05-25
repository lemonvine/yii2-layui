<?php

namespace melon\modules\auth\controllers;

use Yii;
use backend\controllers\AdminController;
use backend\modules\auth\models\AuthRuleQuery;
use backend\modules\auth\models\AuthRule;

/**
 * 后台菜单管理
 */
class RuleController extends AdminController
{
	const MENU_PREFIX = 'MENU_';   //name 前缀

	/**
	 * 菜单列表
	 * @return mixed
	 */
	public function actionIndex()
	{
		$searchModel = new AuthRuleQuery();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		
		return $this->render('index', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}

	/**
	 * 新建菜单
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$this->turnToDialog();
		$model = new AuthRule();
		$model->is_display = 1;
		if(Yii::$app->request->isPost){
			$post = Yii::$app->request->post();
			$model->load($post);
			$model->created_at = time();
			$model->name = self::MENU_PREFIX.(AuthRule::find()->max('id')+1);

			$db = Yii::$app->db;
			$transaction = $db->beginTransaction();
			try{
				$result = $model->save();
				if(!$result){
					$error=array_values($model->getFirstErrors())[0];
					throw new \Exception($error);
				}
				$transaction->commit();
				return $this->modelSaveSuccess();
			}
			catch(\Exception $ex){
				$transaction->rollBack();
				$this->message = $ex->getMessage();
			}
			
		}
		return $this->render('create', [
			'model' => $model,
		]);
	}
		
	/**
	 * 修改菜单信息
	 * @param integer $id
	 * @return mixed
	 */
	public function actionUpdate($id)
	{
		$this->turnToDialog();
		$model = $this->findModel($id);
		if(Yii::$app->request->isPost){
			$post = Yii::$app->request->post();
			$model->load($post);
			$model->updated_at = time();
		
			$db = Yii::$app->db;
			$transaction = $db->beginTransaction();
			try{
				$result = $model->save();
				if(!$result){
					$error=array_values($model->getFirstErrors())[0];
					throw new \Exception($error);
				}
				$transaction->commit();
				return $this->modelSaveSuccess();
			}
			catch(\Exception $ex){
				$transaction->rollBack();
				$this->message = $ex->getMessage();
			}
		}
		return $this->render('create', [
			'model' => $model,
		]);
	}
	
	public function actionApprove($id){
		$model = $this->findModel($id);
		$model->is_display = $model->is_display == 1 ? 0:1;
		$model->save(false);
		return $this->redirect($this->referer);
	}

	/**
	 * 查找model
	 * @param integer $id
	 * @return Auth_rule the loaded model
	 * @throws Exception if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = AuthRule::findOne($id)) !== null) {
			return $model;
		} else {
			throw new \Exception('The requested page does not exist.');
		}
	}
}
