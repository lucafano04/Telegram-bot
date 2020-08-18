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
$msg_id = $update["message"]["message_id"];
$data = NULL;
$ent_type = $update["message"]["reply_to_message"]["entities"][0]["type"];
$ent_offset = $update["message"]["reply_to_message"]["entities"][0]["offset"];
$ent_length = $update["message"]["reply_to_message"]["entities"][0]["length"];
$text_reply = $update["message"]["reply_to_message"]["text"];
if (isset($update["callback_query"]["message"]["chat"]["id"])) {
	$chat = $update["callback_query"]["message"]["chat"]["id"];
	$id = $update["callback_query"]["from"]["id"];
	$data = $update["callback_query"]["data"];
	$msg_id = $update["callback_query"]["message"]["message_id"];
	$nome = $update["callback_query"]["from"]["first_name"];
	$cognome = $update["callback_query"]["from"]["last_name"];
	$username = $update["callback_query"]["from"]["username"];
}
include 'database.php';
//messaggi
$info_msg = "Fux Help è stato sviluppato in PHP (Data)!\nStaff\n• @NonProvareaTaggarmi\n\nSviluppato da @Lucafano04";
$start_msg = "Ciao $nome\ne benvenuto nel bot Fux Help\n\n✅Aggiungendo questo bot nel tuo gruppo puoi gestire la chat in maniera molto semplice!\n\n👉 Aggiungimi in un gruppo e impostami come Amministratore!";
$dona_msg = "Questo all’interno:\n\n❤️Supporta il bot con una piccola donazione volontaria\n\n💬Mail paypal: luxurynetworkita@gmail.com";
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
        	array('text'=>'📖 Guida','url'=>"https://telegra.ph/COME-AGGIUNGERE-IL-TUO-GRUPPOCANALE-ALLA-COMMUNITY-08-13"),
        ),
        array(
        	array('text'=>'🆘 Supporto','callback_data'=>'chat'),
        	array('text'=>'Informazioni ℹ️','callback_data'=>'info'),
        ),
        array(
        	array('text'=>'❤️Dona','callback_data'=>'dona')
        ),
    )
);
$exitk =
array(
	'inline_keyboard' => array(
		array(
			array('text'=>'🔙 Esci dalla chat','callback_data'=>'esci'),
		),
	)
);
$backk = 
array(
	'inline_keyboard' => array(
		array(
			array('text'=>'🔙 indietro','callback_data'=>'start'),
		),
	)
);
//parte pvt
if ($chat > 0) {	
	//live chat     
	if(in_array($id, $admin) and $update['message']['reply_to_message']['forward_from']['id'] and $text) {
  		sendMessage($update['message']['reply_to_message']['forward_from']['id'], 'Risposta dagli Admins:' . "\n" . $text);
  		sendMessage($chat, 'Inviato.');
	}
	if (in_array($id, $admin)&&$ent_type == "hashtag") { 
		$user = substr($text_reply,$ent_offset + 3,$ent_length - 3);
		sendMessage($user,'Risposta dagli Admins:' . "\n" . $text);
		sendMessage($chat, 'Inviato.');
	}
	if ($data == "chat") {
		$sql  = 'UPDATE `gest` SET `page` = \'chat\' WHERE `gest`.`ID` = '.$id;
		if ($conn->query($sql) === TRUE){}
		editMessageText($chat,$msg_id,"*Ora sei in chat*\nInvia un messaggio e noi ti risponderemo\nPer uscire 	digita /esci o premi il tasto qui sotto",$exitk);
	}
	if ($data == "esci" or $text == "/esci") {
		$sql  = 'UPDATE `gest` SET `page` = \'\' WHERE `gest`.`ID` = '.$id;
		if ($conn->query($sql) === TRUE){}
		sendMessage($chat,"Sei uscito dalla chat",$backk);
		editMessageText($chat,$msg_id,"Sei uscito dalla chat",$backk);
		$info['page'] = "";
	}
	if ($info['page'] == "chat"&&$content) {
		foreach($admin as $ad) {
    		$res = ForwardMessage($ad, $chat, $msg_id);
    		$res = json_decode($res,true);
    		if (!$res['result']['forward_from']['id']) {
    			sendMessage($ad,"MESSAGGIO INOLTRATO DA:\n$nome\nID: #id$id\nRispondi a questo");
    		}
  		}
  	}
	// comandi
	if ($text == "/start") {
		sendMessage($chat,$start_msg, $startk);
	}
	if ($data == "start") {
		editMessageText($chat,$msg_id,$start_msg,$startk);
	}
	if ($data == "info") {
		editMessageText($chat,$msg_id,$info_msg,$backk);	
	}
	if ($data == "dona") {
		editMessageText($chat,$msg_id,$dona_msg,$backk);
	}
	$texta = explode(" ", $text);
	if ($texta[0] == "/admin") {
		sendMessage($chat,"admin");
	}
}
//gruppi
if ($chat < 0) {
	$admin = json_decode(getChatAdministrators($chat),true);
	$admin = $admin['result'];
	$ads = array();
	foreach ($admin as $ad) {
		$ads[] = $ad['user']['id'];
	}
	if(in_array($id, $ads)){
		if ($text == "/ban") {
			$user_reply = $update['message']['reply_to_message']['from']['id'];
			$nome_reply = $update['message']['reply_to_message']['from']['first_name'];
			$ok = json_decode(kickChatMember($chat,$user_reply),true);
			if($ok['ok'] == "true"){
					sendMessage($chat, "$nome_reply [ '$user_reply' ] Bannato");
			}else{
				sendMessage($chat, "Errore");
			}	
		}
		if ($text == "/kick") {
			$nome_reply = $update['message']['reply_to_message']['from']['first_name'];
			$user_reply = $update['message']['reply_to_message']['from']['id'];
			$ok = json_decode(kickChatMember($chat,$user_reply,31),true);
			if($ok['ok'] == "true"){
				sendMessage($chat, "$nome_reply [ '$user_reply' ] Kikkato");
			}else{
				sendMessage($chat, "Errore");
			}	
		}
		if ($text == "/mute") {
			$perm = array("can_send_messages"=>false);
			$nome_reply = $update['message']['reply_to_message']['from']['first_name'];
			$user_reply = $update['message']['reply_to_message']['from']['id'];
			$ok = json_decode(restrictChatMember($chat,$id,$perm),true);
			if($ok['ok'] == "true"){
				sendMessage($chat, "$nome_reply [ '$user_reply' ] Mutato");
			}else{
				sendMessage($chat, "Errore");
			}
		}
	}
}
$file = "input.json";
$f2 = fopen($file, 'w');
fwrite($f2, $content);
fclose($f2);
?>