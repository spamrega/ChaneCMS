<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
	<?=AdminModel::generateHeader($settings['title'])?>
</head>
<body>
	<form action="" class="add-form" method="POST">
		<h1 class="page-header add-h1">Добавление товара</h1>
			
		<p>Строка = товар <textarea type="text" name="item_listing" style="height:228px;" class="add form-control" placeholder="ключ 1.." aria-describedby="basic-addon1"><?=implode("\n", $selling_list)?></textarea></p>
		<p><button type="submit" name="add" class="btn btn-primary add-button">Сохранить</button></p>
	</form>
</body>
</html>