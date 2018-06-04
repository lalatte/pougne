<?php

include('api.php');
include('simple_html_dom.php');
include('sell.php');
include('buy.php');

ob_start();
echo "Start : ".date("Y-m-d H:i:s")."\n";

$_SESSION['logic']=1;


$time=date("H:i",time());


/*-----LISTE STOCKS ET CATEGORIES----*/

$orderedstocks1025=array();
$orderedstocks2585=array();

if(isset($stocklist))
{
	foreach ($stocklist as $stock)
	{	
		$request=$database->query("SELECT * FROM codes WHERE code='$stock'");
		$data=$request->fetch();
		$volume=$data['volume'];
		
		$request=$database->query("SELECT * FROM portfolio WHERE stock='$stock'");
		$data=$request->fetch();

		if(count($data)<=1) /*si l'action n'est pas dans le portfolio*/
		{	
			/*Récupération du dernier cours trouvé*/
			$curl = curl_init('https://finance.google.com/finance/getprices?q='.$stock.'&x=EPA&i=60&p=11d&f=d,c,h,l,o,v');
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, false);
			$curl_scraped_page = curl_exec($curl);
			curl_close($curl);
			
			$html = new simple_html_dom();
			$html->load($curl_scraped_page);
			$html2=explode(' ',$html);
			
			$lastline=$html2[sizeof($html2)-2];
			
			if(sizeof(explode(',',$lastline))==6) //s'il y a des données valables
			{
				/*calcul de la quantité d'actions à acheter*/
				$price=explode(',',$lastline)[1];
				
				if($volume>=10000000 && $volume<25000000)
				{
					$orderedstocks2585[$stock]=$price;  //enregistrement actions à acheter
				}
				if($volume>=25000000 && $volume<85000000)
				{
					$orderedstocks2585[$stock]=$price;  //enregistrement actions à acheter
				}
			}
			else
			{
				$price="Price not found";
			}
		}
	}	
	
	/*$stocknumber=count($orderedstocks1025)+count($orderedstocks2585);*/
	$stocknumber=count($orderedstocks2585);
}

echo "<p>Stocks 10-25 M</p>";
print_r($orderedstocks1025);
echo "<p>Stocks 25-85 M</p>";
print_r($orderedstocks2585);
	
/*-------ACHAT--------*/

if(date("H\hi")=="08h59")
{	
	include('cash.php');
	
	if($stocknumber>0&&$globalbad==0) 
	{	
		$available=($cash/$stocknumber)*0.93; //marge de 7%
	}
	
	foreach($orderedstocks2585 as $stock=>$price) //calcul nombre actions à acheter à 09h00
	{	
		$quantity=floor($available/$price);
						
		if($quantity>0)
		{
			/*envoi de l'ordre d'achat*/
			$curl = curl_init('http://pougne.org/log.php?type=buy&stock='.$stock.'&size='.$quantity.'&perc=7'.'&algo=normal&max=NULL&LastPrice='.$price); //enregistrement dans le log

			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, false);
			$curl_scraped_page = curl_exec($curl);
			curl_close($curl);
			
			$curl = curl_init('http://stocky.us-west-2.elasticbeanstalk.com/dg?type=buy&stock='.$stock.'&size='.$quantity.'&perc=7'); //envoi vers API degiro

			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, false);
			$curl_scraped_page = curl_exec($curl);
			curl_close($curl);
			
			$html = new simple_html_dom();
			$html->load($curl_scraped_page);
			
			/*si ordre d'achat a fonctionné, enregistrement dans le portfolio*/
			if($html=="success")
			{	
				
				$post = ['message' =>' '.$stock.' : success'];
				
				$curl = curl_init(); //enregistrement message success
				curl_setopt($curl, CURLOPT_URL,"http://pougne.org/log.php");
				curl_setopt($curl, CURLOPT_POST, 1);
				curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, false);
				$curl_scraped_page = curl_exec($curl);
				curl_close($curl);
		
				$request2=$database->prepare("INSERT INTO portfolio (stock, quantity) VALUES (:stock, :quantity);");
				try 
				{	
					$request2->execute(array(
					'stock' => $stock,
					'quantity' => $quantity	
					));
				}
				catch (Exception $exception) 
				{
					die('Erreur : ' . $exception->getMessage());
				}
			}
			if($html!="success")
			{	
				$post = ['message' =>' '.$stock.' : fail'];

				$curl = curl_init(); //enregistrement message fail
				curl_setopt($curl, CURLOPT_URL,"http://pougne.org/log.php");
				curl_setopt($curl, CURLOPT_POST, 1);
				curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, false);
				$curl_scraped_page = curl_exec($curl);
				curl_close($curl);	
			}
		}
	}
}
	
