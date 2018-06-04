<?php
include('dbconnect.php');
include('sell.php');
include('simple_html_dom.php');
include("countorders.php");
include("maxdegiro.php");
include("dategoogle.php");

ob_start();
?><p><?php
echo "Start : ".date("Y-m-d H:i:s")."\n";
?></p><?php

$time=time()-1;
$timetotal=time();

$LastTime=array();

while(time()<$timetotal+58) //durée totale 1 min
{
	if(time()>=($time+1)) // vérification toutes les secondes
		{
			$time=time();
			
			$portfolio=array();
			$request=$database->query("SELECT * FROM portfolio"); // lecture de la DB
			while($data=$request->fetch())
			{
				$portfolio[$data['stock']]=$data['quantity'];
			}
			
			foreach($portfolio as $stock=>$quantity)
			{
				$request=$database->query("SELECT * FROM codes WHERE code='$stock'"); //récupération de la catégorie
				$data=$request->fetch();
				$volume=$data['volume'];
				
				$curl = curl_init('http://stocky.us-west-2.elasticbeanstalk.com/dg?type=price&stock='.$stock); //lecture du prix sur degiro
				
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, false);
				$html = curl_exec($curl);
				curl_close($curl);
				
				$degiro=json_decode($html,true);
				
				if(is_numeric($degiro['LastPrice']) && Date("H",strtotime($degiro['LastTime']))==Date("H")) //test validité prix et last time
				{
					$maxdegiro=maxdegiro($stock,$volume);
										
					if(!is_numeric($maxdegiro))
					{
						$maxdegiro=$degiro['LastPrice']; //initialisation max pour la première minute (9h-9h01)
					}
					
					if(is_numeric($maxdegiro))
					{
						$max=$maxdegiro;
					}
					
					if(isset($max) && countorders($stock)<=3 && $degiro['LastPrice']<=$max*0.99) //si le prix est en dessous du max -1%, et moins de 3 ventes déjà envoyées, vente déclenchée
					{
						$curl = curl_init('http://pougne.org/log.php?type=sell&stock='.$stock.'&size='.$quantity.'&algo=degiro&max='.$max.'&LastPrice='.$degiro['LastPrice']); //enregistrement dans le log

						curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
						curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, false);
						$curl_scraped_page = curl_exec($curl);
						curl_close($curl);
												
						$request2=$database->query("DELETE FROM portfolio WHERE stock='$stock'"); // suppression du stock de la DB en attendant success
						
						$curl = curl_init('http://stocky.us-west-2.elasticbeanstalk.com/dg?type=sell&stock='.$stock.'&size='.$quantity); //envoi vers API degiro

						curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
						curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, false);
						$curl_scraped_page = curl_exec($curl);
						curl_close($curl);
						
						$html = new simple_html_dom();
						$html->load($curl_scraped_page);
						
						if($html=="success")	//si ordre de vente a fonctionné, enregistrement dans le portfolio
						{	
							unset($portfolio[$stock]);
							echo $stock. " sold.</br>";
						}
						
						if($html!="success")	//si la vente échoue, réinsertion du stock dans la DB
						{	
							$portfolio[$stock]=$quantity;
							$request3=$database->prepare("INSERT INTO portfolio (stock, quantity) VALUES (:stock, :quantity);");
							echo "Selling ".$stock." failed.";
							try 
							{	
								$request3->execute(array(
								'stock' => $stock,
								'quantity' => $quantity	
								));
							}
							catch (Exception $exception) 
							{
								die('Erreur : ' . $exception->getMessage());
							}
						}
						
					}
					
					if($degiro['LastPrice']!=$LastPrice[$stock])
					{
						echo date("H:i:s")." ".$stock." LastPrice=".$degiro['LastPrice']." max=".$max."</br>";
						$LastPrice[$stock]=$degiro['LastPrice'];
					}
					
				}
			}
		}
	usleep(500000);
}
?><p>Portfolio :</p><?php
print_r($portfolio);


$data = ob_get_clean();
$file="curllog.html";
$current = file_get_contents($file);
$current=$data.$current;
$current="<h3>".date("Y-m-d H:i:s")." selldegiro.php</h3>".$current;
file_put_contents($file, $current);

echo $data;
		