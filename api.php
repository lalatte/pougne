<?php
include('dbconnect.php');

$date=date('Y-m-d',time()+600); //date du temps actuel + 10 min (stoppe l'enregistrement à 23h50)
$curl = curl_init("http://stocky.us-west-2.elasticbeanstalk.com/api?date=".$date);


curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, false);
$curl_scraped_page = curl_exec($curl);
curl_close($curl);

$result=json_decode($curl_scraped_page, true);

$i=0;


$stocklist=$result["stocks"];

if($result["globalBad"]=="")
{
	$globalbad=0;
}
if($result["globalBad"]==1)
{
	$globalbad=1;
}

if(count($stocklist)==0)
{echo "Aucune news validée";}

if(count($stocklist)!=0)
{	
	foreach ($stocklist as $stock)
	{	
		// echo $stock." - ";
		
		if(strstr($stock,"'")!=FALSE)
		{
			$stock=str_replace("'","''",$stock);
		}
		
		$result=$database->query("SELECT * FROM codes WHERE stock='".$stock."'");
		$data = $result->fetch();
		$stocklist[$i]=$data['code'];
		$i++;
	}
}


	// echo "Global Bad = ".$globalbad;






