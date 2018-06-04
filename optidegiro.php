<?php

if(!function_exists('optidegiro'))
{
	function optidegiro($datadegiro, $data, $X, $Z, $Xfactor)
	{
		if($datadegiro=="")
		{
			return array("LastTime"=>"No data","LastPrice"=>"No data");
		}
		
		$max=0;
		$daystarted=0;
		
		$data1=explode("\n",$datadegiro);
		array_pop($data1); //suppression de la dernière ligne qui est vide
			
		$buytime=buy($data,$_SESSION['Y'])['buytime'];
		
		if(isset($buytime)&&$buytime!="") //si heure achat opti trouvée
		{
			$buytime=str_replace("h",":",$buytime);
			$buytime=strtotime($buytime);
		}
		
		if(!isset($buytime)||$buytime=="")
		{
			$buytime=strtotime("today 6:00pm"); // si pas d'achat opti, buytime après la fin de la journée
		}
		
		if($_SESSION['logic']==1 || !isset($_SESSION['logic']))
		{
			$starttime=strtotime("today 9:00am");
		}
		if($_SESSION['logic']==2)
		{
			$starttime=strtotime("today 9:05am");
		}
		if($_SESSION['logic']==3)
		{
			$starttime=$buytime;
		}
		if($_SESSION['logic']==4)
		{
			$starttime=max($buytime,strtotime("today 9:06am"));
		}
		
		
		
		foreach($data1 as $line)
		{
			$data2=explode(" ", $line);
			$data3=$data2[2];
			$data4=explode("=",$data3);
			$LastPrice=$data4[1];
			$data5=$data2[1];
			$data6=explode("=",$data5);
			$LastTime=$data6[1];
			$LastTimeUnix=strtotime($LastTime);
			$minutesopen=round(($LastTimeUnix-strtotime("Today 09:00"))/60,0);
			
			if($daystarted==0)
			{
				if(date("H",strtotime($LastTime))=="09")
				{
					$priceopen=$LastPrice;
					$daystarted=1;
				}
			}
			
			$gain0900=100*(($LastPrice/$priceopen)-1);
			
			if($gain0900<=1)
			{
				$trigger=$X;
			}
		
			if($gain0900>1)
			{
				$trigger=$X*(1-(($gain0900-1)/($Xfactor*$gain0900))); //algo X variable
			}
			
			if(isset($LastPrice)&& $LastPrice!="")
			{
				if($LastPrice>$max&& $daystarted==1 && $LastTimeUnix>=$starttime) //enregistrement du max
				{
					$max=$LastPrice;		
				}
				
				if($LastPrice<=$max*(1-$trigger/100)&& $daystarted==1)
				{
					return array("max"=>$max,"LastTime"=>$LastTime,"LastPrice"=>$LastPrice,"trigger"=>round($trigger,2)." (gain=".round($gain0900,2).")");
				}
				
				if(isset($priceopen))
				{
					if($LastPrice<=$priceopen*(1-($Z/100))) //si on détecte une perte de plus de Z% 
					{
						return array("max"=>$priceopen." (Ouverture)","LastTime"=>$LastTime,"LastPrice"=>$LastPrice);
					}
				}
			}
		}
		
		$priceclose=$LastPrice;
		
		// si max invalide ou vente non déclenchée
		$data1reverse=array_reverse($data1,true);
		
		foreach($data1reverse as $line)
		{
			$data2=explode(" ", $line);
			$data3=$data2[2];
			$data4=explode("=",$data3);
			$LastPrice=$data4[1];
			$data5=$data2[1];
			$data6=explode("=",$data5);
			$LastTime=$data6[1];
			$LastTimeUnix=strtotime($LastTime);
	
			
				if(date("H:i",$LastTimeUnix)=="17:24")
			{
				return array("LastTime"=>"Fermeture ".$LastTime,"LastPrice"=>$LastPrice);
			}
			
				if(date("H:i",$LastTimeUnix)=="17:23")
			{
				return array("LastTime"=>"Fermeture ".$LastTime,"LastPrice"=>$LastPrice);
			}
					
				if(date("H:i",$LastTimeUnix)=="17:22")
			{
				return array("LastTime"=>"Fermeture ".$LastTime,"LastPrice"=>$LastPrice);
			}
		
				if(date("H:i",$LastTimeUnix)=="17:21")
			{
				return array("LastTime"=>"Fermeture ".$LastTime,"LastPrice"=>$LastPrice);
			}
			
				if(date("H:i",$LastTimeUnix)=="17:20")
			{
				return array("LastTime"=>"Fermeture ".$LastTime,"LastPrice"=>$LastPrice);
			}
		}
		
		return array("LastTime"=>"Fermeture","LastPrice"=>$priceclose); //si vente non détectée, retourne fermeture
	}
}