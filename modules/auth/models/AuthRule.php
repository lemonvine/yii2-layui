<?php

namespace backend\modules\auth\models;

use Yii;

/**
 * This is the model class for table "{{%auth_rule}}".
 *
 * @property int $rule_id 编号
 * @property string $name 资源名称
 * @property resource $data
 * @property int $parent_id 上一级菜单
 * @property string $menu_name 菜单名称
 * @property string $display_name 显示名称
 * @property int $is_display 是否显示
 * @property string $uri_path 路由
 * @property string $icon 图标
 * @property int $sort_number 排序号
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 *
 * @property AuthAssignment[] $authAssignments
 * @property AuthItem[] $authItems
 */
class AuthRule extends \yii\db\ActiveRecord
{
	public static function tableName()
	{
		return '{{%auth_rule}}';
	}
	
	public function rules()
	{
		return [
			[['name', 'menu_name', 'display_name'], 'required'],
			[['data'], 'string'],
			[['parent_id', 'is_display', 'sort_number', 'created_at', 'updated_at'], 'integer'],
			[['name', 'menu_name', 'display_name'], 'string', 'max' => 64],
			[['uri_path', 'icon'], 'string', 'max' => 256],
			[['name'], 'unique'],
		];
	}
	
	public function attributeLabels()
	{
		return [
			'id' => '编号',
			'name' => '资源名称',
			'data' => 'Data',
			'parent_id' => '上一级菜单',
			'menu_name' => '菜单名称',
			'display_name' => '显示名称',
			'is_display' => '是否显示',
			'uri_path' => '路由',
			'icon' => '图标',
			'sort_number' => '排序号',
			'created_at' => '创建时间',
			'updated_at' => '更新时间',
		];
	}
	
	public function getAuthAssignments()
	{
		return $this->hasMany(AuthAssignment::className(), ['item_name' => 'name']);
	}
	
	public function getAuthItems()
	{
		return $this->hasMany(AuthItem::className(), ['rule_name' => 'name']);
	}
	
	public function getRolemenus()
	{
	
		return $this->hasMany(AuthItemChild::className(), ['parent' => 'name']);
	}
	
	/**
	 * 获取菜单id和名称的键值，用于index中显示“上一级菜单”的名称
	 * @return unknown
	 */
	public static function menuIndex(){
		$data = self::find()->select(['menu_name', 'id'])->asArray()->indexBy('id')->column();
		return $data;
	}
	
	/**
	 * 获取下拉列表中的菜单item
	 * @return string
	 */
	public function getOptions()
	{
		$data = self::find()->where(['parent_id'=>0])->select(['menu_name','id'])->indexBy('id')->asArray()->column();
		$data[0]='主页面';
		return $data;
	}
}
