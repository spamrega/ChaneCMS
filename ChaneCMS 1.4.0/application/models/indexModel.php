<?

class Index
{
	public static function getGoodsList () 
	{
		$db = Db::getConnection();
		
		$query = $db -> select("shop_goods", "*");
		return $query;
	}
	
	public static function getShopSettings () 
	{
		$db = Db::getConnection();
		
		$settings = $db -> select("shop_settings", "*", ["id" => 1]);
	
		return $settings[0]; 
	}

    public static function getPages ()
    {
        $db = Db::getConnection();

        $query = $db -> select("shop_pages", "*");

        $pages = [['page_title' => 'Главная', 'page_url' => '/']];
        foreach($query as $row) {
            $pages[] = ['page_title' => $row['page_title'], 'page_url' => $row['page_url']];
        }

        return $pages;
    }

	public static function getPagesHTML ()
	{
		$db = Db::getConnection();
		
		$query = $db -> select("shop_pages", "*");
		
		$html = '<a href="/"><li>Главная</li></a>';
		foreach($query as $row) {
			$html = $html . "\n" . '<a href="/page/' .$row['page_url']. '"><li>' .$row['page_title']. '</li></a>';
		}
		
		return $html;
	}
	
	public static function getPage ($uri)
	{
		$db = Db::getConnection();
		
		$query = $db -> select("shop_pages", "*", ['page_url' => $uri]);
		
		if ($query[0]['page_url'] == $uri) {
			return [
				'result' => true,
				'page_url' => $query[0]['page_url'],
				'page_title' => $query[0]['page_title'],
				'page_body' => $query[0]['page_body'],
			];
		}
	}
}