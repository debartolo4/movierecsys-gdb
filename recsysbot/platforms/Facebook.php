<?php 

require_once "recsysbot/platforms/Platform.php";
require "recsysbot/facebook/sendMessage.php";
require "recsysbot/facebook/setBotProfile.php";
require "recsysbot/facebook/setGetStarted.php";
require "recsysbot/facebook/setGreeting.php";
require "recsysbot/facebook/setPersistentMenu.php";
require "recsysbot/facebook/getUserInfo.php";
require "recsysbot/facebook/sendChatAction.php";
require "recsysbot/facebook/sendMarkupMessage.php";
require "recsysbot/facebook/sendPhoto.php";
require "recsysbot/facebook/sendLink.php";
$config = require_once '/app/recsysbot/config/movierecsysbot-config.php';


class Facebook implements Platform {
	
	public function getTypingAction() {
		return 'typing_on';
	}
	
	public function sendMessage($chat_id, $text, $reply_markup) {
		if ($reply_markup == null) {
			sendMessage($chat_id, $text);
		} else {
			sendMarkupMessage($chat_id, $text, $reply_markup);
		}
	}
	
	public function sendPhoto($chat_id, $photo, $caption, $reply_markup) {
		sendPhoto($chat_id, $photo, $reply_markup);
		if ($caption != null) {
			self::sendMessage($chat_id, $caption, $reply_markup);
		}
	}
	
	public function sendLink($chat_id, $text, $url, $reply_markup) {
		sendLink($chat_id, $text, $url, $reply_markup);
	}
	
	public function sendChatAction($chat_id, $action) {
		sendChatAction($chat_id, $action);
	}
	
	private function replyKeyboardMarkup($keyboard) {
		
		$quick_replies = array();
		
		foreach ($keyboard as $item) {
			$quick_replies['content_type'] = 'text';
			$quick_replies['title'] = $item;
			$quick_replies['payload'] = $item;
		}
		
		return $quick_replies;
	
	}
	
	public function getWebhookUpdates() {
		return file_get_contents("php://input");
	}
	
	public function getMessageInfo($json) {
		
		$message = $json['entry'][0]['messaging'][0];
		$userInfo = getUserInfo($message['sender']['id']);

		$info = array(
				'message' => $message,
				'messageId' => isset ($message['message']['mid']) ? $message['message']['mid'] : "",
				'chatId' => isset ($message['sender']['id']) ? $message['sender']['id'] : "",
				'firstname' => isset ($userInfo) ? $userInfo['first_name'] : "",
				'lastname' => isset ($userInfo) ? $userInfo['last_name'] : "",
				'username' => "", //Non viene restituito dalla chiamata
				'date' => isset ($json['entry'][0]['time']) ? $json['entry'][0]['time'] : "",
				'text' => isset ($message['message']['text']) ? $message['message']['text'] : "",
				'globalDate' => isset ($json['entry'][0]['time']) ? gmdate("Y-m-d\TH:i:s\Z", $json['entry'][0]['time']) : "",
				
				// Contiene il payload per i pulsanti nel caso vengano utilizzati
				'postbackPayload' => isset ($message['postback']['payload']) ? $message['postback']['payload'] : ""
		);
		
		if  ($info['postbackPayload'] != null) {
			$info['text'] = $info['postbackPayload'];
		}
		
		$info['date'] = intdiv($info['date'], 1000); // Converto da millisecondi a secondi
		
		return $info;
	}
	
}

?>