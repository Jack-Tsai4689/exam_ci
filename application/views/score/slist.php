    <link rel="stylesheet" type="text/css" href="<?=base_url('/cssfunc/ex_sets.css')?>">
    <style type="text/css">
		.left {
			text-align: left !important;
			/*vertical-align: top !important;*/
			padding-left: 5px !important;
		}
/*		.sets_title {
			height: 30px;
			line-height: 30px;
			font-size: 16px;
		}*/
		.condition {
			text-align: left !important;
		}
		.list tr td {
			height: auto !important;
		}
		.list tr td {
			text-align: center;
			height: 25px;
			line-height: 25px;
		}
	</style>
<body>
<div id="all">
	<div id="title"><label class="f17"><?=$title?></label></div>
	<form id="score_form">
	<div class="title_intro condition">
		<div style="width:80px; display:inline-block; position: relative; margin-left:5px;">條件</div>
		年級：
		<select name="gra" onchange="getsubj(this.value)">
			<option value="0">全部</option>
		</select>
		科目：
		<select name="subj" id="subj">
			<option value="0">全部</option>
		</select>
		<input type="hidden" name="page" id="urlpage">
		<input type="button" class="btn" onclick="score_find()" value="篩選">
	</div>
	</form>
	<div class="content">
		<div id="cen">
			<table cellpadding="0" cellspacing="0" width="100%" class="list">
				<thead>
					<tr>
						<th>考卷</th>
						<th width="100">得分</th>
						<th width="250">測驗開始</th>
						<th width="250">測驗結束</th>
						<th width="300" class="last">診斷報告</th>
					</tr>
				</thead>
				<tbody>
				<?php foreach ($Data as $v):?>
				<tr class="">
					<td class="left"><a href="<?=site_url('/exam/score/'.$v->SCID)?>"><?=$v->SETS_NAME?></a></td>
					<td><?=round($v->SC_SCORE, 2)?></td>
					<td><?=$v->SC_DATE?></td>
					<td><?=$v->SC_END?></td>
					<td><a href="<?=site_url('analy/result/'.$v->SCID)?>" target="_blank">考題來源表</a>　<a href="<?=site_url('analy/radar/'.$v->SCID)?>" target="_blank">觀念答對比例圖</a></td>
				</tr>
			<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
	<div id="page" class="content">
		<label class="all_rows">共<?=$Num?>筆資料</label>
		<div class="each">
			<?=$Prev?>
			<select id="pagegroup" onchange="pg(this.value)"><?=$Pg?></select>
			<?=$Next?>
		</div>
	</div>
</div>
<div id="sets_filed" class="list_set">
	<div class="set_all">
		<div class="set_title"><label class="f17">選擇欄位</label></div>
		<div class="set_content">
			<div class="set_cen">
				<div class="set_btn">
					<input type="button" class="btn w75 f14" name="allchk" onclick="chk_all()" value="全部選取">
					<input type="button" class="btn w75 f14" name="allnotchk" onclick="notchk_all()" value="全部不選">
				</div>
				<div class="set_chk">
					<label><input type="checkbox" name="choice_f" checked value="setsname">考卷名稱</label>
					<label><input type="checkbox" name="choice_f" checked value="duty">考卷說明</label>
					<!-- <label><input type="checkbox" name="choice_f" checked>擁有者</label> -->
					<label><input type="checkbox" name="choice_f" checked value="subj">科目</label>
					<label><input type="checkbox" name="choice_f" checked value="times">次數</label>
					<label><input type="checkbox" name="choice_f" checked value="que_nums">題數</label>
					<label><input type="checkbox" name="choice_f" checked value="share">分享對象</label>
					<label><input type="checkbox" name="choice_f" checked value="exam_time">考試時間</label><br>
					<label><input type="checkbox" name="choice_f" checked value="createtime">發表時間</label>
					<label><input type="checkbox" name="choice_f" checked value="lime">考試限時</label>
				</div>
				<div>
                	<div style="text-align:left; float:left;"><input type="button" class="btn w80 f16" value="確定" name="sure" id="sure" onclick="field_change()">&nbsp;&nbsp;<font id="field_msg" color="red"></font></div>
					<div style="text-align:right; height:30px; line-height:30px;"><a href=""><font class="f15"><a href="javascript:void(0)" onclick="close_field()">取消更改</a></font></a></div>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="sets_stulist" class="list_set">
    <div class="set_all">
        <div class="set_title"><label class="f17">班級學生名單</label></div>
        <div class="set_content">
            <div class="set_cen">
				<!--<div class="set_btn">
                    <input type="button" class="btn w75 f14" name="" id="" value="全部選取">
                    <input type="button" class="btn w75 f14" name="" id="" value="全部不選">
                </div> -->
                <div class="set_main">
	                <div class="eachone" onclick="">
	                    <div class="person_pic"><img src="http://<?=$_SERVER['HTTP_HOST'].'/'.$s_pic?>"></div>
	                    <div class="person_dep">
	                        <div class="f16"></div>
	                        <div class="f12"></div>
	                    </div>
	                </div>
                </div>
                <div>
                    <!-- <div style="text-align:left; float:left;"><input type="submit" class="btn w80 f16" value="確定" name="sure" id="sure"></div> -->
                    <div style="text-align:right; height:30px; line-height:30px;"><a href=""><font class="f15"><a href="javascript:void(0)" onclick="close_stu()">關閉</a></font></a></div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
