<?php

function sendMessageURI() {
	return 'https://graph.facebook.com/v2.6/me/messages?access_token=' . token();
}
	
function token() {
	return 'EAAE0Lnad6ywBAMLSxgKrmpli3B3LbptyyC9p5RsE67ZAxqp1IEPaZALNHDrvhZAcNqhy9lnyjhu246w4ujfyg0LTmW8lEpdqwHGLprEXpAitcSppzdyztaWMtcMT3nZCowKEuHX4KtvCFiAZAZA8ayfe9ZAYz6oIFIFXYsNobXjwwZDZD';
}