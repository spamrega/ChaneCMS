<?
	function changeValues ($input, $data)
	{
		while (preg_match("/(%)(.*?)(%)/", $input, $match)) {
			$input = preg_replace("/%".$match[2]."%/", $data[$match[2]], $input);
		}
		return $input;
	}
	
	function issetArray($array)
	{
		$i = 0;
		foreach($array as $item){
			if(empty($item)){ 
				$i++;
			}
		}
		if ($i !== 0) {
			return false;
		} else {
			return true;
		}
	}
	
	function deleteDirectory($dir) {
		if (!file_exists($dir)) {
			return true;
		}

		if (!is_dir($dir)) {
			return unlink($dir);
		}

		foreach (scandir($dir) as $item) {
			if ($item == '.' || $item == '..') {
				continue;
			}

			if (!deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
				return false;
			}

		}

		return rmdir($dir);
	}
	
	if (isset($_POST['install'])) {
		require_once(APPPATH . '/install/sql/Db.php');
		
		$params = $_POST;
		
		if (issetArray($params)){
			$params['user_password'] = md5(md5($params['user_password']));
			try {
				$db = Db::getConnection($params['db_host'], $params['db_name'], $params['db_user'], $params['db_password']);
				
				$sql = file_get_contents(APPPATH . '/install/sql/db.sql');
				
				$sql = changeValues($sql, $params);
				
				$config = changeValues(file_get_contents(APPPATH . '/application/core/config.php'), $params);
				file_put_contents(APPPATH . '/application/core/config.php', $config);
			
				$db -> pdo -> exec($sql);
				
				include(APPPATH . '/application/core/Utilites.php');
				Utilites::getRequest('https://api.as-code.ru/chanecms/install.php?domain=' . $_SERVER['SERVER_NAME']);
			} catch (Exception $e) {
				$error = $e->getMessage();
			}
			
			deleteDirectory(APPPATH . '/install');
			header('Location: /');
		} else {
			$error = 'Все поля должны быть заполнены';
		}
		
	} else {
		
	}
	
	include_once(APPPATH . '/install/views/installView.php');