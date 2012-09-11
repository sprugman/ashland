<?php
include 'ashData.php';
$yearsAr = fileToArray("years.txt");
$goobsAr = fileToArray("goobs.txt");
$showsAr = fileToArray("shows.txt");

function out ($n) {
	echo $n;
}

if (!isset($goob)) $goob = 5;

?>

<html>
<head>
<title>Ashland -- Editing <?=$goobsAr[$goob]["name"]?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="ashland.css" type="text/css">


</head>

<body bgcolor="#FFFFFF" text="#000000" class="edit-mode">

<div class="titleBox">
  <div class="title">Editing <?=$goobsAr[$goob]["name"]?></div>
  <div class="secLink">
    <?php 
    $len = count($yearsAr);
    for($i=0; $i<$len; $i++) {
    	$yr = $yearsAr[$i]["year"];
    	$txt = '<a href="year.php?year=' . $i . '">' . $yr . '</a>';
    	if ($i == $len-1) $tail = '';
    	else $tail = " &middot\n    ";
    	echo $txt,$tail;
    }
    ?>
  </div>
  <div class="secLink">
    <?php 
    $len = count($goobsAr);
    for($i=0; $i<$len; $i++) {
    	$yr = $goobsAr[$i]["name"];
    	if ($i == $goob) $txt = '<b>' . $yr . '</b>';
    	else $txt = '<a href="goob.php?goob=' . $i . '">' . $yr . '</a>';
    	if ($i == $len-1) $tail = '';
    	else $tail = " &middot\n    ";
    	echo $txt,$tail;
    }
    ?>
  </div>
</div>


<div class="content">
	<form name="edit_goob" method="post" action="goob.php">
	<h2>Years Attended</h2>
	<p>
	<?php
		// check box for each year	
		// for each year
		// get the goobs field
		// if I'm in it, make that year checked
		// by default.
		
		$myYears = array();
		foreach ($yearsAr as $i => $aYear) {
			$chk = "";
			$goobyear = explode($divSep,$aYear["goobs"]);
			if (in_array($goob,$goobyear)) {
				$myYears[$i] = $aYear["year"];
				$chk = "checked";
			}
			//echo '<input type="checkbox" name="yr', $aYear["year"], '[]" ', $chk, '>', $aYear["year"];
			
		}
		
		
	
		// output $myYears as links separated by commas.
		foreach ($myYears as $i => $yearName) { 
			$str[] = "<input type=\"checkbox\"" . "<a href=\"year.php?year=$i\">$yearName</a>";
		} 
		//echo @implode(", ",$str);
	?>
	</p>
    <h2>Shows Seen</h2>
		<?php
			$myShows = array();
			$sum = 0;
			foreach ($showsAr as $i => $aShow) {
				$goobrate = explode($divSep,$aShow["ratings"]);
				$goobcomm = explode($divSep,$aShow["comments"]);
				$myRate = $goobrate[$goob];
				$myComm = $goobcomm[$goob];
				//echo $myRate,"<br>\n";
				if (!($myRate == "-1" || $myRate == "")) {
					$sum += $myRate;
					$myShows[$i]["title"] = $aShow["title"];
					$myShows[$i]["rating"] = $myRate;
					$myShows[$i]["comment"] = $myComm;
				}
			}
			echo "<p>Average Rating: ", @round($sum/count($myShows),1), "</p>";
			$tab = '<table cellspacing="0" cellpadding="0" class="smaller">';
			foreach ($myShows as $i => $aShow) { 
				$s[] = "<tr><td class=\"rule\" valign=\"top\" nowrap><a href=\"show.php?show=$i\">" . $aShow["title"] . '</a></td><td class="rule" valign="top" align="right">' . $aShow["rating"] . '</td><td class="rule" valign="top">' . $aShow["comment"] . '&nbsp;</td></tr>';
			}
			echo $tab,@implode("\n",$s),'</table>';
		?>
	</form>
</div>
<h1 class="here">Editing <?=$goobsAr[$goob]["name"]?></h1>


</body>
</html>
