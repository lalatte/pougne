<?php
function gain($momentum0905,$momentum0910)
{	
	$totalgain0900=0;

	include('dbconnect.php');
	
	
	$result=$database->query("SELECT * FROM news ORDER BY ID asc");
	while($data=$result->fetch())
	{
			if($data['momentum0905']>=$momentum0905&&$data['momentum0910']>=$momentum0910)
			{
				$totalgain0900=$totalgain0900+$data['gain0900'];
	
				
			}
	}
	return array($totalgain0900,$totalgain0905,$totalgain0910);
}

$i=-1;
$j=-1;
$gainmax0900=0;
$gainmax0905=0;
$gainmax0910=0;
$imax0900=0;
$imax0905=0;
$imax0910=0;
$jmax0900=0;
$jmax0905=0;
$jmax0910=0;

while($i<=1)
{
	while($j<=1)
	{
		$gain=gain($i,$j);
		if($gain[0]>$gainmax0900)
		{
			?><p></p><?php
			echo "<p>gain 9h00=".$gain[0];
			echo "i=".$i;
			echo "j=".$j;
			echo "</p>";
			$gainmax0900=$gain[0];
			$imax0900=round($i,1);
			$jmax0900=round($j,1);
		}
		if($gain[1]>$gainmax0905)
		{
			?><p></p><?php
			echo "<p>gain 9h05=".$gain[1];
			echo "i=".$i;
			echo "j=".$j;
			echo "</p>";
			$gainmax0905=$gain[1];
			$imax0905=round($i,1);
			$jmax0905=round($j,1);
		}
		if($gain[2]>$gainmax0910)
		{
			?><p></p><?php
			echo "<p>gain 9h10=".$gain[0];
			echo "i=".$i;
			echo "j=".$j;
			echo "</p>";
			$gainmax0910=$gain[2];
			$imax0910=round($i,1);
			$jmax0910=round($j,1);
		}
		$j=$j+0.1;
	}
	$j=-1;
	$i=round($i+0.1,2);
}

?><p></p><?php
echo "---RESULTATS---";
?><p>
Gain max 9h00 : 
<?php
echo $gainmax0900;
?><p><?php
echo "i=".$imax0900;
?></p><?php
?><p><?php
echo "j=".$jmax0900;
?></p>
</p>
<p>
Gain max 9h05 : 
<?php
echo $gainmax0905;
?><p><?php
echo "i=".$imax0905;
?></p><?php
?><p><?php
echo "j=".$jmax0905;
?></p>
</p>
<p>
Gain max 9h10 : 
<?php
echo $gainmax0910;
?><p><?php
echo "i=".$imax0910;
?></p><?php
?><p><?php
echo "j=".$jmax0910;
?></p>
</p>

