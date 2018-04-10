<?php

function replacechat($txt,$pattern) {
	$text=$txt;
	$patterns=explode(json_decode('"\u001F"'), $pattern);
	$patternslen=count($patterns);
	for($i=0; $i<$patternslen; $i++) {
		$current=explode(json_decode('"\u001D"'), $patterns[$i]);
		if(count($current)>1) {
			$text=str_ireplace($current[0], $current[1], $text);
		}
	}
	return $text;
}

?>
