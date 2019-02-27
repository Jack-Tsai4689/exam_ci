<!DOCTYPE html>
<html lang="zh-Hant-TW">
<head>
	<META http-equiv="Content-Type" content="text/html; charset=utf-8">
	<script type="text/javascript" src="<?=base_url('/js/html5media.min.js')?>"></script>
	<script type="text/javascript" src="<?=base_url('/js/jquery.min.js')?>"></script>
	<link rel="stylesheet" type="text/css" href="<?=base_url('/css/reset.css')?>">
	<link rel="stylesheet" type="text/css" href="<?=base_url('/css/main.css')?>">
	<style type="text/css">
        body {
            width: 100%;
            float: left;
            position: relative;
        }
    	#all {
    		margin: 20px auto;
    		width: 1152px;
    	}
    	#title {
    		height: 30px;
    		line-height: 30px;
    	}
    	.title_intro{
    		height: 40px;
    		line-height: 40px;
    	}
    	.title_intro label {
    		margin-right: 5px;
    	}
        .ans {
            height: auto;
            line-height: 30px;
        }
    	.result_times {
    		text-align: center;
    		font-size: 16px;
    	}
    	.result_times.qno {
    		height: auto;
    	}
    	.result_times.qno div {
    		display: inline-block;
    		height: 25px;
    		line-height: 25px;
    		margin-right: 10px;
    		width: 25px;
    		background-color: #B4B4B5;
    		color: white;
            cursor: pointer;
    	}
    	.result_times div {
    		width: 15px;
    		display: inline-block;
    	}
    	.result_times.qno div.finish {
            background-color: #3EAC4A;
        }
        .result_times.qno div.chk {
    		background-color: #B7282C;
    	}
    	.result_times.qno div.current {
            background-color: #0071BC;
        }
    	.cen {
    		margin: 5px 0px 5px 0px;
    		min-height: 300px;
            max-height: 500px;
    		position: relative;
    		overflow: auto;
    	}
    	.que_main {
    		width: 1000px;
            min-height: 300px;
            max-height: 500px;
    		margin: 0px auto;
    		position: relative;
            overflow-y: auto;
    	}
    	#chk_choice {
    		position: absolute;
    		width: auto;
    		margin-left: 70px;
    	}
    	.qno_btn {
    		text-align: center;
    	}
    	#btn_left {
    		position: absolute;
    		z-index: 2;
    		width: 100%;
    		text-align: left;
    	}
    	.btn_center {
    		position: relative;
    		z-index: 2
    	}
    	.btn_right {
    		float: right;
    		margin-top: 8px;
    		margin-right: 5px;
    	}
    	.btn {
    		height: 25px;
    		border: 1px #EED6B4 solid;
    	}
    	.btn:active {
    		border: 1px gray dashed;
    	}
    	.input_field {
    		height: 25px;
    	}
        .sm_no {
            float: left;
            position: relative;
            display: inline-block;
            padding-right: 5px;
        }
        .sm_cont {
            width: 960px;
            display: inline-block;
            overflow-wrap: break-word;
        }
        .Mq {
            width: 100% !important;
        }
	</style>
	<title><?=$title?></title>
