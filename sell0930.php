<?php 

if(!function_exists('sell'))
{
	function sell0905 ($data, $X, $Z)
	{
		$lines=array();
		
		if($data=="")
		{
			return array("max"=>"No data","sellprice"=>"No data","selltime"=>"No data");
		}
		
		
		$data1=explode("a1",$data);
		$data2="a1".$data1[sizeof($data1)-1]; //récupération dernier jour seulement
		$data3=explode(' ',$data2);
		foreach($data3 as $i=>$line)
		{	
			$lines[$i]=explode(',',$data3[$i]);
		}
		array_pop($lines); //suppression de la dernière ligne qui est vide
								
		$timeopen=$lines[0][0];
		$timeopen=substr($timeopen,1);
		$minuteopen=date('i',$timeopen); //calcul de l'heure d'ouverture en minutes après 9h00
	
			foreach($lines as $i=>$line) //initialisation prix 9h05 et max
			{
				$time=$timeopen+60*$lines[$i][0];
				$time=date("h:i",$time);
				$time=strtotime("today ".$time."am");
				
				if($time>=strtotime("today 9:05am")&&!isset($price0905)) 
				{
						$price0905=$lines[$i][1];
						$max=$price0905;
						break; 
						break;
				}
			}
			
			foreach($lines as $i=>$line)
			{			
				$time=$timeopen+60*$lines[$i][0];
				$time=date("h:i",$time);
				$time=strtotime("today ".$time."am");
				
				if($time>=strtotime("today 9:05am") && $lines[$i][1]>$max)
				{
					$max=$lines[$i][1];
				}
				if($time>=strtotime("today 9:05am") && $lines[$i][1]<=$max*(1-($X/100))&& $i!=0) //si on détecte une perde de plus de X% et si ce n'est pas la première ligne
				{
					$time=$timeopen+60*$lines[$i][0];
					$selltime=date("H\hi",$time);
					
					return array("max"=>$max,"sellprice"=>$lines[$i][1],"selltime"=>$selltime);
					
				}
				
				if($time>=strtotime("today 9:05am") && $lines[$i][1]<=$price0905*(1-($Z/100))&& $i!=0) //si on détecte une perde de plus de Z% après 9h05 et si ce n'est pas la première ligne
				{
					$time=$timeopen+60*$lines[$i][0];
					$selltime=date("H\hi",$time);
					
					return array("max"=>"9h05","sellprice"=>$lines[$i][1],"selltime"=>$selltime);
				}
			
			}
		
				
		
		
		
		// si max invalide ou vente non déclenchée
		return array("max"=>$max,"sellprice"=>$lines[sizeof($lines)-1][1],"selltime"=>"Fermeture");
		
	}
}