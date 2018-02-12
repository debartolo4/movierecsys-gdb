<?php 

function setBotProfile() {
	
	$config = require '/app/recsysbot/config/movierecsysbot-config.php';
	
	setGreeting($config['greeting']);
	setGetStarted("get_started");
	setPersistentMenu();
}

?>