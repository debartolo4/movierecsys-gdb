<?php

require_once '/app/recsysbot/facebook/utils.php';

function sendMessage($chat_id, $text) {
			
	$url = sendMessageURI();
	
	$req = [
		'messaging_type' => 'RESPONSE',
		'recipient' => [ 'id' => $chat_id ],
		'message' => [ 'text' => $text ]
	];
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($req));
	curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$result = curl_exec($ch);
	curl_close($ch);
	file_put_contents("php://stderr", "\nResult: " . print_r($result, true) . PHP_EOL);
}