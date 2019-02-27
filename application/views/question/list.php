	<link rel="stylesheet" type="text/css" href="<?=base_url('/cssfunc/ex_set.css')?>">
	<style type="text/css">
		.show{
			display: block;
		}
		.hiden {
			display: none;
		}
		.list > tbody > tr > td.qcont {
			text-align: left;
		}
		.qall, .qsel {
			width: 18px;
			height: 18px;
		}
	</style>
</head>
<body>
<div id="all">
	<div id="title"><label class="f17"><?=$title?></label></div>
	<form name="form1" id="form1">
	<div class="title_intro">
		<div class="top_search"><label style="margin-left:5px;">關鍵字搜尋</label><input type="text" class="input_field" name="q" id="q" value="<?=$Keyword?>"><div class="glass_div" onclick="search_confirm()"><img src="<?=base_url('images/icon_op_glass.png')?>"></div><a href="<?=site_url('/question/cram')?>" style="margin-left:55px;">瀏覽全部</a></div>
		<!-- <label class="f16" id="choice_fie"><a href="javascript:void(0)" onclick="open_field();">選擇欄位</a></label> -->
	</div>
	<div class="title_intro condition">
		<div>
			<div style="width:80px; display:inline-block; position: relative; margin-left:5px;">條件</div>
			年級：
			<select name="gra" id="gra" onchange="getsubj(this.value)">
				<option value="0">全部</option><?=$Grade?>
			</select>
			科目：
			<select name="subj" id="subj" onchange="getchap(this.value)">
				<option value="0">全部</option><?=$Subject?>
			</select>
			章節：
			<select name="chap" id="chap">
				<option value="0">全部</option><?=$Chapter?>
			</select>
			難度：
			<select name="degree">
				<option value=""  <?=$Degree->A?> >全部</option>
				<option value="E" <?=$Degree->E?> >容易</option>
				<option value="M" <?=$Degree->M?> >中等</option>
				<option value="H" <?=$Degree->H?> >困難</option>
				</select>
				<input type="button" class="btn" onclick="ques_find()" value="篩選">
			<input type="hidden" name="p" id="urlpage" value="">
			　　<input type="button" class="btn" id="joinsets" value="加入考卷">
		</div>
	</div>
	</form>
	<div class="content">
		<div id="cen">
			<table cellpadding="0" cellspacing="0" width="100%" class="list">
				<thead>
					<tr>
						<th width="50"><input type="checkbox" class="qall" onclick="check_all(this, '.qsel')"></th>
						<th name="qno" style="width:4%; min-width:39px;">序號</th>
						<th name="que">題目</th>
						<th style="width:80px;">題型</th>
						<th name="ans" style="width:5%; min-width:49px;">答案</th>
						<th name="gra" style="width:6%; min-width:59px;">年級</th>
						<th name="sub" style="width:5%; min-width:49px;">科目</th>
						<th name="chp" style="width:9.5%; min-width:99px;">章節</th>
						<th name="deg" style="width:4%; min-width:39px;">難度</th>
						<th name="pub" class="last" style="width:10%; min-width:109px;">發表時間</th>
					</tr>
				</thead>
				<tbody>
				<?php foreach ($Data as $k => $v):
				$class = (($k+1)%2==0) ? 'shallow':'deep';
				?>
					<tr class="<?=$class?>">
						<td><input type="checkbox" class="qsel" name="q_sel[]" value="<?=$v->QID?>"></td>
						<td name="qno"><?=$v->QID?></td>
						<td class="qcont" name="que"><?=$v->QCONT.'<br>'.$v->ACONT?></td>
						<td><?=$v->QUE_TYPE?></td>
						<td name="ans"><?=$v->ANS?></td>
						<td name="gra"><?=$v->GRA?></td>
						<td name="sub"><?=$v->SUBJ?></td>
						<td name="chp"><?=$v->CHAP?></td>
						<td name="deg"><?=$v->DEGREE?></td>
						<td class="last"><?=$v->UPDATETIME?></td>
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
<!-- <div id="sets_filed" class="list_set">
	<div class="set_all">
		<div class="set_title"><label class="f17">選擇欄位</label></div>
		<div class="set_content">
			<div class="set_cen">
				<div class="set_btn">
					<input type="button" class="btn w75 f14" name="allchk" onclick="chk_all()" value="全部選取">
					<input type="button" class="btn w75 f14" name="allnotchk" onclick="notchk_all()" value="全部不選">
				</div>
				<div class="set_chk">
					<label><input type="checkbox" name="choice_f" checked value="qno">題號</label>
					<label><input type="checkbox" name="choice_f" checked value="que">題目</label>
					<label><input type="checkbox" name="choice_f" checked value="ans">答案</label>
					<label><input type="checkbox" name="choice_f" checked value="deg">難度</label>
					<label><input type="checkbox" name="choice_f" checked value="sub">科目</label>
					<label><input type="checkbox" name="choice_f" checked value="gra">年級</label>
					<label><input type="checkbox" name="choice_f" checked value="chp">章節</label>
					<label><input type="checkbox" name="choice_f" checked value="sets">考卷</label>
					<label><input type="checkbox" name="choice_f" checked value="sh">分享對象</label><br>
					<label><input type="checkbox" name="choice_f" checked value="oans">學生提供其他詳解</label>
					<label><input type="checkbox" name="choice_f" checked value="pub">發表時間</label>
				</div>
				<div>
                	<div style="text-align:left; float:left;"><input type="button" class="btn w80 f16" value="確定" name="sure" id="sure" onclick="field_change()">&nbsp;&nbsp;<font id="field_msg" color="red"></font></div>
					<div style="text-align:right; height:30px; line-height:30px;"><a href=""><font class="f15"><a href="javascript:void(0)" onclick="close_field()">取消更改</a></font></a></div>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="status_list" class="list_set">
	<div id="list_all">
		<div class="set_title"><label class="f17" id="list_title"></label></div>
		<div class="set_content">
			<div id="list_cen">
				<div class="set_main" id="list_main"></div>
				<div id="list_bottom">
					<div style="text-align:right; height:30px; line-height:30px;"><font class="f15"><a href="javascript:void(0)" onclick="close_list()">關閉</a></font></div>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="oans_list" class="list_set">
	<div id="oans_all">
		<div class="set_title"><label class="f17">其他詳解</label></div>
		<div class="set_content">
			<div id="list_cen">
				<div class="set_main" id="list_oans"></div>
				<div id="list_bottom">
					<div style="text-align:right; height:30px; line-height:30px;"><font class="f15"><a href="javascript:void(0)" onclick="close_oans()">關閉</a></font></div>
				</div>
			</div>
		</div>
	</div>
