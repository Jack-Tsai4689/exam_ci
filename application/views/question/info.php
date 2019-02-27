    <style type="text/css">
    	#all {
    		margin: 20px auto;
    		width: 90%;
    	}
    	.cen {
    		margin: 0 auto;
    		padding: 20px 0px 10px 0px;
    		margin: 0px 20px 0px 20px;
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
    	.last {
    		margin-bottom: 20px;
    	}
    	.oans {
    		display: none;
    	}
        .oans_control, .oans_control label {
            cursor: pointer;
        }
        .oans_control label {
            float: left;
        }
        #oans_pic {
            float: left;
            margin-top: 5px;
        }
    	select {
    		margin-right: 5px;
    	}
        video {
            width: 80%;
        }
	</style>
<body>
<div id="all">
	<div class="title"><label class="f17">題目資訊-第<?=$Qid?>題</label></div>
    <?php if ($Qtype!="G"): ?>
    <div class="content">
		<div class="cen">
			<table class="list last" border="0" width="100%" cellpadding="0" cellspacing="0">
                <tr class="deep">
                    <td align="right">擁有者</td>
                    <td width="80%"><?=$Owner?></td>
                </tr>
				<tr>
                    <td><label class="f17"><?=$Que_type?></label></td>
                    <td></td>
                </tr>
                <tr class="deep">
                    <td align="right">題目</td>
                    <td><?=$Qcont?></td>
                </tr>
                <tr class="shallow">
                    <td align="right">知識點</td>
                    <td><?=$Know?></td>
                </tr>
                <tr>
                    <td><label class="f17">範圍</label></td>
                    <td></td>
                </tr>
                <tr class="deep">
                    <td align="right">年級</td>
                    <td width="80%"><?=$Grade?></td>
                </tr>
                <tr class="shallow">
                    <td align="right">科目</td>
                    <td id="subj"><?=$Subj?></td>
                </tr>
                <tr class="deep">
                    <TD align="right">章節</TD>
                    <td><?=$Chap?></TD>
                </TR>
                <tr>
                    <td><label class="f17">選項</label></td>
                    <td></td>
                </tr>
                <tr class="deep">
                    <td align="right">正確答案</td>
                    <td width="80%"><?=$Ans?></td>
                </tr>
                <tr class="shallow">
                    <TD align="right">難易度</TD>
                    <td><?=$Degree?></TD>
                </TR>
                <tr>
                    <td><label class="f17 oans_control" onclick="show_oans('oans')"><img id="oans_pic" src="<?=base_url("/close.png")?>" height="20">詳解</label></td>
                    <td></td>
                </tr>
            </table>
            <table class="list oans last" border="0" width="100%" cellpadding="0" cellspacing="0" id="oans">
                <tr class="deep">
                    <td><?=$Acont?></td>
                </tr>
            </table>
        </div>
    </div>
    <div class="content" style="margin-bottom:50px;">
        <div class="cen" style="padding-bottom:50px;">
            <div style="text-align:left;">
                <a href="<?=site_url('/question/edit/'.$Qid)?>">
                <input type="button" class="btn w150 h30" value="編輯"></a>
                <input type="button" class="btn w150 h30" value="關閉" onclick="window.close();">
            </div>
        </div>
    </div>
    <?php else: ?>
    <div class="content">
        <div class="cen">
            <table class="list last" border="0" width="100%" cellpadding="0" cellspacing="0">
                <tr class="deep">
                    <td align="right">擁有者</td>
                    <td width="80%"><?=$Owner?></td>
                </tr>
                <tr>
                    <td><label class="f17"><?=$Que_type?></label></td>
                    <td></td>
                </tr>
                <tr class="deep">
                    <td align="right">說明</td>
                    <td><?=$Qcont?></td>
                </tr>
                <tr>
                    <td>
                        <a href="<?=site_url('/question/editg/'.$Qid)?>"><input type="button" class="btn w150 h30" value="編輯"></a>
                    </td>
                    <td></td>
                </tr>
            </table>
        </div>
    </div>
    <?php if (!empty($Sub_que)): ?>
    <?php foreach ($Sub_que as $si => $sv): ?>
    <div class="title"><label class="f17">第<?=($si+1)?>小題</label></div>
    <div class="content">
        <div class="cen">
            <table class="list last" border="0" width="100%" cellpadding="0" cellspacing="0">
                <tr>
                    <td><label class="f17"><?=$sv->QUE_TYPE?></label></td>
                    <td></td>
                </tr>
                <tr class="deep">
                    <td align="right">題目</td>
                    <td width="80%"><?=$sv->QCONT?></td>
                </tr>
                <tr class="shallow">
                    <td align="right">正確答案</td>
                    <td width="80%"><?=$Ans?></td>
                </tr>
                <tr class="deep">
                    <td align="right">知識點</td>
                    <td><?=$sv->Know?></td>
                </tr>
                <tr>
                    <td><label class="f17">範圍</label></td>
                    <td></td>
                </tr>
                <tr class="deep">
                    <td align="right">年級</td>
                    <td width="80%"><?=$sv->Grade?></td>
                </tr>
                <tr class="shallow">
                    <td align="right">科目</td>
                    <td id="subj"><?=$sv->Subj?></td>
                </tr>
                <tr class="deep">
                    <TD align="right">章節</TD>
                    <td><?=$sv->Chap?></TD>
                </TR>
                <tr class="shallow">
                    <TD align="right">難易度</TD>
                    <td><?=$sv->DEGREE?></TD>
                </TR>
                <tr>
                    <td><label class="f17 oans_control" onclick="show_oans('oans<?=($si+1)?>')"><img id="oans<?=($si+1)?>_pic" src="<?=base_url("/close.png")?>" height="20">詳解</label></td>
                    <td></td>
                </tr>
            </table>
            <table class="list oans" border="0" width="100%" cellpadding="0" cellspacing="0" id="oans<?=($si+1)?>">
                <tr class="deep">
                    <td><?=$sv->ACONT?></td>
                </tr>
            </table>
            <table class="list last" border="0" width="100%" cellpadding="0" cellspacing="0">
                <tr>
                    <td>
                        <a href="<?=site_url('/question/editgs/'.$sv->Qid)?>"><input type="button" class="btn w150 h30" value="編輯"></a>
                    </td>
                    <td></td>
                </tr>
            </table>
        </div>
    </div>
    <?php endforeach; ?>
    <?php endif; ?>
    <div class="content" style="margin-bottom:50px;">
        <div class="cen" style="padding-bottom:50px;">
            <div style="text-align:left;">
                <input type="button" class="btn w150 h30" value="關閉" onclick="window.close();">
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>
</body>
</html>
<script type="text/javascript">
function show_oans(obj){
    var ans = $('#'+obj);
	if (ans.css('display')=='none'){
		ans.css('display','table');
		$('#'+obj+'_pic').prop('src','<?=base_url("/open.png")?>');
	}else{
		ans.css('display','none');
		$('#'+obj+'_pic').prop('src','<?=base_url("/close.png")?>');
	}
}
window.moveTo((screen.width)*0.2,0);window.resizeTo((screen.width)*0.8,screen.height);window.focus();
</SCRIPT>