<?php
include 'ashData.php';
$yearsAr = fileToArray("years.txt");
$goobsAr = fileToArray("goobs.txt");
$showsAr = fileToArray("shows.txt");

if ($_GET) $show = $_GET['show'];
else if ($_POST) $show = $_POST['show'];

if (isset($_POST['submitShow'])) include 'pro_show.php';
if (!isset($show)) $show = 148;

$tit = "Ashland &#151; " . $showsAr[$show]['title'];

?>

<html>
<head>
<title><?=$tit?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="ashland.css" type="text/css">


</head>

<body bgcolor="#FFFFFF" text="#000000">

<?php include 'nav.php'?>



    
<div class="content">
	<!-- title, year, author, director, theatre -->
	<h1><span class="smaller"><?=$showsAr[$show]["title"]?></span></h1>
	<p class="smaller">
		<?=$yearsAr[$showsAr[$show]["year"]]["year"]?><br>
		by <?=$showsAr[$show]["author"]?><br>
		directed by <?=$showsAr[$show]["director"]?><br>
		in the <?=$showsAr[$show]["theatre"]?>
	</p>
	
	
	
	
	<!-- RATINGS & COMMENTS -->
	<h2>Ratings &amp; Comments <span class="tiny"><a href="edit_show.php?show=<?=$show?>">edit me</a></span></h2>
		<?php $rateAr = array_mask(explode($divSep,$showsAr[$show]["ratings"]),"is_neg"); ?>

		<table cellspacing="0" cellpadding="0">
		<?php
	    	$commAr = array_mask(explode($divSep,$showsAr[$show]["comments"]),"is_neg");
	    	foreach ($rateAr as $i => $rate) {
	    		$comm = $commAr[$i];
	    		$myComm = ($comm) ?  ($myComm = "$comm") : ('');
	    		echo "<tr><td valign=\"top\"><a href=\"goob.php?goob=$i\">" , $goobsAr[$i]["name"] , "</a></td><td>&nbsp;&nbsp;</td><td valign=\"top\">" , $rate , "</td><td>&nbsp;&nbsp;</td><td valign=\"top\">" , un_htmlentities($myComm), "</td></tr>\n";
	    	}
		?>
		</table>
		<hr size=1>
		Average: <?=round(array_mean($rateAr),1)?>
		
		
	<!-- CAST	
	<h2>Cast?</h2>
		Anyone want to enter this data? -->
</div>
<div class="here"><span class="tiny">
    <?php    
	// get the showIDs for all the shows we've seen and put them in $ours[]
	foreach ($yearsAr as $yr) {
		foreach (explode($divSep,$yr["shows"]) as $aShow) {
			if ($aShow) $ours[] = $aShow; //echo $showsAr[$aShow]["title"],"<br>";
		}
	}
	// reverse it (newest on top)
	$ours = array_reverse($ours);
    $len = count($ours);
    $refYear = 0;
    for($i=0; $i<$len; $i++) {
    	$id = $ours[$i];
    	$t = $showsAr[$id]["title"];
    	$yr = $showsAr[$id]["year"];
    	if ($yr != $refYear) {
    		$refYear = $yr;
    		$yLabel = $yearsAr[$yr]["year"];
    		echo '<p class="showyear">',$yLabel,"</p>";
    	} 

    	if ($id == $show) $txt = "<p style=\"color:black;font-weight:bold\" class=\"showlist\">$t</p>";
    	else $txt = '<p class="showlist"><a href="show.php?show=' . $id . '">' . $t . '</a></p>';
    	if ($i == $len-1) $tail = '';
    	else $tail = "\n";
    	echo $txt,$tail;
    }
    echo '</span>';
    ?>&nbsp;</div>

</body>
</html>
