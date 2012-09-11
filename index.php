<?php
include 'ashData.php';
$yearsAr = fileToArray("years.txt");
$goobsAr = fileToArray("goobs.txt");
$showsAr = fileToArray("shows.txt");

if (!isset($year)) $year = count($yearsAr)-1;

if (isset($submitYear)) include 'pro_year.php';

?>

<html>
<head>
<title>Ashland -- <?=$yearsAr[$year]["year"]?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="ashland.css" type="text/css">


</head>

<body bgcolor="#FFFFFF" text="#000000">

<div class="titleBox">
  <div class="title">Ashland Trips</div>
  <div class="secLink">
    <?php 
    $len = count($yearsAr);
    for($i=0; $i<$len; $i++) {
    	$yr = $yearsAr[$i]["year"];
    	if ($i == $year) $txt = '<b>' . $yr . '</b>';
    	else $txt = '<a href="year.php?year=' . $i . '">' . $yr . '</a>';
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
  <div class="secLink"><a href="weekend/">Weekend-O-Matic</a></div>
  
</div>


<div class="content">
	<h2>Who Came</h2>
		<?php
    	$yeargoobs = explode($divSep,$yearsAr[$year]["goobs"]);
        $len = count($yeargoobs);
        for($i=0; $i<$len; $i++) {
        	$yr = $goobsAr[$yeargoobs[$i]]["name"];
        	$txt = '<a href="goob.php?goob=' . $yeargoobs[$i] . '">' . $yr . '</a>';
        	if ($i == $len-1) $tail = '';
        	else $tail = " &middot\n";
        	echo $txt,$tail;
	    }
		?>
	<h2>Highlights <!--span class="tiny"><a href="adf">edit</a></span--></h2>
    	<?=$yearsAr[$year]["highlights"]?>
    <h2>Shows</h2>
		<?php
    	$yearshows = explode($divSep,$yearsAr[$year]["shows"]);
    	$year_sum = 0;
        $len = count($yearshows);
        for($i=0; $i<$len; $i++) {
        	$id = $yearshows[$i];
        	$yr = $showsAr[$id]["title"];
        	$rateAr = array_mask(explode($divSep,$showsAr[$id]["ratings"]),"is_neg");
        	$avg = round(array_mean($rateAr),1);
        	$year_sum += $avg;
        	$txt = '<a href="show.php?show=' . $id . '">' . $yr . '</a> <span class="smaller">(' . $avg . ')</span>';
        	if ($i == $len-1) $tail = '';
        	else $tail = " <br>\n";
        	echo $txt,$tail;
	    }
	    $year_avg = round($year_sum/$len,1)
		?>
		<p>Average Rating Overall: <b><?=$year_avg?></b></p>
</div>
<h1 class="here"><?=$yearsAr[$year]["year"]?><br><span class="tiny"><a href="edit_year.php?year=<?=$year?>">edit me</a></span></h1>

</body>
</html>
