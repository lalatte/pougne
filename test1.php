<?php

$X=1;
$Xfactor=3;

for($i=0;$i<510;$i++)
{
	$trigger=$X*(1-(($Xfactor-1)/$Xfactor)*($i/510));
	echo "i=".$i." trigger=".$trigger."</br>";
	
}