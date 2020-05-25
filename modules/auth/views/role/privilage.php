<?php

use lemon\bootstrap4\ActiveForm;
use yii\helpers\Html;

/* @var $tree array */
/* @var $id Number */
/* @var $role_name String  */

$this->title = '当前角色: ';
$this->params['breadcrumbs'][] = ['label' => '权限分配', 'url' => ['index']];
$this->params['breadcrumbs'][] = '权限分配';

?>
<style>
.auth-tree li{list-style-type: none; padding-left: 30px;}
.auth-tree li input{margin: 5px 10px;}
.auth-tree .on>ul{display: inline;}
.auth-tree li>ul{display: none;}
.auth-tree a{width: 25px; height: 25px; padding: 7px;}
.auth-tree .on>.fa-plus-square-o{display: none;}
.auth-tree  a>.fa-plus-square-o{display: inline;}
.auth-tree .on>.fa-minus-square-o{display: inline;}
.auth-tree  a>.fa-minus-square-o{display: none;}
label {font-size:12px;cursor:pointer;}
label i {font-size:12px;font-style:normal;display:inline-block;width:12px;height:12px;text-align:center;line-height:12px;color:#fff;vertical-align:middle;margin:-2px 2px 1px 0px;border:#2489c5 1px solid;}
input[type="checkbox"],input[type="radio"] {display:none;}
input[type="radio"] + i {border-radius:7px;}
input[type="checkbox"]:checked + i,input[type="radio"]:checked + i {background:#2489c5;}
input[type="checkbox"]:disabled + i,input[type="radio"]:disabled + i {border-color:#ccc;}
input[type="checkbox"]:checked:disabled + i,input[type="radio"]:checked:disabled + i {background:#ccc;}
</style>

<div class="auth-item-create">
	<?php $form = ActiveForm::begin();?>
	
	<div class="form-group" style="padding-top: 1.5em;">
		<input type="hidden" id="back_referer" name="back_referer" value="<?=$this->context->referer?>" />
		<a class="btn btn-default" href="javascript:;" onclick="goback()"> 返回</a>
		<?= Html::submitButton('保存', ['class' => 'btn btn-success' ]) ?>
	</div>
	<div>
		<ul class="auth-tree">
			<?php cutTree($tree);?>
		</ul>
	</div>
	<?php ActiveForm::end();?>
</div>

<?php 
function cutTree($s){
	foreach($s as $key => $val):
?>
	<li id="li-<?=$val['id']?>">
		<?php if(count($val['sub'])>0):?>
		<a class="js-fold-toggle" href="javascript:;" data-sub="<?=$val['id']?>">
			<i class="fa fa-minus-square-o"></i>
			<i class="fa fa-plus-square-o"></i>
		</a>
		<?php else: ?>
		<a class="" href="javascript:;" style="visibility: hidden;" data-sub="<?=$val['id']?>">
			<i class="fa fa-check-square-o"></i>
		</a>
		<?php endif; ?>
		<label>
			<input type="checkbox" class="js-checked-toggle" data-level="<?=$val['id']?>" name="privilage[]" value="<?=$val['id']?>" <?php if($val['selected']) echo 'checked' ?>><i>✓</i><?=$val['menu_name']?>
		</label>
		<?php if(count($val['sub'])>0): ?>
		<ul id="sub-ul-<?=$val['id']?>">
			<?php cutTree($val['sub']);?>
		</ul>
		<?php endif; ?>
	</li>
<?php
	endforeach;
}
?>

<script type="text/javascript">
	function initEvents(){
		$(".js-fold-toggle").click(function(){
			if($(this).hasClass('on')){
				$(this).removeClass('on');
				$(this).parent().removeClass('on');
			}
			else{
				$(this).addClass('on');
				$(this).parent().addClass('on');
			}
		});
		$(".js-checked-toggle").click(function(){
			if($(this).is(":checked")){
				parentIteration1($(this));
				childrenIteration($(this),true);
			}
			else{
				parentIteration0($(this));
				childrenIteration($(this),false);
			}
		});
	}
	function parentIteration1(obj){
		var ancestor =  $(obj).parent().parent().parent().parent();
		if(($(ancestor)[0].tagName) && $(ancestor)[0].tagName.toUpperCase()=="LI"){
			var _input = $(ancestor).children('label').children('input');
			$(_input).prop('checked',true);
			parentIteration1($(_input));
		}
	}

	function parentIteration0(obj){
		var ancestor =  $(obj).parent().parent().parent().parent();
		if(($(ancestor)[0]) && $(ancestor)[0].tagName.toUpperCase()=="LI"){
			var _lis = $(ancestor).children('ul').children('li');
			var _has_child_checked = false;
			$(_lis).each(function(){
				var _input = $(this).children('label').children('input');
				if($(_input).is(":checked")){
					_has_child_checked= true;
					return;
				}
			});
			if(_has_child_checked){
				return;
			}
			var _input = $(ancestor).children('label').children('input');
			$(_input).prop('checked',false);
			parentIteration0($(_input));
		}
	}
	function childrenIteration(obj, r){
		var _children =  $(obj).data('level');
		var _ul = $("#sub-ul-"+_children);
		if($(_ul)){
			var _lis = $(_ul).children('li');
			$(_lis).each(function(){
				var _input = $(this).children('label').children('input');
				$(_input).prop('checked',r);
				childrenIteration($(_input),r);
			});
		}
	}
</script>
<?php 
$Js = <<<JS
initEvents();
JS;

$this->registerJs($Js);
?>