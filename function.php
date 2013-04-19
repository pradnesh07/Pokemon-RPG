<?php
date_default_timezone_set("America/New_York");
function parse($text) {
	$text = security_parse($text);
	$BBCode = array("/\[b\](.*?)\[\/b\]/i","/\[i\](.*?)\[\/i\]/i","/\[u\](.*?)\[\/u\]/i","/\[quote\](.*?)\[\/quote\]/i", "/\[s\](.*?)\[\/s\]/i");
	$html_c = array("<b>$1</b>","<em>$1</em>","<span style=\"text-decoration:underline\">$1</span>","<fieldset class=\"post_quote\"><legend>Quote:</legend>$1</fieldset>","<span style=\"text-decoration:line-through\" >$1</span>");
	$text = preg_replace($BBCode, $html_c, $text, -1);
	$matches = preg_match_all("/\[img\](.*?)\[\/img\]/",$text, $image_matches);
	for($i=0;$i!=$matches;$i++) {
		if(image_type_to_mime_type(exif_imagetype($image_matches[1][$i])) == "image/png" | image_type_to_mime_type(exif_imagetype($image_matches[1][$i])) == "image/gif" | image_type_to_mime_type(exif_imagetype($image_matches[1][$i])) == "image/jpeg") {
			$text = str_replace($image_matches[0][$i], "<img src=\"".$image_matches[1][$i]."\" />", $text);
		} else {
			$text = str_replace($image_matches[0][$i], exif_imagetype($image_matches[1][$i])." -> Image type not supported.", $text);
		}
	}
	$matches = preg_match_all("/\[url=(.*?)\](.*?)\[\/url\]/", $text, $link_matches);
	for($i=0;$i!=$matches;$i++) {
		$text = str_replace($link_matches[0][$i], "<a target=\"_blank\" href=\"".$link_matches[1][$i]."\">".$link_matches[2][$i]."</a>", $text);
	}
	$text = trim($text);
	return $text;
}
function security_parse($text, $type_of_text = null) {
	$text = str_replace("\n", "<br />", stripslashes(htmlentities($text)));
	if($type_of_text == "int") {
		$text = int_parse($text);
	}
	return $text;
}
function mysql_parse($text) {
	$text = preg_replace("/\[quote\](.*?)\[quote\].*\[\/quote\](.*?)\[\/quote\]/i", "[quote]$1 $2[/quote]", $text);
	return mysql_real_escape_string($text);
}
function int_parse($int) {
	if(is_numeric($int)) {
		return intval($int);
	} else {
		return false;
	}
	}
?>