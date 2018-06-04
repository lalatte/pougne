<?php

ob_start();
?><p><?php
echo "Start : ".date("Y-m-d H:i:s")."\n";
?></p><?php


$time=time()-1;
$timetotal=time();

while(time()<$timetotal+90) //durée totale 1 min
{
	if(time()>=($time+1)) // vérification toutes les secondes
		{
			$time=time();
		}
	usleep(100000);
}

?><p><?php
echo "End : ".date("Y-m-d H:i:s")."\n";
?></p><?php

$data = ob_get_clean();
$file="curllog.html";
$current = file_get_contents($file);
$current=$data.$current;
$current="<h3>".date("Y-m-d H:i:s")." test3.php</h3>".$current;
file_put_contents($file, $current);