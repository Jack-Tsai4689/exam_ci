<style type="text/css">
	body {
		font-size: 14px;
	}
	.table {
		/*width: 800px;*/
		margin-bottom: 0px;
	}

	.buynums {
		width: 120px;
	}
	.itemname {
		width: 400px;
	}
	.displayname {
		width: 400px;
	}
	.displayname > input {
		width: 350px;
	}
	.unit {
		width: 80px;
		text-align: center;
	}
	.unit_price {
		width: 150px;
		text-align: right;
	}
	.itemno > input, .unit_price > input, .buynums > input {
		width: 100px;
	}
	.itemno {
		width: 150px;
	}
	input.ls {
		width: 16px;
		padding-left: 0px;
	}
	.buynums, .buynums > input {
		text-align: right;
	}
	.btn {
		width:44px;
		padding: 2px 7px;
		border-radius: 0px;
	}
	.bonus_div {
		display: none;
	}
	.bonus_label {
		width: 80px;
	}
	.money {
		width: 100px;
		text-align: right;
	}
</style>
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/jquery.slick/1.6.0/slick.css"/>
<link rel="stylesheet" type="text/css" href="assets/css/slick/slick-theme.css"/>
<div class="content-section-b">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<?php include('_menu.php') ?>
				<div class="from-group"><h4>價目表設定：<?=$pricegroup->price_name?></h4></div>
				<form name="nprform" id="nprform" method="post" action="<?=site_url('price/create')?>">
				<input type="submit" value="確定" name="price_tag">
				<div class="form-group">產品：
				<?php foreach ($product as $v): ?>
				<label><input type="radio" name="prod" value="<?=$v->id?>"><?=$v->prod_name?></label>
				<?php endforeach; ?>
				</div>
				<input type="hidden" name="gid" value="<?=$gid?>">
				<input type="hidden" id="<?=$this->security->get_csrf_token_name()?>" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash();?>">
				<div id="prod"><input type="button" onclick="more_price()" value="增加價格項目">
					<table class="table" cellpadding="0" cellspacing="0">
						<thead>
							<tr align="left">
								<td class="bonus_label">&nbsp;</td>
								<td class="itemno">品號</td>
								<td class="itemname">品項</td>
								<td class="displayname">顯示名稱</td>
								<td class="unit">單位</td>
								<td class="unit_price">單價</td>
								<td class="buynums">購買量</td>
								<td></td>
							</tr>
						</thead>
					</table>
				</div>
				</form>
			</div>
		</div>
	</div>
	<!-- /.container -->
</div>
<div class="modal fade" id="muliple_item" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<form role="form" action="setting.php" method="post" onsubmit="return check_pay()">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="myModalLabel"><font id="code_rs_title"></font> 品項列表</h4>
					</div>
					<div class="modal-body">
						<div class="form-inline">
						搜尋　<input type="text" id="search_item">
						<style id="search_style"></style>
						<table cellpadding="0" cellspacing="0" id="table_code">
							<thead>
								<tr>
									<td width="60"></td>
									<td width="80">品號</td>
									<td width="250">名稱</td>
									<td align="center" width="60">單位</td>
								</tr>
							</thead>
							<tbody>
							<?php foreach ($item as $v): ?>
								<tr class="item_list" data-index="<?=$v->item_no.' '.$v->item_name?>">
									<td><a href="javascript:void(0)" onclick="item_sel(<?=$v->id?>)">選擇</a></td>
									<td><?=$v->item_no?></td>
									<td><?=$v->item_name?></td>
									<td align="center"><?=$v->unit?></td>
								</tr>
							<?php endforeach; ?>
							</tbody>
						</table>
						<input type="hidden" name="select_code" id="select_code">
						</div>
					</div>
					<div class="modal-footer">
						<input type="reset" class="btn btn-default" data-dismiss="modal" name="pay_cancel" id="pay_cancel" value="關閉">
					</div>
				</form>
			</div>
		</div>
	</div>
