<?php
	$s = '15037627386232450';
	$tmp='';$c=0;
	for ($i=strlen($s)-1; $i>=0; $i--){
		$c++;
		$tmp = $s[$i].$tmp;
		if ($c%3==0 & $i>0)
			$tmp = '.'.$tmp;
		
	}
	echo $tmp;
?>