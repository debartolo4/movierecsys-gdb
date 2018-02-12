<?php
	
	require 'vendor/autoload.php';
	$config = require '/app/recsysbot/config/movierecsysbot-config.php';
	
	foreach ( glob ( "recsysbot/classes/*.php" ) as $file ) {
		require $file;
	}
	foreach ( glob ( "recsysbot/functions/*.php" ) as $file ) {
		require $file;
	}
	foreach ( glob ( "recsysbot/keyboards/*.php" ) as $file ) {
		require $file;
	}
	foreach ( glob ( "recsysbot/messages/*.php" ) as $file ) {
		require $file;
	}
	foreach ( glob ( "recsysbot/replies/*.php" ) as $file ) {
		require $file;
	}
	foreach ( glob ( "recsysbot/restService/*.php" ) as $file ) {
		require $file;
	}
	foreach ( glob ( "recsysbot/platforms/*.php" ) as $file ) {
		require_once $file;
	}
	
	/**
	 * Change platform here.
	 * To create a new platform, create its own php class in the platforms folder.
	 * It has to implement the Platform interface.
	 */
	$platform = new Telegram();
	
	$content = $platform->getWebhookUpdates();
	$update = json_decode($content, true);
	
	if (!$update) {
		exit();
	}

	$messageInfo = $platform->getMessageInfo($update);
	
	// Stampa nel log
	file_put_contents("php://stderr", "messageId: " . $messageInfo['messageId'] . "\nchatId: " . $messageInfo['chatId'] . "\nfirstname: " . $messageInfo['firstname'] . "\nlastname: " . $messageInfo['lastname'] . "\ndate: " . $messageInfo['date'] . "\ntext: " . $messageInfo['text'] . "\nglobalDate: " . $messageInfo['globalDate'] . PHP_EOL);
	
	if ($messageInfo['chatId'] == "") {
		exit();
	}
	
	$messageInfo['text'] = trim ($messageInfo['text']);

	// Metterlo nel config
	$botName = "movierecsysbot";
	
	try {
		if (isset($messageInfo['text'])) {
			messageDispatcher($platform, $messageInfo['chatId'], $messageInfo['messageId'], $messageInfo['date'], $messageInfo['text'], $messageInfo['firstname'], $botName);
		} else {
			$response = "I'm sorry. I received a message, but i can't unswer";
			$platform->sendMessage($messageInfo['chatId'], $response);
		}
		
	} catch ( Exception $e ) {
		file_put_contents ( "php://stderr", "Exception chatId:" . $messageInfo['chatId'] . " - firstname:" . $messageInfo['firstname'] . " - botName" . $botName . " - Date:" . $messageInfo['globalDate'] . " - text:" . $messageInfo['text'] . PHP_EOL );
		file_put_contents ( "php://stderr", "Exception chatId:" . $messageInfo['chatId'] . " Caught exception: " . print_r ( $e->getTraceAsString (), true ) . PHP_EOL );
	}