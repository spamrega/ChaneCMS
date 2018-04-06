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
			<h1 class="page-header">Добавление товара</h1>
			<form action="" method="POST">
				<p>Название страницы <input type="text" name="page_title" class="form-control" placeholder="Контакты" aria-describedby="basic-addon1"></p>
				<p>URL <input type="text" name="page_url" class="form-control" placeholder="contacts" aria-describedby="basic-addon1"></p>
				<p>Содержимое страницы (HTML) <textarea type="text" name="page_body" class="form-control" placeholder="Игра" aria-describedby="basic-addon1"></textarea></p>
				<script type="text/javascript" src="/templates/main/ckeditor/ckeditor.js"></script>
				<script type="text/javascript">CKEDITOR.replace('page_body');CKEDITOR.config.skin='flat';</script>
				<p><button type="submit" name="add" class="btn btn-primary">Сохранить</button></p>
			</form>
		</div>
      </div>
    </div>
</body>
</html>