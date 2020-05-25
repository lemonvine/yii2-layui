<?php

namespace backend\modules\auth\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "shine_auth_assignment".
 *
 * @property string $item_name
 * @property string $user_id
 * @property integer $created_at
 * @property integer $created_user
 *
 * @property AuthItem $itemName
 */
class AuthAssignment extends ActiveRecord
{
	public static function tableName()
	{
		return '{{%auth_assignment}}';
	}
	
	public function rules()
	{
		return [
			[['item_name', 'user_id'], 'required'],
			[['created_at', 'created_user'], 'integer'],
			[['item_name', 'user_id'], 'string', 'max' => 64],
			[['item_name'], 'exist', 'skipOnError' => true, 'targetClass' => AuthItem::className(), 'targetAttribute' => ['item_name' => 'name']],
		];
	}
	
	public function attributeLabels()
	{
		return [
			'item_name' => '资源名称',
			'user_id' => '用户编号',
			'created_at' => '创建时间',
			'created_user' => '创建人员',
		];
	}
	
	public function getItemName()
	{
		return $this->hasOne(AuthItem::className(), ['name' => 'item_name']);
	}
}
