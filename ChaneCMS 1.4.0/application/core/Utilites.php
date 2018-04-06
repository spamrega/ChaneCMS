<?php

class Utilites
{
	public static function getRequest($url) 
	{
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_TIMEOUT, 10);
		curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.2.16) Gecko/20110319 Firefox/3.6.16");
		$curlData = curl_exec($curl);
		curl_close($curl);
		return $curlData;
	}
	
	public static function checkReGoogle ($private, $recaptcha, $ip)
	{
		$url = URL_REGOOGLE."?secret=" .$private. "&response=".$recaptcha."&remoteip=".$ip;
		$res = Utilites::getRequest($url);
		return json_decode($res, true);
	}
	
	public static function generateCode($length=8) 
	{
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPRQSTUVWXYZ0123456789";
		$code = "";
		$clen = strlen($chars) - 1;
		while (strlen($code) < $length) {
				$code .= $chars[mt_rand(0,$clen)];
		}
		return $code;
	}
	
	public static function countGoods($selling) 
	{
		if ($selling != '') {
			return count(explode("\n", $selling));
		} else {
			return 0;
		}
	}
	
	public static function alert($message) 
	{
		require_once(ROOT . '/views/admin/alert.php');
	}
}
