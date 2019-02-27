<style type="text/css">
	.table {
		width: 800px;
		font-size: 16px;
	}
	.btn {
		width:44px;
		padding: 2px 7px;
		border-radius: 0px;
	}
</style>
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/jquery.slick/1.6.0/slick.css"/>
<link rel="stylesheet" type="text/css" href="assets/css/slick/slick-theme.css"/>
		<div class="content-section-b">
			<div class="container">
				<div class="row">
					<div class="col-lg-12">
						<?php include('_menu.php') ?>
						<div class="from-group">
						<form name="npform" id="npform" method="post" action="<?=site_url('set/create')?>" onsubmit="return chk()">
							<div>新增產品</div>
							　　產品名稱　<input type="text" name="prod_name" id="prod_name">
							<input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash();?>">
							<input type="submit" value="確定">
							</div>
						</form>
						<hr></hr>
						產品列表
						<table class="table" cellpadding="0" cellspacing="0">
							<thead>
								<tr>
									<th>名稱</th>
									<th width="100"></th>
									<th width="100"></th>
								</tr>
							</thead>
							<tbody>
							<?php foreach ($product as $v): ?>
								<tr>
									<td><?=$v->prod_name?></td>
									<td>編輯</td>
									<td><input type="button" class="btn btn-danger" value="下架"></td>
								</tr>
							<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<!-- /.container -->
		</div>
<script type="text/javascript">
</script>