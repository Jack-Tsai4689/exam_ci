    <link rel="stylesheet" type="text/css" href="<?=base_url('/cssfunc/ex_sets.css')?>">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="<?=base_url('/js/jquery-ui.js')?>"></script>
    <script type="text/javascript">
    $(function() {
        $( "#begdate" ).datepicker({
            changeMonth: true,
            changeYear: true,
            showOn: "button",
        });
        $( "#enddate" ).datepicker({
            changeMonth: true,
            changeYear: true,
            showOn: "button",
        });
        $( "#score_date" ).datepicker({
            changeMonth: true,
            changeYear: true,
            showOn: "button",
        });
    });
    </script>
	<style type="text/css">
    	#all {
    		width: 1280px;
    	}
    	.cen {
    		margin: 0 auto;
    		padding: 20px 0px 20px 0px;
    		margin: 0px 20px 0px 20px;
    	}
    	.last {
    		padding: 20px 0px 50px 0px;
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
/*    	.shallow td{
    		padding: 10px 0px 10px 0px;
    	}*/
    	#duty td {
    		padding-bottom: 0px;
    	}
    	.list_edit tr td{
    		margin-bottom: 10px;
    		height: 25px;
    		line-height: 25px;
    		padding-left: 10px;
    		vertical-align: top;
    	}
    	.list_edit label {
    		margin-right: 5px;
    	}
    	.list_edit input {
    		margin-right: 5px;
    	}
    	.list_edit {
    		margin-bottom: 20px;
    	}
    	#begdate, #enddate {
    		margin-right: 0px;
    	}
    	select {
    		margin-right: 5px;
    	}
    	textarea {
    		width: 500px;
    		height: 65px;
    		margin: 5px 0px 5px 0px;
    		border: 1px #EED6B4 solid;
    	}
        .sub_title {
            width: 300px;
        }
        .sub label, .sub input, .sub select {
            vertical-align: top;
        }
        .sub span {
            vertical-align: top;
            font-size: 18px;
            cursor: pointer;
        }
        .sub span:hover {
            background-color: #DDD;
            border: 0.5px #DDD solid;
            border-radius: 5px;
        }
        #score_view {
            display: none;
        }
        #big_title .sub {
            /*margin-top: 5px;*/
            border-bottom: 0.5px #D2D5D5 solid;
            padding-top: 5px;
        }
        #ad {
            top: 0px;
            left: 0px;
            display: none;
            width: 0px;
            height: 0px;
        }
	</style>
	<title><?=$title.' 金牌教師'?></title>
