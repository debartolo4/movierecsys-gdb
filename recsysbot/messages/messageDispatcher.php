<?php

function messageDispatcher($platform, $chatId, $messageId, $date, $text, $firstname, $botName) {
	
	$config = require '/app/recsysbot/config/movierecsysbot-config.php';
	
	$platform->sendChatAction($chatId, $platform->getTypingAction());
	
	file_put_contents("php://stderr", "[messageDispatcher] Sending message to server: " . 
			"\nChat ID: " . $chatId . "\nText: " . $text . PHP_EOL);
	
	// Nome provvisorio
	// Prende le informazioni sul messaggio inviato dall'utente e le manda al server
	// $data è già un array; sendMessageToServer si occupa di fare il json_decode
	$data = getReply($chatId, $messageId, $date, $text, $firstname, $botName);
	
	file_put_contents("php://stderr", "[messageDispatcher] Received message from server: ");
	file_put_contents("php://stderr", print_r($data, true) . PHP_EOL);
	
	// Array containing the messages to send to the user.
	$messages = $data['messages'];
	// Array containing the keyboard to provide to the user.
	$markup = $data['reply_markup'];
	
	// Invio i messaggi e la eventuale keyboard all'utente
	foreach ($messages as $message) {

		file_put_contents("php://stderr", "[messageDispatcher] Sending message to user:\n" .
				"chat_id: " . $chatId . "\ntext: " . $message['text'] . "\nphoto: " . $message['photo']. 
				"\nlink: " . $message['link'] . "\nkeyboard: " . print_r($markup, true) . PHP_EOL);
		
		if (isset ($message['photo'])) {
			try {
				$platform->sendPhoto($chatId, $message['photo'], $message['text'], $markup);
			} catch (Exception $e) {
				file_put_contents("php://stderr", "Foto non valida. Invio foto di default.");
				$platform->sendPhoto($chatId, $config['default_photo'], $message['text'], $markup);
			}
		} else if (isset ($message['link'])) {
			$platform->sendLink($chatId, $message['text'], $message['link'], $markup);
		} else {
			$platform->sendMessage($chatId, $message['text'], $markup);
		}
	}
}