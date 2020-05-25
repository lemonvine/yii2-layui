<?php
/**
 * This is the template for generating the model class of a specified table.
 */

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\model\Generator */
/* @var $tableName string full table name */
/* @var $className string class name */
/* @var $queryClassName string query class name */
/* @var $tableSchema yii\db\TableSchema */
/* @var $properties array list of properties (property => [type, name. comment]) */
/* @var $labels string[] list of attribute labels (name => label) */
/* @var $rules string[] list of validation rules */
/* @var $relations array list of relations (name => relation declaration) */

echo "<?php\n";
?>

namespace <?= $generator->ns ?>;

use yii\db\ActiveRecord;

/**
 * 
 * auto-generate <?=date('Y-m-d')."\n" ?>
<?php foreach ($properties as $property => $data): ?>
 * @property <?= "{$data['type']} \${$property}"  . ($data['comment'] ? ' ' . strtr($data['comment'], ["\n" => ' ']) : '') . "\n" ?>
<?php endforeach; ?>
<?php if (!empty($relations)): ?>
 *
<?php foreach ($relations as $name => $relation): ?>
 * @property <?= $relation[1] . ($relation[2] ? '[]' : '') . ' $' . lcfirst($name) . "\n" ?>
<?php endforeach; ?>
<?php endif; ?>
 */
class <?= $className ?> extends ActiveRecord
{
	public static function tableName()
	{
		return '<?= $generator->generateTableName($tableName) ?>';
	}
<?php if ($generator->db !== 'db'): ?>

	public static function getDb()
	{
		return Yii::$app->get('<?= $generator->db ?>');
	}
<?php endif; ?>

	public function rules()
	{
		return [<?= empty($rules) ? '' : ("\n			" . implode(",\n			", $rules) . ",\n		") ?>];
	}

	public function attributeLabels()
	{
		return [
<?php foreach ($labels as $name => $label): ?>
			<?= "'$name' => " . $generator->generateString($label) . ",\n" ?>
<?php endforeach; ?>
		];
	}
<?php foreach ($relations as $name => $relation): ?>

	public function get<?= $name ?>()
	{
		<?= $relation[0] . "\n" ?>
	}
<?php endforeach; ?>
}
