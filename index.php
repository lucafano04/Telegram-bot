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


//tastiere
$startk = 
array(
	'inline_keyboard' => array(
        array(
        	array('text'=>'➕Aggiungimi ad un Gruppo➕','url'=>"t.me/Test_LFS_bot?startgroup=group")
        ),
        array(
        	array('text'=>'👥 Gruppo','url'=>"https://t.me/joinchat/NNggCUfeHDjc7cfq1hUD-Q"),
        	array('text'=>'📣 Canale','url'=>"https://t.me/joinchat/AAAAAEZSB9SLlsS_qVLouQ"),
        	array('text'=>'📖 Guida','url'=>"t.me/test_lfs_bot"),
        ),
        array(
        	array('text'=>'🆘 Supporto','callback_data'=>'suporto'),
        	array('text'=>'Informazioni ℹ️','callback_data'=>'info'),
        ),
    )
);
$suppk =
array(
	'inline_keyboard' => array(
		array(
			array('text'=>'🆘 Supporto in chat', 'callback_data'=>'chat'),
		),
		array(
			array('text'=>'📖 Comandi del bot','callback_data'=>'comandi'),
		),
		array(
			array('text'=>'📖 Guida','url'=>'t.me/test_lfs_bot'),
		),
		array(
			array('text'=>'🔙 indietro','callback_data'=>'start'),
		),
	)
);

// comandi
if ($text == "/start") {
	sendMessage($chat,"*benvenuto*", $startk);
}
if ($data == "start") {
	editMessageText($chat,$msg_id,"*Benvenuto*",$startk);
}
if ($data == "suporto") {
	editMessageText($chat,$msg_id,"Supporto",$suppk);
}
//sendMessage($chat,"```$content```");
$file = "input.json";
$f2 = fopen($file, 'w');
fwrite($f2, $content);
fclose($f2);
var_dump(json_encode($keyboard));
?>