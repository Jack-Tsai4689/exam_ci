<!DOCTYPE html>
<html lang="zh-Hant-TW">
<HEAD>
	<META http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=11; IE=10; IE=9; IE=8; IE=7" />
	<script type="text/javascript" src="<?=base_url('/js/html5media.min.js')?>"></script>
	<script type="text/javascript" src="<?=base_url('/js/jquery.min.js')?>"></script>
	<link rel="stylesheet" type="text/css" href="<?=base_url('/css/reset.css')?>">
	
	<script type="text/javascript" src="<?=base_url('/js/jquery-pack.js')?>"></script>
	<script type="text/javascript" src="<?=base_url('/js/jquery.imgareaselect.min.js')?>"></script>
	<style type="text/css">
		body {
			background-color: white;
		}
    	#all {
    		margin: 20px auto;
    		width: 90%;
    	}
    	.cen {
    		margin: 0 auto;
    		padding: 20px 0px 10px 0px;
    		margin: 0px 20px 0px 20px;
    		position: relative;
    		float: left;
    		width: 97%;
    	}
    	.title {
    		height: 30px;
    		line-height: 30px;
    		margin-bottom: 5px;
    		background-color: #F2D9B6;
    		border-bottom: 1px #B4B5B5 solid;
    		border-right: 1px #B4B5B5 solid;
    		border-left: 1px #B4B5B5 solid;
    		float: left;
    		width: 100%;
    	}
    	.title label {
    		margin-left: 20px;
    	}
    	.input_field {
    		margin:0px;
            width: 500px;
    	}
    	.btn {
    		font-size: 14px;
    	}
    	.f14{
    		margin-left: 5px;
    		margin-right: 5px;
    	}
    	.deep {
    		background-color: #F5F5F4;
    	}
        .deep input {
            margin-left: 5px;
        }
    	.list tr td{
    		margin-bottom: 10px;
    		height: 25px;
    		line-height: 25px;
    		padding-left: 10px;
    		vertical-align: top;
            text-align: center;
    	}
    	.list {
    		margin-bottom: 20px;
    	}
	#fixedBottom {
	    position:fixed;
	    right:110px; bottom:20px; z-index:100;
	    float: right;
	    _position:absolute; 
	    _top:expression(eval(document.body.scrollTop+document.body.clientHeight- this.offsetHeight-(parseInt(this.currentStyle.marginBottom,10)||50))); 
	    _left:expression(expression(eval(offsetParent.scrollLeft+offsetParent.clientWidth-this.offsetWidth)-(parseInt(this.currentStyle.marginLeft,10)||0)-(parseInt(this.currentStyle.marginRight,10)||0)) + 30);
	}   
	</style>
	<TITLE>上傳</TITLE>
</head>
<body>
<div id="all">
	<div class="title"><label class="f17">裁切圖像</label></div>
	<div class="content">
		<div class="cen">
			<form name="thumbnail" action="<?=site_url('/knowledge/cut_act')?>" method="post" enctype="multipart/form-data" onsubmit="return check();">
                <input type="hidden" name="x1" value="" id="x1" />
				<input type="hidden" name="y1" value="" id="y1" />
				<input type="hidden" name="x2" value="" id="x2" />
				<input type="hidden" name="y2" value="" id="y2" />
				<input type="hidden" name="w" value="" id="w" />
				<input type="hidden" name="h" value="" id="h" />
				<input type="hidden" name="src" id="src" value="<?=$src?>">
				<input type="hidden" name="type" value="<?=$type?>">
				<input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>">
                <div align="left">
					<img src=""
					             style="float: left; margin-right: 10px; width:1000px;" id="thumbnail" title="老師請在圖片上按滑鼠左鍵上下移動試試看，截取完範圍請點擊右下角的「圖片上傳」按鈕"/>
					<div id="fixedBottom" >
					<input type="submit" style="font-size:18pt" name="upload_thumbnail" value="圖片上傳" id="save_thumb">
					</div>				
				</div>
            </FORM>
		</div>
	</div>
</div>
</body>
</html>
<script type="text/javascript">
	window.moveTo(0,0);
	window.resizeTo(screen.width, screen.height);
	$('#thumbnail').attr('src','<?=site_url('/').$src?>?'+Math.random());
	$('.set_all', parent.document).css('margin','1%');
	$('.set_all', parent.document).css('width',screen.width-100);
	$('#que_pic', parent.document).attr('width',screen.width-100).attr('height',(screen.height-300));
function check(){
	if(!confirm('這是您要的範圍嗎?'))return false;
}
function preview(img, selection) {
	var scaleX = <?=$thumb_w?> / selection.width; 
	var scaleY = <?=$thumb_h?> / selection.height; 

	$('#thumbnail + div > img').css({ 
		width: Math.round(scaleX * <?=$current_w?>) + 'px', 
		height: Math.round(scaleY * <?=$current_h?>) + 'px',
		marginLeft: '-' + Math.round(scaleX * selection.x1) + 'px', 
		marginTop: '-' + Math.round(scaleY * selection.y1) + 'px' 
	});
	$('#x1').val(selection.x1);
	$('#y1').val(selection.y1);
	$('#x2').val(selection.x2);
	$('#y2').val(selection.y2);
	$('#w').val(selection.width);
	$('#h').val(selection.height);
	console.log($(".imgareaselect-selection").height());
	
} 

$(document).ready(function () {
	$('#save_thumb').click(function() {
		var x1 = $('#x1').val();
		var y1 = $('#y1').val();
		var x2 = $('#x2').val();
		var y2 = $('#y2').val();
		var w = $('#w').val();
		var h = $('#h').val();
		if(x1=="" || y1=="" || x2=="" || y2=="" || w=="" || h==""){
			//alert("You must make a selection first");
			alert("請先選取要截取的畫面");
			return false;
		}else{
			return true;
		}
	});
}); 

$(window).load(function () { //2:133
	$('#thumbnail').imgAreaSelect({
		  //aspectRatio: '1:1', //截取比例
		  //x1: 0, y1: 0, x2: 1000, y2: 100, //需要處理的區域，原始的
		  minWidth: 1000,maxWidth: 1000, 
		  onSelectEnd: preview //選框移動時觸發的事件
    });
    
});
</script>