<?php
include("dbconnect.php");

$result=$database->query("SELECT * FROM recommandations;"); 

while($data=$result->fetch())
{
	$ID=$data['ID'];
	$stock=$data['stock'];
	$result2=$database->query("SELECT * FROM codes WHERE code='$stock';"); 
	$data2=$result2->fetch();
	$volume=$data2['volume'];
	
	$request = $database->prepare("	UPDATE recommandations 
											SET volume= :volume
											WHERE ID= :ID");
			
			try 
			{	
				$request->execute(array(
				'volume' => $volume,
				'ID' => $ID
				));
			}
			catch (Exception $exception) 
			{
				die('Erreur : ' . $exception->getMessage());
			}
}