</head>
<body>
<div id="all">
    <form name="exam_form" id="exam_form" method="POST" action="<?=site_url('/exam/save') ?>">
	<div id="title"><label class="f17">【<?=$Setsname?>】</label></div>
	<div class="title_intro result_times">
        <INPUT type="hidden" name="hour" id="hour" value="<?=$Time->hour?>">
        <INPUT type="hidden" name="min" id="min" value="<?=$Time->min?>">
        <INPUT type="hidden" name="sec" id="sec" value="<?=$Time->sec?>">
		<label>時間到後自動交卷</label><label>&nbsp;&nbsp;剩餘</label>
		<font color="red" id="h">00</font>時
		<font color="red" id="m">00</font>分
		<font color="red" id="s">00</font>秒
	</div>
	<div class="title_intro result_times">
		第<?= str_pad($Part_no,2,0,STR_PAD_LEFT) ?>大題　第<font id="current"><?= str_pad($First_qno,2,0,STR_PAD_LEFT) ?></font>題/共<?=str_pad(count($Qrows),2,0,STR_PAD_LEFT)?>題&nbsp;&nbsp;未作答<font id="n"><?=count($Qrows)?></font> <font color="#3EAC4A">已作答</font><font id="y">0</font> <font color="#B7282C">再檢查</font><font id="r">0</font>
		<input type="hidden" name="type" id="type" value="<?=$Etype?>">
        <input type="hidden" name="exnum" value="<?=count($Qrows)?>">
        <input type="hidden" name="grade" value="<?=$Grade?>">
        <input type="hidden" name="subject" value="<?=$Subject?>">
        <input type="hidden" name="chapter" value="<?=$Chapter?>">
        <input type="hidden" name="sets" value="<?=$Sid ?>">
        <input type="hidden" name="qtype" id="qtype" value="<?=$Que->type?>">
        <input type="hidden" name="qnum" id="qnum" value="<?=$Que->qnum?>">
        <input type="hidden" name="start_time" id="start_time" value="<?=time()?>">
        <input type="hidden" name="csrf_token" value="<?=$this->security->get_csrf_hash()?>">
	</div>
	<div class="title_intro result_times qno">
		<?=$Qno ?>
	</div>
	<input type="hidden" name="current_qno" id="current_qno" value="<?=$First_qno?>">
    <!-- <input type="hidden" name="stu_ans" id="stu_ans" value=""> -->
    <input type="hidden" name="exam" value="<?=$Eid?>">
    <input type="hidden" name="epart" value="<?=$Epart?>">
    <input type="hidden" name="spart" value="<?=$Spart?>">
    <div class="content" id="Q1">
        <div class="cen">
            <input type="hidden" id="Q1_no" value="<?=$Que->qid ?>">
            <div class="que_main" id="Q1_main">
                <?=$Que->qcont ?>
            </div>
        </div>
    </div>
    <div class="title_intro result_times ans" id="A1">
        <span id="A1_main"><?=$Que->ans ?></span>
        <div id="chk_choice"><label><input type="checkbox" name="dou_check" id="dou_check1" value="1">再檢查</label></div>
    </div>
    <input type="hidden" name="next_qtxt" id="next_qtxt" value="">
    <input type="hidden" name="next_qa" id="next_qa" value="">
    <input type="hidden" name="next_qno" id="next_qno" value="">
    <?php 
    foreach ($Qrows as $i => $v):
        if ($i===0)continue;
    ?>
	<div class="content" id="Q<?=$v?>" style="display:none;">
		<div class="cen">
			<div class="que_main" id="Q<?=$v?>_main"></div>
		</div>
	</div>
	<div class="title_intro result_times ans" id="A<?=$v?>" style="display:none;">
        <span id="A<?=$v?>_main"></span>
		<div id="chk_choice"><label><input type="checkbox" name="dou_check" id="dou_check<?=($i+1)?>" value="1">再檢查</label></div>
	</div>
    <?php endforeach; ?>
	<div class="title_intro qno_btn">
		<div id="btn_left"><input type="button" class="btn w150 f14" style="margin-left:5px; display:none;" id="perious" name="perious" value="上一題"><input type="button" class="btn w150 f14 btn_right" id="finish" name="finish" value="交卷"></div>
		<input type="button" class="btn w150 f14 btn_center" id="next" name="next" value="下一題">
	</div>
    </form>
</div>
</body>
</html>
<script language="javascript">
 window.resizeTo(screen.width,screen.height);
