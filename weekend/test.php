<?php

	$output = 'so clearly this works';
	$testfile = 'test.txt';

	echo "writing '$output' to '$testfile'<br>";
	
	$f = fopen($testfile, "w") or die("cannot find file $filename"); 
	fwrite($f, $output,100000);
	fclose($f);

	$file = file($testfile);
	echo "here are the contents of '$testfile': <br>";
	print_r($file);

?>