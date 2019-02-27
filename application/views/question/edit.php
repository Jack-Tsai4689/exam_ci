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
	<FORM name="form1" id="form1" method="POST" enctype="multipart/form-data">
    <div class="content" id="first">
		<div class="cen">
			<table class="list" id="que_main" border="0" width="100%" cellpadding="0" cellspacing="0">
                <tr>
                    <td align="left"><label class="f17">題目</label></td>
                    <td></td>
                </tr>
				<tr class="deep">
                    <td align="right">題型<font color="red">＊</font></td>
                    <td width="80%">
                    	<label><input type="radio" name="f_qus_type" <?=$Que_type->S?> value="S" onclick="change_type(this.value)">單選題</label>
                        <label><input type="radio" name="f_qus_type" <?=$Que_type->D?> value="D" onclick="change_type(this.value)">複選題</label>
                        <label><input type="radio" name="f_qus_type" <?=$Que_type->R?> value="R" onclick="change_type(this.value)">是非題</label>
                        <label><input type="radio" name="f_qus_type" <?=$Que_type->M?> value="M" onclick="change_type(this.value)">選填題</label>
                        <label><input type="radio" name="f_qus_type" <?=$Que_type->G?> value="G" onclick="change_type(this.value)">題組</label>(最多10小題)
                        <font class="f12">*儲存後將無法變更題型</font>
                    </td>
                </tr>
                <tr class="shallow">
                    <td align="right">題目文字說明</td>
                    <td><textarea  name="f_quetxt" id="f_quetxt" cols="50" rows="4" onkeydown="done()" value="<?=$Quetxt?>"><?=$Quetxt?></textarea>
                    <br><font class="f12">*題目文字說明或圖檔不可空白</font>
                    </td>
                </tr>
                <tr class="deep">
                    <td align="right">題目圖檔</td>
                    <td>
                        <IMG id="qimg" src="<?=$Qimg?>" width="98%"><br>
                        <div id="qimg_content"><?=$Qimg_html?></div>
                        <input type="hidden" id="f_qimg" name="f_qimg" value="<?=$Qimgsrc?>">
                        格式：JPG/PNG
                    </td>
                </tr>
                <tr class="shallow">
                    <TD align="right">題目聲音檔</TD>
                    <td><?=$Qsound_html?>
                        <input type="file" name="qsound" id="qsound" accept="audio/mp3">格式：MP3
                    </TD>
                </TR>
                <tr class="deep">
                    <td align="right">知識點</td>
                    <td>
                        <input type="hidden" id="f_pid" name="f_pid" value="<?=$Know_id?>"/>
                        <div><input type="button" id="addpoint" value="選擇知識點"><div id="point_content" style="display: inline-block;"><?=$Know_content?></div>
                        <font color="green">*「知識點」有助於學生在看診斷報告時，對題目的解答較易於融會貫通噢~</font>
                    </td>
                </tr>
                <tr>
                    <td align="left" colspan="2"><label class="f17">範圍</label><font color="green">*確實設定範圍，在學生的診斷報告中，較可以準確分析學生「較強」或「較弱」是哪些</font></td>
                </tr>
                <tr class="deep">
                    <td align="right">年級<font color="red">＊</font></td>
                    <td width="80%">
                        <select name="f_grade" id="f_grade" onchange="subj_c(this.value,'q')"><?=$Q_Grade?></select>
                    </td>
                </tr>
                <tr class="shallow">
                    <td align="right">科目<font color="red">＊</font></td>
                    <td id="subj">
                        <select name="f_subject" id="f_subject" onchange="chap_c(this.value,'q')"><?=$Q_Subject?></select>
                    </td>
                </tr>
                <tr class="deep">
                    <TD align="right">章節<font color="red">＊</font></TD>
                    <td>
                        <div class="ui-widget">
                            <select id="f_chapterui" name="f_chapterui">
                                <option value=""></option><?=$Q_Chapter?>
                            </select>
                            <label id="chapter_error" class="error_msg" style="margin-left:40px;"></label>
                        </div>
                    </TD>
                </TR>
            </table>
            <table class="list" border="0" width="100%" cellpadding="0" cellspacing="0" id="notgp">
                <tr>
                    <td align="left"><label class="f17">選項</label></td>
                    <td></td>
                </tr>
                <tr class="shallow" name="ans_type" <?=$Rtype?>>
                    <td align="right">選項個數<font color="red">＊</font></td>
                    <td>
                        <select name="option_num" id="option_num" onchange="optnum(this.value)"><?=$Option_num?></select>
                    </td>
                </tr>
                <tr class="deep" id="simple">
                    <td align="right">正確答案<font color="red">＊</font></td>
                    <td width="80%">
                        <div id="ans_group"><?=$Ans?></div>
                        <label id="ans_group_error" class="error_msg"></label>
                    </td>
                </tr>
                <tr class="deep math">
                    <td align="right">選項題數<font color="red">＊</font></td>
                    <td width="80%">
                        <select name="num" id="num" onchange="num_change(this.value)"><?=$Num?></select>
                    </td>
                </tr>
                <tr class="shallow math">
                    <td align="right">正確解答<font color="red">＊</font></td>
                    <td id="correct_ans_math"><?=$Correct_ans_math?></td>
                </tr>
                <tr class="deep write">
                    <td align="right">標準答案<font color="red">＊</font></td>
                    <td width="80%">
                        <label><input type="radio" name="write_correct" checked id="0">無</label>
                        <label><input type="radio" name="write_correct" id="1">有</label>
                        <input type="text" name="" id="" class="input_field">
                    </td>
                </tr>
                <tr class="shallow">
                    <TD align="right">難易度</TD>
                    <td>
                        <label><input type="radio" name="f_degree" value="E" <?=$Degree->E?> >容易</label>
                        <label><input type="radio" name="f_degree" value="M" <?=$Degree->M?> >中等</label>
                        <label><input type="radio" name="f_degree" value="H" <?=$Degree->H?> >困難</label>
                    </TD>
                </TR>
                <tr>
                    <td><label class="f17 oans_control" id="oans_control" onclick="show_oans('oans')">詳解<img class="oans_pic" id="pic_oans" src="<?=base_url('/close.png')?>" height="20"></label></td>
                    <td></td>
                </tr>
            </table>
			<table class="list table_last oans" border="0" width="100%" cellpadding="0" cellspacing="0" id="oans">
				<tr class="deep">
                    <td align="right">文字說明</td>
                    <td width="80%">
                    	<textarea  name="f_anstxt" cols="50" rows="4" value="<?=$Anstxt?>"><?=$Anstxt?></textarea>
                    </td>
                </tr>
                <tr class="shallow">
                    <td align="right">圖片檔</td>
                    <td>
                        <IMG id="aimg" src="<?=$Aimg?>" width="98%"><br>
                        <div id="aimg_content"><?=$Aimg_html?></div>
                        <input type="hidden" id="f_aimg" name="f_aimg" value="<?=$Aimgsrc?>">
                        格式：JPG/PNG
                    </td>
                </tr>
                <tr class="deep">
                    <TD align="right">聲音檔</TD>
                    <td><?=$Asound_html?>
                        <input type="file" name="asound" id="asound" accept="audio/mp3">格式：MP3
                    </TD>
                </TR>
                <tr class="shallow">
                    <td align="right">影片檔</td>
                    <td><?=$Avideo_html?>
                        <input type="file" name="avideo" id="avideo" accept="video/mp4">格式：MP4
                    </TD>
                </tr>
            </table>
        </div>
    </div>
    <div class="content" style="margin-bottom:50px;">
        <div class="cen" style="padding-bottom:50px;">
            <div style="text-align:left;">
                <input type="hidden" name="csrf_token" value="<?=$this->security->get_csrf_hash()?>">
                    <input type="button" class="btn w150 h30" value="確定" name="save_close" id="save_close" onclick="check()">
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
<div id="que_know" class="list_set">
    <div class="set_all">
        <img src="<?=base_url('/loading.gif')?>" id="loading_kstatus">
        <iframe width="1500" height="100%" id="qknows"></iframe>
        <input type="button" style="float:right;" name="" id="" value="關閉" class="btn w100" onclick="close_know()">
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
</body>
</html>
<script type="text/javascript">
function gb(v){
    return document.getElementById(v);
}
<?=$now_type?>
function show_oans(elem){
    var oans = $('#'+elem);
    if (oans.css('display')=='none'){
        oans.css('display','table');
        $('#pic_'+elem).prop('src','<?=base_url('/open.png')?>');
    }else{
        oans.css('display','none');
        $('#pic_'+elem).prop('src','<?=base_url('/close.png')?>');
    }
}
window.moveTo(0,0);
window.resizeTo(screen.width,screen.height);
window.focus();
// function get_data2(f_qid,f_type) {
//     window.open("upvs_2.php?f_qid="+f_qid+"&f_type="+f_type,null,'width=700px,height=500px,resizable=yes,scrollbars=yes,status=yes');
// }
(function( $ ) {
    $.widget( "custom.combobox", {
        _create: function() {
           this.wrapper = $( "<span>" )
               .addClass( "custom-combobox" )
               .insertAfter( this.element );
            this.element.hide();
            this._createAutocomplete();
            this._createShowAllButton();
        },
        _createAutocomplete: function() {
            var selected = this.element.children( ":selected" ),
                value = selected.val() ? selected.text() : "";
            if(''!=$( "#f_chapter" ).val()&&''==value) value=$( "#f_chapter" ).val();
            this.input = $( "<input>" )
                .appendTo( this.wrapper )
                .val( value )
                .attr( "title", "" )
                .addClass( "custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left" )
                .autocomplete({
                    delay: 0,
                    minLength: 0,
                    source: $.proxy( this, "_source" )
                })
                .tooltip({
                    tooltipClass: "ui-state-highlight"
               });
    
            this._on( this.input, {
                autocompleteselect: function( event, ui ) {
                    ui.item.option.selected = true;
                    this._trigger( "select", event, {
                        item: ui.item.option
                    });
                },
                autocompletechange: "_removeIfInvalid"
            });
        },
        _createShowAllButton: function() {
            var input = this.input,
            wasOpen = false;
            $( "<a>" ).attr( "tabIndex", -1 )
                      .attr( "title", "顯示此年級、科目下所有章節" )
                      .tooltip()
                      .appendTo( this.wrapper )
                      .button({
                        icons: {
                           primary: "ui-icon-triangle-1-s"
                        },
                        text: false
                      })
                      .removeClass( "ui-corner-all" )
                      .addClass( "custom-combobox-toggle ui-corner-right" )
                      .mousedown(function() {
                        wasOpen = input.autocomplete( "widget" ).is( ":visible" );
                      })
            .click(function() {
               input.focus();
    // Close if already visible
                   if ( wasOpen ) { return; }
    // Pass empty string as value to search for, displaying all results
               input.autocomplete( "search", "" );
            });
        },
        _source: function( request, response ) {
            var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
            response( this.element.children( "option" ).map(function() {
                var text = $( this ).text();
                if ( this.value && ( !request.term || matcher.test(text) ) )
                return {
                    label: text,
                    value: text,
                    option: this
                };
            }) );
        },
        _removeIfInvalid: function( event, ui ) {
            $( "#f_chapter" ).val(this.input.val());
        },
        _destroy: function() {
           this.wrapper.remove();
           this.element.show();
        }
    });
})( jQuery );
    
