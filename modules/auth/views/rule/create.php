<?php

use yii\helpers\Html;
use lemon\bootstrap4\ActiveForm;
use common\repository\Pattern;
use lemon\web\AdminLteAsset;

/* @var $this yii\web\View */
/* @var $model backend\modules\auth\models\AuthRule */

$this->title = '添加菜单';
$this->params['breadcrumbs'][] = ['label' => '菜单列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

AdminLteAsset::loadModule($this, 'handlebar');
AdminLteAsset::addScript($this, 'js/icons');


?>
<style>
	.bs-icons-list{padding-left: 0;list-style: none; margin-top: 0; margin-bottom: 10px;}
	.bs-icons-list li{float: left; width: 20%; padding: 5px; font-size: 14px; text-align: left; background-color: #f9f9f9; border: 1px solid #fff; color: #000;}
	.icons-list h4{color: #aaa; padding: 10px;}
	.bs-icons-list a{color: #000;}	
	.bs-icons-list a:hover{color:green;}
</style>
<div class="container-fluid">
	<?php 
		$form = ActiveForm::begin([
			'id' => 'main_form',
	 		'layout' => 'horizontal'
		]); 
	?>
		<?= $form->field($model, 'name')->textInput(['maxlength' => true,'disabled'=>"disabled", 'placeholder'=>'自动生成']) ?>
		<?= $form->field($model, 'menu_name')->textInput(['maxlength' => true]) ?>
		<?= $form->field($model, 'display_name')->textInput(['maxlength' => true]) ?>
		<?= $form->field($model, 'parent_id')->dropDownList($model->getOptions(),['inline'=>true, 'onchange'=>'onParentChange(this)'])?>
		<?= $form->field($model, 'uri_path')->textInput(['maxlength' => true]) ?>
		<?= $form->field($model, 'icon', ['append' => ['type'=>'button', 'content' => '选择', 'options'=>['onclick'=>'onPickIcon()']]])->textInput(['placeholder'=>'Font Awesome 字体图标']) ?>
		<?= $form->field($model, 'is_display')->radioList(Pattern::$CODE['display'], ['inline'=>true, ]) ?>
		<?= $form->field($model, 'sort_number')->textInput(['placeholder'=>'排序号']) ?>
		
		<div class="form-group text-center">
			<?= Html::submitButton('保存', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
		</div>
	<?php ActiveForm::end(); ?>
</div>

<script id="template_icon_list" type="text/x-handlebars-template">
	{{#each this}}
		<div class="icons-list">
			<p><h4>{{title}}</h4></p>
			<ul class="bs-icons-list">
			{{#each items}}
				<li class="icon_list_li" data-icon="{{this}}"><a><i class="fa fa-lg fa-{{this}}"></i> {{this}}</a></li>
			{{/each}}
			</ul>
		</div>
		<p style="clear:both;"><br /></p>
	{{/each}}
</script>

<script type="text/javascript">
	var layerIcons;
	
	function onPickIcon(){
		_html = $("#template_icon_list").html();
		var tmpfn = Handlebars.compile(_html);
		var _content = tmpfn(AWESOME_JSON);
		$("#main_print_items").append();
		layerIcons = layer.open({
			  type: 1,
			  skin: 'layui-layer-demo', //加上边框
			  area: ['90%', '90%'], //宽高
			  content: _content
			});
	}
	function initEvents(){
		$("#authrule-display_name").focus(function(){
			var _val = $("#authrule-menu_name").val();
			if($(this).val()==""){
				$(this).val(_val);
			}
		});
		$(document).on('click', '.icon_list_li', function(){
			$("#authrule-icon").val($(this).data('icon'));
			layer.close(layerIcons);
		});
	}
	function onParentChange(obj){
		
	}
</script>

<?php 
$Js = <<<JS
$(function(){
	initEvents();
});
JS;
$this->registerJs($Js);
		
?>