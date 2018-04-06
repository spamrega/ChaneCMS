<?

class Payment
{
	public static function getPaymentsList ()
	{
		$db = Db::getConnection();
		
		$query = $db -> select("shop_settings", ["primearea_merchant", "primearea_secret", "cryptonator_merchant", "cryptonator_secret"]);
		
		$query = $query[0];
		
		$primearea = ($query['primearea_merchant'] != '' && $query['primearea_secret'] != '');
		$cryptonator = ($query['cryptonator_merchant'] != '' && $query['cryptonator_secret'] != '');
		
		return array('primearea' => $primearea, 'cryptonator' => $cryptonator);
	}
	
	public static function getPaymentSettings ($system)
	{
		$db = Db::getConnection();
		
		switch ($system) {
			case 'primearea':
				$query = $db -> select("shop_settings", ["primearea_merchant", "primearea_secret"]);
				return $query[0];
			
			case 'cryptonator':
				$query = $db -> select("shop_settings", ["cryptonator_merchant", "cryptonator_secret"]);
				return $query[0];
		}
	}
	
	public static function payPr ($item_id, $email, $item, $order_id)
	{
		$item_name = $item['item_name'];
		$item_price = $item['item_price'];
		$ip = $_SERVER['REMOTE_ADDR'];
		$date = time();
		
		if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$db = Db::getConnection();
			
			$db -> insert("shop_payments", [
				"order_id" => $order_id,
				"item" => $item_name,
				"item_id" => $item_id,
				"amount" => $item_price,
				"state" => 0,
				"ip" => $ip,
				"email" => $email,
				"date" => $date
			]);
			
			$p_id = $order_id;
						
			$p_settings = Payment::getPaymentSettings('primearea');
			
			$data = array(
				'shopid' => $p_settings['primearea_merchant'],
				'payno' => $p_id,
				'amount' => $item_price,
				'description' => 'Оплата заказа #' . $p_id,
				'success' => 'http://' . $_SERVER['SERVER_NAME'] . '/purchase/' . $p_id
			);
						
			ksort($data,SORT_STRING);
			$sign = hash('sha256', implode(':', $data).':'.$p_settings['primearea_secret']);
			echo '
				<form id="payment" style="display:none" method="POST" action=https://primearea.biz/merchant/pay/ >
				<input type="hidden" name="shopid" value="'.$data['shopid'].'">
				<input type="hidden" name="payno" value="'.$data['payno'].'">
				<input type="hidden" name="amount" value="'.$data['amount'].'">
				<input type="hidden" name="description" value="'.$data['description'].'">
				<input type="hidden" name="sign" value="'.$sign.'"><br>
				<input type="hidden" name="success" value="' .$data['success']. '"><br>
				<button type="submit">Если вы не были переадресованы на страницу с оплатой в течение 5 секунд, нажмите сюда</button>
				</form>
			';
		} else {
			Router::page404;
		}
	}
	
	public static function payCr ($item_id, $email, $item, $order_id)
	{
		$item_name = $item['item_name'];
		$item_price = $item['item_price'];
		$ip = $_SERVER['REMOTE_ADDR'];
		$date = time();
		
		if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$db = Db::getConnection();
			
			$db -> insert("shop_payments", [
				"order_id" => $order_id,
				"item" => $item_name,
				"item_id" => $item_id,
				"amount" => $item_price,
				"state" => 0,
				"ip" => $ip,
				"email" => $email,
				"date" => $date
			]);
			
			$p_settings = Payment::getPaymentSettings('cryptonator');
			
			$item_name = $order_id;
			$invoice_currency = 'rur';
			$invoice_amount = $item_price;
			$success_url = 'http://' . $_SERVER['SERVER_NAME'] . '/purchase/' . $order_id;
			$sign = md5($p_settings['cryptonator_merchant'].':'.$invoice_amount.':'.$order_id);

			$url = URL_CRYPTONATOR . '?merchant_id=' . $p_settings['cryptonator_merchant'] . '&item_name=' . $item_name . '&invoice_currency=' . $invoice_currency . '&invoice_amount=' . $invoice_amount . '&order_id=' . $order_id . '&success_url=' . $success_url;				
			return $url;
		} else {
			Router::page404();
		}
	}
	
	public static function getPayment($id)
	{
		$db = Db::getConnection();
		
		if (intval($id) > 0) {
			$query = $db -> select('shop_payments', '*', ['order_id' => $id]);
			
			if (isset($query[0]['order_id'])) {
				return $query[0];
			} else {
				return ['result' => false, 'message' => 'Заказ не найден'];
			}
		} else {
			return ['result' => false, 'message' => 'Заказ не найден'];
		}
	}
}