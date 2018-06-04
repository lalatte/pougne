<?php

function maxdegiro($stock,$volume)
{
	$maxdegiro="Day not started";
	$daystarted=0;
	
	$file="./degiro/".$stock.".txt";
	$current = file_get_contents($file);
	$data=explode("\n",$current);
	
	
	if($volume>=10000000 && $volume<85000000)
	{
		foreach ($data as $line)
		{
			$data2=explode(" ",$line);
			
			if(array_key_exists(1,$data2))
			{
				$data6=$data2[1];
				$data7=explode("=",$data6);
				$LastTime=$data7[1];
			}
			
			if(date("H",strtotime($LastTime))=="09")
			{
				$daystarted=1;
			}
				
			if(array_key_exists(2,$data2))
			{
				$data3=$data2[2];
				$data4=explode("=",$data3);
				$data5=$data4[1];
				if(is_numeric($data5) && $daystarted==1)
				{
					if($data5>$maxdegiro || $maxdegiro=="Day not started")
					{
						$maxdegiro=$data5;
					}
				}
			}
		}
	}
	
	/*
	if($volume>=10000000 && $volume<25000000)
	{
		foreach ($data as $line)
		{
			$data2=explode(" ",$line);
			
			if(array_key_exists(1,$data2))
			{
				$data6=$data2[1];
				$data7=explode("=",$data6);
				$LastTime=$data7[1];
				$LastTimeUnix=strtotime($LastTime);
			}
			if(date("H",strtotime($LastTime))=="09")
			{
				$daystarted=1;
			}
				
			if(array_key_exists(2,$data2))
			{
				$data3=$data2[2];
				$data4=explode("=",$data3);
				$data5=$data4[1];
				if(is_numeric($data5))
				{
					if($data5>$maxdegiro && $daystarted==1 && $LastTimeUnix>=strtotime("today 9:05am"))
					{
						$maxdegiro=$data5;
					}
				}
			}
		}
	}
	*/
	
	return $maxdegiro;	
}