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
          <h1 class="page-header">Платежи</h1> 
          <h2 class="sub-header">Счета</h2>
          <div class="table-responsive">
		  
		  <form class="" method="POST" style="margin-bottom:5px;display:flex;max-width:371px;float:right;">
            <input type="text" name="order_id" class="form-control" placeholder="Поиск счета по номеру">
			<button type="submit" name="action" value="search" class="btn btn-lg btn-primary" style="margin-left:10px;height:34px;line-height:14px;" type="submit">Найти</button>
			<button type="submit" name="action" value="clear" class="btn btn-lg btn-primary" style="margin-left:10px;height:34px;line-height:14px;" type="submit">Очистить</button>
		  </form>
		  
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Товар</th>
                  <th>Сумма</th>
                  <th>IP</th>
                  <th>Почта</th>
                  <th>Дата</th>
                  <th>Статус</th>
                  <th>Ссылка</th>
                </tr>
              </thead>
              <tbody>
				<?
					foreach ($payments as $payment) {
						AdminModel::generatePaymentView($payment);
					}
				?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
</body>
</html>