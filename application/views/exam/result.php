	<style type="text/css">
    	#all {
    		margin: 20px auto;
    		min-width: 1152px;
    	}
    	#title {
    		height: 30px;
    		line-height: 30px;
    	}
    	.title_intro{
    		height: 40px;
    		line-height: 40px;
    	}
    	.title_intro input {
    		margin-left: 5px;
    	}
    	.title_intro label {
    		margin-right: 5px;
    		font-size: 16px;
    	}
        .title_intro > .part {
            font-size: 16px;
            text-align: center;
            background-color: #EED6B4;
        }
    	.result_times{
    		text-align: center;
    	}
    	#cen {
    		padding: 20px 5px 15px 5px;
    	}
    	.qno {
    		width: 45px;
    		vertical-align: middle;
    		font-size: 18px;
    	}
    	.qno_c {
    		width: 50px;
    		vertical-align: middle;
    	}
    	.qno_ans {
    		font-size: 16px;
    		vertical-align: middle;
            width: 50px;
    	}
    	.qno_ans div {
    		margin-bottom: 5px;
    	}
    	.qno_ans input {
    		margin-right: 5px;
    	}
    	.qno_intro {
    		width: 1000px;
    	}
        .que {
            width: 1000px;
        }
        .que img {
            width: 1000px;
        }
    	.list td {
    		padding-bottom: 5px;
    	}
    	.list {
    		margin-bottom: 15px;
    		margin-left: 5px;
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
        .eror {
            color: #B3B3B3;
        }
	</style>
</head>
<body>
<div id="all">
	<div id="title"><label class="f17"><?=$title?></label></div>
	<div class="title_intro result_times">
		<label>費時</label><label><?=$UseTime->hour?> 時 <?=$UseTime->min?> 分 <?=$UseTime->sec?> 秒</label>
		<label>答對</label><label style="color:#076AAF"><?=$Main->SC_RNUM?></label><label>題<label>
		<label>答錯</label><label style="color:#B7282C"><?=$Main->SC_WNUM?></label><label>題</label>
		<label>未答<label><?=$Main->SC_NNUM?></label><label>題</label>
		<label>得分<label><font color="#C1272D"><?=round($Main->SC_SCORE, 2)?></font></label>分
	</div>
	<div class="title_intro">
        <?php if ($Open_ans): ?>
        <input type="button" class="btn w100 f14 nans" value="隱藏解答">
        <?php else: ?>
        <input type="button" class="btn w100 f14 ans" value="顯示解答">
        <?php endif; ?>
		<input type="button" class="btn w100 f14 analy" value="考題來源表">
		<INPUT type="hidden" name="f_sid" id="f_sid"  value="">
        <INPUT type="hidden" name="p_sids" id="p_sids" value="">
        <INPUT type="hidden" name="f_subject" id="f_subject" value="">
        <INPUT type="hidden" name="fkey" id="fkey" value="">
	</div>
    <?php foreach ($Part as $i => $v):?>
    <div class="title_intro">
        <div class="part">第<?=($i+1)?>大題(<?=$v->PERCEN?> %) 答對 <?=$v->SC_RNUM?> 題　答錯 <?=$v->SC_WNUM?> 題　未答 <?=$v->SC_NNUM?> 題</div>
    </div>
	<div class="content">
		<div id="cen">
			<table class="list" cellpadding="0" cellspacing="0" width="100%">
            <?php foreach ($Data[$i] as $iq => $q): ?>
				<tr align="center">
					<td class="qno"><?=($iq+1)?>.</td>
					<td class="qno_c"><?=$q->CORR?></td>
					<td class="qno_ans"><?=$q->MY_ANS?></td>
					<td class="que" align="left"><?=$q->QCONT?></td>
				</tr>
                <?php if ($Open_ans): ?>
                <tr align="center">
                    <td class="qno">解答</td>
                    <td class="qno_c"></td>
                    <td class="qno_ans"><?=$q->ANS_RIGHT?></td>
                    <td class="que" align="left">
                    	<?=$q->ACONT ?>
                    </td>
                </tr>
                <?php endif; ?>
                <tr>
                    <td colspan="5"><hr></td>
                </tr>
            <?php endforeach; ?>
			</table>
		</div>
	</div>
    <?php endforeach; ?>
	<div class="title_intro">
        <?php if ($Open_ans): ?>
        <input type="button" class="btn w100 f14 nans" value="隱藏解答">
        <?php else: ?>
        <input type="button" class="btn w100 f14 ans" value="顯示解答">
        <?php endif; ?>
		<input type="button" class="btn w100 f14 analy" value="考題來源表">
		<input type="text" class="input_field w250" name="" id="">
	</div>
</div>
</body>
</html>
<script type="text/javascript">
    window.moveTo(0,0);window.resizeTo(screen.width,screen.height);
    <?=$Url?>
    $(".analy").on('click', function(){
        location.href = "<?=site_url('analy/result/'.$Eid)?>";
    });
</script>