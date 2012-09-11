<?php

$colSep = "\t";
$divSep = "(-)";

function fileToArray ($file) {
	global $colSep;
	
	$rows = file($file);
	$colHeads = explode($colSep,trim($rows[0]));
	array_shift($rows);
	$numRows = count($rows);
	$numCols = count($colHeads);
	
	for ($i=0; $i<$numRows; $i++){
		$cols = explode($colSep,trim($rows[$i]));
		for ($j=0; $j<$numCols; $j++){
			$db[$i][$colHeads[$j]] = $cols[$j];
		}
	}
	return $db;
}


function arrayToFile ($filename,$arr) {
	global $colSep;
	
	$keys = implode($colSep,array_keys($arr[0]));
	$output = $keys . "\n";
	foreach ($arr as $row) {
		$output = $output . implode($colSep,$row) . "\n";
	}
	$f = fopen($filename, "w") or die("cannot find file $filename"); 
	fwrite($f, $output,100000);
	fclose($f);
}


function ar2str ($arr,$sep=",",$start="[",$end="]") {
	if (is_array($arr)) $out = $start.implode($sep,$arr).$end;
	else $out = $arr;
	return $out;
}

function crop ($fileArr,$field,$needle) {
	$result = array();
	foreach ($fileArr as $i=> $row) {
		if ($row[$field] == $needle) $result[$i] = $row;
	}
	return $result;
}

function array_mask($array, $callback) { 
	$farray = array (); 
	while(list($key,$val) = each($array)) 
	if (!$callback($val)) 
	$farray[$key] = $val; 
	return $farray; 
}

function is_neg ($n){ return ($n<0);}

function array_mean ($arr) {
	$sum = 0;
	foreach ($arr as $a) $sum += $a;
	$mean = (count($arr) > 0) ? $sum/count($arr) : 0;
	return $mean;
}


function array_stripslashes($arr = array()) { 
	$rs = array(); 
	while (list($key,$val) = each($arr)) { 
		$rs[$key] = stripslashes($val); 
	} 
	return $rs; 
} 

function array_cleanText($arr = array()) { 
	$rs = array(); 
	while (list($key,$val) = each($arr)) { 
		$rs[$key] = str_replace("\r\n","<br />",(htmlentities(stripslashes($val)))); 
	} 
	return $rs; 
} 

function cleanText ($str) {
	return str_replace("\r\n","<br />",(htmlentities(stripslashes($str))));
}

function unCleanText ($str) {
	return un_htmlentities(str_replace("<br>","\r\n",(str_replace("<br />","\r\n",($str)))));
}

function un_htmlentities ($string)
{
   $trans_tbl = get_html_translation_table (HTML_ENTITIES);
   $trans_tbl = array_flip($trans_tbl);
   return strtr($string, $trans_tbl);
}

/*
Function array_walk2($Array, $Function) 
{ 
// This function will apply a function to all an array's values. 
// The values will be quoted in the function call if $Use_Quotes is true. 

// Only deal with array's and real functions. 
If (!Is_Array($Array) OR !Function_Exists($Function)) Return $Array; 

// Force pointer to be at the first element of the array. 
Reset($Array); 

// Iterate through all values. 
While(List($Key, $Value) = Each($Array)) 
{ 
// If the element is an array, do that too. 
If (Is_Array($Array[$Key])) 
{ 
// It's an array, let's get recursive. 
$Array[$Key] = Array_Walk2($Array[$Key], $Function); 
} 
Else // !Is_Array($Array[$Key]) 
{ 
// It's a value, let's do our magic. 
Eval("\$Array[$Key] = $Function(\"$Array[$Key]\");"); 
} 
} 

Return $Array; 
}

function out($o) {
	echo $o;
}
*/
?>