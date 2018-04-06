<?php

class Db
{
	public static function getConnection($db_host, $db_name, $db_user, $db_password)
	{
		require_once(APPPATH . '/install/sql/Medoo.php');
		
		$db = new Medoo([
			'database_type' => 'mysql',
			'database_name' => $db_name,
			'server' => $db_host,
			'username' => $db_user,
			'password' => $db_password,
			'charset' => 'utf8'
		]);
		
		return $db;
	}
}