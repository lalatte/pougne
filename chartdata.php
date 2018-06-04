<?php
include("dbconnect.php");
include("sell.php");
include("buy.php");
include("optidegiro.php");

$_SESSION['logic']=3;

$ID=$_GET['ID'];

$result=$database->query("SELECT * FROM news WHERE ID='$ID';");

$data=$result->fetch();

$datagoogle=$data['data'];
$closepreviousday=$data['closepreviousday'];

$cols=array();
$rows=array();

$data1=explode("a",$datagoogle);
$data2=$data1[count($data1)-1];

$data3=explode(" ",$data2);
array_pop($data3); //supprime la dernière ligne qui est vide

$data5=explode(",",$data3[0]);
$timeopen=$data5[0];
$timeopen="Date(".date("Y,m,d",($data['date'])).",".date("H,i",(int)$timeopen).",0,0)";

$priceopen=$data5[4];


$rows[]=array(
				'c' =>array
					(
						array('v' =>"Date(".date("Y,m,d",($data['date'])).",08,50,0,0)"),
						array('v' =>null),
						array('v' =>null),
						array('v' =>$closepreviousday/$priceopen)
					)
			);


			
foreach($data3 as $line)
{
	$data4=explode(",",$line);
	$price=$data4[1];
		
	$time=$data5[0]+60*$data4[0];
	$time="Date(".date("Y,m,d",($data['date'])).",".date("H,i",(int)$time).",0,0)";
	
	$rows[]=array(
				'c' =>array
					(
						array('v' =>$time),
						array('v' =>null),
						array('v' =>(float)$price/$priceopen),
						array('v' =>$closepreviousday/$priceopen)
					)
   );
}


$rows[1]=array('c' =>array
					(
						array('v' =>$timeopen),
						array('v' =>null),
						array('v' =>$data5[1]/$priceopen),
						array('v' =>$closepreviousday/$priceopen)
					)
				);
			
if($data['cat2']=="0.25"||$data['cat2']=="1") //heure d'achat 9h00 si 0.25 ou 1
{
	$rows[]=array('c' =>array
					(
						array('v' =>"Date(".date("Y,m,d",($data['date'])).","."09,0,0)"),
						array('v' =>"buy"),
						array('v' =>null),
						array('v' =>null)
					)
				);
}

if($data['cat2']=="10") //heure d'achat 9h05 si 10
{
	$rows[]=array('c' =>array
					(
						array('v' =>"Date(".date("Y,m,d",($data['date'])).","."09,05,0)"),
						array('v' =>"buy"),
						array('v' =>null),
						array('v' =>null)
					)
				);
}

/*
$selltime=optidegiro($data['datadegiro'],1,$data['cat2'])['LastTime']; //calcul heure vente degiro
if($selltime=="Fermeture")
		{
			$time3="Date(".date("Y,m,d",($data['date'])).",17,25,0,0)";
		}
		else
		{
			$time1=explode(":",$selltime);
			$time2=$time1[0].",".$time1[1].",0"; //conversion en format js
			$time3="Date(".date("Y,m,d",($data['date'])).",".$time2.")";
		}
*/

$selltime="No data";
		
if($selltime=="No data") // si vente degiro non trouvée
{
	$selltime=sell($data['data'],1,3,$data['cat2'])['selltime']; //calcul heure vente google
	if($selltime=="Fermeture")
		{
			$time3="Date(".date("Y,m,d",($data['date'])).",17,25,0,0)";
		}
	else
		{
			$time1=explode("h",$selltime);
			$time2=$time1[0].",".$time1[1].",0"; //conversion en format js
			$time3="Date(".date("Y,m,d",($data['date'])).",".$time2.")";
		}
}

	
$rows[]=array('c' =>array
				(
					array('v' =>$time3),
					array('v' =>"sell"),
					array('v' =>null),
					array('v' =>null)
				)
			);

$buytime=buy($data['data'],1,$data['cat2'])['buytime']; //calcul heure achat opti
if($buytime!="")
{
	$time4=explode("h",$buytime);
	$time5=$time4[0].",".$time4[1].",0"; //conversion en format js
	$time6="Date(".date("Y,m,d",($data['date'])).",".$time5.")";
	
	$rows[]=array('c' =>array
				(
					array('v' =>$time6),
					array('v' =>"buyopti"),
					array('v' =>null),
					array('v' =>null)
				)
			);
}
	
$label=$data['stock']." ".date("Y-m-d",($data['date']));

			
$cols[]=array("label"=>"time","type"=>"datetime");
$cols[]=array("type"=>"string","role"=>"annotation");
$cols[]=array("label"=>$label,"type"=>"number");
$cols[]=array("label"=>"previous day","type"=>"number");

	
$jsonarray=array();
$jsonarray["cols"]=$cols;
$jsonarray["rows"]=$rows;
	
$json=json_encode($jsonarray,JSON_PRETTY_PRINT);

echo $json;