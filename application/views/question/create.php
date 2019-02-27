<?php 
//open.png, close.png
//from: http://fontawesome.io/
//author: fontawesome
//copy_from: http://big.miankoutu.com/3gpic/70443, http://big.miankoutu.com/3gpic/69876
?>
<!DOCTYPE html>
<html lang="zh-Hant-TW">
<head>
    <META http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=11; IE=10; IE=9; IE=8; IE=7" />
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
    <?=$Sets_msg?>
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
                    <td align="right">題型設定<font color="red">＊</font></td>
                    <td width="80%">
                    	<label><input type="radio" name="f_qus_type" checked value="S" onchange="change_type(this.value)">單選題</label>
                        <label><input type="radio" name="f_qus_type" value="D" onchange="change_type(this.value)">複選題</label>
                        <label><input type="radio" name="f_qus_type" value="R" onchange="change_type(this.value)">是非題</label>
                        <label><input type="radio" name="f_qus_type" value="M" onchange="change_type(this.value)">選填題</label>
                    </td>
                </tr>
                <tr class="shallow">
                    <td align="right">題目文字說明</td>
                    <td><textarea  name="f_quetxt" id="f_quetxt" cols="50" rows="4" onkeydown="done()" value=""></textarea>
                    <br><font class="f12">*題目文字說明或圖檔不可空白</font>
                    </td>
                </tr>
                <tr class="deep">
                    <td align="right">題目圖檔</td>
                    <td>
                        <IMG id="qimg" src="<?=$Qimg?>" width="80%"><br>
                        <div id="qimg_content"><?=$Qimg_html?></div>
                        <input type="hidden" id="f_qimg" name="f_qimg" value="">
                    	格式：JPG/PNG
                    </td>
                </tr>
                <tr class="shallow">
                    <td align="right">題目聲音檔</td>
                    <td><input type="file" name="qsound" id="qsound" accept="audio/mp3">格式：MP3</td>
                </TR>
                <tr class="deep">
                    <td align="right">知識點</td>
                    <td>
                        <input type="hidden" id="f_pid" name="f_pid" value=""/>
                        <div><font color="green">*「知識點」有助於學生在看診斷報告時，對題目的解答較易於融會貫通噢~</font></div>
                        <div><input type="button" id="addpoint" value="選擇知識點"><div id="point_content" style="display: inline-block;"></div></div>
                    </td>
                </tr>
                <tr class="shallow">
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
                    <td align="right">章節<font color="red">＊</font></td>
                    <td>
                        <div class="ui-widget">
                            <select id="f_chapterui" name="f_chapterui">
                                <option value=""></option>
                                <?=$Q_Chapter?>
                            </select>
                            <label id="chapter_error" class="error_msg" style="margin-left:40px;"></label>
                        </div>
                    </td>
                </TR>
                <tr>
                    <td align="left"><label class="f17">選項</label></td>
                    <td></td>
                </tr>
                <tr class="shallow" name="ans_type">
                    <td align="right">選項個數<font color="red">＊</font></td>
                    <td>
                        <select name="option_num" id="option_num" onchange="optnum(this.value)">
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                        </select>
                    </td>
                </tr>
                <tr class="deep" id="simple">
                    <td align="right">正確答案<font color="red">＊</font></td>
                    <td width="80%">
                        <div id="ans_group"></div>
                        <label id="ans_group_error" class="error_msg"></label>
                    </td>
                </tr>
                <tr class="deep math">
                    <td align="right">選項題數<font color="red">＊</font></td>
                    <td width="80%">
                        <select name="num" id="num" onchange="num_change(this.value)">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                        </select>
                    </td>
                </tr>
                <tr class="shallow math">
                    <td align="right">正確解答<font color="red">＊</font></td>
                    <td id="correct_ans_math">
                        <div id="a1"><span>No.1</span><label><input type="radio" name="ans1" value="1">1</label><label><input type="radio" name="ans1" value="2">2</label><label><input type="radio" name="ans1" value="3">3</label><label><input type="radio" name="ans1" value="4">4</label><label><input type="radio" name="ans1" value="5">5</label><label><input type="radio" name="ans1" value="6">6</label><label><input type="radio" name="ans1" value="7">7</label><label><input type="radio" name="ans1" value="8">8</label><label><input type="radio" name="ans1" value="9">9</label><label><input type="radio" name="ans1" value="0">0</label><label><input type="radio" name="ans1" value="a">-</label><label><input type="radio" name="ans1" value="b">±</label>
                        </div>
                    </td>
                </tr>
                <tr class="shallow">
                    <td align="right">難易度</td>
                    <td>
                        <label><input type="radio" name="f_degree" value="E" <?=$Degree->E?> >容易</label>
                        <label><input type="radio" name="f_degree" value="M" <?=$Degree->M?> >中等</label>
                        <label><input type="radio" name="f_degree" value="H" <?=$Degree->H?> >困難</label>
                    </td>
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
                    	<textarea  name="f_anstxt" cols="50" rows="4" value=""></textarea>
                    </td>
                </tr>
                <tr class="shallow">
                    <td align="right">圖片檔</td>
                    <td>
                        <IMG id="aimg" src="<?=$Aimg?>" width="80%"><br>
                        <div id="aimg_content"><?=$Aimg_html?></div>
                        <input type="hidden" id="f_aimg" name="f_aimg" value="">
                        格式：JPG/PNG
                    </td>
                </tr>
                <tr class="deep">
                    <td align="right">聲音檔</td>
                    <td><input type="file" name="asound" id="asound" accept="audio/mp3">格式：MP3</td>
                </TR>
                <tr class="shallow">
                    <td align="right">影片檔</td>
                    <td><input type="file" name="avideo" id="avideo" accept="video/mp4">格式：MP4</td>
                </tr>
            </table>
        </div>
    </div>
    <div class="content" style="margin-bottom:50px;">
        <div class="cen" style="padding-bottom:50px;">
            <div style="text-align:left;">
                <input type="hidden" name="csrf_token" value="<?=$this->security->get_csrf_hash()?>">
                    <input type="submit" class="btn w150 h30" value="存檔，出下一題" name="save_next" id="save_next" onclick="check('n')">
                    <input type="button" class="btn w150 h30" value="存檔，離開" name="save_close" id="save_close" onclick="check('c')">
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
change_type('S');
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
var rows_m = 1;
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
        },
        error: function(){
            gb('f_subject').innerHTML = '<option value="0">無科目</optoin>';
            gb('f_chapterui').innerHTML = '<option value="0">無章節</optoin>';
        }
    });
}
function chap_c(v, type){
    if (type==="q"){
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
            },
            error: function(){
                gb('f_chapterui').innerHTML = '<option value="0">無章節</optoin>';
            }
        });
    }else{
        $('#s_sets').empty();
        $.ajax({
            type:"GET",
            url:"<?=site_url('/question/ajsets')?>",
            dataType:"JSON",
            data:{'type':'sets', 'g':gb('s_grade').value, 's':v},
            success: function(rs){
                var html = '';
                for(var i in rs){
                    html+= '<option value="'+rs[i].ID+'">'+rs[i].SETS_NAME+'</option>';
                }
                $("#s_sets").html(html);
            },
            error: function(){
                alert('無科目');
            }
        });
        
    }
}

