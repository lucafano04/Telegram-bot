<?php
function sendMessage($chat_id,$mex,$keyb)
{
	global $url;
	if ($keyb) {
		$key = "&reply_markup=".json_encode($keyb,true);
	}
	$mes = urlencode($mex);
	file_get_contents($url."/sendMessage?chat_id=".$chat_id."&text=".$mes."&parse_mode=Markdown".$key);
}
?>