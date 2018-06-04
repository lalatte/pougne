<?php
include("dbconnect.php");
include("simple_html_dom.php");
$result=$database->query("SELECT * FROM codes;"); 

while($data=$result->fetch())
{
	$stock=$data['code'];
	
	$curl = curl_init('https://finance.google.com/finance?q=EPA%3A'.$stock);

	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, false);

	$curl_scraped_page = curl_exec($curl);

	curl_close($curl);

	$html = new simple_html_dom();
	$html->load($curl_scraped_page);


	$snapdata=$html->find('.snap-data',0);

	$data=explode("td",$snapdata);

	$data2=$data[15];
	$data3=explode("/",$data2);
	$data4=$data3[1];

	$avgvolume=substr($data4,0,-2);
	echo $stock." : Volume= ".$avgvolume;
	
	$request = $database->prepare("	UPDATE codes 
											SET avgvolume= :avgvolume
											WHERE code= :code");
			
			try 
			{	
				$request->execute(array(
				'avgvolume' => $avgvolume,
				'code' => $stock
				));
			}
			catch (Exception $exception) 
			{
				die('Erreur : ' . $exception->getMessage());
			}
}