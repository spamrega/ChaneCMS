<?

class AdminModel
{	
	/* Метод авторизации */
	public static function signin ($login, $password, $recaptcha_private, $recaptcha_response, $captcha)
	{
		$db = Db::getConnection();
		
		if ($captcha) {
			$result = Utilites::checkReGoogle($recaptcha_private, $recaptcha_response, $_SERVER["REMOTE_ADDR"]);
			if ($result['success']) {
				$passed = true;
			} else {
				$passed = false;
			}
		} else {
			$passed = true;
		}
			
		if ($passed) {
			$login = $_POST['login'];
			$query = $db -> select("users_admin", "*", ["user_login" => $login]);
			$data = $query[0];
			if($data['user_password'] === md5(md5($_POST['password'])))
			{
				$hash = md5(Utilites::generateCode(23));
				$db -> update("users_admin", ["user_hash" => $hash], ["id" => $data['id']]);
				setcookie("id", $data['id'], time()+3600, "/");
				setcookie("hash", $hash, time()+3600, "/");
				return ['result' => true];
			}
			else
			{
				return ['result' => false, 'message' => 'Неверный логин и/или пароль'];
			}
		} else {
			return ['result' => false, 'message' => 'Неверная каптча'];
		}
	}
	
	/* Проверка авторизации */
	public static function isAuth()
	{
		$db = Db::getConnection();
		
		if (isset($_COOKIE['id']) and isset($_COOKIE['hash'])) {
			$id = intval($_COOKIE['id']);
			$query = $db -> select("users_admin", "*", ["id" => $id]);
			$userdata = $query[0];

			if(($userdata['user_hash'] !== $_COOKIE['hash']))
			{
				return false;
			} else {
				return true;
			}
		} else {
			return false;
		}
	}
	
	public static function getShopSettings () 
	{
		$db = Db::getConnection();
		
		$settings = $db -> select("shop_settings", "*", ["id" => 1]);
		$settings = $settings[0];
		
		if ($settings['recaptcha_public'] != '' || $settings['recaptcha_private'] != '') {
			$settings['captcha'] = true;
		} else {
			$settings['captcha'] = false;
		}
		return $settings; 
	}
	
	public static function generateHeader ($title)
	{
		$settings = AdminModel::getShopSettings();
		$settings['title'] = $title;
		require_once(ROOT . '/views/admin/headerView.php');
	}
	
	public static function getPayments($order_id = 0)
	{
		$db = Db::getConnection();
		if (intval($order_id) === 0) {
			$query = $db -> select("shop_payments", "*", ["ORDER" => ["id" => "DESC"], "LIMIT" => 15]);
		} else {
			$query = $db -> select("shop_payments", "*", ["order_id" => $order_id]);
		}
		
		return $query;
	}
	
	public static function getGoods()
	{
		$db = Db::getConnection();
	
		$query = $db -> select("shop_goods", "*");
		return $query;
	}
	
	public static function generatePaymentView($item)
	{
		include(ROOT . '/views/admin/paymentView.php');
	}
	
	public static function generateGoodsTableView($item)
	{
		include(ROOT . '/views/admin/goodsTableView.php');
	}
	
	public static function generatePagesTableView($item)
	{
		include(ROOT . '/views/admin/pagesTableView.php');
	}
	
	public static function paid ($state) {
		if ($state == 0) {
			return "Не оплачен";
		} else {
			return "Оплачен";
		}
	}
	
	public static function getItem ($id)
	{
		$db = Db::getConnection();
	
		$query = $db -> select("shop_goods", "*", ["id" => $id]);
		return $query[0];
	}
	
	public static function deleteItem ($id)
	{
		$db = Db::getConnection();
	
		$db -> delete("shop_goods", ["id" => $id]);
		return true;
	}
	
