<?php
include('dbconnect.php');
include('api.php');
include('apiechos.php');
include('apiboursier.php');
include('countfails.php');

ob_start();
echo "Start : ".date("Y-m-d H:i:s")."\n";

$echos=array();
foreach($listechos as $array)
{
	$echos[]=$array["stock"];
}

$boursier=array();
foreach($listboursier as $array)
{
	$boursier[]=$array["stock"];
}

$stocklist=array_unique(array_merge($stocklist,$echos,$boursier));

?><p>Stock list :</p><p><?php
print_r($stocklist);
?></p><?php

$datadegiro=array_fill_keys($stocklist,"");

$time=time()-1;
$timetotal=time();

if(date("H\hi")=="08h55")
{
	fopen("curllog.html","w");
}

if(date("H\hi")=="09h00")
{
	foreach ($stocklist as $stock)
	{
		fopen("./degiro/".$stock.".txt","w");
	}
	
	echo "<p>Files erased.</p>";
}

if(time()>=strtotime("Today 08:59") && time()<=strtotime("Today 05:30 pm") && date("D")!="Sat" && date("D")!="Sun")
{	

	$LastTime=array();
	
	?><p>Last known values :</p><?php
	
	foreach ($stocklist as $stock)
	{
		$file="./degiro/".$stock.".txt";
		$current = file_get_contents($file);
		
		$data=explode("\n",$current);
		$data2=$data[count($data)-2]; //dernière ligne
		$data3=explode(" ",$data2);
		$data4=$data3[1];
		$data5=explode("=",$data4);
		$data6=$data5[1];
		$LastTime[$stock]=$data6;
		$data7=$data3[2];
		$data8=explode("=",$data7);
		$LastPrice[$stock]=$data8[1];
		
		echo $stock." : LastTime= ".$LastTime[$stock]." LastPrice=".$LastPrice[$stock]."</br>";
	}
	
	?><p>Saved values :</p><?php
	
	while(time()<$timetotal+58)
	{
		if(time()>=($time+1))
		{
			$time=time();
			foreach ($stocklist as $stock)
				{
					if(countfails($stock)<3)
					{
						$curl = curl_init('http://stocky.us-west-2.elasticbeanstalk.com/dg?type=price&stock='.$stock); //lecture du prix sur degiro
						
						curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
						curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, false);
						curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0); 
						curl_setopt($ch, CURLOPT_TIMEOUT, 300); //timeout in seconds
						$html = curl_exec($curl);
						curl_close($curl);
						
						$degiro=json_decode($html,true);
						
						if($degiro['LastTime']!=$LastTime[$stock] && $degiro['LastPrice']!=$LastPrice[$stock])
						{
							$datadegiro[$stock]=date("H:i:s")." LastTime=".$degiro['LastTime']." LastPrice=".$degiro['LastPrice']."\n";
							echo date("H:i:s")." ".$stock.": LastTime=".$degiro['LastTime']." LastPrice=".$degiro['LastPrice']."</br>";
							$LastTime[$stock]=$degiro['LastTime'];
							$LastPrice[$stock]=$degiro['LastPrice'];
							$file="./degiro/".$stock.".txt";
							$current = file_get_contents($file);
							$current.=$datadegiro[$stock];
							file_put_contents($file, $current);
						}
					}
				}
		}
		usleep(500000);
	}
}

$data = ob_get_clean();

$file="curllog.html";
$current = file_get_contents($file);
$current=$data.$current;
$current="<h3>".date("Y-m-d H:i:s")." datadegiro.php</h3>".$current;
file_put_contents($file, $current);

echo $data;

