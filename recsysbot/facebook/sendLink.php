<?php

require_once '/app/recsysbot/facebook/createQuickReplies.php';

function sendLink($chat_id, $text, $link, $reply_markup) {
	
	$url = sendMessageURI();
	
	$message = [
		'attachment' => [
			'type' => 'template',
			'payload' => [
				'template_type' => 'button',
				'text' => $text,
				'buttons' => [
					[
						'type' => 'web_url',
						'url' => $link,
						'title' => 'Watch Trailer'
					]
				]
			]
		]	
	];
	
	$quick_replies = array();
	
	if ($reply_markup != null) {
		$quick_replies = createQuickReplies($reply_markup);
		$message['quick_replies'] = $quick_replies;
	}
	
	$req = [
		'messaging_type' => 'RESPONSE',
		'recipient' => [ 'id' => $chat_id ],
		'message' => $message
	];
	
	file_put_contents("php://stderr", "\nSto inviando questo link: " . print_r($req, true) . PHP_EOL);
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($req));
	curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$result = curl_exec($ch);
	curl_close($ch);
	file_put_contents("php://stderr", "\nResult: " . print_r($result, true) . PHP_EOL);
}