$(function() {
    $( "#f_chapterui" ).combobox();
});
// function delete_que(){//刪除
//     if (confirm('刪除後以上您輸入的資料都會消失，您確定要刪除嗎?')){
//         location.href="ex_md.php?act=delete";
//     }
// }
//var rows_m = 1;

function subj_c(v, type){
    $.ajax({
        type:"GET",
        url:"<?=site_url('/basic/gsclist')?>",
        dataType:"JSON",
        data:{'type':'subj', 'g':v},
        success: function(rs){
            if (type==="q")$("#f_subject").html('');
            var html = '';
            for(var i in rs){
                html+= '<option value="'+rs[i].ID+'">'+rs[i].NAME+'</option>';
            }
            if (type==="q"){
                $("#f_subject").html(html);
                chap_c(gb('f_subject').value, type);
            }else{
                $("#s_subject").html(html);
                chap_c(gb('s_subject').value, type);
            }
        }
    });
}
function chap_c(v, type){
    $('.custom-combobox-input').val('');
    $('#f_chapterui').empty();
    $.ajax({
        type:"GET",
        url:"<?=site_url('/basic/gsclist')?>",
        dataType:"JSON",
        data:{'type':'chap', 'g':gb('f_grade').value, 's':v},
        success: function(rs){
            var html = '';
            for(var i in rs){
                html+= '<option value="'+rs[i].ID+'">'+rs[i].NAME+'</option>';
            }
            $("#f_chapterui").html(html);
        }
    });
}

