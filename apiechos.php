<?php
include('dbconnect.php');

$date=date('Y-m-d',time()+600); //date du temps actuel + 10 min (stoppe l'enregistrement à 23h50)
$curl = curl_init("http://echos.us-west-2.elasticbeanstalk.com/api?date=".$date);


curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, false);
$curl_scraped_page = curl_exec($curl);
curl_close($curl);

$result=json_decode($curl_scraped_page, true);

$listechos=$result["stocks"];

if(count($listechos)==0)
{	
	$listechos="";
}

if(count($listechos)!=0)
{	
	$i=0;
	foreach ($listechos as $key=>$value)
	{	
		$result=$database->query("SELECT * FROM codes WHERE stock='".$value['stock']."'");
		$data = $result->fetch();
		$listechos[$i]=array("stock"=>$data['code'],"variation"=>round($value['variation'],2),"analyst"=>$value['analyst']);
		$i++;
	}
}
