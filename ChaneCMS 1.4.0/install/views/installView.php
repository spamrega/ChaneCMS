<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="http://getbootstrap.com/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="http://getbootstrap.com/examples/jumbotron-narrow/jumbotron-narrow.css">
	<link rel="stylesheet" href="css/style.css">
</head>
<body>
	<div class="container">
		<div class="row marketing">
			<div class="col-lg-12">
				<form action="#" method="POST" autocomplete="off">
					<input type="password" style="margin-left:-1000px;"> <!-- Костыль для Google Chrome -->
					
					<?if (isset($error)){?>
						<p><b>При установке ChaneCMS произошла следующая ошибка:</b> <code><?=$error?></code></p>
					<?}?>
					<h3>Установка Chane CMS 1.2</h3>
					<h5>Настройки соединения с базой данных</h5>
					<p><input type="text" name="db_host" placeholder="Host/IP базы данных" class="form-control" autocomplete="off"></p>
					<p><input type="text" name="db_name" placeholder="Название базы данных" class="form-control" autocomplete="off"></p>
					<p><input type="text" name="db_user" placeholder="Пользователь базы данных" class="form-control" autocomplete="off"></p>
					<p><input type="password" name="db_password" placeholder="Пароль базы данных" class="form-control" autocomplete="off"></p>
					
					<h5>Настройки магазина</h5>
					<p><input type="text" name="shop_name" placeholder="Название магазина" class="form-control" autocomplete="off"></p>
					<p><input type="text" name="shop_desc" placeholder="Описание магазина" class="form-control" autocomplete="off"></p>
					<p><input type="text" name="shop_tags" placeholder="Теги магазина" class="form-control" autocomplete="off"></p>
					<p><input type="text" name="shop_icon" placeholder="URL иконка магазина" class="form-control" autocomplete="off"></p>

					<h5>Настройки безопасности</h5>
					<p><input type="text" name="user_login" placeholder="Логин администратора" class="form-control" autocomplete="off"></p>
					<p><input type="password" name="user_password" placeholder="Пароль администратора" class="form-control" autocomplete="off"></p>

					<p><input type="submit" name="install" value="Установить" class="form-control" autocomplete="off"></p>
				</form>
			</div>
		</div>
		<footer class="footer">
			<p>&copy; 2017 TheArtik</p>
		 </footer>
    </div>
</body>