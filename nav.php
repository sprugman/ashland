<div class="titleBox">
  <div class="title"><?=$tit?></div>
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
