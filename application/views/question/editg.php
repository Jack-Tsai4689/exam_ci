<?php 
//open.png, close.png
//from: http://fontawesome.io/
//author: fontawesome
//copy_from: http://big.miankoutu.com/3gpic/70443, http://big.miankoutu.com/3gpic/69876
?>
<!DOCTYPE html>
<html lang="zh-Hant-TW">
<head>
	<style type="text/css">
    	#all {
    		margin: 20px auto;
    		width: 1152px;
    	}
    	.cen {
    		margin: 0 auto;
    		padding: 20px 0px 10px 0px;
    		margin: 0px 20px 0px 20px;
    	}
    	#sets_title {
    		height: 30px;
    		line-height: 30px;
    		margin-bottom: 5px;
    		background-color: white;
    		border-bottom: 1px #B4B5B5 solid;
    		border-right: 1px #B4B5B5 solid;
    		border-left: 1px #B4B5B5 solid;
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
    	#sets_title label{
    		margin-left: 20px;
    	}
    	.title label {
    		margin-left: 20px;
            float: left;
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
    	.shallow {
    		background-color: #FCFCFC;
    	}
    	.shallow td{
    		padding: 10px 0px 10px 0px;
    	}
    	#duty td {
    		padding-bottom: 0px;
    	}
    	.list tr td{
    		margin-bottom: 10px;
    		height: 25px;
    		line-height: 25px;
    		padding-left: 10px;
    		vertical-align: top;
    	}
    	.list label {
    		margin-right: 5px;
    	}
    	.list input {
    		margin-right: 5px;
    	}
    	.table_last {
    		margin-bottom: 20px;
    	}
    	.oans {
    		display: none;
    	}
    	.oans_control, .oans_control label {
    		cursor: pointer;
            float: left;
    	}
        .oans_control label {
            float: left;
        }
        .oans_pic {
            float: right;
        }
        .title_pic {
            float: left;
            width: 25px;
            height: 25px;
            margin-top: 3px;
        }
        /*#oans_pic {
            float: right;
            margin-top: 2px;
        }*/
    	select {
    		margin-right: 5px;
    	}
    	textarea {
    		width: 500px;
    		height: 60px;
    		margin: 5px 0px 5px 0px;
            border: 1px #EED6B4 solid;
    	}
        .custom-combobox {
            position: relative;
            display: inline-block;
        }
        .custom-combobox-toggle {
            position: absolute;
            top: 0;
            bottom: 0;
            margin-left: -1px;
            padding: 0;
        }
        .custom-combobox-input {
            margin: 0 !important;
            padding: 5px 10px;
        }
        .set_all {
            margin: 2% auto;
            width: 960px;
            text-align: center;
        }
        #more_btn {
            text-align: center;
            background-color: #F8CDB9;
        }
        #more_btn:hover {
            background-color: #FCE3CE;
            cursor: pointer;
        }
        .move {
            display: inline-block;
            margin-left: 20px;
        }
        #ans_group {
            display: inline-block;
        }
        .error_msg {
            color: red;
        }
        #que_pic {
            display: none;
        }
        #loading_status {
            width: 48px;
        }
        #correct_ans_math span{
            width: 40px;
            display: inline-block;
        }
        #correct_ans_math div:last-child {
            border: 0.5px #E6E6E6 solid;
            display: inline-block;
            padding: 0px 5px 0px 5px;
        }
        #correct_ans_math div {
            border: 0.5px #E6E6E6 solid;
            display: inline-block;
            padding: 0px 5px 0px 5px;
            border-bottom: none;
        }
        .audio {
            /*width: 300px;*/
        }
        /*#partd {
            display: none;
        }*/
        .math, .write {
            display: none;
        }
        .hiden {
            display: none;
        }
        .show {
            display: block;
        }
        video {
            width: 80%;
        }
	</style>
