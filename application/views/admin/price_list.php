<style type="text/css">
	.table {
		width: auto;
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
						<form name="npform" id="npform" method="post" action="<?=site_url('price/create_group')?>" onsubmit="return chk()">
							<div>新增價目</div>
							　　價目表名稱　<input type="text" name="price_name" id="price_name">
							<input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash();?>">
							<input type="submit" value="確定">
							</div>
						</form>
						<hr></hr>
						價目群
						<table class="table" cellpadding="0" cellspacing="0">
							<thead>
								<tr>
									<th>名稱</th>
									<th width="100"></th>
									<th width="100"></th>
								</tr>
							</thead>
							<tbody>
							<?php foreach ($price as $v): ?>
								<tr align="center">
									<td align="left"><?=$v->price_name?></td>
									<td><a href="<?=site_url('price/show/'.$v->id)?>">瀏覽</a></td>
									<td><a href="<?=site_url('price/edit/'.$v->id)?>">編輯</a></td>
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