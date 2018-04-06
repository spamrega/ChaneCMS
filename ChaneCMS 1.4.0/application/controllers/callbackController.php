<?php

class callbackController
{
	public function actionPrimearea ()
	{
		$db = Db::getConnection();
		
		if ($_SERVER["REMOTE_ADDR"] == '109.120.152.109') {
			require_once(ROOT . '/models/indexModel.php');
			require_once(ROOT . '/models/itemModel.php');
			
			$settings = Index::getShopSettings();
			
			parse_str(file_get_contents('php://input'), $post);
			
			print_r($post);
			$order_id = $post["payno"];
			$amount = $post["amount"];

			$query = $db -> select("shop_payments", "*", ["order_id" => $order_id]);
			$data = $query[0];
			
			$item_id = $data['item_id'];
			$email = $data['email'];
			$ip = $data['ip'];

			if($data["amount"] == $amount) {
				$sign = $post['sign'];
				unset($post['sign']);
				ksort($post,SORT_STRING);
				$signi = hash('sha256',implode(':',$post).':'.$settings['primearea_secret']);
				if($signi !== $sign)exit('invalid hash|' . $signi . '|'. $sign);
				
				if ($data['state'] == 0) {
					$query = $db -> select("shop_goods", "*", ["id" => $item_id]);
					$data_goods = $query[0];
					$item_name = $data_goods['item_name'];
					$goods = $data_goods['item_selling'];
					$goods_a = explode("\n", $goods);
					$item_selling = $goods_a[0];
					unset($goods_a[0]);
					$goods = implode("\n", $goods_a);
					
					$db -> update("shop_goods", [
						"item_selling" => $goods
					], ["id" => $item_id]);
					
					$db -> update("shop_payments", [
						"state" => 1,
						"item_selling" => $item_selling
					], ["order_id" => $order_id]);

					if (SMTP_USE) {
                        $to = $email;
                        $subject = 'Ваш заказ #' . $order_id;
                        $message = file_get_contents(APPPATH . '/templates/main/views/mailTemplate.tpl');
                        $styles = file_get_contents(APPPATH . '/templates/main/css/mail.css');

                        $message = str_replace('%item_name%', $item_name, $message);
                        $message = str_replace('%item_sold%', $item_selling, $message);
                        $message = str_replace('%styles%', $styles, $message);

                        Mailer::send($to, $subject, $message);
                    }
					
					if ($settings['telegram_id'] == '' and $settings['telegram_token'] == ''){

					} else {
						Notificator::sendMessage($settings['telegram_token'], $settings['telegram_id'], "Успешная оплата.\r\nСумма: $amount\r\nТовар: $item_name\r\nIP: $ip\r\nМерчант: Primearea");
					}
						
					die('YES');
				} else {
					die('paid');
				}
			} else {
				die('invalid_amount' . $data["amount"] .'|'. $amount);
			}
		} else {
			die('invalid_ip');
		}
	}
	
	public static function actionCryptonator ()
	{
		$db = Db::getConnection();
		
		require_once(ROOT . '/models/indexModel.php');
		require_once(ROOT . '/models/itemModel.php');
			
		$settings = Index::getShopSettings();
			
		$merchant_id = $_REQUEST['merchant_id'];
		$invoice_id = $_REQUEST['invoice_id'];
		$invoice_created = $_REQUEST['invoice_created'];
		$invoice_expires = $_REQUEST['invoice_expires'];
		$invoice_amount = $_REQUEST['invoice_amount'];
		$invoice_currency = $_REQUEST['invoice_currency'];
		$invoice_status = $_REQUEST['invoice_status'];
		$invoice_url = $_REQUEST['invoice_url'];
		$order_id = $_REQUEST['order_id'];
		$checkout_address = $_REQUEST['checkout_address'];
		$checkout_amount = $_REQUEST['checkout_amount'];
		$checkout_currency = $_REQUEST['checkout_currency'];
		$date_time = $_REQUEST['date_time'];
		$secret_hash = $_REQUEST['secret_hash'];
		
		$secret = $settings['cryptonator_secret'];

		$secret_hash_server = sha1($merchant_id . '&' . $invoice_id . '&' . $invoice_created . '&' . $invoice_expires . '&' . $invoice_amount . '&' . $invoice_currency . '&' . $invoice_status . '&' . $invoice_url . '&' . $order_id . '&' . $checkout_address . '&' . $checkout_amount . '&' . $checkout_currency . '&' . $date_time . '&' . $secret);

		if ($secret_hash == $secret_hash_server) {
			if ($invoice_status == 'paid') {
				$query = $db -> select("shop_payments", "*", ["order_id" => $order_id]);
				$data = $query[0];
				$item_id = $data['item_id'];
				$email = $data['email'];
				$ip = $data['ip'];
				
				if ($data['state'] == 0) {
					$query = $db -> select("shop_goods", "*", ["id" => $item_id]);
					$data = $query[0];
					$goods = $data['item_selling'];
					$goods_a = explode('\n', $goods);
					$item_selling = $goods_a[0];
					unset($goods_a[0]);
					$goods = implode('\n', $goods_a);
					
					$db -> update("shop_goods", [
						"item_selling" => $goods
					], ["id" => $item_id]);
					
					$db -> update("shop_payments", [
						"state" => 1,
						"item_selling" => $item_selling
					], ["order_id" => $order_id]);
					
					$to = $email;
					$subject = 'Ваш заказ #' . $order_id;
					$message = file_get_contents(APPPATH . '/templates/main/views/mailTemplate.tpl');
					$styles = file_get_contents(APPPATH . '/templates/main/css/mail.css');
					
					$message = str_replace('%item_name%', $item_name, $message);
					$message = str_replace('%item_sold%', $item_selling, $message);
					$message = str_replace('%styles%', $styles, $message);
					
					Mailer::send($to, $subject, $message);
					
					
					if ($settings['telegram_id'] == '' and $settings['telegram_token'] == ''){

					} else {
						Notificator::sendMessage($settings['telegram_token'], $settings['telegram_id'], "Успешная оплата.\r\nСумма: $amount\r\nТовар: $item_name\r\nIP: $ip\r\nМерчант: Cryptonator");
					}
			
					exit('YES');
				}
			}
		} else {
			die("error");
		}
	}
}