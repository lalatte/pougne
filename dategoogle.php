<?php

function dategoogle($data)
{
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
	
	$dategoogle=date("Y-m-d",$timeopen);
	
	return $dategoogle;
	
}