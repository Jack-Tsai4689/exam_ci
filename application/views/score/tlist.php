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
		.list > thead > tr > th {
			width: 20%;
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
	<form id="scoreform">
	<div class="title_intro condition">
		<div style="width:80px; display:inline-block; position: relative; margin-left:5px;">條件</div>
		<?php if ($_SESSION['gold']->type==="W"): ?>
		分校：
		<select name="ga" id="ga" onchange="getc(this.value)">
			<?php
			foreach ($Group as $g):
				$selected = ($g->id===$Sel->ga) ? 'selected':'';
			?>
			<option <?=$selected?> value="<?=$g->id?>"><?=$g->name?></option>
			<?php endforeach; ?>
		</select>　
		<?php endif; ?>
		班級：
		<select name="ca" id="ca" onchange="getcla(this.value)">
			<?php 
			foreach ($Ca as $c):
				$selected = ($c->id===$Sel->ca) ? 'selected':'';
			?>
			<option <?=$selected?> value="<?=$c->id?>"><?=$c->name?></option>
			<?php endforeach; ?>
		</select>　
		班別：
		<select name="cla" id="cla" onchange="getsets(this.value)">
			<option value="0">全部</option>
			<?php
			foreach ($Cla as $cl):
				$selected = ($cl->id===$Sel->cla) ? 'selected':'';
			?>
			<option <?=$selected?> value="<?=$cl->id?>"><?=$cl->name?></option>
			<?php endforeach; ?>
		</select>　
		考卷：
		<select name="sets" id="sets">
			<?php 
			foreach ($Sets as $set):
				$selected = ($set->id===$Sel->sets) ? 'selected':'';
			?>
			<option <?=$selected?> value="<?=$set->id?>"><?=$set->name?></option>
			<?php endforeach; ?>
		</select>　
		<input type="hidden" name="page" id="urlpage" value="">
		<input type="button" class="btn" onclick="score_find()" value="篩選">
	</div>
	</form>
	<div class="content">
		<div id="cen">
			<table cellpadding="0" cellspacing="0" width="100%" class="list">
				<thead>
					<tr>
						<th>學號</th>
						<th>姓名</th>
						<th>得分</th>
						<th>測驗用時</th>
						<th class="last">診斷報告</th>
					</tr>
				</thead>
				<tbody>
				<?php foreach ($Data as $v):?>
				<tr class="">
					<td><a href="<?=site_url('/exam/score/'.$v->SCID)?>" target="_blank"><?=$v->SC_STN?></a></td>
					<td><a href="<?=site_url('/exam/score/'.$v->SCID)?>" target="_blank"><?=$v->STNAME?></a></td>
					<td><?=$v->SC_SCORE?></td>
					<td><?=$v->SC_DATE?></td>
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
<!--
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
					<label><input type="checkbox" name="choice_f" checked>擁有者</label>
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
-->
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
<form id="ajform">
	<input type="hidden" name="type" id="type">
	<input type="hidden" name="data" id="data">
	<input type="hidden" name="csrf_token" id="_token">
</form>
</body>
</html>
<script type="text/javascript">
function gb(v){
	return document.getElementById(v);
}
function close_stu(){$('#sets_stulist').hide();}
// function chk_all(){
// 	$('input:checkbox[name=choice_f]').prop('checked',true);
// }
// function notchk_all(){
// 	$('input:checkbox[name=choice_f]').prop('checked',false);	
// }
// function field_change(){
// 	var chk,attribute;
// 	var real = $('input:checkbox[name=choice_f]:checked').val();
// 	if (real==null){
// 		document.getElementById('field_msg').innerHTML = '至少選一個';
// 	}else{
// 		$('input:checkbox[name=choice_f]').each(function(){
// 			chk = $(this).prop('checked');
// 			attribute = $(this).val();
// 			if (chk){
// 				$('th[name="'+attribute+'"]').css('display','table-cell');
// 				$('td[name="'+attribute+'"]').css('display','table-cell');
// 			}else{
// 				$('th[name="'+attribute+'"]').css('display','none');
// 				$('td[name="'+attribute+'"]').css('display','none');
// 			}
// 		});
// 		close_field();
// 	}
// }
// function change_finish(value){
// 	var chk = $("#set_finish_"+value).prop("checked") ;
// 	var func = $('#edit_func_'+value);
// 	$('div[name=edit_group]').removeClass('show');
// 	if (chk){
// 		success(value);
// 	}else{
// 		failed(value);
// 	}
// }
// function open_field(){
// 	$('#sets_filed').css('display','block');
// }
// function close_field(){
// 	$('#sets_filed').css('display','none');
// 	document.getElementById('field_msg').innerHTML = '';
// }
// function show_icon(){ $('#intro_icon').show()}
// function hide_icon(){ $('#intro_icon').hide();}

function pg(v){
	gb('urlpage').value = v;
	score_find();
}
function score_find(){
	location.href = '<?=site_url('/score')?>?'+$("#scoreform").serialize();
}
function getc(v){
	$.ajax({
        type:"GET",
        url:"<?=site_url('/Apig/ajgca')?>",
        data:{type:"c", g:v},
        dataType: "JSON",
        success:function(rs){
            var html = '';
			for(var i in rs){
				html+= '<option value="'+rs[i].id+'">'+rs[i].name+'</option>';
			}
			gb('ca').innerHTML = html;
			getcla(gb('ca').value);
        }
    });
}
function getcla(v){
	$.ajax({
        type:"GET",
        url:"<?=site_url('/Apig/ajgca')?>",
        data:{type:"ca", c:v},
        dataType: "JSON",
        success: function(rs){
            var html = '<option value="0">全部</option>';
			for(var i in rs){
				html+= '<option value="'+rs[i].id+'">'+rs[i].name+'</option>';
			}
			gb('cla').innerHTML = html;
			//getsets(0);
        }
    });
}
function getsets(v){
	$.ajax({
		type:"GET",
		url:"<?=site_url('/Apig/ajsets')?>",
		data:{type:'sets', 'c':gb('ca').value, 'ca':v },
		dataType:"JSON",
		success: function(rs){
			var html = '';
			for(var i in rs){
				html+= '<option value="'+rs[i].id+'">'+rs[i].name+'</option>';
			}
			gb('sets').innerHTML = html;
		}
	});
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
</script>