<?php

class Db
{
	public static function getConnection()
	{
		require_once(ROOT . '/core/Medoo.php');
		
		$db = new Medoo([
			'database_type' => 'mysql',
			'database_name' => DB_DATABASE,
			'server' => DB_HOST,
			'username' => DB_USER,
			'password' => DB_PASSWORD,
			'charset' => 'utf8'
		]);
		
		return $db;
	}
}