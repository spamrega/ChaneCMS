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
			<h1 class="page-header"><?=$item['item_name']?></h1>
			<form action="" method="POST">
				<p>Название товара <input type="text" name="item_title" class="form-control" value="<?=$item['item_name']?>" placeholder="Counter-Strike" aria-describedby="basic-addon1"></p>
                <p>Цена товара (от 1 рубля) <input type="number" step="any" name="item_price" class="form-control" placeholder="399" value="<?=$item['item_price']?>" aria-describedby="basic-addon1"></p>
                <p>URL изображения для списка товаров (рекомендуемый размер <?=$template['product_min_width'] . 'x' . $template['product_min_height']?>px)<input type="text" name="item_img_1" value="<?=$item['item_img_1']?>" class="form-control" placeholder="https://.../img.png" aria-describedby="basic-addon1"></p>
				<p>URL изображения для страницы товара (рекомендуемый размер <?=$template['product_max_width'] . 'x' . $template['product_max_height']?>px)<input type="text" name="item_img_2" value="<?=$item['item_img_2']?>" class="form-control" placeholder="https://.../img.png" aria-describedby="basic-addon1"></p>
				<p>Описание товара для страницы товара <textarea type="text" name="item_desc" class="form-control" placeholder="Игра" aria-describedby="basic-addon1"><?=$item['item_desc']?></textarea></p>
				<p>Дополнительная информация для страницы товара <textarea type="text" name="item_desc_a" class="form-control" placeholder="Активация в приложении Steam" aria-describedby="basic-addon1"><?=$item['item_desc_a']?></textarea></p>
				<p><button type="submit" name="save" class="btn btn-primary">Сохранить</button></p>
			</form>
		</div>
      </div>
    </div>
</body>
</html>