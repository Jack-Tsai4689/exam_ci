	<style type="text/css">
    	#all {
    		width: 90%;
    	}
    	#cen {
    		margin: 0 auto;
    		padding: 20px 0px 50px 0px;
    		margin: 0px 20px 0px 20px;
    	}
    	.input_field {
    		margin:0px;
    	}
    	.btn:active {
    		border: 0.5px gray dashed;
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
    	.list {
    		margin-bottom: 20px;
    	}
    	select {
    		margin-right: 5px;
            font-family: "微軟正黑體";
    	}
    	textarea {
    		width: 500px;
    		height: 65px;
    		margin: 5px 0px 5px 0px;
    	}
	</style>
</head>
<body>
<div id="all">
	<div id="title"><label class="f17"><?=$title?></label></div>
	<div class="content">
		<div id="cen">
            <form onsubmit="return check_data(this)">
    			<table class="list" border="0" width="100%" cellpadding="0" cellspacing="0">
                    <tr class="deep">
                        <td width="250" align="right">選擇方式</td>
                        <td width="80%">
                    		<label><input type="radio" name="etype" class="chk_exam" <?=($Etype==="S") ? 'checked':'' ?> value="S">考卷</label>
                            <label><input type="radio" name="etype" class="chk_exam" <?=($Etype==="C") ? 'checked':'' ?> value="C">章節</label>
                        </td>
                    </tr>
                    <?php if ($Etype==="C"): ?>
                    <tr class="shallow">
                        <td align="right">年級</td>
                        <td>
                            <select name="gra" id="gra" onchange="getsubj(this.value)">
                                <?=$Grade?>
                            </select>
                        </td>
                    </tr>
                    <tr class="deep">
                        <td align="right">科目</td>
                        <td>
                            <select name="subj" id="subj" onchange="getchap(this.value)">
                                <option value="0">全部</option>
                                <?=$Subject?>
                            </select>
                        </td>
                    </tr>
                    <tr class="shallow">
                        <td align="right">章節</td>
                        <td>
                            <select name="chap" id="chap">
                                <option value="0">全部</option>
                            </select>
                        </td>
                    </tr>
                    <tr class="deep">
                        <td align="right">難度</td>
                        <td><label><input type="radio" name="degree" class="deg" value="X">混合</label> 
                            <label><input type="radio" name="degree" class="deg" value="E" checked>容易</label> 
                            <label><input type="radio" name="degree" class="deg" value="M">中等</label> 
                            <label><input type="radio" name="degree" class="deg" value="H">困難</label>
                        </td>
                    </tr>
                    <tr class="shallow">
                        <td align="right">題數</td>
                        <td><label><input type="radio" name="rows" class="rw" value="10" checked>10</label> 
                            <label><input type="radio" name="rows" class="rw" value="20">20</label> 
                            <label><input type="radio" name="rows" class="rw" value="60">60</label>
                        </td>
                    </tr>
                    <?php endif; ?>
                    <?php if ($Etype==="S"): ?>
                    <tr class="shallow">
                        <td align="right">考卷</td>
                        <td>
                        	<select name="sets" id="sets" onchange="sets_intro(this.value);">
                    			<?=$Setsname?>
                    		</select>
                        </td>
                    </tr>
                    <tr class="deep">
                        <td align="right">摘要</td>
                        <td id="duty"><?=$Intro?></td>
                    </tr>
                    <?php endif; ?>
    			</table>
                <div>
                    <input type="hidden" name="csrf_token" value="<?=$this->security->get_csrf_hash()?>">
                	<div style="text-align:left; float:left;"><input type="submit" class="btn w150 f16" value="開始考試" name="goexam" id="goexam"></div>
    			</div>
            </form>
		</div>
	</div>
</div>
</body>
</html>
<script type="text/javascript">
$(".chk_exam").on("click", function(){
    location.href = "<?=site_url('/exam')?>?etype="+this.value;
});
function check_data(obj){
    $.ajax({
        type: "POST",
        url: "<?=site_url('/exam/ajginfo')?>",
        data: $(obj).serialize(),
        dataType: "JSON",
        success: function(){
            window.open("<?=site_url('/exam/start')?>","result","width="+screen.width+",height="+screen.height+",resizable=yes,scrollbars=yes,location=no");
        }
    });
    return false;
}
function sets_intro(v){
    if (isNaN(v))return;
    $.ajax({
        type: "GET",
        url: "<?=site_url('/exam/ajinfo')?>",
        data: {'sid':v},
        dataType: "JSON",
        success: function(rs){
            gb('duty').innerHTML = rs.data;
        }
    });
}
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
</script>