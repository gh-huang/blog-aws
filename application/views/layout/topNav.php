<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-param" content="_csrf">
    <title>文章管理</title>
    <link href="<?=_PUBLIC?>/css/bootstrap.css" rel="stylesheet">
	<link href="<?=_PUBLIC?>/css/site.css" rel="stylesheet">    
	<style type="text/css">
		.navbar-inverse .navbar-brand {color: #fff;}
	</style>
 	<script src="<?=_PUBLIC?>/js/jquery.js"></script>
	<script src="<?=_PUBLIC?>/js/yii.js"></script>
	<script src="<?=_PUBLIC?>/js/yii.gridView.js"></script>
	<script src="<?=_PUBLIC?>/js/bootstrap.js"></script>
</head>
<body style="overflow-y: scroll">

<div class="wrap">
    <nav id="w1" class="navbar-inverse navbar-fixed-top navbar" role="navigation">
	    <div class="container">

		    <div class="navbar-header">
				<a class="navbar-brand" href="<?=site_url('welcome/index')?>">CodeIgniter博客</a>
			</div>
			<div id="w1-collapse" class="collapse navbar-collapse">
				<ul id="w2" class="navbar-nav navbar-right nav">
					<li <?php if($this->router->class == 'welcomeController' && ($this->router->method == 'index' || $this->router->method='detail')) echo 'class="active"'; ?>><a href="<?=site_url('welcomeController/index')?>">首页</a></li>
					<?php if(isset($_SESSION['is_admin'])): ?>
						<li <?php if($this->router->class == 'postController') echo 'class="active"'; ?>><a href="<?=site_url('postController/postList')?>">文章管理</a></li>

						<li <?php if($this->router->class == 'categoryController') echo 'class="active"'; ?>><a href="<?=site_url('categoryController/categoryList')?>">分类管理</a></li>

						<li <?php if($this->router->class == 'commentController') echo 'class="active"'; ?>><a href="<?=site_url('commentController/commentList')?>">评论管理<span class="badge badge-inverse" id="comment-status-num"></span></a></li>

						<li <?php if($this->router->class == 'replyController') echo 'class="active"'; ?>><a href="<?=site_url('replyController/replyList')?>">回复管理<span class="badge badge-inverse" id="reply-status-num"></span></a></li>

						<li <?php if($this->router->class == 'userController') echo 'class="active"'; ?>><a href="<?=site_url('userController/userList')?>">会员管理</a></li>

						<li><a href="<?=site_url('userController/logout')?>">退出(<?=$_SESSION['username'];?>)</a></li>
					<?php elseif(isset($_SESSION['id'])): ?>
						<li><a href="">我的收藏</a></li>
						<li><a href="">我的评论</a></li>
						<li><a href="">我的提问</a></li>
						<li><a href="<?=site_url('WelcomeController/logout')?>">退出(<?=$_SESSION['username'];?>)</a></li>
					<?php else: ?>
						<li><a href="">关于博主</a></li>
						<li <?php if($this->router->class == 'welcomeController' && $this->router->method == 'register') echo 'class="active"'; ?>><a href="<?=site_url('WelcomeController/register')?>">注册</a></li>
						<li <?php if($this->router->class == 'welcomeController' && $this->router->method == 'login') echo 'class="active"'; ?>><a href="<?=site_url('WelcomeController/login')?>">登录</a></li>
					<?php endif; ?>
				</ul>
			</div>
		</div>
	</nav>