	public static function updateItem ($id, $data)
	{
		$db = Db::getConnection();
		$item_title = htmlspecialchars($data['item_title'], ENT_QUOTES);
		$item_price = number_format($data['item_price'], 2, '.', '');
				
		$item_img_1 = $data['item_img_1'];
		$item_img_2 = $data['item_img_2'];
				
		$item_desc = htmlspecialchars($data['item_desc'], ENT_QUOTES);
		$item_desc_a = htmlspecialchars($data['item_desc_a'], ENT_QUOTES);
				
		if ((filter_var($item_img_1, FILTER_VALIDATE_URL) === FALSE) and (filter_var($item_img_2, FILTER_VALIDATE_URL) === FALSE)) {
			die('Invalid URL');
		}
				
		$db -> update("shop_goods", [
			"item_name" => $item_title,
			"item_desc" => $item_desc,
			"item_price" => $item_price,
			"item_img_1" => $item_img_1,
			"item_img_2" => $item_img_2,
			"item_desc_a" => $item_desc_a
		], ["id" => $id]);
	}
	
	public static function addItem ($data)
	{
		$db = Db::getConnection();
		$item_title = htmlspecialchars($data['item_title'], ENT_QUOTES);
        $item_price = number_format($data['item_price'], 2, '.', '');
				
		$item_img_1 = $data['item_img_1'];
		$item_img_2 = $data['item_img_2'];
				
		$item_desc = htmlspecialchars($data['item_desc'], ENT_QUOTES);
		$item_desc_a = htmlspecialchars($data['item_desc_a'], ENT_QUOTES);
				
		if ((filter_var($item_img_1, FILTER_VALIDATE_URL) === FALSE) and (filter_var($item_img_2, FILTER_VALIDATE_URL) === FALSE)) {
			die('Invalid URL');
		}
				
		$db -> insert("shop_goods", [
			"item_name" => $item_title,
			"item_desc" => $item_desc,
			"item_price" => $item_price,
			"item_img_1" => $item_img_1,
			"item_img_2" => $item_img_2,
			"item_desc_a" => $item_desc_a
		]);
	}
	
	public static function getListing ($id)
	{
		$db = Db::getConnection();
		
		$query = $db -> select('shop_goods', ['item_selling'], ['id' => $id]);
		
		return $query[0];
	}
	
	public static function uploadListing ($id, $data)
	{
		$db = Db::getConnection();
		
		$db -> update('shop_goods', ['item_selling' => $data], ['id' => $id]);
		
		return true;
	}
	
	public static function getPages ()
	{
		$db = Db::getConnection();
	
		$query = $db -> select("shop_pages", "*");
		return $query;
	}
	
	public static function getPage ($id)
	{
		$db = Db::getConnection();
	
		$query = $db -> select("shop_pages", "*", ["id" => $id]);
		return $query[0];
	}
	
	public static function deletePage ($id)
	{
		$db = Db::getConnection();
	
		$db -> delete("shop_pages", ["id" => $id]);
		return true;
	}
	
	public static function updatePage ($id, $data)
	{
		$db = Db::getConnection();
		
		$page_title = htmlspecialchars($_POST['page_title'], ENT_QUOTES);
		$page_url = htmlspecialchars($_POST['page_url'], ENT_QUOTES);
		$page_body = $_POST['page_body']; /* использовать HTML теги можно*/
				
		$db -> update("shop_pages", [
			"page_title" => $page_title,
			"page_url" => $page_url,
			"page_body" => $page_body
		], ["id" => $id]);
	}
	
	public static function addPage ($data)
	{
		$db = Db::getConnection();
		
		$page_title = htmlspecialchars($_POST['page_title'], ENT_QUOTES);
		$page_url = htmlspecialchars($_POST['page_url'], ENT_QUOTES);
		$page_body = $_POST['page_body']; /* использовать HTML теги можно*/
				
		$db -> insert("shop_pages", [
			"page_title" => $page_title,
			"page_url" => $page_url,
			"page_body" => $page_body
		]);
	}
	
