<?php
	define('DB_USER', '%db_user%'); 				#Пользователь БД
	define('DB_PASSWORD', '%db_password%');			#Пароль пользователя БД
	define('DB_DATABASE', '%db_name%');			#Название БД
	define('DB_HOST', '%db_host%');				#Хост БД, обычно - localhost
	
	define('URL_REGOOGLE', 'https://www.google.com/recaptcha/api/siteverify');
	define('URL_CRYPTONATOR', 'https://api.cryptonator.com/api/merchant/v1/startpayment');
	define('URL_PRIMEAREA', 'https://primearea.biz/merchant/pay/');
	
	define('VER', '1.4');

    define('SMTP_USE', false); 		#Отправлять письма {true / false}
	define('SMTP_HOST', ''); 		#Адрес SMTP сервера
	define('SMTP_USERNAME', ''); 		#Логин SMTP почты
	define('SMTP_PASSWORD', ''); 		#Пароль SMTP почты
	define('SMTP_PORT', '587'); 		#Порт SMTP (587)
	define('SMTP_FROM', ''); 		#Адрес почты, с которой отправляются письма (обычно SMTP_USERNAME)
	define('SMTP_FROMNAME', ''); 		#Имя почты, может быть названием сайта

    /* Минимизация выводимых данных, никак не сказывается на отображаемом HTML, только на размере данных */
    define('MINIFY_OUTPUT', true);
	