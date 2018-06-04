<?php
include("dbconnect.php");

$result=$database->query("SELECT * FROM codes;"); 

while($data=$result->fetch())
{
	$volume=$data['avgvolume'];
	$volume=str_replace(",","",$volume);
	
	if(strstr($volume,"M"))
	{
		$volume=str_replace(".","",$volume);
		$volume=str_replace("M","0000",$volume);
	}
	$volume=(float)$volume;
	
	$request = $database->prepare("	UPDATE codes 
											SET avgvolume= :avgvolume
											WHERE code= :code");
			
			try 
			{	
				$request->execute(array(
				'avgvolume' => $volume,
				'code' => $data['code']
				));
			}
			catch (Exception $exception) 
			{
				die('Erreur : ' . $exception->getMessage());
			}
}