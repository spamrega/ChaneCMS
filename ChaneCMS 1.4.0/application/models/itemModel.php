<?

class Item
{
	/* Информация о товаре */
	public static function getItemInfo ($id) 
	{
		$db = Db::getConnection();
		
		$goods = $db -> select("shop_goods", "*", ["id" => $id]);
		
		if ($goods[0]['id'] == $id) {
		    $goods = $goods[0];
		    $goods['count'] = count(explode("\n", $goods['item_selling']));
			return $goods;
		}
	}
	
	public static function generateHeader ($title)
	{
		$settings = Index::getShopSettings();

		$description = $settings['shop_name'] . ' - ' . $settings['shop_desc'];
		$keywords = $settings['shop_tags'];
		$icon = $settings['shop_icon'];
		$page_title = $title;

		require_once(APPPATH . '/templates/' . Buble::templateName() . '/views/headerView.php');
	}
}