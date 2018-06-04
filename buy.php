<?php

if(!function_exists('buy'))
{
	function buy ($data, $Y, $logic)
	{
		$lines=array();
		
		if($data=="")
		{
			return array("min"=>"No data","buyprice"=>"No data","buytime"=>"No data");
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
		
		$open=$lines[0][4];
		$min=$open; //initialisation min
		
		if(!isset($logic) || $logic==1)
		{
			foreach ($lines as $i=>$line)
			{
				if($lines[$i][1]<$min)
				{
					$min=$lines[$i][1];
				}
				if($lines[$i][1]>=$min*(1+($Y/100))&& $i!=0 ) //si on détecte une perde de plus de X% et si ce n'est pas la première ligne 
				{
					$time=$timeopen+60*$lines[$i][0];
					$buytime=date("H\hi",$time);
					
					return array("min"=>$min,"buyprice"=>$lines[$i][1],"buytime"=>$buytime);
					
				}
			}
		}
		
		if($logic==2)
		{
			foreach ($lines as $i=>$line)
			{
				if($lines[$i][1]>=$open*(1+($Y/100))&& $i!=0 ) //si on détecte une perde de plus de X% et si ce n'est pas la première ligne 
				{
					$time=$timeopen+60*$lines[$i][0];
					$buytime=date("H\hi",$time);
					
					return array("min"=>$open,"buyprice"=>$lines[$i][1],"buytime"=>$buytime);
					
				}
			}
		}
		
	}
}