</head>
<body>
<div id="all">
		<div class="title"><label class="f17"><?=$title?></label></div>
		<form name="form1" id="form1" method="post" action="<?=site_url('/sets/update').'/'.$Sid?>" onsubmit="return check_data()">
		<div class="content">
			<div class="cen last">
				<table class="list_edit" border="0" width="100%" cellpadding="0" cellspacing="0">
	                <tr class="deep">
	                    <td width="250" align="center">考卷名稱</td>
	                    <td width="80%"><INPUT type="text" class="input_field w250" id="setsname" name="setsname" size="15" maxlength="20" value="<?=$Setsname?>"></td>
	                </tr>
					<tr class="shallow" id="duty">
	                    <td align="center">考卷說明</td>
	                    <td><textarea name="intro" id="intro" cols="50" rows="4" placeholder="範例：1-20題是非題。21-40題選擇題共40題" value="<?=$Intro?>"><?=$Intro?></textarea></td>
	                </tr>
	                <tr class="deep">
	                    <td align="center">考試時間</td>
	                    <td>
	                    	<label><input type="radio" name="chk_date" <?=$Time->date_N?> value="2">不限</label>
	                    	<label><input type="radio" name="chk_date" <?=$Time->date_Y?> value="1">期間內</label>
	                    	<INPUT type="text" class="input_field" name="begdate" id="begdate" size="10" maxlength="10" readonly value="<?=$Time->begdate?>">
                    		<select name="begTimeH"><?=$Time->begTimeH?></select>時 　～　
                    		<INPUT type="text" class="input_field" name="enddate" id="enddate" size="10"  maxlength="10" readonly value="<?=$Time->enddate?>">
                    		<select name="endTimeH"><?=$Time->endTimeH?></select>時
	                    </td>
	                </tr>
	                <tr class="shallow">
	                    <TD align="center">考試限時</TD>
	                    <td>
                            <select name='limTimeH' id='limTimeH'><?=$Lim->limTimeH?></select>時  
                    		<select name='limTimeM' id='limTimeM'><?=$Lim->limTimeM?></select>分 
                    		<select name='limTimeS' id='limTimeS'><?=$Lim->limTimeS?></select>秒
	                    </TD>
	                </TR>
	                <tr class="deep">
	                    <TD align="center">重覆考</TD>
	                    <td>
                    		<label><input type="radio" name="f_times" <?=$Again->N?> value="2">不行</label>
                    		<label><input type="radio" name="f_times" <?=$Again->Y?> value="1">可以</label>
	                    </TD>
	                </tr>
                    <tr class="shallow">
                        <td align="center">年級</td>
                        <td>
                            <select name="grade" id="grade" onchange="subj_c(this.value)">
                                <?=$Grade?>
                            </select>
                        </td>
                    </tr>
                    <tr class="deep">
                        <td align="center">科目</td>
                        <td id="subj">
                            <select name="subject" id="subject">
                                <?=$Subject?>
                            </select>
                    </td>
                    </tr>
                    <tr class="shallow">
                        <TD align="center">總分</TD>
                        <TD><INPUT type="text" class="input_field w50" id="sum" name="sum" size="3" maxlength="3" value="<?=$Sum?>"></TD>
                    </TR>
                    <tr class="deep">
                        <TD align="center">及格分數</TD>
                        <TD><INPUT type="text" class="input_field w50" id="passscore" name="passscore" size="3" maxlength="3" value="<?=$Pass?>"></TD>
                    </TR>
                    <tr class="shallow">
                        <td align="center">大題</td>
                        <td id="big_title">
                            <input type="button" value="新增大題" onclick="add_title()" class="btn"> <font color="red">刪除會連同考卷題目一併刪</font><br>
                            <div class="sub" id="<?=$fsub->ID?>">
                                <div><input type="hidden" name="sub_id[]" value="<?=$fsub->ID?>">
                                    <label>大題</label><input style="width:40px; text-align:center;" type="text" value="<?=$fsub->PART?>" class="input_field subsort" name="sub_sort[]" id="sub_sort" placeholder="順序"><label>　分數比重</label><input style="width:40px; text-align:center;" value="<?=$fsub->PERCEN?>" type="text" class="input_field subscore" name="sub_score[]" maxlength="4" id="sub_score">
                                    <label>%　</label>
                                </div>
                                <div>
                                    <label class="csub_intro">大題說明</label>
                                    <textarea name="sub_intro[]" class="subintro" value="<?=$fsub->INTRO?>"><?=$fsub->INTRO?></textarea>
                                </div>
                            </div>
                            <?php if (!empty($osub)): ?>
                                    <?php foreach ($osub as $ok => $ov): ?>
                            <div class="sub" id="<?=$ov->ID?>">
                                <div><input type="hidden" name="sub_id[]" value="<?=$ov->ID?>">
                                    <label>大題</label><input style="width:40px; text-align:center;" type="text" value="<?=$ov->PART?>" class="input_field subsort" name="sub_sort[]" id="sub_sort" placeholder="順序"><label>　分數比重</label><input style="width:40px; text-align:center;" value="<?=$ov->PERCEN?>" type="text" class="input_field subscore" name="sub_score[]" maxlength="4" id="sub_score">
                                    <label>%　</label><span title="移除" onclick="delr(this)">&times;</span>
                                </div>
                                <div>
                                    <label class="csub_intro">大題說明</label>
                                    <textarea name="sub_intro[]" class="subintro" value="<?=$ov->INTRO?>"><?=$ov->INTRO?></textarea>
                                </div>
                            </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </td>
                    </tr>
				</table>
                <div>
                    <input type="hidden" name="delsub" id="delsub">
                    <input type="hidden" name="csrf_token" value="<?=$this->security->get_csrf_hash()?>" />
                	<div style="text-align:left; float:left;"><INPUT type="submit" class="btn w150 f16" value="儲存" name="save" id="save"></div>
					<div style="text-align:right; height:30px; line-height:30px;"><a href="<?=site_url('/sets')?>"><font class="f15">返回上一層</font></a></div>
				</div>
            </div>
		</div>
    </form>
    <iframe src="" id="ad" name="ad"></iframe>