/*
if(date("H\hi")=="09h05")
{	
	include('cash.php');
	
	$startdate=strtotime("today");
	$enddate=strtotime("tomorrow");
	
	foreach($orderedstocks0905 as $stock=>$price) //unset des actions ayant un momentum négatif
	{	
		$request3=$database->query("SELECT * FROM news WHERE stock='$stock' AND date>'$startdate' AND date<'$enddate'"); //lecture de la db pour trouver momentum 0905
		$data3=$request3->fetch();
	
		if(is_numeric($data3['momentum0905']))
		{
			if($data3['momentum0905']<0)
			{
				unset($orderedstocks0905[$stock]);
			}
		}
		if(!is_numeric($data3['momentum0905']))
		{
			unset($orderedstocks0905[$stock]);
		}
		
		$post = ['message' =>' '.$stock.' : momentum='.$data3['momentum0905']];

		$curl = curl_init(); //enregistrement dans le log
		curl_setopt($curl, CURLOPT_URL,"http://pougne.org/log.php");
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
				

		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, false);
		$curl_scraped_page = curl_exec($curl);
		curl_close($curl);	
	}
	
	$stocknumber0905=count($orderedstocks0905);
			
	if($stocknumber0905>0&&$globalbad==0) 
	{	
		$available=($cash/$stocknumber0905)*0.93; //marge de 7%
	}
			
	foreach($orderedstocks0905 as $stock=>$price) //achat des stocks n'ayant pas été unset du a un momentum négatif
	{
		$quantity=floor($available/$price);
		
		if($quantity>0)
		{
			$curl = curl_init('http://pougne.org/log.php?type=buy&stock='.$stock.'&size='.$quantity.'&perc=7'.'&algo=normal&max=NULL&LastPrice='.$price); //enregistrement achat dans le log
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, false);
			$curl_scraped_page = curl_exec($curl);
			curl_close($curl);
			
			$curl = curl_init('http://stocky.us-west-2.elasticbeanstalk.com/dg?type=buy&stock='.$stock.'&size='.$quantity.'&perc=7'); //envoi vers API degiro
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, false);
			$curl_scraped_page = curl_exec($curl);
			curl_close($curl);
			
			$html = new simple_html_dom();
			$html->load($curl_scraped_page);
			
			//si ordre d'achat a fonctionné, enregistrement dans le portfolio
			if($html=="success")
			{	
				$post = ['message' =>' '.$stock.' : success'];
				
				$curl = curl_init(); //enregistrement message success
				curl_setopt($curl, CURLOPT_URL,"http://pougne.org/log.php");
				curl_setopt($curl, CURLOPT_POST, 1);
				curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, false);
				$curl_scraped_page = curl_exec($curl);
				curl_close($curl);
		
				$request2=$database->prepare("INSERT INTO portfolio (stock, quantity) VALUES (:stock, :quantity);");
				try 
				{	
					$request2->execute(array(
					'stock' => $stock,
					'quantity' => $quantity	
					));
				}
				catch (Exception $exception) 
				{
					die('Erreur : ' . $exception->getMessage());
				}
			}
			if($html!="success")
			{	
				$post = ['message' =>' '.$stock.' : fail'];

				$curl = curl_init(); //enregistrement message fail
				curl_setopt($curl, CURLOPT_URL,"http://pougne.org/log.php");
				curl_setopt($curl, CURLOPT_POST, 1);
				curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, false);
				$curl_scraped_page = curl_exec($curl);
				curl_close($curl);	
			}
		}
	}
}
*/

/*------VENTE-------*/



$portfolio=array();
$request=$database->query("SELECT * FROM portfolio");
while($data=$request->fetch())
{
	$portfolio[$data['stock']]=$data['quantity'];
}

?><p><?php
echo "Portfolio : ";
print_r($portfolio);

$startdate=strtotime("today");
$enddate=strtotime("tomorrow");
foreach($portfolio as $stock=>$quantity)
{
	$request2=$database->query("SELECT * FROM news WHERE stock='$stock' AND date>'$startdate' AND date<'$enddate'");
	$data=$request2->fetch();
			
	if($data['stock']==$stock) //si les actions sont trouvées dans la base de données news
	{
		$selltime=sell($data['data'],1,3,1000)['selltime'];
		
		//calcul de timeopti
		if($selltime=="Fermeture" || strstr($selltime,"Fermeture")!=false)
		{
			$timeopti=strtotime("today 5:25pm");
		}
		else
		{
			$timeopti=strtotime(str_replace('h', ':', $selltime));
		}
		
		if(time()>$timeopti)			//si la vente opti est déclenchée, ou plus de 17h25, envoi de l'ordre de vente
		{
			$curl = curl_init('http://pougne.org/log.php?type=sell&stock='.$stock.'&size='.$quantity.'&algo=normal&max='.sell($data['data'],1,3,1000)['max'].'&LastPrice='.$data['price']); //enregistrement dans le log

			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, false);
			$curl_scraped_page = curl_exec($curl);
			curl_close($curl);
			
			$curl = curl_init('http://stocky.us-west-2.elasticbeanstalk.com/dg?type=sell&stock='.$stock.'&size='.$quantity); //envoi vers API degiro


			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, false);
			$curl_scraped_page = curl_exec($curl);
			curl_close($curl);
			
			$html = new simple_html_dom();
			$html->load($curl_scraped_page);
			
			//si ordre de vente a fonctionné, enregistrement dans le portfolio
			if($html=="success")
			{	
				$request2=$database->query("DELETE FROM portfolio WHERE stock='$stock'");
			}
		}
	}
}


$data = ob_get_clean();
$file="curllog.html";
$current = file_get_contents($file);
$current=$data.$current;
$current="<h3>".date("Y-m-d H:i:s")." sendorders.php</h3>".$current;
file_put_contents($file, $current);

echo $data;



