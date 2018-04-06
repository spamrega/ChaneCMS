<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
	<?=AdminModel::generateHeader($settings['title'])?>
</head>
<body>
	<nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">ChaneCMS <?=VER?></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
              <? include(ROOT . '/views/admin/menuView.php')?>
          </ul>
        </div>
      </div>
    </nav>
	
	<div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
          <ul class="nav nav-sidebar">
              <? include(ROOT . '/views/admin/menuView.php')?>
          </ul>
        </div>

        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
			<h1 class="page-header">Товары <a href="/admin/goods/add"><i class="glyphicon glyphicon-plus icon-right"></i></a></h1>
			<div class="table-responsive">
				<table class="table table-bordered table-striped">
					<thead>
						<tr>
							<th class="col-xs-4 first_id">#</th>
							<th class="col-xs-4">Название</th>
							<th class="col-xs-4">Цена</th>
							<th class="col-xs-4 mid_id">Количество</th>
							<th class="col-xs-4 mid_id">Управление</th>
						</tr>
					</thead>
					<tbody>
						<?
							foreach ($goods as $item) {
								AdminModel::generateGoodsTableView($item);
							}
						?>
					</tbody>
				</table>
			</div>
		</div>
      </div>
    </div>
	
	<script type="text/javascript">
		function upload(id) {	
			var newWin = window.open("/admin/goods/upload/" + id,
			   "Загрузка товара",
			   "width=600, height=450, resizable=yes, scrollbars=yes, status=yes"
			)

			newWin.focus();
			var timer = setInterval(function() {
				if (newWin.closed) {
					location.reload();
					clearInterval(timer);
				}
			}, 100);
		}
	</script>
</body>
</html>