$(document).mouseleave(function(e){
  window.onbeforeunload = function (e) {
    return '確定放棄?';
  }
});
function gb(v){
    return document.getElementById(v);
}
var hours = <?=$Time->hour?>;
var minutes = <?=$Time->min?>;
var seconds = <?=$Time->sec?>;
var cache = 59;
$(document).ready(function (){
    var exam_times;
    count();
});
function count(){
    if (hours==0 && minutes==0 && seconds==0){
        window.onbeforeunload = null;
        gb('next_qa').value = 'part';
        exam_form.submit();
    }else{
        exam_times = setTimeout("count()", 1000);
        if (seconds == 0){
            if (minutes == 0){
                hours -= 1;
                minutes = 59;
                seconds = cache;
            }else{
                seconds = cache;
                minutes = minutes-1;
            }
        }else{
            seconds = seconds-1;
        }
        gb('min').value = minutes;
        gb('sec').value = seconds;
        gb('hour').value = hours;
        if (hours<10){
            var hour = '0'+hours;
        }else {var hour = hours;}
        if (minutes<10){
            var min = '0'+minutes;
        }else {var min = minutes;}
        if (seconds<10){
            var sec = '0'+seconds;
        }else {var sec = seconds;}
        gb('h').innerHTML = hour;
        gb('m').innerHTML = min;
        gb('s').innerHTML = sec;
    }
}
// document.onkeydown = function(event){
// //鎖特定按鍵 116 F5  123 F12
//     if (event.keyCode == 116 || event.keyCode == 123 ||  
//         event.keyCode == 17 || event.keyCode == 18 || 
//         event.keyCode == 82 || event.keyCode == 85 || 
//         event.keyCode == 73){
//         event.keyCode = 0;
//         event.returnValue = false;
//     }
// }
// document.oncontextmenu = function(){ //鎖右鍵 chrome可破解
//     event.returnValue = false;
// }
var current = <?=$First_qno?>,
    y=0;
    n=<?=count($Qrows)?>,
    r=0,
    all = <?=count($Qrows)?>,
    stu_ans = Array(<?=count($Qrows)?>),
    du_check = Array(<?=count($Qrows)?>);
    for (var i = 0; i < <?=count($Qrows)?>; i++) {
        stu_ans[i] = '';
        du_check[i] = '';
    }
