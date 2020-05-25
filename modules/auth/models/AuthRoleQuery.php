<?php

namespace backend\modules\auth\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Auth_itemSearch represents the model behind the search form about `common\models\Auth_item`.
 */
class AuthRoleQuery extends AuthRole
{
	public function rules()
	{
		return [
			[['name'], 'safe'],
		];
	}
	
	public function search($params)
	{
		$query = self::find();
		
		$dataProvider = new ActiveDataProvider([
			'query' => $query,
		]);
		$dataProvider->setSort(false);
		
		$this->load($params);
		
		if (!$this->validate()) {
			$query->where('0=1');
			return $dataProvider;
		}
		
		$query->andFilterWhere(['like', 'name', $this->name]);

		return $dataProvider;
	}
}
