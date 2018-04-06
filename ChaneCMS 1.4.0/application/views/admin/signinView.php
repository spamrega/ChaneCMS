<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
	<?=AdminModel::generateHeader($settings['title'])?>
	<?
		if ($settings['captcha']) {
			echo '<script src="https://www.google.com/recaptcha/api.js" async defer></script>';
		}
	?>
</head>
<body>
	<div class="container">
		<form class="resp" action="" method="POST">
			<p><h2 class="form-signin-heading"><?=$settings['title']?></h2></p>
			<p><input type="text" class="form-control" name="login" placeholder="Логин" required autofocus></p>
			<p><input type="password" name="password" class="form-control" placeholder="Password" required></p>
			<?
			if ($settings['captcha']) {?>
			<p><div class="captcha" style="width:304px;margin:auto;">
				<div class="g-recaptcha" data-sitekey="<?=$settings['recaptcha_public']?>"></div>
			</div></p>
			<?}
			if ($error_message == '') {} else {?>
				<p style="text-align:center;"><code><?=$error_message?></code></p>
			<?}?>
			<p><button class="btn btn-lg btn-primary btn-block" type="submit" name="submit" value="adsad" >Продолжить</button></p>
		</form>
    </div>
</body>
</html>