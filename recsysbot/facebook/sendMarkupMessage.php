<?php

require_once '/app/recsysbot/facebook/utils.php';
require_once '/app/recsysbot/facebook/createQuickReplies.php';

function sendMarkupMessage($chat_id, $text, $reply_markup) {
	
	$url = sendMessageURI();
	
	$quick_replies = createQuickReplies($reply_markup);
	
	$req = [
			'messaging_type' => 'RESPONSE',
			'recipient' => [ 'id' => $chat_id ],
			'message' => [ 
					'text' => $text,
					'quick_replies' => $quick_replies
			]
	];
	file_put_contents("php://stderr", "\nSto inviando questo markup: " . print_r($req, true) . PHP_EOL);
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($req));
	curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$result = curl_exec($ch);
	curl_close($ch);
	file_put_contents("php://stderr", "\nResult: " . print_r($result, true) . PHP_EOL);
}