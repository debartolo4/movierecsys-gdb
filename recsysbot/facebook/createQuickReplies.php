<?php

function createQuickReplies($reply_markup) {
	
	$MAX_OPTIONS = 11;
		
	$keyboard = $reply_markup['keyboard'];
		
	$options = array();
	for ($i = 0; $i < count($keyboard); $i++) {
		for ($j = 0; $j < count($keyboard[$i]); $j++) {
			$options[] = $keyboard[$i][$j];
		}
	}
	
	$quick_replies = array();
	for ($i = 0; $i < count($options); $i++) {
		$quick_replies[] = [
				"content_type" => "text",
				"title" => $options[$i],
				"payload" => $options[$i]
		];
	}
	$quick_replies = array_slice($quick_replies, 0, $MAX_OPTIONS);
		
	return $quick_replies;
}