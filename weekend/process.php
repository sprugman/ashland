<?php
	$who = $_POST['who'];
	$votes = $_POST['votes'];
	$goobmessage = $_POST['goobmessage'];
	
	if ($datafile == "weekrates.txt") {
		$city = 'Ashland';
		$url_suffix = '';
	} else {
		$city = 'NYC';
		$url_suffix = '/nyc.php';
	}

	$ratesAr[$who]["ratings"] = implode($divSep,$votes);
	arrayToFile ($datafile,$ratesAr);
	
	$to = '';
	foreach ($goobsAr as $goob) {
		if ($goob['core']) $to .= ($goob['email'] . ',');
	}
	
	$name = ucfirst($goobsAr[$who]['name']);
	$myemail = $goobsAr[$who]['email'];
	
	$subject = "$city update from $name.";
	
	$faveWeeks = '6/17, 6/23 and 9/3';
	$gm = stripcslashes($goobmessage);
	$message = "A word from $name on the occasion of changing weekend-o-matic preferences:\r\n\r\n$gm\n\n__________________________\n\nhttp://micahfreedman.com/ashland/weekend$url_suffix";
	
	$headers .= "From: $name <$myemail>\r\n"; 
	$headers .= "Reply-To: $name <$myemail>\r\n";
	$headers .= "Return-Path: <i@micahfreedman.com>\n";  // Return path for errors
	
	mail ($to, $subject, $message, $headers);

?>