<?php
/*fonction affichant une cellule colorée en fonction de la valeur*/
if(!function_exists('colorvalue'))
	{
		function colorvalue ($value,$blue)
		{
			if($blue==1)
			{
				$coloredvalue="<td class=lightblue>".$value."</td>";
			}
			
			if($blue==2)
			{
				$coloredvalue="<td>".$value."</td>";
			}
			
			if($blue=="")
			{	
				if ($value<=-1) {$colorclass="class=red";}
				if ($value<0&&$value>-1) {$colorclass="class=lightred";}
				if ($value>=0&&$value<1) {$colorclass="class=lightgreen";}
				if ($value>=1) {$colorclass="class=green";}
			
				$coloredvalue="<td ".$colorclass.">".$value." %".$blue."</td>";
			}
			
			if($value==="")
			{
				$coloredvalue="<td><p>&nbsp;</p></td>";
			}
			
			return $coloredvalue;
		}
	}
	
if(!function_exists('colorvaluebold'))
	{
		function colorvaluebold ($value)
		{
			if ($value<=-1) {$colorclass="class=red";}
			if ($value<0&&$value>-1) {$colorclass="class=lightred";}
			if ($value>=0&&$value<1) {$colorclass="class=lightgreen";}
			if ($value>=1) {$colorclass="class=green";}
		
		$coloredvalue="<td style='font-weight:bold;' ".$colorclass.">".$value."%</td>";
		
		return $coloredvalue;
		}
	}
?>