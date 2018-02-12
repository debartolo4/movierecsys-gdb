<?php

// PARAMETRI DA MODIFICARE
$WEBHOOK_URL = 'https://movierecsys-gdb.herokuapp.com/execute.php';
$BOT_TOKEN = '461248954:AAHEq_phNUTqNpZ0QEZLJp_3bEe9RUEm5fY'; //Telegram

// NON APPORTARE MODIFICHE NEL CODICE SEGUENTE
$API_URL = 'https://api.telegram.org/bot' . $BOT_TOKEN . '/';
$method = 'setWebhook';
$parameters = array (
		'url' => $WEBHOOK_URL 
);
$url = $API_URL . $method . '?' . http_build_query ( $parameters );
$handle = curl_init ( $url );
curl_setopt ( $handle, CURLOPT_RETURNTRANSFER, true ); // true
curl_setopt ( $handle, CURLOPT_CONNECTTIMEOUT, 5 ); // 5
curl_setopt ( $handle, CURLOPT_TIMEOUT, 60 ); // 60
$result = curl_exec ( $handle );
print_r ( $result );
