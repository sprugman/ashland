<?php

	$ratesAr[$who]["ratings"] = implode($divSep,$votes);
	arrayToFile ($datafile,$ratesAr);
	
	$to = '';
	foreach ($goobsAr as $goob) {
		if ($goob['core']) $to .= ($goob['email'] . ',');
	}
	
	$name = ucfirst($goobsAr[$who]['name']);
	
	$subject = "Ashland update from $name.";
	
	$faveWeeks = '6/17, 6/23 and 9/3';
	$message = "In his infinite wisdom, our friend $name has changed his preferences for the weekend. Go to www.sprug.com/ashland/weekend to check out the new matrix. (Oooh... pretty colors....)";
	
	$headers = "Return-Path: <i@micahfreedman.com>\n";  // Return path for errors
	
	mail ($to, $subject, $message, $headers);

?>