</div>
</body>
</html>
<script type="text/javascript">
function trim(value){
    return value.replace(/^\s+|\s+$/g, '');
}
function gb(v){
    return document.getElementById(v);
}
var dsub = [];
function del(obj){
    var sub = obj.parentElement.parentElement;
    $(sub).remove();
}
function delr(obj){
    if (confirm('確定刪除?')){
        var sub = obj.parentElement.parentElement;
        dsub.push(sub.id);
        gb('delsub').value = dsub.join(',');
        $(sub).remove();
    }
}
function add_title(){
    var html = '<div class="sub"><div><input type="hidden" name="sub_id[]" value=""><label>大題</label><input type="text" style="width:40px; text-align: center;" class="input_field subsort" name="sub_sort[]" placeholder="順序"><label>　分數比重</label><input type="text" style="width: 40px; text-align: center;" class="input_field subscore" name="sub_score[]" maxlength="4"><label>%　</label><span title="移除" onclick="del(this)">&times;</span></div><div><label class="csub_intro">大題說明</label><textarea name="sub_intro[]" class="subintro"></textarea></div></div>';
    $('#big_title').append(html);
}
// function check_all(obj,cName)
//     {
//         var checkboxs = document.getElementsByName(cName);
//         for(var i=0;i<checkboxs.length;i++){checkboxs[i].checked = obj.checked;}
//     }
function check_data(){
    var setsname = trim(gb('setsname').value);//名稱
    var error = false;
    var percen = 0;
    $(".subsort").each(function(){
        if (isNaN(this.value) || this.value=='' || this.value<1){
            error = true; alert('大題順序錯誤'); return false;
        }
    });
    if (error)return false;
    $(".subscore").each(function(){
        if (isNaN(this.value) || this.value=='' || this.value<1){
            error = true; alert('分數比例錯誤'); return false;
        }
        percen+=Number(this.value);
    });
    if (error)return false;
    if (percen!=100){
        alert('分數比例總和需為100'); return false;
    }
    if (setsname==''){
        alert('考試名稱有誤'); return false;
    }else if (!isNaN(setsname)){
        alert('考卷名稱不能都是數字'); return false;
    }
    var date = $('input[name=chk_date]:checked').val();
    if (date==0){
        if (gb('begdate').value > gb('enddate').value){
            alert('考試結束時間需大於等於考試起始時間!'); return false;
        }
    }
    var limTimeH = gb('limTimeH').value;
    var limTimeM = gb('limTimeM').value;
    var limTimeS = gb('limTimeS').value;
    if (limTimeH==0 && limTimeM==0 && limTimeS==0){
        alert('考試限時不可以都是0!'); return false;
    }
    var passscore = gb('passscore').value;
    if (passscore<=0 || isNaN(passscore)){
        alert('及格分數有誤'); return false;
    }
    var sum_score = gb('sum').value;
    if (sum_score<=0 || isNaN(sum_score)){
        alert('總分有誤'); return false;
    }
}
function subj_c(v){
    $.ajax({
        type:"GET",
        url:"<?=site_url('/basic/gsclist')?>",
        dataType:"JSON",
        data:{'type':'subj', 'g':v},
        success: function(rs){
            $("#subject").html('');
            var html = '';
            for(var i in rs){
                html+= '<option value="'+rs[i].ID+'">'+rs[i].NAME+'</option>';
            }
            $("#subject").html(html);
        }
    });
}
</script>