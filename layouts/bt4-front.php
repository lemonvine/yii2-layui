<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use common\bootstrap\assets\FrontAsset;
use common\bootstrap\widgets\NavBar;

FrontAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
		<meta charset="<?= Yii::$app->charset ?>">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<?php $this->registerCsrfMetaTags() ?>
		<title><?= Html::encode($this->title) ?></title>
		<?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>


<header id="header" class="header">
	<div class="header-top">
		<div class="container ">
			<div class="main-header navbar navbar-expand navbar-white">
				<ul class="nav">
					<li class="nav-item">
						<a class="nav-link text-gray" title="北京市" href="#"><span class="icon flaticon-placeholder"></span> 北京市</a>
					</li>
				</ul>
				<ul class="navbar-nav ml-auto right">
					<li class="nav-item">
						<a class="nav-link" href="javascript:;">
							<span class="pl-2 pr-2">柠檬很忙</span> <img src="http://localhost:8082/assets/1e577aa0/img/user2-160x160.jpg" class="image img-circle" alt="User Image">
						</a>
					</li>
				</ul>
			</div>
		
		</div>
	</div>
	<div class="header-middle">
		<div class="container display-table">
			<div class="header-logo">
				<a href="index.html"><img alt="Kobolg" src="images/logo.png" class="logo"></a>
			</div>
			<div class="header-search">
				<form role="search" method="get" class="form-search block-search-form kobolg-live-search-form">
					<input autocomplete="off" class="searchfield txt-livesearch input" name="s" value="" placeholder="Search here..." type="text">
					<button type="submit" class="btn btn-danger btn-submit"><span class="flaticon-search"></span></button>
				</form>
			</div>
			<div class="header-control">
				<a class="block-link" href="cart.html">
					<span class="flaticon-online-shopping-cart cart-icon"></span>
					<span class="cart-count">33</span>
				</a>
			</div>
		</div>
	</div>
	
	<div class="header-navbar">
		<div class="container display-table">
			<div class="navbar-vertical">
				<input type="checkbox" id="btn_menu_title" style="display: none;">
				<div class="navbar-title text-center" id="">
					<label class="navbar-title-text text-center" for="btn_menu_title">全部商品</label>
				</div>	
				<ul class="nav flex-column navbar-content">
					<li class="nav-item">
						<a class="nav-link" title="Camera" href="#"><i class="icon flaticon-technology"></i><span>相机</span></a>
					</li>
					<li class="nav-item">
						<a class="nav-link" title="Camera" href="#"><span class="icon flaticon-console"></span>游戏机</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" title="Camera" href="#"><span class="icon flaticon-technology"></span>相机</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" title="Camera" href="#"><span class="icon flaticon-console"></span>游戏机</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" title="Camera" href="#"><span class="icon flaticon-technology"></span>相机</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" title="Camera" href="#"><span class="icon flaticon-console"></span>游戏机</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" title="Camera" href="#"><span class="icon flaticon-technology"></span>相机</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" title="Camera" href="#"><span class="icon flaticon-console"></span>游戏机</a>
					</li>
				</ul>
				
			</div>
			<div class="navbar-horizontal">
				<ul class="nav">
					<li class="nav-item">
						<a class="nav-link" title="Camera" href="#">首页</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#">全部分类</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#">热卖商品</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#">关于我们</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
</header>










<div class="wrap">
	<div style="background: blue; height: 200px;">
	
	</div>
	<div id="demo" class="carousel slide" data-ride="carousel">
 
  <!-- 指示符 -->
  <ul class="carousel-indicators">
    <li data-target="#demo" data-slide-to="0" class="active"></li>
    <li data-target="#demo" data-slide-to="1"></li>
    <li data-target="#demo" data-slide-to="2"></li>
  </ul>
 
  <!-- 轮播图片 -->
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="https://static.runoob.com/images/mix/img_fjords_wide.jpg">
    </div>
    <div class="carousel-item">
      <img src="https://static.runoob.com/images/mix/img_nature_wide.jpg">
    </div>
    <div class="carousel-item">
      <img src="https://static.runoob.com/images/mix/img_mountains_wide.jpg">
    </div>
  </div>
 
  <!-- 左右切换按钮 -->
  <a class="carousel-control-prev" href="#demo" data-slide="prev">
    <span class="carousel-control-prev-icon"></span>
  </a>
  <a class="carousel-control-next" href="#demo" data-slide="next">
    <span class="carousel-control-next-icon"></span>
  </a>
 
</div>
	
	
	
		<?php
		/*
		NavBar::begin([
				'brandLabel' => Yii::$app->name,
				'brandUrl' => Yii::$app->homeUrl,
				'options' => [
						'class' => 'navbar-inverse navbar-fixed-top',
				],
		]);
		
		$menuItems = [
				['label' => 'Home', 'url' => ['/site/index']],
				['label' => 'About', 'url' => ['/site/about']],
				['label' => 'Contact', 'url' => ['/site/contact']],
		];
		if (Yii::$app->user->isGuest) {
				$menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
				$menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
		} else {
				$menuItems[] = '<li>'
						. Html::beginForm(['/site/logout'], 'post')
						. Html::submitButton(
								'Logout (' . Yii::$app->user->identity->username . ')',
								['class' => 'btn btn-link logout']
						)
						. Html::endForm()
						. '</li>';
		}
		echo \yii\bootstrap4\Nav::widget([
				'options' => ['class' => 'navbar-nav navbar-right'],
				'items' => $menuItems,
		]);
		NavBar::end();
		*/
		?>

		<div class="container">
				<?= $content ?>
		</div>
</div>

<footer id="footer" class="footer">
	<div class="footer-helper">
		<div class="container">
			<div class="row">
				<div class="col-lg-4 col-md-4 col-sm-12">
					<h5 class="text-center">商城介绍</h5>
					<p>小格调商城主要从事精品水果批发，服务于望京地区，我们的提供的水果新鲜，品质优良
					
					</p>
				</div>
				
				<div class="col-lg-4 col-md-4 col-sm-12">
					<h5 class="text-center">品质服务</h5>
					<div class="row">
						<ul class="list-inline col-6 text-center">
							<li><a href="1.html">服务声明</a></li>
							<li><a href="1.html">配送范围</a> </li>
							<li><a href="1.html">购物流程</a> </li>
							<li><a href="1.html">配送范围</a> </li>
						</ul>
						<ul class="list-inline col-6 text-center">
							<li> <a href="1.html">常见问题</a></li>
							<li><a href="1.html">售后服务</a></li>
							<li><a href="1.html">会员服务</a></li>
							<li><a href="1.html">订单服务</a></li>
						</ul>
					
					</div>
				
				</div>
				<div class="col-lg-4 col-md-4 col-sm-12">
					<h5 class="text-center">联系我们</h5>
					<ul class="list-inline">
						<li>客服电话: 400-6666-6666</li>
						<li>在线客服：</li>
						<li>邮箱：Info@info.com</li>
						<li>在线客服</li>
						<li>7x24小时在线订购</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<div class="footer-copyright">
		<div class="container">
			<div class="row">
				<div class="col-md-6">
					<p>© Copyright <?= date('Y') ?> <?= Html::encode(Yii::$app->name) ?>版权所有.</p>
				</div>
				<div class="col-md-6 text-right">
					<p>技术支持: 柠檬工作室</p>
				</div>
			</div>
		</div>
	</div>
</footer>
<a href="javascript:" class="backtotop active"><i class="fa fa-angle-up"></i></a>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
