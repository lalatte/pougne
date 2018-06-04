<?php 

function countfails($stock)
{
	$count=0;
	$maxcount=0;

	$file = "./degiro/".$stock.".txt";
	$current = file_get_contents($file);
	$datadegiro=str_replace("\n","<br>",$current); 
	$datadegiro=explode("<br>",$datadegiro);
	array_pop($datadegiro);
	
	foreach($datadegiro as $line)
	{
		$text=explode(" ",$line);
				
		if(array_key_exists(2,$text))
		{
			$text2=$text[2];
			$text3=explode("=",$text2)[1];
		}
		
		if(!is_numeric($text3))
		{
			$count++;
		}
		else
		{
			if($count>$maxcount)
			{
				$maxcount=$count;
			}
			$count=0;
		}
		
		
	}

	return $maxcount;
}

	
	