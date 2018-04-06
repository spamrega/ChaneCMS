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
			<h1 class="page-header">Настройки</h1>
			<div class="settings">
				<form action="" method="POST">
					<h3 class="page-header">Настройки магазина</h3>
					<p>Название магазина <input autocomplete="off" type="text" name="shop_name" value="<?=$settings['shop_name']?>" class="form-control" placeholder="ChaneCMS" aria-describedby="basic-addon1"></p>
					<p>Краткое описание <input autocomplete="off" type="text" name="shop_desc" value="<?=$settings['shop_desc']?>" class="form-control" placeholder="интернет магазин" aria-describedby="basic-addon1"></p>
					<p>Теги магазина <input autocomplete="off" type="text" name="shop_tags" value="<?=$settings['shop_tags']?>" class="form-control" placeholder="магазин, купить" aria-describedby="basic-addon1"></p>
					<p>Favicon магазина <input autocomplete="off" type="text" name="shop_icon" value="<?=$settings['shop_icon']?>" class="form-control" placeholder=".png .ico" aria-describedby="basic-addon1"></p>
					
					<h3 class="page-header">Настройки оплаты</h3>
					<p>PrimeArea shopid <input autocomplete="off" type="text" name="primearea_merchant" value="<?=$settings['primearea_merchant']?>" class="form-control" placeholder="1234" aria-describedby="basic-addon1"></p>
					<p>Секретная фраза PrimeArea Merchant <input autocomplete="off" type="password" name="primearea_secret" value="<?=$settings['primearea_secret']?>" class="form-control" placeholder="XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX" aria-describedby="basic-addon1"></p>
					<p>Cryptonator merchant_id <input autocomplete="off" type="text" name="cryptonator_merchant" value="<?=$settings['cryptonator_merchant']?>" class="form-control" placeholder="XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX" aria-describedby="basic-addon1"></p>
					<p>Секретная фраза Cryptonator Merchant <input autocomplete="off" type="password" name="cryptonator_secret" value="<?=$settings['cryptonator_secret']?>" class="form-control" placeholder="XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX" aria-describedby="basic-addon1"></p>
					<p><button type="submit" name="save" class="btn btn-primary">Сохранить</button></p>
				</form>
			</div>
		</div>
		
		<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
			<h3 class="page-header">Информирование</h3>
			<div class="settings">
				<form action="" method="POST">
					<? if ($settings['telegram_id'] == '') {?>
						<p><code>Чтобы узнать ID чата, напишите боту сообщение и перейдите по данной ссылке - <a href="https://api.telegram.org/bot<?=$settings['telegram_token']?>/getUpdates">Обновления бота</a> ID чата будет находиться в данном тексте "chat":{"id":ID_ЧАТА,...</code></p>
					<?}?>
					<p>Telegram BOT access token <input autocomplete="off" type="text" name="telegram_token" value="<?=$settings['telegram_token']?>" class="form-control" placeholder="" aria-describedby="basic-addon1"></p>
					<p>Telegram chatID <input autocomplete="off" type="text" name="telegram_id" value="<?=$settings['telegram_id']?>" class="form-control" placeholder="" aria-describedby="basic-addon1"></p>
					<p><button type="submit" name="inform" class="btn btn-primary">Сохранить</button>
					<? if ($settings['telegram_id'] != '' && $settings['telegram_token'] != '') {?>
						<button type="submit" name="test_inform" class="btn btn-primary">Отправить тестовое сообщение</button></p>
					<?}?>
				</form>
			</div>
		</div>
		
		<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
			<h3 class="page-header">Google Recaptcha</h3>
			<div class="settings">
				<form action="" method="POST">	
					<p>Публичный ключ <input type="text" readonly name="recaptcha_public" onfocus="this.removeAttribute('readonly')" value="<?=$settings['recaptcha_public']?>" class="form-control" placeholder="" autocomplete="off"></p>
					<p>Секретный ключ <input type="password" readonly name="recaptcha_private" onfocus="this.removeAttribute('readonly')" value="<?=$settings['recaptcha_private']?>" class="form-control" placeholder="" autocomplete="off"></p>
					<p><button type="submit" name="regoogle" class="btn btn-primary">Сохранить</button></p>
				</form>
			</div>
		</div>	
		
		<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
			<h3 class="page-header">Смена пароля</h3>
			<div class="settings">
				<form action="" method="POST">	
					<p>Старый пароль <input autocomplete="off" type="password" name="old_password" value="не надо читать" class="form-control" placeholder="" aria-describedby="basic-addon1"></p>
					<p>Новый пароль <input autocomplete="off" type="password" onchange="" id="password1" name="new_password" value="" class="form-control" placeholder="" aria-describedby="basic-addon1"></p>
					<p>Новый пароль повтор <input autocomplete="off" type="password" id="password2" name="new_password_repeat" value="" class="form-control" placeholder="" aria-describedby="basic-addon1"></p>
					<p><button type="submit" name="change" class="btn btn-primary">Сохранить</button></p>
				</form>
			</div>
		</div>
      </div>
    </div>
</body>
</html>