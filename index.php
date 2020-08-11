<?php
// inizializazzione file
include 'token.php';
include 'function.php';
//url preliminare
$url = "https://api.telegram.org/bot" . $token;
// get content of POST request
$content = file_get_contents("php://input");
$update = json_decode($content,true);

// variabili
$chat = $update["message"]["chat"]["id"];
$text = $update["message"]["text"];
$id = $update["message"]["from"]["id"];
$nome = $update["message"]["from"]["first_name"];
$cognome = $update["message"]["from"]["last_name"];
$username = $update["message"]["from"]["username"];
if (isset($update["callback_query"]["message"]["chat"]["id"])) {
	$chat = $update["callback_query"]["message"]["chat"]["id"];
	$id = $update["callback_query"]["message"]["from"]["id"];
	$data = $update["callback_query"]["data"];
	$msg_id = $update["callback_query"]["message"]["message_id"];
	$nome = $update["callback_query"]["message"]["from"]["first_name"];
	$cognome = $update["callback_query"]["message"]["from"]["last_name"];
	$username = $update["callback_query"]["message"]["from"]["username"];
}
include 'database.php';



$keyboard = array(
        array(
          array('text'=>'text1','callback_data'=>"1")
          ,array('text'=>'text2','callback_data'=>"2")
        ),
        array(
          array('text'=>'start','callback_data'=>"4")
        )
      );
$keyboard = array(
    'inline_keyboard' => $keyboard
);


// comandi
if ($text == "/start") {
	sendMessage($chat,"*benvenuto*");
}
if ($text == "/info") {
	sendMessage($chat, "*INFO*\nID: $id\nNome: $nome\nCognome: $cognome\nUsername: @$username)");
}
if ($text == "/key") {
	sendMessage($chat, "Tastiera",$keyboard);
}
sendMessage($chat,"```$content```");
$file = "input.json";
$f2 = fopen($file, 'w');
fwrite($f2, $content);
fclose($f2);
var_dump(json_encode($keyboard));
?>