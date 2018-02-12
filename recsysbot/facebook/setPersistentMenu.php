<?php 

function setPersistentMenu() {
	
	$config = require("/app/recsysbot/config/movierecsysbot-config.php");
	$url = "https://graph.facebook.com/v2.6/me/messenger_profile?access_token=" . $config['facebook_token'];
	
	$req = [
		"persistent_menu" => array(
			0 => [
				"locale" => "default",
				"composer_input_disabled" => "false",
				"call_to_actions" => array(
					0 => [
						"title" => "Commands",
						"type" => "nested",
						"call_to_actions" => array(
							0 => [
									"title" => "Start",
									"type" => "postback",
									"payload" => "startCommand"
							],
							1 => [
									"title" => "Info",
									"type" => "postback",
									"payload" => "infoCommand"
							],
							2 => [
									"title" => "Help",
									"type" => "postback",
									"payload" => "helpCommand"
							],
							3 => [
									"title" => "Reset",
									"type" => "postback",
									"payload" => "resetCommand"
							]
						)
					]
				)
			]
		)	
	];
	
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($req));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_HTTPHEADER,  ['Content-Type: application/json']);
	$res = curl_exec($ch);
	curl_close($ch);
	file_put_contents("php://stderr", "Creato menu persistente, risposta: " . $res . PHP_EOL);
}

?>