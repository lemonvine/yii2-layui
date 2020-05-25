<?php

namespace backend\modules\auth\controllers;

use Yii;
use common\repository\Pattern;
use backend\models\User;
use backend\controllers\AdminController;
use backend\modules\auth\models\AuthUser;
use backend\modules\auth\models\AuthUserQuery;
use backend\modules\auth\models\UserUpdatePwd;
use backend\modules\auth\models\AuthUserRole;
use backend\modules\auth\models\AuthRole;

/**
 * 后台用户
 */
class UserController extends AdminController
{	
	public function actionIndex()
	{
		$searchModel = new AuthUserQuery();
		$params = Yii::$app->request->queryParams;
		$dataProvider = $searchModel->search($params);

		return $this->render('index', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}
	
	public function actionCreate()
	{
		$this->turnToDialog();
		$model = new AuthUser();
		$model->setScenario('create');
		try{
			if(Yii::$app->request->isPost){
				$post = Yii::$app->request->post();
				$model->load($post);
				if (!preg_match(Pattern::$RegEx, $model->password)) {
					throw new \Exception('密码不符合规则');
				}
				$model->password_hash = Yii::$app->security->generatePasswordHash($model->password);
				$model->created_at = time();
				$model->created_user = $this->user_id;
				$model->auth_key = md5('LEMON'. time());
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
	
	public function actionUpdate($id)
	{
		$this->turnToDialog();
		$model = $this->findModel($id);
		try{
			if(Yii::$app->request->isPost){
				$post = Yii::$app->request->post();
				$model->load($post);
				if(!empty($model->password)){
					if (!preg_match(Pattern::$RegEx, $model->password)) {
						throw new \Exception('密码不符合规则');
					}
					$model->password_hash = Yii::$app->security->generatePasswordHash($model->password);
				}
				$model->updated_at = time();
				$result = $model->save();
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
	
	public function actionDelete($id)
	{
		AuthUser::updateAll(['status'=>4], ['id'=>$id]);
		return $this->redirect(['index']);
	}
	
	/**
	 * 添加角色
	 * @param unknown $id
	 * @return \yii\web\Response|string
	 */
	public function actionRoles($id)
	{
		$this->turnToDialog();
		$model = $this->findModel($id);
		$my_user_id = $this->user_id;
		
		if(Yii::$app->request->isPost){
			$post = Yii::$app->request->post();
			if(isset($post['userrole'])){
				$roles_new = $post['userrole'];
			}
			else{
				$roles_new = [];
			}
			$roles_old = AuthUserRole::find()->where(['user_id'=>$id])->select(['role_id'])->asArray()->column();
			
			$add = [];
			$delete = [];
			foreach ($roles_new as $val1){
				if(!in_array($val1, $roles_old)){
					$add[] = $val1;
				}
			}
			foreach ($roles_old as $val2){
				if(!in_array($val2, $roles_new)){
					$delete[] = $val2;
				}
			}
			
			$user_id = $this->user_id;
			$str_delete = implode(',', $delete);
			$str_add = implode(',', $add);
			$cmd = Yii::$app->db->createCommand("CALL standard_authuser_v1(:user_id, :ouser_id, :str_delete, :str_add, @i, @s)");
			$cmd->bindParam(':user_id', $id, \PDO::PARAM_INT,11);
			$cmd->bindParam(':ouser_id', $user_id, \PDO::PARAM_INT, 11);
			$cmd->bindParam(':str_delete', $str_delete, \PDO::PARAM_STR, 1000);
			$cmd->bindParam(':str_add', $str_add, \PDO::PARAM_STR, 1000);
			$res = $cmd->execute();
			$s = Yii::$app->db->createCommand("select @i,@s");
			$ret = $s->queryOne();
			$code = $ret['@i'];
			if($code==0){
				return $this->modelSaveSuccess('分配成功');
			}
			else{
				$this->message = $ret['@s'];
			}
			
		}
		$this->deliver['all_role'] = AuthRole::getHoldRoles($this->user_id);
		$this->deliver['self_role'] = AuthUserRole::getHoldRoleByUser($id);
		
		return $this->render('roles', [
			'model' => $model,
		]);
	}
	
	/**
	 * 修改密码
	 */
	public function actionUpdatepwd()
	{
		$this->turnToDialog();
		$model = new UserUpdatePwd();
		try{
			if(Yii::$app->request->isPost){
				$userid = $this->user_id;
				$user = $this->findModel($userid);
				$post = Yii::$app->request->post();
				$post_model = $post['UserUpdatePwd'];
				if(empty($post_model['new_pwd'])){
					throw new \Exception("新密码不能为空");
				}
				if (!preg_match(Pattern::$RegEx, $post_model['new_pwd'])) {
					throw new \Exception('密码不符合规则');
				}
				if($post_model['new_pwd']!=$post_model['confirm_pwd']){
					throw new \Exception("新密码与密码确认不一致");
				}
				$success = $user->validatePassword($post_model['old_pwd']);
				if($success){
					$pwdhash = Yii::$app->security->generatePasswordHash($post_model['new_pwd']);
					$result = User::updateAll(['password_hash'=>$pwdhash],['id'=>$userid]);
					Yii::$app->user->logout();
					return $this->render('uppwdok', []);
				}
				else{
					throw new \Exception("原密码不正确");
				}
			}
		}
		catch(\Exception $ex){
			$this->message = $ex->getMessage();
		}
		
		return $this->render('updatepwd', [
			'model' => $model,
		]);
	}
	
	protected function findModel($id)
	{
		if (($model = AuthUser::findOne($id)) !== null) {
			return $model;
		}

		throw new \Exception('The requested page does not exist.');
	}
}
