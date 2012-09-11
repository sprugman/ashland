<?php
include '../ashData.php';
include 'image.php';
$goobsAr = fileToArray("../goobs.txt");
$datafile = "weekratesNYC.txt";
$ratesAr = fileToArray($datafile);

$id = (isset($_GET['id'])) ? $_GET['id'] : -1;
$edit = ($id == -1) ? 0 : 1;

$weekends = listOfWeeks(6, 3, 10, 7);
$rateValues = array(3,2,1,0,-1,-2,-3);
$rateLabels = array("Love it!", "I'll go", "Might go", "Don't know", "Might not", "Unlikely", "Hate it.");

if (isset($_POST['change'])) include 'process.php';



//------------------------------ DATE STUFF ------------------------------

# Given a starting date and and ending date, return a list of month/day
# strings corresponding to each week between the dates, inclusive.
function listOfWeeks($start_month, $start_day, $end_month, $end_day) {
  $return_value = array();

  while (dateBefore($start_month, $start_day, $end_month, $end_day)) {
    array_push($return_value, "$start_month/$start_day");
    nextWeek($start_month, $start_day);
  }  
  array_push($return_value, "$end_month/$end_day");
  return($return_value);
}

# Determine whether one date precedes another.
function dateBefore($start_month, $start_day, $end_month, $end_day) {

  if ($start_month < $end_month) {
    return(1);
  } else if ($start_month > $end_month) {
    return(0);
  } else if ($start_day < $end_day) {
    return(1);
  }
  return(0);
}

# Add a week to a given month/day combo.
function nextWeek(&$month, &$day) {

  # Store the number of days in each month.
  $monthLengths = array(0, 31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31); // jan == 1, not 0

  $day += 7;
  if ($day > $monthLengths[$month]) {
    $day -= $monthLengths[$month];
    $month++;
  }
}

//--- end DATE STUFF

/*
function getColor ($r, $factor = '3') {
	$numGoobs = 8; // this is derivable, but I don't feel like dealing with it right now...
	$base = '7';
	$num = base_convert (round(($numGoobs*$factor - $r -1)/$factor), 10, 16);
	if ($r > 0) $result = '#' . $num . $base . $num;
	else $result = '#' . $num . $base . $base;
	//echo $result . " | ";
	return $result;
}
*/
function getColor ($r, $max=24) {
	$hue = ($r < 0) ? 10 : 140;
	$sat = abs($r/$max);
	$val = .45 + $sat * .4;
	$hsv = array($hue, $sat, $val);
	$result = "rgb(" . implode(", ", Image::hsv2rgb($hsv)) . ")";
	return $result;
}




?>

<html>
<head>
<title>NYC -- Weekend-O-Matic</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="../ashland.css" type="text/css">
<link rel="stylesheet" href="planning.css" type="text/css">


</head>

<body bgcolor="#FFFFFF" text="#000000">

<div class="titleBox">
  <div class="title">NYC Weekend-O-Matic</div>
  <div class="secLink">
  	<a href="../">Home</a> &middot; <a href="./">Go to Ashland Version</a> &middot; <a href="http://orshakes.org">OSF site</a>
  </div>
</div>


<div style="margin:45px 3% 10px 3% ">
	
	<? if ($edit) echo "<form name=\"edit_row\" method=\"post\" action=\"nyc.php\">\n"; ?>
	<table border="0" width="94%" cellspacing="0">
	
	<!-- TABLE HEADERS -->
	<tr><td colspan="<?= count($weekends) + 2 ?>" style="text-align:left" class="tiny">Click on your name to change your odds of going for each weekend.</td></tr>
	<tr class="header">
		<td rowspan="2" valign="bottom">Goob</td>
		<td align="center" colspan="<?= count($weekends) ?>">Weekends (Thursdays)</td>
		<td rowspan="2" valign="bottom">Score</td>
	</tr><tr class="header">
		<? foreach ($weekends as $w) {
			// this will be the Thursdays that we are considering
			echo "<td>$w</td>";
		} 
		echo "\n";
		?>
	</tr>
	
	
	<!-- DATA/EDIT REGION -->
	<? 
	$rowcount = 0;
	foreach($goobsAr as $i => $goob) {
		$rowClass = ($rowcount%2) ? "even" : "odd";
		if ($goob["core"]) {
			$rowcount++;
	?>
	<tr class="<?=$rowClass?>">
		<td><? if ($i != $id) {?> <a href="./nyc.php?id=<?=$i?>"><b> <?}?><?=$goob["name"]?><? if ($i !== $id) {?></b></a><?}?></td>
		<? 
		$goobrates = explode($divSep,$ratesAr[$i]['ratings']);
		foreach ($weekends as $j => $w) {

			if ($i != $id) {
				$myRate = $goobrates[$j];
				$rateClass = array_search($myRate, $rateValues);
				
				if (!isset($weekSum[$j])) $weekSum[$j] = $myRate;
				else $weekSum[$j] += $myRate;
//				echo "<td class=\"$rateClass\">" , $myRate , "</td>";
				echo "<td style=\"background-color:" . getColor($myRate, 3) . "\">" , $rateLabels[$rateClass] , "</td>";
			}
			else {
			// edit mode for this row
			// # is score as recieved from the $weekends array
			echo "<td><select name=\"votes[]\">";
			foreach ($rateValues as $k => $rV) {
				if ($rV == $goobrates[$j]) $sel = " selected";
				else $sel = "";
				?>
				<option value="<?=$rV?>"<?=$sel?>><?= $rateLabels[$k] ?></option>
				<?
			}
			echo "</select></td>";
			}
		}
		
		if ($i != $id) {
			// sum the row
			$rowsum = array_sum($goobrates);
			echo "\n<td>$rowsum</td>\n";
		}
		else { ?>
		
			<td rowspan="2"><input type="submit" name="change" value="SUBMIT &raquo;"></td>
			</tr><tr>
			<td class="tiny"><b>add a message</b></td>
			<td colspan="<?=count($weekends)?>"><textarea name="goobmessage" style="width:100%; background-color:#ff9"></textarea></td>
		<? }
		?>
	</tr>
	
	<? }} ?>
	
	<!-- FOOT -->
	<tr class="foot">
		<td>TOTAL</td>
		<? 
		
		foreach ($weekends as $j => $w) {
			// this will be the Thursdays that we are considering
			$aColor = getColor($weekSum[$j]);
			echo "<td style=\"background-color:$aColor\">$weekSum[$j]</td>";
		} 
		echo "\n";
		?>
		<td>&nbsp;</td>
	</tr></table>
	<? if ($edit) { ?>
   		<input type="hidden" name="who" value="<?=$id?>">
		</form>
	<? } ?>

<? 
$mails = array();
foreach($goobsAr as $goob) {
	if ($goob['core']) {
		$mails[] = $goob['email'];
	}
}
$mail = implode(", ", $mails);
/*
$mails = array();
foreach($goobsAr as $goob) {
	if ($goob['core']) {
		$mails[] = $goob['email'];
	}
}
$mail = '';
foreach ($mails as $i => $m) {
	if ($i>0) {
		$sep = ($i==1) ? '?' : '&';
		$mail .= $sep . 'cc=';
	}
	$mail .= $m;
}
*/
?>

<p><a href="mailto:<?=$mail?>">Send an email to everyone...</a></p>
<p><a href="./">.</a></p>

</div>

</body>
</html>