function go(qno){
    $('#go'+current).removeClass('current');
    //$('#go'+current).addClass('other');
    var oans = Array();
    var etype = gb('qtype').value;
    switch(etype){
        case 'S':
        case 'R':
            oans.push($('input[name="ans'+current+'"]:checked').val());
            break;
        case 'D':
            $('input[name="ans'+current+'[]"]:checked').each(function(){
                oans.push(this.value);
            });
            break;
        case 'M':
            var i = 1;
            var num = gb('qnum').value;
            var sel_v = '';
            while(num>=i){
                sel_v = $('input[name="ans'+current+'_'+i+'"]:checked').val();
                if (sel_v!=="")oans.push(sel_v);
                i++;
            }
            
    }
    var ans = oans.join('.');
    // var ans = $('input[name=f_opt'+current+']:checked').val();
    if (ans!=''){
        $('#go'+current).addClass('finish');
        if (stu_ans[current-1]==''){
            n--;    y++;
            gb('n').innerHTML = n;
            gb('y').innerHTML = y;
        }
        stu_ans[current-1] = ans;
        //$('#stu_ans').val(JSON.stringify(stu_ans));
    }
    var check = $('#dou_check'+current).prop('checked');
    if (check){//mark
        $('#go'+current).addClass('chk');
        if (du_check[current-1]==''){
            du_check[current-1] = 1;
            r++;
            gb('r').innerHTML = r;
        }
    }else{
        if (du_check[current-1]==1){
            du_check[current-1] = '';
            r--;
            gb('r').innerHTML = r;
            $('#go'+current).removeClass('chk');
        }
    }
    gb('current_qno').value = current;
    var txt = ($('#Q'+qno+'_main').html()=='')?'n':'y';
    gb('next_qtxt').value = txt;
    gb('next_qa').value = 'q';
    gb('next_qno').value = qno;
    if (txt==="n"){
        clearTimeout(exam_times);
        $('#perious').prop('disabled', true);
        $('#next').prop('disabled', true);
    }    
    $.ajax({
        type:'post',
        url:'<?=site_url('/exam/save') ?>',
        dataType: 'json',
        data: $('#exam_form').serialize(),
        success: function (data, textStatus, jqXHR){
            gb('qtype').value = data.type;
            gb('qnum').value = data.qnum;
            if (txt=='n'){
                count();
                $('#Q'+qno+'_main').html(data.qcont);
                $('#A'+qno+'_main').html(data.ans);
                $('#perious').prop('disabled', false);
                $('#next').prop('disabled', false);
            }            
        }
    });
    $('#Q'+current).css('display','none');
    $('#A'+current).css('display','none');
    current = qno;
    $('#Q'+qno).css('display','block');
    $('#A'+qno).css('display','block');
    //window.onbeforeunload = '';
    but_change();
}
function but_change(){
    $('audio').each(function(){
        this.pause(); // Stop playing
        this.currentTime = 0; // Reset time
    }); 
    $('#go'+current).addClass('current');
    $('#go'+current).removeClass('other');
    if (current==1){
        //$('#finish').css('display','none');
        $('#perious').css('display','none');
        $('#next').css('display','inline-block');
    }else if (current==all){
        $('#next').css('display','none');
        //$('#finish').css('display','block');
        $('#perious').css('display','inline-block');

    }else{
        //$('#finish').css('display','none');
        $('#next').css('display','inline-block');
        $('#perious').css('display','inline-block');
    }
    if (current<10){
        $('#current').html('0'+current);    
    }else{
        $('#current').html(current);    
    }
}
$('#next').click(function(){
    var oans = Array();
    var etype = gb('qtype').value;
    switch(etype){
        case 'S':
        case 'R':
            oans.push($('input[name="ans'+current+'"]:checked').val());
            break;
        case 'D':
            $('input[name="ans'+current+'[]"]:checked').each(function(){
                oans.push(this.value);
            });
            break;
        case 'M':
            var i = 1;
            var num = gb('qnum').value;
            var sel_v = '';
            while(num>=i){
                sel_v = $('input[name="ans'+current+'_'+i+'"]:checked').val();
                if (sel_v!=="")oans.push(sel_v);
                i++;
            }
            
    }
    var ans = oans.join('.');
    if (ans!=''){
        $('#go'+current).addClass('finish');
        if (stu_ans[current-1]==''){
            n--;    y++;
            gb('n').innerHTML = n;
            gb('y').innerHTML = y;
        }
        stu_ans[current-1] = ans;
    } 
    var check = $('#dou_check'+current).prop('checked');
    if (check){//mark
        $('#go'+current).addClass('chk');
        if (du_check[current-1]==''){
            du_check[current-1] = 1;
            r++;
            gb('r').innerHTML = r;
        }
    }else{
        if (du_check[current-1]==1){
            du_check[current-1] = '';
            r--;
            gb('r').innerHTML = r;
            $('#go'+current).removeClass('chk');
        }
    }

    $('#go'+current).removeClass('current');
    gb('current_qno').value = current;
    var next = current+1;
    var txt = ($('#Q'+next+'_main').html()=='')?'n':'y';
    gb('next_qtxt').value = txt;
    gb('next_qa').value = 'n';
    if (txt==="n"){
        clearTimeout(exam_times);
        $('#perious').prop('disabled', true);
        $('#next').prop('disabled', true);
    }
    $.ajax({
        type:'post',
        url:'<?=site_url('/exam/save') ?>',
        dataType: 'json',
        data: $('#exam_form').serialize(),
        success: function (data, textStatus, jqXHR){
            gb('qtype').value = data.type;
            gb('qnum').value = data.qnum;
            if (txt=='n'){
                count();
                $('#Q'+next+'_main').html(data.qcont);
                $('#A'+next+'_main').html(data.ans);
            }
            $('#perious').prop('disabled', false);
            $('#next').prop('disabled', false);
        }
    });
    $('#Q'+current).css('display','none');
    $('#A'+current).css('display','none');
    current+=1;
    $('#Q'+current).css('display','block');
    $('#A'+current).css('display','block');
    but_change();
});
$('#perious').click(function(){
    var oans = Array();
    var etype = gb('qtype').value;
    switch(etype){
        case 'S':
        case 'R':
            oans.push($('input[name="ans'+current+'"]:checked').val());
            break;
        case 'D':
            $('input[name="ans'+current+'[]"]:checked').each(function(){
                oans.push(this.value);
            });
            break;
        case 'M':
            var i = 1;
            var num = gb('qnum').value;
            var sel_v = '';
            while(num>=i){
                sel_v = $('input[name="ans'+current+'_'+i+'"]:checked').val();
                if (sel_v!=="")oans.push(sel_v);
                i++;
            }
            
    }
    var ans = oans.join('.');
    if (ans!=''){
        $('#go'+current).addClass('finish');
        if (stu_ans[current-1]==''){
            n--;    y++;
            gb('n').innerHTML = n;
            gb('y').innerHTML = y;
        }
        stu_ans[current-1] = ans;
    }
    var check = $('#dou_check'+current).prop('checked');
    if (check){//mark
        $('#go'+current).addClass('chk');
        if (du_check[current-1]==''){
            du_check[current-1] = 1;
            r++;
            gb('r').innerHTML = r;
        }
    }else{
        if (du_check[current-1]==1){
            du_check[current-1] = '';
            r--;
            gb('r').innerHTML = r;
            $('#go'+current).removeClass('chk');
        }
    }
    $('#go'+current).removeClass('current');
    gb('current_qno').value = current;
    var next = current-1;
    var txt = ($('#Q'+next+'_main').html()=='')?'n':'y';
    gb('next_qtxt').value = txt;
    gb('next_qa').value = 'p';
    if (txt==="n"){
        clearTimeout(exam_times);
        $('#perious').prop('disabled', true);
        $('#next').prop('disabled', true);
    }
    $.ajax({
        type:'post',
        url:'<?=site_url('/exam/save') ?>',
        dataType: 'json',
        data: $('#exam_form').serialize(),
        success: function (data, textStatus, jqXHR){
            gb('qtype').value = data.type;
            gb('qnum').value = data.num;
            if (txt=='n'){
                $('#Q'+next+'_main').html(data.qcont);
                $('#A'+next+'_main').html(data.ans);
                count();
                $('#perious').prop('disabled', false);
                $('#next').prop('disabled', false);
            }
        }
    });
    $('#Q'+current).css('display','none');
    $('#A'+current).css('display','none');
    current-=1;
    $('#Q'+current).css('display','block');
    $('#A'+current).css('display','block');
    but_change();
});
$('#finish').click(function(){
    var oans = Array();
    var etype = gb('qtype').value;
    switch(etype){
        case 'S':
        case 'R':
            oans.push($('input[name="ans'+current+'"]:checked').val());
            break;
        case 'D':
            $('input[name="ans'+current+'[]"]:checked').each(function(){
                oans.push(this.value);
            });
            break;
        case 'M':
            var i = 1;
            var num = gb('qnum').value;
            var sel_v = '';
            while(num>=i){
                sel_v = $('input[name="ans'+current+'_'+i+'"]:checked').val();
                if (sel_v!=="")oans.push(sel_v);
                i++;
            }
            
    }
    var ans = oans.join('.');
    // var ans = $('input[name=f_opt'+current+']:checked').val();
    if (ans!=''){
        $('#go'+current).addClass('finish');
        if (stu_ans[current-1]==''){
            n--;    y++;
            gb('n').innerHTML = n;
            gb('y').innerHTML = y;
        }
        stu_ans[current-1] = ans;
        //$('#stu_ans').val(JSON.stringify(stu_ans));
    }
    var check = $('#dou_check'+current).prop('checked');
    if (check){//mark
        $('#go'+current).addClass('chk');
        if (du_check[current-1]==''){
            du_check[current-1] = 1;
            r++;
            gb('r').innerHTML = r;
        }
    }else{
        if (du_check[current-1]==1){
            du_check[current-1] = '';
            r--;
            gb('r').innerHTML = r;
            $('#go'+current).removeClass('chk');
        }
    }
    var len = stu_ans.length;
    var no_ans = Array();
    var no = 0;
    for (var i = 0; i < len; i++) {
        //console.log(stu_ans[i]);
        if (stu_ans[i]==''){
            no_ans[no] = (i+1);
            no++;
        }
    }

    gb('current_qno').value = current;
    gb('next_qa').value = 'f';
    clearTimeout(exam_times);
    $.ajax({
        type:'post',
        url:'<?=site_url('/exam/save') ?>',
        dataType: 'json',
        data: $('#exam_form').serialize(),
        success: function (data, textStatus, jqXHR){}
    });
    if (no==0){
        if (confirm("確定要交卷?")){
            window.onbeforeunload = null;
            done();
        }else{
            setTimeout("count()", 1000);
        }
    }else{
        var all_no = no_ans.join(',');
        if (confirm("您還有第"+all_no+"題未作答，確定要交卷？")){
            window.onbeforeunload = null;
            done();
        }else{
            setTimeout("count()", 1000);
        }
    }
});
function done(){
    gb('next_qa').value = 'part';
    exam_form.submit();
}
function QS(i){
    var s = document.getElementById('S'+i);
    s.play();
}
</script>