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
$nome = $update["message"]["from"]["first_name"];

// comandi
if ($text == "/start") {
	sendMessage($chat,"*benvenuto*",false);
}
sendMessage($chat,"```$content```",false);
$file = "input.json";
$f2 = fopen($file, 'w');
fwrite($f2, $content);
fclose($f2);
?>