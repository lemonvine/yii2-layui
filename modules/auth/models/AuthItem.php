<?php

namespace backend\modules\auth\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "mcch_auth_item".
 *
 *
 * @property string $parent
 * @property string $child
 * 
 */
class AuthItem extends ActiveRecord
{
	public $password_repeat;
	
	public static function tableName()
	{
		return '{{%auth_item}}';
	}
	
	public function rules()
	{
		return [
			[['parent', 'child'], 'required'],
			[['parent', 'child', 'created_at', 'created_user'], 'integer'],
			[['parent', 'child'], 'unique'],
		];
	}
	
	public function attributeLabels()
	{
		return [
			'parent' => '角色',
			'child' => '资源',
			'created_at' => '创建时间',
			'created_user' => '创建人',
		];
	}

}
