<?php
	define('ROOT', dirname(__FILE__));
	
	require_once ROOT . '/core/Router.php';
	require_once ROOT . '/core/config.php';
	require_once ROOT . '/core/Db.php';
	require_once ROOT . '/core/Notificator.php';
	require_once ROOT . '/core/Buble.php';
	require_once ROOT . '/core/Utilites.php';
	require_once ROOT . '/core/Mailer.php';

	$time_upd = time();
	
	$router = new Router();
	$router -> run();