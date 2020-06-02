<?php
use yii\helpers\Html;

/* @var $content string */

?>

<fieldset class="table-search-fieldset">
	<legend>查询</legend>
	<div style="margin: 10px 10px 10px 10px">
		<?=Html::beginForm($this->context->action, $this->context->method, $this->context->options)?>
			<div class="layui-form-item">
				<?=$content?>
				<div class="layui-inline" style="float: right">
					<button type="submit" class="layui-btn layui-btn-primary"  lay-submit lay-filter="data-search-btn"><i class="layui-icon"></i> 搜 索</button>
				</div>
			</div>
		<?=Html::endForm();?>
	</div>
</fieldset>