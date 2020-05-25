<?php

namespace backend\modules\auth\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\auth\models\LogOperate;
use backend\models\User;

/**
 * LogOperateQuery represents the model behind the search form of `backend\modules\auth\models\LogOperate`.
 */
class LogOperateQuery extends LogOperate
{
	public function rules()
	{
		return [
			[['id', 'type', 'operator_id', 'create_at'], 'integer'],
			[['content'], 'safe'],
		];
	}
	
	public function search($params)
	{
		$query = LogOperate::find()->alias('T1');
		$query->leftJoin(User::tableName().' as T2', 'T1.operator_id = T2.id');
		$query->select(['T1.id', 'type', 'content', 'operator_id', 'real_name', 'create_at']);

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
		]);
		$dataProvider->setSort(false);

		$this->load($params);

		if (!$this->validate()) {
			$query->where('0=1');
			return $dataProvider;
		}
		
		$query->andFilterWhere([
			'id' => $this->id,
			'type' => $this->type,
			'operator_id' => $this->operator_id,
			'create_at' => $this->create_at,
		]);
		$query->orderBy(['id'=>SORT_DESC]);

		$query->andFilterWhere(['like', 'content', $this->content]);

		return $dataProvider;
	}
}
