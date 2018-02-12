<?php 

interface Platform {
	
	public function getTypingAction();
	
	/**
	 * Send a message.
	 * @param $chat_id The chat where to send the message to.
	 * @param $text The text of the message.
	 * @param $reply_markup Array representing the keyboard provided to the users, 
	 * must contain 3 values:
	 * 'keyboard' - the keyboard structure as a multidimensional string array
	 * 'resize_keyboard' - boolean flag to set the keyboard as resizable
	 * 'one_time_keyboard' - boolean flag to set the keyboard as one time keyboard
	 */
	public function sendMessage($chat_id, $text, $reply_markup);
	
	/**
	 * Send a photo.
	 * @param $chat_id The chat where to send the message to.
	 * @param $photo The photo URL.
	 * @param $caption The caption to send alongside with the photo.
	 * @param $reply_markup Array representing the keyboard provided to the users, 
	 * must contain 3 values:
	 * 'keyboard' - the keyboard structure as a multidimensional string array
	 * 'resize_keyboard' - boolean flag to set the keyboard as resizable
	 * 'one_time_keyboard' - boolean flag to set the keyboard as one time keyboard
	 */
	public function sendPhoto($chat_id, $photo, $caption, $reply_markup);
	
	/**
	 * Send a platform-dependant representation of a button referencing an URL.
	 * @param $chat_id The chat where to send the message to.
	 * @param $text The text of the clickable object.
	 * @param $url The URL where the link points to.
	 * @param $reply_markup Array representing the keyboard provided to the users, 
	 * must contain 3 values:
	 * 'keyboard' - the keyboard structure as a multidimensional string array
	 * 'resize_keyboard' - boolean flag to set the keyboard as resizable
	 * 'one_time_keyboard' - boolean flag to set the keyboard as one time keyboard
	 */
	public function sendLink($chat_id, $text, $url, $reply_markup);
	
	/**
	 *
	 * @param unknown $array Array containing the chat_id and the action.
	 */
	public function sendChatAction($chat_id, $action);
	
	public function getWebhookUpdates();
	
	/**
	 * Get various information about the message.
	 * @param unknown $json The JSON-serialized message object.
	 * @return An array containing:
	 * 			'messageId' - the ID of the message;
	 * 			'chatId' - the ID of the user;
	 * 			'firstname' - the first name of the user;
	 * 			'lastname' - the last name of the user;
	 * 			'username' - the username of the user;
	 * 			'date' - the date of the message in UNIX epoch format;
	 * 			'text' - the text of the message;
	 * 			'globalDate' - a readable format of the date.
	 */
	public function getMessageInfo($json);
}

?>