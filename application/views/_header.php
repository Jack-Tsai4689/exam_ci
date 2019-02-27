<!DOCTYPE html>
<html lang="zh-Hant-TW">
<head>
	<title><?=$title.'  金牌教師'?></title>
	<META http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=11; IE=10; IE=9; IE=8; IE=7" />
	<script type="text/javascript" src="<?=base_url('/js/html5media.min.js')?>"></script>
	<script type="text/javascript" src="<?=base_url('/js/jquery.min.js')?>"></script>
	<link rel="stylesheet" type="text/css" href="<?=base_url('/css/reset.css')?>">
	<link rel="stylesheet" type="text/css" href="<?=base_url('/css/main.css')?>">
<script type="text/javascript">
	$(function(){
	    $("ul#navigation > li:has(ul) > a").append('<div class="arrow-bottom"><img src="<?=base_url('/open.png')?>" height="20"></div>');
	    $("ul#navigation > li ul li:has(ul) > div a").append('<div class="arrow-right"><img src="<?=base_url('/close.png')?>" height="20"></div>');
	});
	function gb(v){
		return document.getElementById(v);
	}
	function trim(value){
	    return value.replace(/^\s+|\s+$/g, '');
	}
</script>
</head>
<div id="top"><a href="ex_listw.php" title="回首頁"><img src="<?=base_url('/logo.png')?>" style="height:50px;margin-left:50px;"></a>
	<div id="menu">
		<ul id="navigation">
			<?php if ($ident->dp_type==="T"): ?>
			<li>
				<a href="javascript:void(0)">出題系統</a>
				<ul>
					<li><div class="ex"><a href="<?=site_url('/sets')?>">我的考卷</a></div></li>
					<li><div class="ex"><a href="<?=site_url('/question')?>">我的題庫</a></div></li>
					<li><div class="ex"><a href="<?=site_url('/question/cram')?>">補習班題庫</a></div></li>
					<li><div class="ex"><a href="<?=site_url('/knowledge')?>">知識點管理</a></div></li>
				</ul>
			</li>
			<li><a href="<?=site_url('/score')?>">成績查詢</a></li>
			<?php endif; ?>
			<?php if ($ident->dp_type==="S"): ?>
			<!-- <li>
				<a href="javascript:void(0)">線上測驗</a>
				<ul>
					<li><div class="te"><a href="<?=site_url('/exam')?>">評量測驗</a></div></li>
					<li><div class="te"><a href="<?=site_url('/score')?>">成績查詢</a></div></li>
				</ul>
			</li> -->
			<li><a href="<?=site_url('/exam')?>">評量測驗</a></li>
			<li><a href="<?=site_url('/score')?>">成績查詢</a></li>
			<?php endif; ?>
		</ul>
		<div class="top_per" id="top_id"><a href="profile_infoi.php"><?=$_SESSION['gold']->epname.$ident->dp_name?></a></div><div class="top_per"><a href="<?=site_url('/main/logout')?>">登出系統</a></div>
	</div>
</div>