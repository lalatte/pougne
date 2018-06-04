<?php 

if(!function_exists('sell'))
{
	function sell ($data, $X, $Z, $Xfactor)
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
		$priceopen=$lines[0][4];
		$timeopen=substr($timeopen,1);
		$minuteopen=date('i',$timeopen); //calcul de l'heure d'ouverture en minutes après 9h00
	
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
			
		
		$max=$priceopen; //initialisation max
		
		
		
		
		foreach($lines as $i=>$line)
		{			
			
		
			$time=$timeopen+60*$lines[$i][0];
			$time=date("H:i",$time);
			$time=strtotime($time);
		
			$gain0900=100*(($lines[$i][1]/$priceopen)-1);
		
			if($gain0900<=1)
			{
				$trigger=$X;
			}
		
			if($gain0900>1)
			{
				$trigger=$X*(1-(($gain0900-1)/($Xfactor*$gain0900))); //algo X variable
			}
			
			if($time>=$starttime && $lines[$i][1]>$max)
			{
				$max=$lines[$i][1];
			}
			if($time>=$starttime && $lines[$i][1]<=$max*(1-($trigger/100))&& $i!=0) //si on détecte une perte de plus de trigger% et heure supérieure au start
			{
				$time=$timeopen+60*$lines[$i][0];
				$selltime=date("H\hi",$time);
				
				return array("max"=>$max,"sellprice"=>$lines[$i][1],"selltime"=>$selltime,"trigger"=>round($trigger,2)." (gain=".round($gain0900,2).")");
				
			}
			
			if($lines[$i][1]<=$priceopen*(1-($Z/100))&& $i!=0) //si on détecte une perte de plus de Z% 
			{
				$time=$timeopen+60*$lines[$i][0];
				$selltime=date("H\hi",$time);
				
				return array("max"=>$priceopen." (Ouverture)","sellprice"=>$lines[$i][1],"selltime"=>$selltime);
				
			}
		}
		
		
	
		
				
		
		
		
		// si max invalide ou vente non déclenchée
		$linesreverse=array_reverse($lines,true);
		
		foreach($linesreverse as $i=>$line)
		{			
			$time=$timeopen+60*$lines[$i][0];
			$time=date("H:i",$time);
			
			if($time=="17:25")
			{
				return array("max"=>$max,"sellprice"=>$lines[$i][1],"selltime"=>"Fermeture 17h25");
			}
			if($time=="17:24")
			{
				return array("max"=>$max,"sellprice"=>$lines[$i][1],"selltime"=>"Fermeture 17h24");
			}
			if($time=="17:23")
			{
				return array("max"=>$max,"sellprice"=>$lines[$i][1],"selltime"=>"Fermeture 17h23");
			}
			if($time=="17:22")
			{
				return array("max"=>$max,"sellprice"=>$lines[$i][1],"selltime"=>"Fermeture 17h22");
			}
			if($time=="17:21")
			{
				return array("max"=>$max,"sellprice"=>$lines[$i][1],"selltime"=>"Fermeture 17h21");
			}
			if($time=="17:20")
			{
				return array("max"=>$max,"sellprice"=>$lines[$i][1],"selltime"=>"Fermeture 17h20");
			}
		}
		
		// si prix 17h20-25 non trouvé
		return array("max"=>$max,"sellprice"=>$lines[sizeof($lines)-1][1],"selltime"=>"Fermeture");
	}
}