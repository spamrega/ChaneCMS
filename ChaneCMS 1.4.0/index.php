<?php
	ini_set('display_errors', 1);
	#error_reporting(E_ALL);
    #error_reporting(0);
	define('APPPATH', dirname(__FILE__));
    define('B_START', microtime(true));
	
	if (file_exists(APPPATH . '/install/index.php')) {
		require_once(APPPATH . '/install/index.php');
	} else {
		require_once 'application/bootstrap.php';
	}
