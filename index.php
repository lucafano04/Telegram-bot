<?php
// inizializazzione file
include 'token.php';
include 'function.php';
include 'database.php';
//url preliminare
$url = "https://api.telegram.org/bot" . $token;
// get content of POST request
$content = file_get_contents("php://input");
$update = json_decode($content,true);

// variabili
$chat = $update["message"]["chat"]["id"];
$text = $update["message"]["text"];

// comandi
if ($text == "/start") {
	sendMessage($chat,"*benvenuto*");
}
sendMessage($chat,"```$content```");
$file = "input.json";
$f2 = fopen($file, 'w');
fwrite($f2, $content);
fclose($f2);
?>