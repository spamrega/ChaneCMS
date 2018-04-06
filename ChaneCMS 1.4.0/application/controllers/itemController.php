<?php

class itemController
{
	public function actionView ($params)
	{
		require_once(ROOT . '/models/indexModel.php');
		
		$shop = Index::getShopSettings();
        $pages = ['pages' => Index::getPages()];

		$id = intval($params[0]);
		
		require_once(ROOT . '/models/itemModel.php');
		
		$item = Item::getItemInfo($id);



        $data = array_merge($item, $shop, $pages);
        $data['page_title'] = 'Купить '.$item['item_name'].' - '.$shop['shop_name'];

		if ($item['id'] == $id) {
            $Buble = new Buble('itemView');
            $Buble -> createView($data);
		} else {
			Router::page404();
		}
		

		return true;
	}
	
	public function actionBuy ($params)
	{
		require_once(ROOT . '/models/indexModel.php');
        $shop = Index::getShopSettings();
        $pages = ['pages' => Index::getPages()];
		$id = intval($params[0]);
		
		require_once(ROOT . '/models/itemModel.php');
		$item = Item::getItemInfo($id);

		require_once(ROOT . '/controllers/paymentController.php');
		$payment = Payment::getPaymentsList();
        if (!$payment['primearea']) $payment['primearea'] = '0';
        if (!$payment['cryptonator']) $payment['cryptonator'] = '0';
		if ($item['item_selling'] != '') {
			$order_id = $this -> generateOrderID();
            $data = array_merge($item, $payment, $shop, $pages);
            $data['order_id'] = $order_id;
            $data['page_title'] = 'Покупка товара ' . $data['item_name'] . ' - ' . $data['shop_name'];
            $data['id'] = $id;

            $Buble = new Buble('itemBuyView');
            $Buble -> createView($data);
		} else {
			Router::page404();
		}
		return true;
	}
	
	public function generateOrderID ()
	{
		$characters = '1234567890123456789987654321123456789';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < 8; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
			if ($i === 0 && $randomString[0] === 0) {
				$randomString[0] = $characters[rand(0, 8)];
			}	
		}
		return $randomString;
	}
	
	public function actionPay($params)
	{
		$system = $params[0];
		$item_id = $params[1];
		$email = $_POST['email'];

		if ($system != '' && $item_id != '' && $email != '') {
			require_once(ROOT . '/controllers/paymentController.php');
			$payment = Payment::getPaymentsList();
			require_once(ROOT . '/models/itemModel.php');
			$item = Item::getItemInfo(intval($params[1]));
			if ($item['item_selling'] != '') {
				if ($payment['primearea'] && $system == 'primearea') {
					Payment::payPr($item_id, $email, $item, $this -> generateOrderID());
				} else {
					if ($system != 'cryptonator') {
						Router::page404();
					}
				}
				
				if ($payment['cryptonator'] && $system == 'cryptonator') {
					echo Payment::payCr($item_id, $email, $item, $this -> generateOrderID());
				} else {
					if ($system != 'primearea') {
						Router::page404();
					}
				}
			} else {
				Router::page404();
			}
		} else {
			Router::page404();
		}
		
		return true;
	}
	
	public function actionPurchase($params)
	{
		$order_id = intval($params[0]);
		
		require_once(ROOT . '/controllers/paymentController.php');
        require_once(ROOT . '/models/indexModel.php');
		$payment = Payment::getPayment($order_id);
        $shop = Index::getShopSettings();
        $pages = ['pages' => Index::getPages()];

        $data = array_merge($payment, $shop, $pages);

		if ($payment['item_selling'] != '') {
            $data['order_id'] = $order_id;
            $data['page_title'] = 'Оплата товара ' . $data['order_id'] . ' - ' . $data['shop_name'];

            $Buble = new Buble('purchaseView');
            $Buble -> createView($data);
		} else {
			Router::page404();
		}
		return true;
	}
}