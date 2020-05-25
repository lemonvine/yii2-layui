<?php

namespace backend\modules\auth\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\auth\models\AuthUserRole;

/**
 * AuthUserRoleQuery represents the model behind the search form about `backend\modules\auth\models\AuthUserRole`.
 */
class AuthUserRoleQuery extends AuthUserRole
{
	public function rules()
	{
		return [
			[['name'], 'safe'],
			[['user_id'], 'integer'],
		];
	}
	
	public function search($params)
	{
		$query = AuthUserRole::find();

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
		]);
		$dataProvider->setSort(false);

		$this->load($params);

		if (!$this->validate()) {
			return $dataProvider;
		}
		
		$query->andFilterWhere([
			'user_id' => $this->user_id,
		]);

		$query->andFilterWhere(['like', 'name', $this->name]);

		return $dataProvider;
	}
}
