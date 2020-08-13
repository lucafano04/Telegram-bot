<?php
function sendMessage($chat_id,$mex,$keyb = false)
{
	global $url;
	if ($keyb) {
		$data = json_encode($keyb);
		$key = "reply_markup=".urlencode($data);
	}
	$mes = urlencode($mex);
	file_get_contents($url."/sendMessage?chat_id=".$chat_id."&text=".$mes."&parse_mode=Markdown&".$key);
}
function editMessageText($chat_id,$message_id,$mex,$keyb = false)
{
	global $url;
	if ($keyb) {
		$data = json_encode($keyb);
		$key = "&reply_markup=".$data;
	}else{
		$key = NULL;
	}
	$mes = urlencode($mex);
	file_get_contents($url."/editMessageText?chat_id=".$chat_id."&message_id=".$message_id."&text=".$mes."&parse_mode=Markdown&".$key);
}
function ForwardMessage($chat_id,$from_chat_id,$message_id)
{
	global $url;
	return file_get_contents($url."/ForwardMessage?chat_id=".$chat_id."&from_chat_id=".$from_chat_id."&message_id=".$message_id);
}
?>