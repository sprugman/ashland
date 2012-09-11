<?php

	$goobs = $_POST['goobs'];
	$highlights = $_POST['highlights'];
	$shows = $_POST['shows'];
	$cost = $_POST['cost'];
		
	if (!isset($goobs)) $goobs = array();
	if (!isset($highlights)) $highlights = "";
	if (!isset($shows)) $shows = array();
	
	
	$yearsAr[$year]["goobs"] = implode($divSep,$goobs);
	$yearsAr[$year]["highlights"] = cleanText($highlights);
	$yearsAr[$year]["shows"] = implode($divSep,$shows);
	$yearsAr[$year]["cost"] = $cost;

	arrayToFile ("years.txt",$yearsAr);
?>