</head>
<body>
<div id="all">
	<div class="title"><label class="f17"><?=$title?></label></div>
	<FORM name="form1" id="form1" method="POST" enctype="multipart/form-data" action="<?=site_url('/question/updateg').'/'.$Qid?>" onsubmit="return check(this)">
    <div class="content" id="first">
		<div class="cen">
			<table class="list" id="que_main" border="0" width="100%" cellpadding="0" cellspacing="0">
                <tr>
                    <td align="left"><label class="f17">題組題目</label></td>
                    <td></td>
                </tr>
                <tr class="deep">
                    <td align="right">題目文字說明</td>
                    <td><textarea  name="f_quetxt" id="f_quetxt" cols="50" rows="4" onkeydown="done()" value="<?=$Quetxt?>"><?=$Quetxt?></textarea>
                    <br><font class="f12">*題目文字說明或圖檔不可空白</font>
                    </td>
                </tr>
                <tr class="shallow">
                    <td align="right">題目圖檔</td>
                    <td>
                        <IMG id="qimg" src="<?=$Qimg?>" width="98%"><br>
                        <div id="qimg_content"><?=$Qimg_html?></div>
                        <input type="hidden" id="f_qimg" name="f_qimg" value="<?=$Qimgsrc?>">
                        格式：JPG/PNG
                    </td>
                </tr>
                <tr class="deep">
                    <TD align="right">題目聲音檔</TD>
                    <td><?=$Qsound_html?>
                        <div id="qudiv"  <?=$Qsound_hidden?>><input type="file" name="f_qsound" id="f_qsound" accept="audio/mp3">格式：MP3</div>
                    </TD>
                </TR>
            </table>
        </div>
    </div>
    <div class="content" style="margin-bottom:50px;">
        <div class="cen" style="padding-bottom:50px;">
            <div style="text-align:left;">
                <input type="hidden" name="csrf_token" value="<?=$this->security->get_csrf_hash()?>">
                    <input type="submit" class="btn w150 h30" value="確定" name="save_close" id="save_close">
            </div>
        </div>
    </div>
    </form>
</div>
<div id="sets_filed" class="list_set">
    <div class="set_all">
        <img src="<?=base_url('/loading.gif')?>" id="loading_status">
        <iframe width="1500" height="920" id="que_pic"></iframe>
        <input type="button" style="float:right;" name="" id="" value="關閉" class="btn w100" onclick="close_pic()">
    </div>
</div>
<div id="posting" class="list_set">
    <div class="set_all">
        <div class="set_content">
            <div class="set_cen">
            處理中...
            </div>
        </div>
    </div>
</div>
<form id="udata">
    <input type="hidden" name="type" id="uq">
    <input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>">
</form>
</body>
</html>
<script type="text/javascript">
function gb(v){
    return document.getElementById(v);
}
window.moveTo(0,0);
window.resizeTo(screen.width,screen.height);
window.focus();

function uque(v){
    if (v==="dedque"){
        if (!confirm('確定刪除？'))return false;
        gb('uq').value = v;
        $.ajax({
            type:"POST",
            url:"<?=site_url('/question/rmpic')?>",
            data:$(gb('udata')).serialize(),
            dataType:"JSON",
            success: function(rs){
                gb('qimg_content').innerHTML = rs.html;
                gb('qimg').src = '';
                gb('f_qimg').value = '';
            }
        });
        return;
    }
    document.getElementById('que_pic').src="<?=site_url('/question/qupload')?>?type="+v;
    $('#sets_filed').show();
    $('#loading_status').show();
    $("#que_pic").load(function(){
        $('#loading_status').hide();
        $('#que_pic').show();
    });
}
function close_pic(){
    $('#sets_filed').hide();
    $('#que_pic').hide();
}

function trim(value){
    return value.replace(/^\s+|\s+$/g, '');
}
var action = false;
function done(){
    action = true;
}

function check(act){
    var q=0;
    var error = false;//data_check();
    if (!error){
        //背景post
        $('#posting').show();
        // $.ajax({
        //     type:"POST",
        //     url:"<?=site_url('/question/updateg').'/'.$Qid?>",
        //     data:new FormData(gb('form1')),
        //     contentType: false,
        //     processData: false,
        //     cache: false,
        //     dataType:"JSON",
        //     success: function(rs){
        //         opener.location.href = '<?=site_url('/question')?>';
        //         window.close();
        //     }
        // });
        // return false;
    }

}
function remove_point(){
    var point = document.getElementById('point_content');
    point.innerHTML = '<input type="button" value="選擇知識點" class="btn w100 h25" name="f_btn" onClick="select_point()">';
    // var point = $('#point_content');
    // point.html('');
    // point.append($('<input>').attr({type:'button',value:'選擇知識點',class:'btn w100 h25',name:'f_btn',onClick:'select_point()'}));
    // document.getElementById('f_pid').value = 't';
    // document.forms[0].submit();
}
function rem(elem){
    if (confirm('檔案無法復原，確定?')){
        switch(elem){
            case 'delqimg':
                gb('f_qimg').value = '';
                gb('qimg').src = '';
            case 'delqaudio':
                gb('f_qsound').value = '';
                $("#qudiv").removeClass('hiden');
                $("#qsound_d").remove();
                break;
            case 'delsaudio':
                gb('f_asound').value = '';
                $("#asound_d").remove();
                break;
            case 'delsavideo':
                gb('f_avideo').value = '';
                $("#avideo_d").remove();
                break;
        }
    }
}
</SCRIPT>