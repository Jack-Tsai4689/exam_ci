	<style type="text/css">
		#all {
			margin: 20px auto;
			min-width: 1152px;
		}
		#title {
			height: 30px;
			line-height: 30px;
		}
		#cen {
			width: 100%;
		}
		.hover {
			background-color: #FCE3CE;
		}
		.select {
			background-color: #F8CD89;
		}
		.content {
			float: left;
			width: 100%;
		}
		.btn {
			height: 25px;
			margin-bottom: 5px;
			border: 0.5px #EED6B4 solid;
		}
		.btn_page {
			height: 20px;
		}
		.title_intro {
			position: relative;
			height: 40px;
			line-height: 40px;
		}
		.title_intro input {
			margin-left: 5px;
		}
		.title_intro.btn{
			height: 25px;
		}
		#end {
			float: right;
			margin-right: 10px;
		}
		.list tr th {
			height: 40px;
		}
		.list tr td, .list tr th{
			vertical-align: middle;
			text-align: center;
			border-right: 1px #B4B5B5 solid;
			height: 40px;
		}
		.list .deep {
			background-color: #EFEFEE;
			font-weight: bold;
		}
		.list .shallow {
			background-color: #FCFCFC;
			font-weight: bold;
		}
		.list th.last{
			text-align: center;
			border-right: 0px;
		}
		.list td.last{
			border-right: 0px;
		}
		.list div.que {
			margin: 5px;
			background-color: gray;
			height: 30px;

		}
		.btn:active {
			border: 0.5px gray dashed;
		}
		.ps label {
			margin-left: 20px;
			color: #D35E69;
		}
		.title_intro.part > div {
			text-align: center;
			font-size: 16px;
		}
		.title_intro.part {
			background-color: #EED6B4;
		}
		
	</style>
</head>
<body>
<div id="all">
	<div id="title"><label class="f17"><?=$title?></label></div>
	<INPUT type="hidden" name="f_sid" id="f_sid" value="">
    <INPUT type="hidden" name="f_exnumr" id="f_exnumr" value="">
    <INPUT type="hidden" name="f_subject" id="f_subject" value="">
    <INPUT type="hidden" name="f_bmenuname" id="f_bmenuname" value="">
    <INPUT type="hidden" name="fkey" id="fkey" value="">
	<div class="title_intro">
		<input type="button" class="btn w100" id="see_result" value="回到題目區">
		<input type="button" class="btn w150" id="see_radar" value="觀念答對比率圖">
		<label class="f15" id="end"></label>
	</div>
	<?php foreach ($Part as $pi => $v):?>
	<div class="title_intro part">
		<div>第<?=($pi+1)?>大題 <?=round($v->score,2)?>分　答對<?=$v->rnum?>題　答錯<?=$v->wnum?>題　未答<?=$v->nnum?>題</div>
	</div>
	<div class="content">
		<div id="cen">
			<table width="100%" class="list">
				<thead>
					<tr class="shallow">
						<th style="min-width:60px;">題號</th>
						<th style="width:100%;">考題來源</th>
						<th style="min-width:60px;">對錯</th>
						<th style="min-width:60px;">答對率</th>
						<th style="min-width:60px;">難易度</th>
						<th style="min-width:90px;">作答</th>
						<th class="last" style="min-width:90px;">答案</th>
					</tr>
				</thead>
			<?php foreach ($v->qdata as $i => $q): ?>
				<tbody>
					<tr class="<?=($i%2===0) ? 'deep':'shallow'?>">
						<td><?=($i+1)?>.</td>
						<td align="left"><?=$q->chap?></td>
						<td><?=$q->right?></td>
						<td><?=$q->percen?>%</td>
						<td><?=$q->degree?></td>
						<td><?=$q->my_ans?></td>
						<td class="last"><?=$q->ans_right?></td>
					</tr>
				</tbody>
			<?php endforeach; ?>
			</table>
		</div>
	</div>
	<?php endforeach; ?>
	<!-- <div class="title_intro ps">
		<label>PS:答對率的答案以該員最高分統計</label>
	</div> -->
</div>
</body>
</html>
<script type="text/javascript">
	$("#see_result").on('click', function(){
		location.href = "<?=site_url('exam/score/'.$Eid)?>";
	});
	$("#see_radar").on('click', function(){
		location.href = "<?=site_url('analy/radar/'.$Eid)?>";
	});
</script>