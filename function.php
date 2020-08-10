<?php
function sendMessage($chat_id,$mex)
{
	global $url;
	$mes = urlencode($mex);
	file_get_contents($url."/sendMessage?chat_id=".$chat_id."&text=".$mes."&parse_mode=Markdown");
}
?>