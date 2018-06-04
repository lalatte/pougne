<?php	
$curl = curl_init('http://stocky.us-west-2.elasticbeanstalk.com/dg?type=cash');
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, false);
$cash= curl_exec($curl);
$cash=round($cash,2);
curl_close($curl);

$curl = curl_init('http://pougne.org/log.php?cash='.$cash);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, false);
curl_exec($curl);
curl_close($curl);