	public static function changePassword($old_password, $new_password, $new_password_repeat)
	{
		$db = Db::getConnection();

		$query = $db -> select('users_admin', '*', ['user_password' => $old_password]);
		$settings = $query[0];
		
		if ($new_password == $new_password_repeat) {
			if ($settings['user_password'] == $old_password) {
				$db -> update("users_admin", ["user_password" => $new_password], ["user_password" => $old_password]);
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	
	public static function saveBaseSettings ($data)
	{
		$db = Db::getConnection();
		
		$shop_name = $_POST['shop_name'];
		$shop_desc = $_POST['shop_desc'];
		$shop_tags = $_POST['shop_tags'];
		$shop_icon = $_POST['shop_icon'];
				
		$primearea_merchant = $_POST['primearea_merchant'];
		$primearea_secret = $_POST['primearea_secret'];
		$cryptonator_merchant = $_POST['cryptonator_merchant'];
		$cryptonator_secret = $_POST['cryptonator_secret'];
				
		$db -> update("shop_settings", [
			"shop_name" => $shop_name,
			"shop_desc" => $shop_desc,
			"shop_tags" => $shop_tags,
			"shop_icon" => $shop_icon,
			"primearea_merchant" => $primearea_merchant,
			"primearea_secret" => $primearea_secret,
			"cryptonator_merchant" => $cryptonator_merchant,
			"cryptonator_secret" => $cryptonator_secret
		], ["id" => 1]);
	}
	
	public static function saveInformSettings ($data)
	{
		$db = Db::getConnection();
		
		$telegram_token = $_POST['telegram_token'];
		$telegram_id = $_POST['telegram_id'];
				
		$db -> update("shop_settings", [
			"telegram_token" => $telegram_token,
			"telegram_id" => $telegram_id
		]);
	}
	
	public static function saveCaptchaSettings ($data)
	{
		$db = Db::getConnection();
		
		$recaptcha_public = $_POST['recaptcha_public'];
		$recaptcha_private = $_POST['recaptcha_private'];
				
		$db -> update("shop_settings", [
			"recaptcha_public" => $recaptcha_public,
			"recaptcha_private" => $recaptcha_private
		]);
	}
	
	public static function testTelegramInformer ()
	{
		$settings = AdminModel::getShopSettings();

		Notificator::sendMessage($settings['telegram_token'], $settings['telegram_id'], 'Тестовое сообщение! Спасибо, что выбрали ChaneCMS.');
	}

    public static function isAdmin ()
    {
        $db = Db::getConnection();

        if (isset($_COOKIE['id']) and isset($_COOKIE['hash'])) {
            $id = intval($_COOKIE['id']);
            $query = $db->select("users_admin", "*", ["id" => $id]);
            if ($query[0]['user_role'] == 1) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public static function getCurrentUser() {
        $db = Db::getConnection();

        if (isset($_COOKIE['id']) and isset($_COOKIE['hash'])) {
            $id = intval($_COOKIE['id']);
            $query = $db->select("users_admin", "*", ["id" => $id]);
            if ($query[0]['user_login'] != '') {
                return ['id' => $query[0]['id'], 'login' => $query[0]['user_login']];
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public static function getUsers($login = '') {
        $db = Db::getConnection();
        if ($login != '') {
            $query = $db->select('users_admin', '*', ['user_login[!]' => $login]);
        } else {
            $query = $db->select('users_admin', '*');
        }
        return $query;
    }

    public static function deleteUser($id) {
	    $currentUser = AdminModel::getCurrentUser();
	    if ($currentUser['id'] != $id) {
            $db = Db::getConnection();
            $db->delete('users_admin', ['id' => $id]);
	        return true;
        } else {
	        return false;
        }
    }

    public static function createUser($login, $password, $role) {
        $currentUser = AdminModel::getCurrentUser();
        $db = Db::getConnection();
        $query = $db->select('users_admin', '*', ['user_login' => $login]);
        if ($query[0]['user_login'] == '') {
            $db->insert('users_admin', [
                'user_login' => $login,
                'user_password' => md5(md5($password)),
                'user_role' => $role
            ]);

            return true;
        } else {
            return false;
        }
    }
}