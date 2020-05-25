<?php

namespace backend\modules\auth\controllers;

use Yii;
use yii\db\Expression;
use backend\controllers\AdminController;
use backend\modules\auth\models\AuthRule;
use backend\modules\auth\models\AuthRoleQuery;
use backend\modules\auth\models\AuthRole;
use backend\modules\auth\models\AuthItem;

/**
 * 角色控制器
 */
class RoleController extends AdminController
{
	const ROLE_PREFIX = 'ROLE_';   //name 前缀
	
	public function actionIndex()
	{
		$searchModel = new AuthRoleQuery();
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
		$model = new AuthRole();
		if(Yii::$app->request->isPost){
			$post = Yii::$app->request->post();
			$model->load($post);
			$model->created_at = time();
			$model->created_user = $this->user_id;
			$result = $model->save();
			return $this->modelSaveSuccess();
		}
		return $this->render('create', [
			'model' => $model
		]);
	}
	
	public function actionUpdate($id)
	{
		$this->turnToDialog();
		$model = $this->findModel($id);
		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->modelSaveSuccess();
		} else {
			return $this->renderAjax('create', [
				'model' => $model,
			]);
		}
	}
	
	public function actionPrivilage($id)
	{
		$this->turnToDialog();
		if(Yii::$app->request->isPost){
			$post = Yii::$app->request->post();
			if(isset($post['privilage'])){
				$menus_new = $post['privilage'];
			}
			else{
				$menus_new = [];
			}
			$menus_old = AuthItem::find()->where(['parent'=>$id])->select(['child'])->asArray()->column();
			
			$add = [];
			$delete = [];
			
			foreach ($menus_new as $val1){
				if(!in_array($val1, $menus_old)){
					$add[] = $val1;
				}
			}
			foreach ($menus_old as $val2){
				if(!in_array($val2, $menus_new)){
					$delete[] = $val2;
				}
			}
			
			$user_id = $this->user_id;
			$str_delete = implode(',', $delete);
			$str_add = implode(',', $add);
			$cmd = Yii::$app->db->createCommand("CALL standard_authrole_v1(:role_id, :user_id, :str_delete, :str_add, @i, @s)");
			$cmd->bindParam(':role_id', $id, \PDO::PARAM_INT,11);
			$cmd->bindParam(':user_id', $user_id, \PDO::PARAM_INT, 11);
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
		$tree =  $this->getMenusWithRole($id);
		return $this->render('privilage', ['id' => $id, 'tree' => $tree]);
	}
	
	protected function findModel($id)
	{
		if (($model = AuthRole::findOne($id)) !== null) {
			return $model;
		} else {
			throw new \Exception('数据不存在.');
		}
	}
		
	/**
	 * 列出所有菜单，并关联角色的权限
	 * 字段selected为角色是否拥有权限，1拥有，0不拥有
	 * @param unknown $role
	 */
	protected function getMenusWithRole($role){
		$expression = new Expression('CASE WHEN ISNULL(T2.parent) THEN 0 ELSE 1 END AS selected');
		$menus = AuthRule::find()->alias('T1')
		->leftjoin(AuthItem::tableName().' AS T2',"T1.id=T2.child AND T2.parent={$role}")
		->select(['T1.id', 'menu_name', 'parent_id', $expression])
		->orderBy('T1.sort_number')
		->asArray()
		->all();
		$tree = [];
		foreach($menus as $menu){
			$tree[$menu['parent_id']][]=$menu;
		}
		//建立树级关系
		$tree2 = $this->getTree($tree, 0);
		return $tree2;
	}
	
	/**
	 * 嵌套获取树级关系的菜单
	 * @param unknown $data
	 * @param unknown $pid
	 */
	protected function getTree($data, $pid){
		if(array_key_exists($pid, $data)){
			$tree = $data[$pid];
			foreach($tree as  $key=>$item){
				$temp = $this->getTree($data, $item['id']);
				$tree[$key]['sub']= $temp;
			}
			return $tree;
		}
		else{
			return [];
		}
	}
	
}