function num_change(v){//選填用
    var math = $('#form1 #correct_ans_math');
    var newone = Number(v);
    var oldone = Number(rows_m);
    if (newone>oldone){
        var start = oldone+1;
        for(var i=start; i<=v;i++){
            html = '<div id="a'+i+'"><span>No.'+i+'</span>';
            var j = 1;
            while (j<=9){
                html+= '<label><input type="radio" name="ans'+i+'" value="'+j+'">'+j+'</label>';
                j++;
            }
            html+= '<label><input type="radio" name="ans'+i+'" value="0">0</label>';
            html+= '<label><input type="radio" name="ans'+i+'" value="a">-</label>';
            html+= '<label><input type="radio" name="ans'+i+'" value="b">±</label>';
            html+= '</div>';
            math.append(html);
        }
        rows_m = newone;
    }else if (newone<oldone){
        var j = oldone;
        while(j>newone){
            math.find('#a'+j).remove();
            j--;
        }
        rows_m = newone;
    }
        //correct_ans_math
}
function getCookie(c_name) {
    var i, x, y, ARRcookies = document.cookie.split(";");
    for (i = 0; i < ARRcookies.length; i++) {
        x = ARRcookies[i].substr(0, ARRcookies[i].indexOf("="));
        y = ARRcookies[i].substr(ARRcookies[i].indexOf("=") + 1);
        x = x.replace(/^\s+|\s+$/g, "");
        if (x == c_name) {
            return unescape(y);
        }
    }
}
function uque(v){
    if (v==="dque"){
        $.ajax({
            type:"POST",
            url:"<?=site_url('/question/rmpic')?>",
            data:{'csrf_token':getCookie('csrf_token'), 'type':v},
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
    if (v==="dans"){
        $.ajax({
            type:"POST",
            url:"<?=site_url('/question/rmpic')?>",
            data:{'type':v},
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
function close_pic(){
    $('#sets_filed').hide();
    $('#que_pic').hide();
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

// function select_point(){//知識點
//     document.getElementById('que_pic').src="";
//     document.getElementById('que_pic').src="ex_point.php?fkey=6";
//     $('#que_pic').attr('width','100%');
//     $('#que_pic').attr('height',screen.height*0.8);
//     $('#sets_filed .set_all').css('width','90%');
//     $('#sets_filed').show();
    //var point = window.open("ex_point.php?fkey=6","ex_point","width=1240px,height=600px,resizable=yes,scrollbars=yes,status=yes");
// }
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
    $('#form1 input[name="f_imgsrc[]"]').each(function(){
        no = this.id;
        no = no.substring(8);
        var quetxt = $('#f_quetxt'+no).val();
        var img = $(this).val();
        i++;
        if (quetxt=='' && img==''){
            error = true;
        }
    });
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
function check(act){
    var q=0;
    var error = false;//data_check();
    if (!error){
        //背景post
        $('#posting').show();
        $.ajax({
            type:"POST",
            url:"<?=site_url('/question/add')?>",
            data:new FormData(gb('form1')),
            contentType: false,
            processData: false,
            cache: false,
            dataType:"JSON",
            success: function(rs){
                opener.location.href = '<?=site_url('/question')?>';
                if (act==="c"){
                    window.close();
                }else{
                    window.location.reload();
                }
            }
        });
        // $.ajax({
        //     type:'post',
        //     url:'mdpost.php',
        //     dataType: 'json',
        //     data: $('#form1').serialize(),
        //     success: function (data, textStatus, jqXHR){
        //         if (data.success){
        //             alert('儲存成功');
        //             var newurl = opener.location.href;
        //             if (type=='feedback'){
        //                 if (newurl==originurl){ opener.location.reload();}
        //                 window.close();
        //             }else{
        //                 if (type!=''){
        //                     opener.location.href = 'ex_sets.php';    
        //                 }else{
        //                     opener.location.href = 'ex_set.php';    
        //                 }    
        //             }
                    
        //             if (act=='c'){window.close();}
        //             if (act=='n'){
        //                 if (q==''){
        //                     location.href="http://<?=$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']?>";
        //                 }else{
        //                     location.href="http://<?=$_SERVER['HTTP_HOST']?>/ex_md.php?str_data=%2C%2C%2C%2C%2C&fkey=6";
        //                 }
        //             }
        //         }else{
        //             alert(data.msg);
        //             $('#posting').hide();
        //         }
        //     }
        // });
    }
}
function change_type(ans_t){//選項設定
    // if (ans_t==="G")location.href = "<?=site_url('question/createg')?>";
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
function remove_point(){
    var point = document.getElementById('point_content');
    point.innerHTML = '<input type="button" value="選擇知識點" class="btn w100 h25" name="f_btn" onClick="select_point()">';
    // var point = $('#point_content');
    // point.html('');
    // point.append($('<input>').attr({type:'button',value:'選擇知識點',class:'btn w100 h25',name:'f_btn',onClick:'select_point()'}));
    // document.getElementById('f_pid').value = 't';
    // document.forms[0].submit();
}
// function rem(elem,no){
//     if (confirm('檔案無法復原，確定?')){
//         var obj = $('#f_'+elem+no).val();
//         $.getJSON("rem_file.php", {type:elem,file:obj,no:no}, function(data){
//             if (no==''){
//                 $('#'+elem+'_content').html(data);
//             }else{
//                 $('#q'+no+'_'+elem+'_content').html(data);
//             }
//         });
//     }
// }

</SCRIPT>