</div> -->
<div id="sets_list" class="list_set">
	<div id="oans_all">
		<div class="set_title"><label class="f17">題目加入考卷</label></div>
		<div class="set_content">
			<div id="list_cen">
				<form id="setsform" onsubmit="return addform(this)">
				<div class="set_main" id="data_list">
					考卷：<select name="sets" id="sets" onchange="getpart(this.value)"></select><br><br>
					大題：
					<div id="sets_part"></div>
					<input type="hidden" name="ques" id="ques">
					<input type="hidden" name="csrf_token" id="sqtoken">
				</div>
				<div id="list_bottom">
					<div style="float:left;"><input type="submit" value="確定"></div>
					<div style="text-align:right; height:30px; line-height:30px;"><font class="f15"><a href="javascript:void(0)" onclick="close_sets()">關閉</a></font></div>
				</div>
				</form>
			</div>
		</div>
	</div>
</div>
</body>
</html>
<script type="text/javascript">
// function chk_all(){
// 	$('input:checkbox[name=choice_f]').prop('checked',true);
// }
// function notchk_all(){
// 	$('input:checkbox[name=choice_f]').prop('checked',false);	
// }
// function open_edit(value){
// 	var func = $('#edit_func_'+value);
// 	if (func.hasClass('show')){
// 		func.removeClass('show');
// 	}else{
// 		$('div[name=edit_group]').removeClass('show');
// 		func.addClass('show');
// 	}
// }
// function open_field(){
// 	$('#sets_filed').css('display','block');
// }
// function close_field(){
// 	$('#sets_filed').css('display','none');
// 	document.getElementById('field_msg').innerHTML = '';
// }
var i='';
function check_all(obj,cName){
	$(cName).prop('checked', obj.checked);
    // var checkboxs = document.getElementsByName(cName);
    // for(var i=0;i<checkboxs.length;i++){checkboxs[i].checked = obj.checked;}
}
function search_confirm(){
  var search = gb("q").value;
  var pattern = new RegExp("[`~!@#$^&()=|{}':;'-+,\\[\\].<>/?~！@#￥……&*（）——|{}【】『；：」「'。，、？]");
  var rs = "";
  for (var i = 0; i < search.length; i++) { 
      rs += search.substr(i, 1).replace(pattern, ''); 
  } 
  if (search.trim()!='')ques_find();
}
// function close_oans(){ $('#oans_list').css('display','none');}
function getsubj(v){
	if (v==="0"){
		gb('subj').innerHTML = '<option value="0">全部</option>';
		gb('chap').innerHTML = '<option value="0">全部</option>';
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
function getchap(v){
	if (v==="0"){
		gb('chap').innerHTML = '<option value="0">全部</option>';
		return;
	}
	gb('chap').innerHTML = '<option value="">搜尋中</option>';
	$.ajax({
		type:"GET",
		url:"<?=site_url('/basic/gsclist')?>",
		data:{'type':'chap', 'g':gb('gra').value, 's':v},
		dataType:"JSON",
		success: function(rs){
			gb('chap').innerHTML = '';
			var html = '<option value="0">全部</option>';
			for (var i in rs){
				html+= '<option value="'+rs[i].ID+'">'+rs[i].NAME+'</option>';
			}
			gb('chap').innerHTML = html;
		},
		error: function(rs){
			if (rs.status===400)alert('請重新查詢');
			if (rs.status===404)gb('chap').innerHTML = '<option value="0">全部</option>';
		}
	});
}
function pg(v){
	gb('urlpage').value = v;
	ques_find();
}
function ques_find(){
	location.href = '<?=site_url('/question/cram')?>?'+$('#form1').serialize();
}
$("#joinsets").on('click', function(){
	var que_sel = false;
	var addque = new Array();
	var qq = $(".qsel:checked").val();
	if (typeof qq !=="undefined")que_sel = true;
	if (!que_sel){
		alert('沒勾選題目');
		return false;
	}
	$.ajax({
		type: "GET",
		url: "<?=site_url('sets/ajsets_list')?>",
		dataType: "JSON",
		success: function(rs){
			var set_html = '';
			rs.sets.forEach(function(e){
				set_html+= '<option value="'+e.ID+'">'+e.NAME+'</option>';
			});
			var part_html = '';
			rs.sub.forEach(function(e){
				part_html+= '<div><input type="radio" name="spart" value="'+e.ID+'">'+e.NAME+'</div>';
			});
			gb('sets').innerHTML = set_html;
			gb('sets_part').innerHTML = part_html;
		}
	});
	$('#sets_list').show();
});
function getpart(v){
	$.ajax({
		type: "GET",
		url: "<?=site_url('sets/ajsets_sub')?>",
		data: {sid:v},
		dataType: "JSON",
		success: function(rs){
			var part_html = '';
			rs.forEach(function(e){
				part_html+= '<div><label><input type="radio" name="spart" value="'+e.ID+'">'+e.NAME+'('+e.SCORE+'%)</label></div>';
			});
			gb('sets_part').innerHTML = part_html;
		}
	});
}
function addform(obj){
	var addque = new Array();
	$(".qsel:checked").each(function(){
		addque.push(this.value);
	});
	gb('ques').value = addque.join(',');
	gb('sqtoken').value = getCookie('csrf_token');
	$.ajax({
		type: "POST",
		url: "<?=site_url('sets/ajsets_add')?>",
		data: $(obj).serialize(),
		dataType: "JSON",
		success: function(){
			alert('加入成功');
			$('#sets_list').hide();
		}
	});
	return false;
}
function close_sets(){
	$('#sets_list').hide();
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