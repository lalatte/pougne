<?php
include("dbconnect.php");
include("getprice.php");

$request=$database->query("SELECT * FROM news ORDER BY ID");

while($data=$request->fetch())
{
	$ID=$data['ID'];
	$lines=$data['data'];
	$date=date("d",$data['date']);
	$time=date("H",$data['date']);
	echo "time= ".$time."  ";
	if($time<6)
	{
		$date--;
	}
	$price0903=getprice($date,3,$lines);
	if($price0903=="Price not found")
	{
		$price0903=0;
	}
	

	if($data['open']!=0 && $price0903!=0)
	{
		$momentum0903=($price0903/$data['open'])-1;
		$momentum0903=round($momentum0903*100,2);
		$gain0903=($data['price']/$price0903)-1;
		$gain0903=round($gain0903*100,2);
	}
	
	if(isset($momentum0903))
	{
		echo " date= ".$date." price0903= ".$price0903." momentum0903= ".$momentum0903."</p>";
		
		$request2 = $database->prepare("	UPDATE news 
												SET price0903= :price0903, momentum0903= :momentum0903, gain0903= :gain0903
												WHERE ID= :ID");
				
				try 
				{	
					$request2->execute(array(
					'price0903' => $price0903,
					'momentum0903'=> $momentum0903,
					'gain0903'=> $gain0903,
					'ID' => $ID
					));
				}
				catch (Exception $exception) 
				{
					die('Erreur : ' . $exception->getMessage());
				}
	}
}