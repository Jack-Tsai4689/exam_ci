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
    	function gb(v){
    		return document.getElementById(v);
    	}
    	function trim(value){
		    return value.replace(/^\s+|\s+$/g, '');
		}
    </script>
	<style type="text/css">
    	#all {
    		width: 800px;
    		margin: 50px auto;
    	}
    	#cen {
            font-size: 20px;
            margin: 20px 20px 0px 20px;
            position: relative;
    	}
    	#cen > div {
    		line-height: 25px;
    	}
    	div.sub {
    		margin-left: 2em;
    		font-size: 16px;
    	}
    	div.sub_intro {
    		/*margin-left: 4em;*/
    		font-size: 16px;	
    	}
    	#go {
    		position: relative;
    		text-align: center;
    		margin-bottom: 20px;
    	}
    	#go input {
    		font-size: 20px;
    	}
    	#tip {
    		font-size: 14px;
    		line-height: 16px !important;
    		margin-top: 5px;
    	}
    	.text{

    	}
	</style>
</head>
<body>
<div id="all">
	<div id="title"><label class="f17"><?=$Setsname?></label></div>
	<form name="form1" id="form1" method="post" action="<?=site_url('/exam/go')?>">
		<div class="content">
			<div id="cen">
				<table cellpadding="0" cellspacing="0" class="list" width="100%">
					<tr>
						<td align="center">總分</td>
						<td><strong><font color="blue"><?=$Sum?></font></strong>分</td>
					</tr>
					<?php foreach ($Sub_info as $key => $v): ?>
	                <tr>
						<td></td>
						<td>第<?=($key+1)?>大題&nbsp;-&nbsp;配分&nbsp;<strong><font color="blue"><?=$v->PERCEN?></font></strong>%</td>
					</tr>
					<tr>
						<td></td>
						<td><?=$v->INTRO?></td>
					</tr>
					<?php endforeach; ?>
					<tr>
						<td align="center">及格</td>
						<td><strong><font color="blue"><?=$Pass_core?></font></strong>分</td>
					</tr>
					<tr>
						<td align="center">限時</td>
						<td><?=$Limetime?></td>
					</tr>
				</table>
				<div id="tip"><font color="red">※&nbsp;<?=$Times?><br>※&nbsp;請再次確認您選擇的考卷是否正確<br>※&nbsp;點擊「開始測驗」進行考試<br>※&nbsp;考試時，請勿重整網頁，以免影響您的考試權益</font></div>
			</div>
            <div id="go"><input type="submit" class="btn w100" value="開始測驗"></div>
		</div>
		<input type="hidden" name="etype" value="<?=$Etype?>">
		<input type="hidden" name="num" value="<?=$Num?>">
		<input type="hidden" name="grade" value="<?=$Grade?>">
		<input type="hidden" name="subject" value="<?=$Subject?>">
		<input type="hidden" name="chapter" value="<?=$Chapter?>">
		<input type="hidden" name="degree" value="<?=$Degree?>">
		<input type="hidden" name="sets" value="<?=$Sid?>">
		<input type="hidden" name="csrf_token" value="<?=$this->security->get_csrf_hash()?>">
	</FORM>
</body>
</html>
<script type="text/javascript">
document.onkeydown = function(event){
//F5->116  F12->123 shift->16 ctrl->17 alt->18 R->82 U->85 I->73 S->83 P->80
	var key_array = [116,123,16,17,18,80,82,83,85,73];
	key_array.forEach(function(key){
		if (event.keyCode==key){
			event.keyCode = 0;
        	event.returnValue = false;
        	return false;
		}
	});
}
// document.oncontextmenu = function(){
// 	window.event.returnValue=false; //將滑鼠右鍵事件取消
// }
//window.moveTo((screen.width)/4,(screen.height)/5);
</script>