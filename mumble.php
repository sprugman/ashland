<?php
include 'ashData.php';
$yearsAr = fileToArray("years.txt");
$goobsAr = fileToArray("goobs.txt");
$showsAr = fileToArray("shows.txt");

if (!isset($year)) $year = count($yearsAr)-1; //-1; //
if (!isset($goob)) $goob = -1; //count($goobsAr)-1; //
if (!isset($show)) $show = -1;

?>

<html>
<head>
<title>Ashland -- <?=$yearsAr[$year]["year"]?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="ashland.css" type="text/css">

<style>
div { margin:15; margin-top:50; }
p { font-weight:bold }
</style>

</head>

<body bgcolor="#FFFFFF" text="#000000">

<?php 

	function column ($arr,$field) {
		foreach ($arr as $i => $row) {
			$out[$i] = $row[$field];
		}
	return $out;
	}
	
	// [4,5,7]
	// array of IDs, database, field
	
	function ids2fields($ids,$db,$field) {
		foreach ($ids as $id) {
			$out[$id] = $db[$id][$field];
		}
	return $out;
	}
	
	function ar2links ($arr,$test,$yes,$no,$sep) {
		//$goob = 1;
		$tobo = '$i==$test';
		foreach ($arr as $i => $a) {
			eval ("\$ystr = \"$yes\";");
			eval ("\$nstr = \"$no\";");
			eval ("\$tstr = $tobo;");
			//echo $tstr;
			$out[] = ($tstr) ? $ystr : $nstr;
		}
		$result = implode($sep,$out);
		return $result;
	}

?>


<div>
<p>All Years 2</p>

<?php 
    $yrName = column($yearsAr,'year');
    foreach ($yrName as $i => $yn) {
    	$ytxt[] = ($i==$year) ? "<b>$yn</b>" : "<a href=\"mumble.php?year=$i\">$yn</a>";
    }
    echo implode(" &middot\n    ",$ytxt);
?>


</div><div>
<p>All Goobs 2</p>

<?php 
    $gbName = column($goobsAr,'name');
    
    $y = '<b>$a</b>';
    $n = '<a href=\"mumble.php?goob=$i\">$a</a>';
    $s = " &middot\n    ";
    echo ar2links($gbName,$goob,$y,$n,$s);
    
    
    
    
    echo"<br><br>-----<br><br>";
    
    
    
    
    foreach ($gbName as $i => $gn) {
    	$gtxt[] = ($i==$goob) ? "<b>$gn</b>" : "<a href=\"mumble.php?goob=$i\">$gn</a>";
    }
    echo implode(" &middot\n    ",$gtxt);
?>


</div><div>
<p>Year Goobs 2</p>

<?php
    $yeargoobs = explode($divSep,$yearsAr[$year]["goobs"]);
    
    foreach ($yeargoobs as $ygb) {
    	$nm = $goobsAr[$ygb]["name"];
    	$ygt[] = "<a href=\"goob.php?goob=$ygb\">$nm</a>";
    }
    echo implode(" &middot\n    ",$ygt);
    
?>
    
    
</div><div>
<p>Year Shows 2</p>

<?php
    $yearshows = explode($divSep,$yearsAr[$year]["shows"]);
    $year_sum = 0;
    
    foreach($yearshows as $id){
    	$yr = $showsAr[$id]["title"];
    	$rateAr = array_mask(explode($divSep,$showsAr[$id]["ratings"]),"is_neg");
    	$avg = round(array_mean($rateAr),1);
    	$year_sum += $avg;
    	$boo[] = '<a href="show.php?show=' . $id . '">' . $yr . '</a> <span class="smaller">(' . $avg . ')</span>';
    }
    $year_avg = round($year_sum/count($yearshows),1);
    
    echo implode("<br>\n",$boo);
    echo "<p>average: $year_avg</p>";
?>

</div>

</body>
</html>
