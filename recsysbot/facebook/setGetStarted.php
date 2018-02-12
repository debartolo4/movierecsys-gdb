<?php

function setGetStarted($payload) {
	
	$config = require '/app/recsysbot/config/movierecsysbot-config.php';
	$url = "https://graph.facebook.com/v2.6/me/messenger_profile?access_token=" . $config['facebook_token'];
	
	$req = [
		"get_started" => [ "payload" => $payload ]	
	];
	
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($req));
	curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$res = curl_exec($ch);
	curl_close($ch);
	file_put_contents("php://stderr", "Creato pulsante get_started, risposta: " . $res . PHP_EOL);
	file_put_contents("php://stderr", "URL: " . $url . PHP_EOL);
}

?>