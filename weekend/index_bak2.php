<?php
include '../ashData.php';
$goobsAr = fileToArray("../goobs.txt");
$datafile = "weekrates.txt";
$ratesAr = fileToArray($datafile);

$edit = 1;
if (!isset($id)) {
	$id = -1;
	$edit = 0;
}


$weekends = listOfWeeks(5, 15, 9, 18);
$rateValues = array(-1,0,1);


if (isset($change)) include 'process.php';



//------------------------------ DATE STUFF ------------------------------

# Given a starting date and and ending date, return a list of month/day
# strings corresponding to each week between the dates, inclusive.
function listOfWeeks($start_month, $start_day, $end_month, $end_day) {
  $return_value = array();

  while (dateBefore($start_month, $start_day, $end_month, $end_day)) {
    array_push($return_value, "$start_month/$start_day");
    nextWeek(&$start_month, &$start_day);
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
function nextWeek($month, $day) {

  # Store the number of days in each month.
  $monthLengths = array(31, 29, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);

  $day += 7;
  if ($day > $monthLengths[$month]) {
    $day -= $monthLengths[$month];
    $month++;
  }
}

//--- end DATE STUFF


function getColor ($r) {
	$numGoobs = 8; // this is derivable, but I don't feel like dealing with it right now...
	$base = '7';
	$num = base_convert (($numGoobs - $r -1), 10, 16);
	if ($r > 0) $result = '#' . $num . $base . $num;
	else $result = '#' . $num . $base . $base;
	return $result;
}




?>

<html>
<head>
<title>Ashland -- Weekend-O-Matic</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="../ashland.css" type="text/css">
<link rel="stylesheet" href="planning.css" type="text/css">


</head>

<body bgcolor="#FFFFFF" text="#000000">

<div class="titleBox">
  <div class="title">Ashland Weekend-O-Matic</div>
  <div class="secLink">
  	<a href="../">Home</a> &middot; <a href="../show/">ShowChooser</a> &middot; <a href="http://orshakes.org">OSF site</a>
  </div>
</div>


<div style="margin:45px 3% 10px 3% ">
	
	<? if ($edit) echo "<form name=\"edit_row\" method=\"post\" action=\"index.php\">\n"; ?>
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
		<td><? if ($i != $id) {?> <a href="./index.php?id=<?=$i?>"><b> <?}?><?=$goob["name"]?><? if ($i !== $id) {?></b></a><?}?></td>
		<? 
		$goobrates = explode($divSep,$ratesAr[$i]['ratings']);
		foreach ($weekends as $j => $w) {

			if ($i != $id) {
				$myRate = $goobrates[$j];
				$rateClass = array_search($myRate, $rateValues);
				
				if (!isset($weekSum[$j])) $weekSum[$j] = $myRate;
				else $weekSum[$j] += $myRate;
				echo "<td class=\"$rateClass\">" , $myRate , "</td>";
			}
			else {
			// edit mode for this row
			// # is score as recieved from the $weekends array
			echo "<td><select name=\"votes[]\">";
			foreach ($rateValues as $rV) {
				if ($rV == $goobrates[$j]) $sel = " selected";
				else $sel = "";
				?>
				<option value="<?=$rV?>"<?=$sel?>><?=$rV?></option>
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
		else {
			echo "\n<td><input type=\"submit\" name=\"change\" value=\"SUBMIT &raquo;\"></td>\n";
		}
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
$mail = "";
foreach($goobsAr as $goob) {
	if ($goob['core']) {
		$mail .= $goob['email'];
		$mail .= ';';
	}
}
?>

<p><a href="mailto:<?=$mail?>">Send an email to everyone...</a></p>
<p><a href="./">.</a></p>

</div>

</body>
</html>
