<?php
include 'ashData.php';
$years = fileToArray("years.txt");
$goobs = fileToArray("goobs.txt");
$shows = fileToArray("shows.txt");
$year = $_GET['year'];

function out ($n) {
	echo $n;
}

if (!isset($year)) $year = count($years)-1;

?>

<html>
<head>
<title>Ashland <?=$year?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="ashland.css" type="text/css">


</head>

<body bgcolor="#FFFFFF" text="#000000" class="edit-mode">

<div class="titleBox">
  <div class="title">Editing <?=$years[$year]["year"]?></div>
  <div class="secLink">edit: 
    <?php 
    $len = count($years);
    for($i=0; $i<$len; $i++) {
    	$yr = $years[$i]["year"];
    	if ($i == $year) $txt = '<b>' . $yr . '</b>';
    	else $txt = '<a href="edit_year.php?year=' . $i . '">' . $yr . '</a>';
    	if ($i == $len-1) $tail = '';
    	else $tail = " &middot\n    ";
    	echo $txt,$tail;
    }
    ?>
  </div>
</div>





<!--  CONTENT -->
<div class="content">
  
  <form name="edit_year" method="post" action="year.php">
	<h2>Who Came <span class="tiny">Check the goobs who went.</span></h2>
		<?php
    	$yeargoobs = explode($divSep,$years[$year]["goobs"]);
        $len = count($goobs);
        for($i=0; $i<$len; $i++) {
        	$name = $goobs[$i]["name"];
        	(in_array((string)$i,$yeargoobs)) ? $chk=" checked" : $chk="";
        	$txt = "<input type=\"checkbox\" name=\"goobs[]\" value=\"$i\"$chk>$name";
        	$tail = ($i == $len-1) ? "" : "&nbsp;&nbsp;&nbsp;&nbsp;";
        	echo $txt,$tail;
	    }
		?>
		
	<h2>Highlights <span class="tiny">Edit the trip highlights.</span></h2>
		<textarea name="highlights" wrap="VIRTUAL" rows="5" style="width:100%; height:60px;"
			><?= unCleanText($years[$year]["highlights"]) ?></textarea>
    	
    <h2>Shows <span class="tiny">Check the shows that we saw.</span></h2>
		<?php
			$yearshows = crop($shows,"year",$year);
			$goobshows = explode($divSep,$years[$year]["shows"]);
			$len = count($yearshows);
            foreach($yearshows as $i=> $ys) {
            	(in_array($i,$goobshows)) ? $chk=" checked" : $chk="";
            	$txt = '<input type="checkbox" name="shows[]" value="' . $i . "\"$chk>" . $ys["title"];
            	if ($i == $len-1) $tail = '';
            	else $tail = "<br>\n";
            	echo $txt,$tail;
            }
		?>
    <h2>Cost</h2>
	<input type="textfield" name="cost" value="<?=$years[$year]["cost"]?>">
    			
	<p>	
	<input type="submit" name="submitYear" value="Submit">
	<input type="reset" name="reset" value="Reset">
    <input type="submit" name="cancel" value="Cancel">
    <input type="hidden" name="year" value="<?=$year?>">
    </p>
  </form>
</div>
<h1 class="here"></h1>


</body>
</html>
