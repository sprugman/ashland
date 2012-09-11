<?php
include 'ashData.php';
$yearsAr = fileToArray("years.txt");
$goobsAr = fileToArray("goobs.txt");
$showsAr = fileToArray("shows.txt");

function out ($n) {
	echo $n;
}

$show = $_GET['show'];

if (!isset($show)) $show = 116;

?>

<html>
<head>
<title>Ashland -- <?=$showsAr[$show]["title"]?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="ashland.css" type="text/css">


</head>

<body bgcolor="#FFFFFF" text="#000000" class="edit-mode">

<div class="titleBox">
  <div class="title">Ashland Trips</div>
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
    	$txt = '<a href="goob.php?goob=' . $i . '">' . $yr . '</a>';
    	if ($i == $len-1) $tail = '';
    	else $tail = " &middot\n    ";
    	echo $txt,$tail;
    }
    ?>
  </div>
</div>



<div class="content">
	<!-- title, year, author, director, theatre -->
	<h1><span class="smaller">Editing <?=$showsAr[$show]["title"]?></span></h1>
	<p class="smaller">
		<?=$yearsAr[$showsAr[$show]["year"]]["year"]?><br>
		by <?=$showsAr[$show]["author"]?><br>
		directed by <?=$showsAr[$show]["director"]?><br>
		in the <?=$showsAr[$show]["theatre"]?>
	</p>
	
	<h2>Ratings and Comments<br>
	<span class="tiny">(Choose "-1" if you didn't see the show.)</span></h2>
	
	
	
	
	<form name="edit_show" method="post" action="show.php">
		<p>
		<?php
			$rateAr = explode($divSep,$showsAr[$show]["ratings"]);
			$commAr = explode($divSep,$showsAr[$show]["comments"]);
			
			function WriteOpts($id) {
				global $rateAr;
				$result = "";
				$myRate = $rateAr[$id];
				$sel = ($myRate == "-1" || $myRate == "") ? -1 : $myRate;
				for ($i=-1;$i<=10;$i++){
					$selTxt = ($i == $sel) ? ' selected' : '';
					$result .= "<option$selTxt>$i</option>";
				}
				return $result;
			}
			
			$yearID = $showsAr[$show]["year"]; 
			$yeargoobs = explode($divSep,$yearsAr[$yearID]["goobs"]);
			$len = count($goobsAr);
			
			for ($i=0; $i<$len; $i++){
				if (!in_array($i,$yeargoobs)) { 
		?>
        <input type="hidden" name="rates[<?=$i?>]" value="-1">
        <input type="hidden" name="comments[<?=$i?>]" value="">
		
				<?php } else { ?>				
		
		<?=$goobsAr[$i]["name"]?> 
		<select name="rates[<?=$i?>]"><?=WriteOpts($i)?></select> 
		<textarea class="editShow" name="comments[<?=$i?>]"><?=str_replace('"','&quot;',unCleanText($commAr[$i]))?></textarea><br>
		
			<?php }} ?>
		
		</p>
		<input type="submit" name="submitShow" value="Submit">
		<input type="reset" name="reset" value="Reset">
        <input type="submit" name="cancel" value="Cancel">
        <input type="hidden" name="show" value="<?=$show?>">
	</form>
	


	<!-- CAST 	
	<h2>Cast?</h2>
		Anyone want to enter this data?-->
</div>
<div class="here"><span class="tiny">edit<br>
    <?php    
	// get the showIDs for all the shows we've seen and put them in $ours[]
	foreach ($yearsAr as $yr) {
		foreach (explode($divSep,$yr["shows"]) as $aShow) {
			if ($aShow) $ours[] = $aShow; //echo $showsAr[$aShow]["title"],"<br>";
		}
	}
	$ours = array_reverse($ours);
    $len = count($ours);
    for($i=0; $i<$len; $i++) {
    	$id = $ours[$i];
    	$t = $showsAr[$id]["title"];
    	if ($id == $show) $txt = "<b style=\"color:black\">$t</b>";
    	else $txt = '<a href="edit_show.php?show=' . $id . '">' . $t . '</a>';
    	if ($i == $len-1) $tail = '';
    	else $tail = "<br>\n";
    	echo $txt,$tail;
    }
    echo '</span>';
    ?></div>
    

</body>
</html>