<script type="text/javascript">
function close_stu(){$('#sets_stulist').hide();}
function chk_all(){
	$('input:checkbox[name=choice_f]').prop('checked',true);
}
function notchk_all(){
	$('input:checkbox[name=choice_f]').prop('checked',false);	
}
function field_change(){
	var chk,attribute;
	var real = $('input:checkbox[name=choice_f]:checked').val();
	if (real==null){
		document.getElementById('field_msg').innerHTML = '至少選一個';
	}else{
		$('input:checkbox[name=choice_f]').each(function(){
			chk = $(this).prop('checked');
			attribute = $(this).val();
			if (chk){
				$('th[name="'+attribute+'"]').css('display','table-cell');
				$('td[name="'+attribute+'"]').css('display','table-cell');
			}else{
				$('th[name="'+attribute+'"]').css('display','none');
				$('td[name="'+attribute+'"]').css('display','none');
			}
		});
		close_field();
	}
}
function page(p){
	location.href = '<?=site_url("/sets")?>?p='+p;
}
function change_finish(value){
	var chk = $("#set_finish_"+value).prop("checked") ;
	var func = $('#edit_func_'+value);
	$('div[name=edit_group]').removeClass('show');
	if (chk){
		success(value);
	}else{
		failed(value);
	}
}
function failed(value){//已完成，切成未
    $.getJSON("sets_class.php", {set_id:value, f:'N'}, function(data){
        if (data.msg!='OK'){
            $("#set_finish_"+value).prop("checked",true);
            alert(data.msg);
        }else{
        	location.reload();
        }
    });
}
function success(value){//未完成，切成已
	$.getJSON("sets_class.php", {set_id:value, f:'Y'}, function(data){
        if (data.msg=='OK'){
			location.reload();
        }else{
        	$("#set_finish_"+value).prop("checked",false);
        	alert(data.msg);
        }
    });
}
function copyfrom(value){
	location.href = "ex_sets.php?action=copy&sets="+value;
}
function open_edit(value){
	var func = $('#edit_func_'+value);
	if (func.hasClass('show')){
		func.removeClass('show');
	}else{
		$('div[name=edit_group]').removeClass('show');
		func.addClass('show');
	}
}
function delete_que(value){//刪試卷
    if (confirm('確定刪除此考卷?')){
        location.href="ex_sets.php?action=delete&sets="+value;
    }
}
// function open_class(){
// 	$('#sets_class').css('display','block');
// }
// function close_class(){
// 	$('#sets_class').css('display','none');
// }
function open_field(){
	$('#sets_filed').css('display','block');
}
function close_field(){
	$('#sets_filed').css('display','none');
	document.getElementById('field_msg').innerHTML = '';
}
$('#tiphelp').mouseover(function() {
  $('.tip').css('display','block');
});
$('#tiphelp').mouseout(function() {
  $('.tip').css('display','none');
});
function show_icon(){ $('#intro_icon').show()}
function hide_icon(){ $('#intro_icon').hide();}

function getsubj(v){
	if (v==="0"){
		gb('subj').innerHTML = '<option value="0">全部</option>';
		return;
	}
	gb('subj').innerHTML = '<option value="">搜尋中</option>';
	$.ajax({
		type:"GET",
		url:"<?=site_url('/basic/gsclist')?>",
		data:{'type':'subj', g:v},
		dataType:"JSON",
		success: function(rs){
			gb('subj').innerHTML = '';
			var html = '<option value="0">全部</option>';
			for (var i in rs){
				html+= '<option value="'+rs[i].ID+'">'+rs[i].NAME+'</option>';
			}
			gb('subj').innerHTML = html;
		},
		error: function(rs){
			if (rs.status===400)alert('請重新查詢');
			if (rs.status===404)gb('subj').innerHTML = '<option value="0">全部</option>';
		}
	});
}
function pg(v){
	gb('urlpage').value = v;
	score_find();
}
function score_find(){
	location.href = '<?=site_url('/score')?>?'+$("#score_form").serialize();
}
function open_ask(obj){
	if (confirm('動作無法復原，確定開放？')){
		var form = obj.parentElement;
		$.ajax({
			type: "POST",
			url: "<?=site_url('/sets/ajsets_publish')?>",
			data: $(form).serialize(),
			dataType: "JSON",
			success: function(){
				location.reload();
			},
			error: function (rs){
				if (rs.status===406)alert('配分錯誤，請確認');
			}
		});
	}
}
</script>