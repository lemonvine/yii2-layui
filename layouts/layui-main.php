<?php
use yii\helpers\Html;
use melon\assets\AppAsset;
use melon\web\Breadcrumbs;
use melon\web\Menu;
use melon\repository\Undefinitive;

/* @var $this \yii\web\View */
/* @var $content string */

$this->registerAssetBundle(AppAsset::className());

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
	<head>
		<meta charset="<?= Yii::$app->charset ?>"/>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<?= Html::csrfMetaTags() ?>
		<title><?= Html::encode($this->title) ?></title>
		<link rel="icon" type="image/x-icon" class="js-site-favicon" href="/favicon.ico">
		<?php $this->head() ?>
	</head>
	<body class="layui-layout-body layuimini-all">
<?php $this->beginBody() ?>
		<div class="layui-layout layui-layout-admin">
			<div class="layui-header header">
				<div class="layui-logo"><a href=""><img src="/images/logo.png" alt="logo" style="width: 50px;"><h1>LAYUI MINI</h1></a></div>
				<a><div class="layuimini-tool"><i title="展开" class="fa fa-outdent" data-side-fold="1"></i></div></a>

				<ul class="layui-nav layui-layout-left layui-header-menu layui-header-pc-menu mobile layui-hide-xs">
				<li class="layui-nav-item layui-this" id="currencyHeaderId" data-menu="currency"> <a href="javascript:;"><i class="fa fa-address-book"></i> 常规管理</a> </li>
				</ul>
				<ul class="layui-nav layui-layout-left layui-header-menu mobile layui-hide-sm">
					<li class="layui-nav-item">
						<a href="javascript:;"><i class="fa fa-list-ul"></i> 选择模块</a>
						<dl class="layui-nav-child layui-header-mini-menu"></dl>
					</li>
				</ul>
				<ul class="layui-nav layui-layout-right">
					<li class="layui-nav-item" lay-unselect>
						<a href="javascript:;" data-refresh="刷新"><i class="fa fa-refresh"></i></a>
					</li>
					<li class="layui-nav-item" lay-unselect>
						<a href="javascript:;" data-clear="清理" class="layuimini-clear"><i class="fa fa-trash-o"></i></a>
					</li>
					<li class="layui-nav-item mobile layui-hide-xs" lay-unselect>
						<a href="javascript:;" data-check-screen="full"><i class="fa fa-arrows-alt"></i></a>
					</li>
					<li class="layui-nav-item layuimini-setting">
						<a href="javascript:;">admin</a>
						<dl class="layui-nav-child">
							<dd>
								<a href="javascript:;" data-content-href="page/user-setting.html" data-title="基本资料" data-icon="fa fa-gears">基本资料</a>
							</dd>
							<dd>
								<a href="javascript:;" data-content-href="page/user-password.html" data-title="修改密码" data-icon="fa fa-gears">修改密码</a>
							</dd>
							<dd>
								<a href="javascript:;" class="login-out">退出登录</a>
							</dd>
						</dl>
					</li>
					<li class="layui-nav-item layuimini-select-bgcolor mobile layui-hide-xs">
						<a href="javascript:;" data-bgcolor="配色方案"><i class="fa fa-ellipsis-v"></i></a>
					</li>
				</ul>
			</div>

			<div class="layui-side layui-bg-black">
				<div class="layui-side-scroll layui-left-menu">
					<?=Undefinitive::adminMenus(YII_DEBUG)?>
				</div>
			</div>
			
			<div class="layui-body">
				<div class="layui-card layuimini-page-header layui-hide-xs">
					<?=Breadcrumbs::widget(['links' => $this->breadcrumbs, 'navOptions'=>['class'=>'right']]) ?>
					
				</div>
				
				
				
				
				<div class="layuimini-content-page">
					<div class="layuimini-container layui-anim layui-anim-upbit">
						<div class="layuimini-main">
							<?=$content?>
						</div>
					</div>
				</div>
				
				
				
				
			</div>
		</div>
		
<?php $this->endBody() ?>
		
	<?php 
$js = <<<JS
	layui.use(['element', 'layer', 'form', 'layuimini'], function () {
		var $ = layui.jquery,
			element = layui.element,
			layer = layui.layer,
			layuimini = layui.layuimini;

		//layuimini.init('api/init.json');

		$('.login-out').on("click", function () {
			layer.msg('退出登录成功', function () {
				window.location = '/page/login-1.html';
			});
		});

		layuimini.listen();

	});
JS;
$this->registerJs($js);

?>	
		
		
		
		
<script type="text/javascript">
</script>
	</body>
	
</html>
<?php $this->endPage() ?>
