<?php

require_once '/app/recsysbot/facebook/utils.php';

function sendChatAction($chat_id, $action) {
		
	$url = sendMessageURI();
	
	$json = [
		'messaging_type' => 'RESPONSE',
		'recipient' => [
				'id' => $chat_id
		],
		'sender_action' => $action
	];
	file_put_contents("php://stderr", "Sending chat action: " . print_r($json, true) . PHP_EOL);
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($json));
	curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$result = curl_exec($ch);
	curl_close($ch);
}