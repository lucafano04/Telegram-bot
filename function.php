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
function getChatAdministrators($chat_id){
	global $url;
	return file_get_contents($url."/getChatAdministrators?chat_id=".$chat_id);
}
function kickChatMember($chat_id,$user_id,$until_date = 0)
{
	global $url;
	return file_get_contents($url."/kickChatMember?chat_id=".$chat_id."&user_id=".$user_id."&until_date=".$until_date);
}
function unbanChatMember($chat_id,$user_id)
{
	global $url;
	return file_get_contents($url."/unbanChatMember?chat_ixd=".$chat_id."&user_id=".$user_id);
}
function restrictChatMember($chat_id,$user_id,$permissions)
{
	global $url;
	return file_get_contents($url."/restrictChatMember?chat_id=".$chat_id."&user_id=".$user_id."&permissions=".$permissions);
}
function pinChatMessage($chat_id,$message_id,$disable_notification = false)
{
	global $url;
	return file_get_contents($url."/pinChatMessage?chat_id=".$chat_id."&message_id=".$message_id."&disable_notification=".$disable_notification);
}
function deleteMessage($chat_id,$message_id)
{
	global $url;
	return file_get_contents($url."/deleteMessage?chat_id=".$chat_id."&message_id=".$message_id);
}
function unpinChatMessage($chat_id)
{
	global $url;
	return file_get_contents($url."/unpinChatMessage?chat_id=".$chat_id);
}
?>