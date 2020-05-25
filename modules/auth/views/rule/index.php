<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use melon\widgets\SearchForm;
use backend\modules\auth\models\AuthRule;
use common\widgets\ButtonGroup;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\auth\models\AuthRuleQuery */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '菜单管理';
$this->params['breadcrumbs'][] = $this->title;

$parents = AuthRule::menuIndex();
$parents[0]='主页面';


?>



<?php $form = SearchForm::begin();?>
	<?=$form->field($searchModel, 'menu_name');?>
	<?=$form->field($searchModel, 'parent_id')->dropDownList((new AuthRule())->getOptions(),['prompt'=>'全部']) ?>
<?php  SearchForm::end(); ?>

<?php /*= GridView::widget([
	'dataProvider' => $dataProvider,
	'pager' => ['class'=>'yii\bootstrap4\LinkPager'],
	'tableOptions' => ['class' => 'table table-striped table-bordered table-head-fixed'],
	'columns' => [
		['attribute' => 'parent_id','format'=>'raw', 'value'=> function($model) use($parents){
			return $parents[$model->parent_id];
		}],
		'menu_name',
		['attribute' => 'is_display', 'format'=> ['pattern', 'display']],
		'sort_number',
		'uri_path',
		['class' => 'yii\grid\ActionColumn',
		 'header' => '操作',
		 'template'=>'{update} {approve} {abutton}',
		 'buttons' => [
			 'update' => function($url,$model,$key){
				return ButtonGroup::DialogButton(['title'=>'修改', 'url'=>$url, 'isbtn'=>false, 'color'=>'primary', 'size'=>'md']);
			 },
			 'approve' => function($url,$model,$key){
				if($model->is_display==1){
					$display_name = '隐藏';
					$confirm_title = '确定要取消显示吗';
				}
				else{
					$display_name = '显示';
					$confirm_title = '确定要显示吗';
				}
				$options = [ 'class' => 'btn btn-outline-danger', 'data-confirm' => $confirm_title];
				return Html::a($display_name, $url, $options);
			},
			]
		],
	],
]); */?>
