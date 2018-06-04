<?php 

include("getprice.php");
include("dbconnect.php");
include("sell0930.php");

$result=$database->query("SELECT * FROM news WHERE avgvolume>1000000 AND avgvolume<25000000 ORDER BY ID DESC");

$totalgain=0;

while($data=$result->fetch())
{
	echo "<p>";
	echo $data['stock']." ";
		
	if(date("H",$data['date'])<05)
	{	
		$day=date('d',$data['date'])-1;
	}
	else
	{
		$day=date('d',$data['date']);
	}
	
	$price0930=getprice($day,30,$data['data']);
	echo "price 0930=".$price0930." ";

	$sellprice=sell0930($data['data'],1,10);

	print_r($sellprice);
	echo "</p>";
	
	if(is_numeric($sellprice['sellprice'])&& is_numeric($price0930))
	{
		$gain=100*(($sellprice['sellprice']/$price0930)-1);
		echo " gain=".round($gain,2);
	
		$totalgain=$totalgain+$gain;
	}
	
	
}

echo round($totalgain,2);

