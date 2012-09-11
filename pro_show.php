<?php

	$rates = $_POST['rates'];
	$comments = $_POST['comments'];
	
	if (!isset($rates)) $rates = array();
	if (!isset($comments)) $comments = array();
	
	$showsAr[$show]["ratings"] = implode("$divSep",$rates);
	$showsAr[$show]["comments"] = implode("$divSep",array_cleanText($comments));

	arrayToFile ("shows.txt",$showsAr);
?>
