<?php 

function countorders($stock)

{
	$count=0;

	$file = 'log.txt';
	$current = file_get_contents($file);
	$current.="\n";
	$log=str_replace("\n","<br>",$current); 
	$log=explode("<br>",$log);

	foreach($log as $line)
	{
		$text=explode(" ",$line);
		if(array_key_exists(2,$text))
		{
			$solddate=$text[0];
			$text2=$text[2];
			$text3=explode("=",$text2);
			if(array_key_exists(1,$text3))
			{
				$text4=$text3[1];
				if($text4=="sell")
				{
					$text5=$text[3];
					$soldstock=explode("=",$text5)[1];
				}
				else
				{
					$soldstock="";
				}
			}
		
			if($solddate==date("Y-m-d") && $soldstock==$stock)
			{
				$count++;
			}
		}
	}

	return $count;
}

