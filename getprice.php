<?php

if(!function_exists('getprice'))
	{
		
		function getprice(int $day, $time, $lines)
		{
			$found=0;
		
			$lines=str_replace("TIMEZONE_OFFSET=60", "", $lines);
			$lines=str_replace("TIMEZONE_OFFSET=-60", "", $lines);
			$lines=explode("a",$lines);
			
			/*conversion du html en tableau dayindex=>lineindex=>posindex*/
			
			foreach($lines as $i=>$daytable)
			{
				$new=preg_replace('/\s+/', '<p>', $daytable);
				$daytable=explode('<p>',$new);
				
				foreach($daytable as $j=>$linetable)
				{
					$linetable=explode(',',$linetable);
					$daytable[$j]=$linetable;
				}
				$lines[$i]=$daytable;
			}

			//vérification date recherchée=date lue dans l'API
		
			$dayindex=null;
			for($i=1;$i<sizeof($lines);$i++)
			{
				if(date("d",$lines[$i][0][0])==$day)
				{
					$dayindex=$i;
				}
			}
			if($dayindex==null)
			{
				return("Price not found");
			}
			
			$found=0;
			
			//si le cours recherché est à l'ouverture ou à la fermeture
			if(gettype($time)=="string")
			{
				if($time=="open");
				{
					$lineindex=0;
					$posindex=4;
					$found=1;
				}
				if($time=="close")
				{	
					//print_r($lines[$dayindex]);
					$lineindex=sizeof($lines[$dayindex])-2;		
					$posindex=1;
					$found=1;
				}
			}
			
			//si le cours recherché est à une heure précise
			if(gettype($time)!="string")
			{
				$posindex=1;
				
				//recherche heure d'ouverture
				$timeopen=substr($lines[$dayindex][0][0],0);
				$minuteopen=date('i',$timeopen);
				
				//recherche du cours le plus récent avant ou à l'heure recherchée
				$size=sizeof($lines[$dayindex])-2;
				for($i=0;$i<=$size;$i++)
				{	
					//si la ligne commence par le timestamp du jour, conversion en minute
					if($lines[$dayindex][$i][0]<1000)
					{
						$minute=$lines[$dayindex][$i][0];
					}
					if($lines[$dayindex][$i][0]>1000)
					{	
						$minute=date("i",$lines[$dayindex][$i][0]);
					}
					
					//comparaison minute avec minute recherchée
					if($minute<=$time-$minuteopen)
					{
						$lineindex=$i;
						$found=1;
					}
				}
			
			}
				
			if($found==1)
			{
				return $lines[$dayindex][$lineindex][$posindex];
			}
			else
			{
				return("Price not found");
			}
		}
	}
		