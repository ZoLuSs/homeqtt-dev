<?php

function base64url_encode($data) {

	return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
  
}

function generate_jwt($payload) {
	$headers_encoded = base64url_encode(json_encode(array('alg'=>'HS256','typ'=>'JWT')));
	
	$payload_encoded = base64url_encode(json_encode($payload));

	$db = new SQLite3(__DIR__ . '/../../homeqtt.db');

	$secret = $db->querySingle('SELECT value FROM config WHERE name="JWT_KEY"');
	
	$signature = hash_hmac('SHA256', $headers_encoded.".".$payload_encoded, $secret, true);
	$signature_encoded = base64url_encode($signature);
	
	$jwt = "$headers_encoded.$payload_encoded.$signature_encoded";
	
	return $jwt;
}