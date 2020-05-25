<?php

namespace backend\modules\auth\models;

use yii\data\ActiveDataProvider;

class AuthRuleQuery extends AuthRule
{
	public $description;
	
	public function rules()
	{
		return [
			[['id', 'parent_id', 'is_display', 'sort_number', 'created_at', 'updated_at'], 'integer'],
			[['name', 'data', 'menu_name', 'uri_path', 'icon','description'], 'safe'],
		];
	}
	
	public function search($params)
	{
		$query = AuthRule::find();
		
		$dataProvider = new ActiveDataProvider([
			'query' => $query,
		]);
		$dataProvider->setSort(false);

		$this->load($params);

		if (!$this->validate()) {
			return $dataProvider;
		}
		
		$query->andFilterWhere([
			'id' => $this->id,
			'parent_id' => $this->parent_id,
			'is_display' => $this->is_display,
		]);

		$query->andFilterWhere(['like', 'menu_name', $this->menu_name])
			->andFilterWhere(['like', 'uri_path', $this->uri_path]);
		
		$query->orderBy(['parent_id'=>SORT_ASC, 'sort_number'=>SORT_ASC]);
		
		return $dataProvider;
	}
}
