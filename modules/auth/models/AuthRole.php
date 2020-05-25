<?php

namespace backend\modules\auth\models;

use Yii;

/**
 * This is the model class for table "{{%auth_role}}".
 *
 * @property int $id 编号
 * @property string $name 角色名称
 * @property string $description 描述
 * @property int $created_at 创建时间
 * @property int $created_user 创建人
 */
class AuthRole extends \yii\db\ActiveRecord
{
	public static function tableName()
	{
		return '{{%auth_role}}';
	}
	
	public function rules()
	{
		return [
			[['name'], 'required'],
			[['description'], 'string'],
			[['created_at', 'created_user'], 'integer'],
			[['name'], 'string', 'max' => 64],
			[['name'], 'string', 'max' => 256],
		];
	}
	
	public function attributeLabels()
	{
		return [
			'id' => '编号',
			'name' => '角色名称',
			'description' => '描述',
			'created_at' => '创建时间',
			'created_user' => '创建人',
		];
	}
	
	/**
	 * 获取所有角色名称和角色主键
	 * @param string $name 角色主键，为空则表示查询所有的角色名称
	 * @return string|array
	 */
	public static function getHoldRoles(){
		$user_id = Yii::$app->user->identity->id;
		
		if($user_id==1){
			$result = self::find()->select(['name', 'id'])->indexBy('id')->column();
		}
		else{
			$result = self::find()->alias("T1")->leftJoin(AuthUserRole::tableName().' as T2', 'T1.id = T2.role_id')
			->select(['T1.name', 'T1.id'])->andWhere(['or',['=', 'T1.created_user', $user_id], ['=','T2.user_id', $user_id]])->indexBy('id')->column();
			
		}
		return $result;
	}
}