<script src="<?=site_url('')?>assets/js/bootstrap.js"></script>
<script type="text/javascript">
	var ptable = 1;
	var btable = 1;
	var item_selected = null;
	var selected_type = null;
	function chk(){
		if (document.getElementById('prod_name').value=="")return false;
	}
	function more_price(){
		//var table = $('#prod'+v).find('table.price');
		var html = '<table id="prod_'+ptable+'" class="table" cellpadding="0" cellspacing="0"><tbody><tr><td class="bonus_label">價格<input type="hidden" name="noitem[]" id="noitem_'+ptable+'"><input type="hidden" name="brange[]" id="brange_'+ptable+'" value=""></td><td class="itemno"><input type="text" name="item[]" id="item_'+ptable+'"><input type="button" class="ls" value="…" onclick="ilist(\'p\',\'_'+ptable+'\')"></td><td class="itemname"><font id="item_name_'+ptable+'"></font></td><td class="displayname"><input type="text" name="dis[]" id="dis_'+ptable+'"></td><td class="unit"><font id="unit_'+ptable+'"></font></td><td class="unit_price"><input type="text" name="uprice[]" id="uprice_'+ptable+'" class="money"></td><td class="buynums"><input type="text" name="buyrows[]" id="buyrows_'+ptable+'"></td><td><input type="button" onclick="more_bonus('+ptable+')" value="增加優待項目">&nbsp;<a href="javascript:void(0)" onclick="rm(\'_'+ptable+'\')">移除</td></tr></tbody></table><div id="bonus_div_'+ptable+'"></div>';
		$('#prod').append(html);

		// <table id="prod'+v+'_'+ptable+'" class="table" cellpadding="0" cellspacing="0">
		// 	<tbody>
		// 		<tr>
		// 			<td class="bonus_label">價格<input type="hidden" name="noitem'+v+'[]" id="noitem'+v+'_'+ptable+'"></td>
		// 			<td class="itemno"><input type="text" name="item'+v+'[]" id="item'+v+'_'+ptable+'"></td>
		// 			<td class="itemname"><font id="item_name'+v+'_'+ptable+'"></font></td>
		// 			<td class="displayname"><input type="text" name="dis'+v+'[]" id="dis'+v+'_'+ptable+'"></td>
		// 			<td class="unit"><font id="unit'+v+'_'+ptable+'"></font></td>
		// 			<td class="unit_price"><font id="unit_price'+v+'_'+ptable+'"></font></td>
		// 			<td class="buynums"><input type="text" name="buyrows'+v+'[]" id="buyrows'+v+'_'+ptable+'"></td>
		// 			<td><input type="button" onclick="more_bonus('+v+','+ptable+')" value="增加優待項目">&nbsp;<a href="javascript:void(0)" onclick="rm(\''+v+'_'+ptable+'\')">移除</td>
		// 		</tr>
		// 	</tbody>
		// </table>
		// <div id="bonus_div'+v+'_'+ptable+'"></div>

		ptable++;
	}
	function ilist(t, v){
		item_selected = v;
		selected_type = t;
		$('#muliple_item').modal('show');
	}
	function item_sel(v){
		$.ajax({
			type: "POST",
			url: "<?=site_url('api/item')?>/"+v,
			dataType: "json",
			data: {csrf_token:$('#csrf_token').val()},
		}).done(function(rs){
			document.getElementById('noitem'+item_selected).value = rs.id;
			document.getElementById('unit'+item_selected).innerHTML = rs.unit;
			document.getElementById('dis'+item_selected).value = rs.name;
			if (selected_type=='p'){
				document.getElementById('item'+item_selected).value = rs.no;
				document.getElementById('item_name'+item_selected).innerHTML = rs.name;
			}
			if (selected_type=='b'){
				document.getElementById('bitem'+item_selected).value = rs.no;
				document.getElementById('bitem_name'+item_selected).innerHTML = rs.name;
			}
			set_bitem(item_selected, rs.id);
		}).fail(function(){

		});
		$('#muliple_item').modal('hide');
	}
	function set_bitem(id, v){
		$('input[name="pitem'+id+'[]"]').each(function(){
			this.value = v;
		});
	}
	function rm(v){
		$('#prod'+v).remove();
		$('#bonus_div'+v).remove();
	}
	function more_bonus(i){
		var itemno = '';
		var brange = document.getElementById('brange_'+i);
		if (brange.value=="")brange.value = '_'+i;
		if ($('#noitem_'+i).val()!='')itemno = $('#noitem_'+i).val();
		var html = '<table class="table" cellpadding="0" cellspacing="0"><tbody><tr><td class="bonus_label"><font color="red">優惠</font><input type="hidden" name="noitem_'+i+'[]" id="noitem_'+i+'_'+btable+'"><input type="hidden" name="pitem_'+i+'[]" id="pitem_'+i+'_'+btable+'" value="'+itemno+'"></td><td class="itemno"><input type="text" name="bitem_'+i+'[]" id="bitem_'+i+'_'+btable+'"><input type="button" class="ls" value="…" onclick="ilist(\'b\',\'_'+i+'_'+btable+'\')"></td><td class="itemname"><font id="bitem_name_'+i+'_'+btable+'"></font></td><td class="displayname"><input type="text" name="bdis_'+i+'[]" id="dis_'+i+'_'+btable+'"></td><td class="unit"><font id="unit_'+i+'_'+btable+'"></font></td><td class="unit_price"><input type="text" name="buprice_'+i+'[]" id="buprice_'+i+'_'+btable+'" class="money"></td><td class="buynums"><input type="text" name="bnums_'+i+'[]" id="bnums_'+i+'_'+btable+'" class="money"></td><td><a href="javascript:void(0)" onclick="rmb(this)">移除</td></tr></tbody></table>';
		$('#bonus_div_'+i).append(html);
		
		// <table class="table" cellpadding="0" cellspacing="0">
		// 	<tbody>
		// 		<tr>
		// 			<td class="bonus_label"><font color="red">優惠</font><input type="hidden" name="noitem'+v+'_'+i+'[]" id="noitem'+v+'_'+i+'_'+btable+'"><input type="hidden" name="pitem'+v+'_'+i+'[]" id="pitem'+v+'_'+i+'_'+btable+'" value="'+itemno+'"></td>
		// 			<td class="itemno"><input type="text" name="bitem'+v+'[]" id="bitem'+v+'_'+i+'_'+btable+'"></td>
		// 			<td class="itemname"><font id="bitem_name'+v+'_'+i+'_1"></font></td>
		// 			<td class="displayname"><input type="text" name="bdis'+v+'[]" id="dis'+v+'_'+i+'_'+btable+'"></td>
		// 			<td class="unit"><font id="unit'+v+'_'+i+'_'+btable+'"></font></td>
		// 			<td class="unit_price"><input type="text" name="buprice'+v+'[]" id="buprice'+v+'_'+i+'_'+btable+'" class="money"></td>
		// 			<td class="buynums"><input type="text" name="bnums'+v+'[]" id="bnums'+v+'_'+i+'_'+btable+'" class="money"></td>
		// 			<td><a href="javascript:void(0)" onclick="rmb(this)">移除</td>
		// 		</tr>
		// 	</tbody>
		// </table>

		btable++;
	}
	function rmb(obj){
		var div = $(obj).parents('div');
		var div_id = $(div).attr('id');
		var table = $(obj).parents('table');
		$(table).remove();
		var table_rows = $('#'+div_id).find('table').length;
		if (table_rows==0){
			var range = div_id.substr(9, div_id.length);
			document.getElementById('brange'+range).value = "";
		}
	}
	function view(v){
		var pro = document.getElementById('product');
		pro.src = "/homepage/admin/product/"+v;
		pro.height = 0;
		pro.onload = function(){
			document.getElementById('product_info').width = this.contentWindow.document.body.scrollWidth;
			this.height = this.contentWindow.document.body.scrollHeight+10;
			document.getElementById('product_info').height = this.contentWindow.document.body.scrollHeight+15;
		}
	}
	var searchstyle = document.getElementById('search_style');
	if (searchstyle){
	document.getElementById('search_item').addEventListener('input', function(){
	    if (!this.value){
	        searchstyle.innerHTML = '';
	        return;
	    }
	    searchstyle.innerHTML = ".item_list:not([data-index*=\""+this.value+"\"]) {display:none;}";
	});
	}
</script>