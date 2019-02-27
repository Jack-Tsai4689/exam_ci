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
        .math {
            display: none;
        }
        .hiden {
            display: none;
        }
        .show {
            display: block;
        }
	</style>
</head>
<body>
<div id="all">
	<div class="title"><label class="f17"><?=$title?></label></div>
	<FORM name="form1" id="form1" method="POST" enctype="multipart/form-data" onsubmit="return check(this)">
    <div class="content" id="first">
		<div class="cen">
			<table class="list" id="que_main" border="0" width="100%" cellpadding="0" cellspacing="0">
                <tr>
                    <td align="left"><label class="f17">題組題目</label></td>
                    <td><input type="button" value="改回非題組" onclick="location.href='<?=site_url('/question/create')?>'"></td>
                </tr>
                <tr class="deep">
                    <td align="right">題組文字說明</td>
                    <td><textarea  name="gpcontent" id="gpcontent" cols="50" rows="4" value=""></textarea>
                    <br><font class="f12">*題目文字說明或圖檔不可空白</font>
                    </td>
                </tr>
                <tr class="shallow">
                    <td align="right">題組圖檔</td>
                    <td>
                        <IMG id="qimg" src="<?=$Qimg?>" width="80%"><br>
                        <div id="qimg_content"><?=$Qimg_html?></div>
                        <input type="hidden" id="f_qimg" name="f_qimg" value="">
                    	格式：JPG/PNG
                    </td>
                </tr>
                <tr class="deep">
                    <td align="right">題組聲音檔</td>
                    <td><input type="file" name="qsound" id="qsound" accept="audio/mp3">格式：MP3</td>
                </tr>
            </table>
        </div>
    </div>
    <div class="content" style="margin-bottom:50px;">
        <div class="cen" style="padding-bottom:50px;">
            <div style="text-align:left;">
                <input type="hidden" name="csrf_token" value="<?=$this->security->get_csrf_hash()?>">
                    <input type="submit" class="btn w150 h30" value="存檔，接續出子題" name="save_next" id="save_next" onclick="post_act(this.id)">
                    <input type="submit" class="btn w150 h30" value="存檔，離開" name="save_close" id="save_close" onclick="post_act(this.id)">
                    <input type="hidden" name="act" id="act">
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
            處理中...<label id="progress"></label>
            </div>
        </div>
    </div>
</div>
<div id="que_know" class="list_set">
    <div class="set_all">
        <img src="<?=base_url('/loading.gif')?>" id="loading_kstatus">
        <iframe width="1500" height="100%" id="qknows"></iframe>
        <input type="button" style="float:right;" name="" id="" value="關閉" class="btn w100" onclick="close_know()">
    </div>
</div>
</body>
</html>
<script type="text/javascript">
window.moveTo(0,0);
//window.resizeTo(screen.width,screen.height);
window.focus();
function uque(v){
    if (v==="dque"){
        $.ajax({
            type:"POST",
            url:"<?=site_url('/question/rmpic')?>",
            data:{'type':v},
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
function check(form){
    var q=0;
    var error = false;//data_check();
    if (!error){
        //背景post
        $('#posting').show();
        $.ajax({
            type:"POST",
            url:"<?=site_url('/question/addg')?>",
            data:new FormData(form),
            contentType: false,
            processData: false,
            cache: false,
            dataType:"JSON",
            xhrFields: {
                onprogress: function (event) {
                    //Download progress
                    if (event.lengthComputable) {
                        gb('progress').innerHTML = ((event.loaded / event.total) * 100)+'%';
                    }
                }
            },
            success: function(rs){
                if (gb('act').value==="save_next")location.href = '<?=site_url('/question/creategs')?>/'+rs.gid;
                if (gb('act').value==="save_close"){
                    opener.location.href = '<?=site_url('/question')?>';
                    window.close();
                }
            }
        });
    }
    return false;
}
function post_act(act){
    gb('act').value = act;
}
</SCRIPT>