<?php
namespace backend\modules\auth\models;

/**
 * 修改密码的模型
 * @author shaodd 
 *
 */
class UserUpdatePwd extends AuthUser{
	public $old_pwd;
	public $new_pwd;
	public $confirm_pwd;
	
	public function rules() {
		return [
			[['new_pwd', 'old_pwd', 'confirm_pwd'], 'required'],
		];
	}
	
	public function attributeLabels(){
		return[
			'old_pwd' => '原密码',
			'new_pwd' => '新密码',
			'confirm_pwd' => '确认密码'
		];
	}
}