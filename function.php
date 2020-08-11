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
?>