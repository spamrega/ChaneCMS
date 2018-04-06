<?php

class indexController
{
	public function actionIndex ()
	{
		require_once(ROOT . '/models/indexModel.php');

        $goods = ['goods' => Index::getGoodsList()];
		$shop = Index::getShopSettings();
		$pages = ['pages' => Index::getPages()];

		$data = array_merge($goods, $shop, $pages);
        $data['page_title'] = $shop['shop_desc'].' - '.$shop['shop_name'];

        $Buble = new Buble('indexView');
        $Buble -> createView($data);

		return true;
	}
	
	public function actionPage ($data)
	{
		require_once(ROOT . '/models/indexModel.php');

		$page_uri = $data[0];
        $pages = ['pages' => Index::getPages()];
		$page = Index::getPage($page_uri);
		
		if ($page['result']) {
			$shop = Index::getShopSettings();
            $Buble = new Buble('pageView');
            $data = array_merge($pages, $shop, $page);
            $data['page_title'] = $page['page_title'].' - '.$shop['shop_name'];
            $Buble -> createView($data);
		} else {
			Router::page404();
		}
		return true;
	}
}