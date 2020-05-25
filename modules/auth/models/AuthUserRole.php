<?php

namespace backend\modules\auth\models;

use Yii;

/**
 * This is the model class for table "shine_auth_user_role".
 *
 * @property string $name
 * @property integer $user_id
 *
 * @property AuthItem $name0
 */
class AuthUserRole extends \yii\db\ActiveRecord
{
	public static function tableName()
	{
		return '{{%auth_user_role}}';
	}
	
	public function rules()
	{
		return [
			[['role_id', 'user_id'], 'required'],
			[['role_id', 'user_id'], 'integer'],
			[['role_id'], 'exist', 'skipOnError' => true, 'targetClass' => AuthRole::className(), 'targetAttribute' => ['role_id' => 'id']],
		];
	}
	
	public function attributeLabels()
	{
		return [
			'role_id' => '角色主键',
			'user_id' => '用户id',
		];
	}
	
	/**
	 * 获取用户已拥有哪些角色
	 * @param number $uid 查询的用户编号
	 */
	public static function getHoldRoleByUser($uid){
		$data = self::find()->select(['role_id'])->where(['user_id'=>$uid])->column();
		return $data;
	}
}
