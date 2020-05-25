<?php

namespace backend\modules\auth\models;

use Yii;

/**
 * This is the model class for table "paf8_log_operate".
 *
 * @property string $id 编号
 * @property int $type 类型
 * @property string $content 修改内容
 * @property int $operator_id 操作人
 * @property int $create_at 操作时间
 */
class LogOperate extends \yii\db\ActiveRecord
{
	public $real_name;
	public static function tableName()
	{
		return '{{log_operate}}';
	}
	
	public function rules()
	{
		return [
			[['type', 'operator_id', 'create_at'], 'integer'],
			[['content'], 'string', 'max' => 1024],
		];
	}
	
	public function attributeLabels()
	{
		return [
			'id' => '编号',
			'type' => '类型',
			'content' => '修改内容',
			'operator_id' => '操作人',
			'create_at' => '操作时间',
		];
	}

}
