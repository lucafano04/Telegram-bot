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
		$key = "reply_markup=".urlencode($data);
	}
	$mes = urlencode($mex);
	file_get_contents($url."/editMessageText?chat_id=".$chat_id."&text=".$mes."&message_id=".$message_id."&parse_mode=Markdown&".$keyb);
}
?>