<?php

	$ratesAr[$who]["ratings"] = implode($divSep,$votes);

	arrayToFile ($datafile,$ratesAr);
?>