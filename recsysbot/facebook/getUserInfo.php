<?php

require_once '/app/recsysbot/facebook/utils.php';

function getUserInfo($chat_id) {
	
	$url = 'https://graph.facebook.com/v2.6/' . $chat_id . '?fields=first_name,last_name&access_token=' . token();
	$result = json_decode(file_get_contents($url), true);
	file_put_contents("php://stderr", "\nUser info: " . print_r($result, true) . PHP_EOL);
	return $result;
}