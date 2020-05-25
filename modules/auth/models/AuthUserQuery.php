<?php

namespace backend\modules\auth\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\auth\models\AuthUser;

/**
 * AuthUserQuery represents the model behind the search form of `backend\modules\auth\models\AuthUser`.
 */
class AuthUserQuery extends AuthUser
{
	public function rules()
	{
		return [
			[['id', 'status', 'created_at', 'updated_at'], 'integer'],
			[['username', 'auth_key', 'password_hash', 'password_reset_token', 'real_name', 'nick_name', 'avatar', 'email', 'phone'], 'safe'],
		];
	}
	
	public function search($params)
	{
		$query = AuthUser::find();

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
				'status' => $this->status,
				'phone' => $this->phone,
		]);

		$query->andFilterWhere(['like', 'username', $this->username])
			->andFilterWhere(['like', 'real_name', $this->real_name])
			->andFilterWhere(['like', 'nick_name', $this->nick_name]);
		;
		
		return $dataProvider;
	}
}
