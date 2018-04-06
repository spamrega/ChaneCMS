<?php

class Notificator
{
	public static function sendMessage($bot_token, $chat_id, $message)
	{
		if ($bot_token[0].$bot_token[1].$bot_token[2] != 'bot') {
			$bot_token = 'bot' . $bot_token;
		}
		$url = "https://api.telegram.org/" . $bot_token . "/sendMessage?chat_id=" . $chat_id .
		"&text=" . urlencode($message);
		
		file_get_contents($url);
	}
}