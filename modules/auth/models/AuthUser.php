<?php

namespace backend\modules\auth\models;

use backend\models\User;

/**
 * This is the model class for table "{{%auth_user}}".
 *
 * @property int $id 编号
 * @property string $username 用户登录名
 * @property string $auth_key
 * @property string $password_hash 密码
 * @property string $password_reset_token 重置密码
 * @property string $real_name 真实姓名
 * @property string $nick_name 用户昵称
 * @property string $avatar 用户头像
 * @property string $email 邮箱
 * @property string $phone 手机
 * @property int $status 状态
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 */
class AuthUser extends User
{
	public $password;
	
	public static function tableName()
	{
		return '{{%auth_user}}';
	}
	
	public function scenarios()
	{
		$scenarios = parent::scenarios();
		$scenarios['create'] = ['username', 'password', 'real_name', 'nick_name', 'avatar', 'email', 'phone'];
		
		return $scenarios;
	}
	
	public function rules()
	{
		return [
			[['username', 'auth_key', 'password_hash', 'created_at'], 'required'],
			[['status', 'created_at', 'updated_at', 'created_user'], 'integer'],
			[['username', 'auth_key', 'real_name', 'nick_name', 'avatar', 'password'], 'string', 'max' => 32],
			[['password_hash', 'password_reset_token'], 'string', 'max' => 256],
			[['email', 'phone'], 'string', 'max' => 64],
			['username', 'unique'],
			[['password', 'real_name'], 'required', 'on'=>['create']],
			['phone', 'match', 'pattern'=>'/^1[0-9]{10}$/', 'message'=>'{attribute}必须为1开头的11位数字'],
			['email', 'email'],
		];
	}
	
	public function attributeLabels()
	{
		return [
			'id' => '编号',
			'username' => '用户登录名',
			'auth_key' => 'Auth Key',
			'password_hash' => '密码',
			'password' => '密码',
			'password_reset_token' => '重置密码',
			'real_name' => '真实姓名',
			'nick_name' => '用户昵称',
			'avatar' => '用户头像',
			'email' => '邮箱',
			'phone' => '手机',
			'status' => '状态',
			'created_at' => '创建时间',
			'updated_at' => '更新时间',
			'created_user' => '创建人',
		];
	}
}