function num_change(v){//選填用
    var math = $('#form1 #correct_ans_math');
    var html = '';
    for(var i=1; i<=v;i++){
        html+= '<div id="a'+i+'"><span>No.'+i+'</span>';
        var j = 1;
        while (j<=9){
            html+= '<label><input type="radio" name="ans'+i+'" value="'+j+'">'+j+'</label>';
            j++;
        }
        html+= '<label><input type="radio" name="ans'+i+'" value="0">0</label>';
        html+= '<label><input type="radio" name="ans'+i+'" value="a">-</label>';
        html+= '<label><input type="radio" name="ans'+i+'" value="b">±</label>';
        html+= '</div>';
    }
    math.html(html);
}
function uque(v){
    if (v==="deque"){
        $.ajax({
            type:"POST",
            url:"<?=site_url('/question/rmpic')?>",
            data:{'type':v, 'csrf_token':getCookie('csrf_token')},
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
function uans(v){
    if (v==="deans"){
        $.ajax({
            type:"POST",
            url:"<?=site_url('/question/rmpic')?>",
            data:{'type':v, 'csrf_token':getCookie('csrf_token')},
            dataType:"JSON",
            success: function(rs){
                gb('aimg_content').innerHTML = rs.html;
                gb('aimg').src = '';
                gb('f_aimg').value = '';
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
function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}
function close_pic(){
    $('#sets_filed').hide();
    $('#que_pic').hide();
}
function select_point(){//知識點
    document.getElementById('que_pic').src="";
    document.getElementById('que_pic').src="ex_point.php?fkey=6";
    $('#que_pic').attr('width','100%');
    $('#que_pic').attr('height',screen.height*0.8);
    $('#sets_filed .set_all').css('width','90%');
    $('#sets_filed').show();
    //var point = window.open("ex_point.php?fkey=6","ex_point","width=1240px,height=600px,resizable=yes,scrollbars=yes,status=yes");
}
// document.onkeydown = function(event){//鎖特定按鍵 116 F15  123 F12
//     if (event.keyCode == 116){
//         if (confirm('確定要重新整理?未存檔資料將可能遺失!')){
//         }else{
//             event.keyCode = 0;
//             event.returnValue = false;
//         }
//     }
// }
function trim(value){
    return value.replace(/^\s+|\s+$/g, '');
}
var action = false;
function done(){
    action = true;
}
function form_check(obj){
    if (data_check()){
        alert('請確認無誤');
        return false;
    }
}
function data_check(){
    var no = '';
    var error = false;
    var i = 0;
    var correct_ans = $('input[name="ans[]"]:checked').val();
    if (correct_ans==null){
        document.getElementById('ans_group_error').innerHTML = '(X) 設定答案';
    }else{
        document.getElementById('ans_group_error').innerHTML = '';
    }
    var chapter = document.getElementById('f_chapter').value;
    if (trim(chapter)==''){
        error = true;
        document.getElementById('chapter_error').innerHTML = '(X) 章節勿空白';
    }else{
        document.getElementById('chapter_error').innerHTML = '';
    }
    return error;
}
var originurl = opener.location.href;
function check(){
    var error = false;//data_check();
    if (!error){
        //var form = new FormData(gb('form1'));
        //背景post
        $('#posting').show();
        $.ajax({
            type:"POST",
            url:"<?=site_url('/question/update').'/'.$Qid?>",
            data:new FormData(gb('form1')),
            contentType: false,
            processData: false,
            cache: false,
            dataType:"JSON",
            success: function(rs){
                opener.location.href = '<?=site_url('/question')?>';
                window.close();
            }
        });
    }
}
function no_display(num){//編號切換
    var j ='';
    for (var i=0; i <num; i++) {
        j = String.fromCharCode(i+65);
        $('#ans_'+(i+1)).html(j);
    }
}
function change_type(ans_t){//選項設定
    if (ans_t!=="M"){
        $(gb('simple')).show();
        $('tr[name="ans_type"]').show();
        $(".math").hide();
    }
    switch(ans_t){
        case 'S'://單選
            $('#form1 tr[name=ans_type]').css('display','table-row');
            var num = gb('option_num').value;
            var html = '';
            for (var i =1; i <=num; i++) {
                j = String.fromCharCode(i+64);
                html+= '<label><input name="ans[]" type="radio" value="'+i+'"><font id="ans_'+i+'">'+j+'</font></label>';
            }
            $('#form1  #ans_group').html(html);
            break;
        case 'D'://複選
            $('#form1 tr[name=ans_type]').css('display','table-row');
            var num = gb('option_num').value;
            var html = '';
            for (var i =1; i <=num; i++) {
                j = String.fromCharCode(i+64);
                html+= '<label><input name="ans[]" type="checkbox" value="'+i+'"><font id="ans_'+i+'">'+j+'</font></label>';
            }
            $('#form1  #ans_group').html(html);
            break;
        case 'R'://是非
            var html = '';
            html+= '<label><input type="radio" name="ans[]" value="1" checked>O</label>  <label><input type="radio" name="ans[]" value="2">X</label>';
            $('#form1 tr[name=ans_type]').css('display','none');
            $('#form1 #ans_group').html(html);
            break;
        case 'M'://選填
            $('tr[name="ans_type"]').hide();
            $(gb('simple')).hide();
            $(".math").show();
            break;
    }
}
function optnum(v){//選項數擷取
    var type = $('input[name="f_qus_type"]:checked').val();
    change_type(type);
}
function ao_display(n, v){//編號切換
    var j ='';
    var l =n.length;
    var newn = n.substring(8,l);
    var num = $('#form1 > #option_num'+newn).val();
    for (var i=0; i <num; i++) {
        if (v==0)j = i+1;
        if (v==1)j = String.fromCharCode(i+65);
        //alert(j);
        $('#form1 > #ans'+newn+'_'+(i+1)).html(j);
    }
}
function change_ans_type(ans_q,ans_t){//選項設定
    
    var l = ans_q.length;
    var newn = ans_q.substring(8);
    var ans_type = '';
    var form1 = document.getElementById('form1');
    //alert(ans_q+','+ans_t);
    if (ans_t == 1 || ans_t == 3){ans_type = 'radio';}
    if (ans_t == 2){ans_type = 'checkbox';}
    $(form1).find('#q'+newn+' > input[name="correct_ans'+newn+'[]"]').each(function(){
        $(this).attr('type',ans_type);
        $(this).prop('type',ans_type);
    });
    var ans_len = $(form1).find('#q'+newn+' > input[name="correct_ans'+newn+'[]"]').length;

    if (ans_t == 3){
        $(form1).find('#q'+newn+' > tr[name=ans_type'+newn+']').css('display','none');
        var html = '<label><input name="correct_ans'+newn+'[]" type="radio" value="1" checked>O</label><label><input name="correct_ans'+newn+'[]" type="radio" value="2" checked>X</label>';
        $(form1).find('#q'+newn+' > #ans_group'+newn).html(html);
        // $(form1).find('#q'+newn+' > #ans_group'+newn).append(
        //     $('<label>').append($('<input>').attr({name:'correct_ans'+newn+'[]', type: 'radio', value:'1', checked:true}),'O'),
        //     $('<label>').append($('<input>').attr({name:'correct_ans'+newn+'[]', type: 'radio', value:'2'}),'X')
        // );
    }else{
        $('tr[name=ans_type'+newn+']').css('display','table-row');
        var ans_ntype = $('input:radio[name="f_ansopt'+newn+'"]:checked').val();
        var num = $('#option_num'+newn).val();
        //alert(num+','+ans_len);
        //alert(num);
        var all = num-ans_len;
        if (ans_len==2){
            $('#form1 > #ans_group'+newn).html('');
            var i=0;
            var j ='';
            var qtype = '';
            if (ans_t==2){ qtype = 'checkbox'; }
            if (ans_t==1){ qtype = 'radio'; }
            for (i; i <num; i++) {
                j = i+1;
                // if (ans_ntype==1)j = String.fromCharCode(i+65);
                $('#form1 > #ans_group'+newn).append(
                    $('<label>').append( $('<input>').attr({name:'correct_ans'+newn+'[]', type: qtype, value:i}),$('<font>').attr('id','ans'+newn+'_'+j).text(j))
                );
            }
            ao_display('#form1 f_ansopt'+newn,ans_ntype);
        }else{
            switch (true){
                case all>0:
                var html = '';
                    for (i=ans_len; i <num; i++) {
                        j = i+1;
                        // if (ans_ntype==1)j = String.fromCharCode(i+65);
                        html+= '<label><input name="correct_ans'+newn+'[]" type="'+ans_type+'" value="'+j+'"><font id="ans'+newn+'_'+j+'">'+j+'</font></label>';
                        // $('#form1 > #ans_group'+newn).append(
                        //     $('<label>').append( $('<input>').attr({name:'correct_ans'+newn+'[]', type: ans_type, value:i}),$('<font>').attr('id','ans'+newn+'_'+j).text(j))
                        // );
                    }
                    $(form1).find('#ans_group'+newn).append(html);
                    ao_display('f_ansopt'+newn,ans_ntype)
                    break;
                case all<0:
                    for(var i=ans_len; i>num; i--){
                        $(form1).find('#ans_group'+newn+' label:last').remove();
                    }
                    break;
            }
        }
    }
}
function opt_num(n, v){//選項數擷取
    var l = n.length;
    var newn = n.substring(10);
    var type = $('#form1').find('#q'+newn).find('#qus_type'+newn).val();
    //var type = $('#form1 > #q'+newn+' #qus_type'+newn).val();
    //alert(newn+','+type);
    change_ans_type('qus_type'+newn,type);
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
$("#addpoint").on('click', function(){
    document.getElementById('qknows').src= "<?=site_url('/knowledge/join')?>";
    openframe();
});
$("#point_content").on("click", "#clear_know", function(){
    gb('f_pid').value = '';
    gb('point_content').innerHTML = '';
});
function close_know(){
    $('#que_know').hide();
    $('#qknows').hide();
}
function openframe(){
    gb("qknows").style.width = '100%';
    gb("qknows").style.height = screen.height*0.7+'px';
    // $('#que_pic').attr('width','100%');
    // $('#que_pic').attr('height',screen.height*0.8);
    $('#que_know .set_all').css('width','90%');
    $('#que_know').show();
    $('#loading_kstatus').show();
    $("#qknows").load(function(){
        $('#loading_kstatus').hide();
        $('#qknows').show();
    });
}
function rem(elem){
    if (confirm('檔案無法復原，確定?')){
        switch(elem){
            case 'delqaudio':
                gb('f_qsound').value = '';
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

<?php 
if (!empty($f_qid)){ 
    echo 'var no='.($sub_rows+1).';';
    echo 'var num='.($sub_rows+1).';';
}else{
    echo 'var no=1;';
    echo 'var num=1;';
}
?>
function remove_q(no){
    if (confirm('確定移除?')){
        $('#nq'+no).remove();
        $('#q'+no).remove();
        var no_sub = $('#form1 div label.no a');
        no_sub.each(function(i){
            $(this).text('第'+(i+1)+'小題');
            num = (i+1);    
        });
        if (no_sub.length==0){
            no = 1;
            num = 1;
        }else{
            num++;
        }
        if (num<11){
            $('#more_btn').show();
        }
    }
}
function oc(id){
    var cont = $('#'+id+'content');
    if (cont.css('display')=='block'){
        cont.css('display','none');
        $('#'+id+'oc_pic').prop('src','close.png');
    }else{
        cont.css('display','block');
        $('#'+id+'oc_pic').prop('src','open.png');
    }
}
</SCRIPT>