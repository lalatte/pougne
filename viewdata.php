<h2>Cours Degiro</h2>



<h4>News validées :</h4>
<?php include('api.php'); 

if(count($stocklist)!=0)
{
	foreach($stocklist as $stock)
	{
		echo '<a href="./data.php?stock='.$stock.'">'.$stock.'</a></br>';
	}
}
		
?>

<h4>Echos :</h4>
<?php include('apiechos.php');

if($listechos=="")
{
	echo "Aucune reco trouvée";
}

foreach ($listechos as $key=>$array)
{
	echo '<a href="./data.php?stock='.$array['stock'].'">'.$array['stock'].'</a></br>';
}
?>

<h4>Boursier :</h4>
<?php include('apiboursier.php');

if($listboursier=="")
{
	echo "Aucune reco trouvée";
}


foreach ($listboursier as $key=>$array)
	{
		echo '<a href="./data.php?stock='.$array['stock'].'">'.$array['stock'].'</a></br>';
	}
?>
<p></p>
<?php

?>
<p>
<form method="post" action="data.php">
Cours à afficher :
<input type="text" name="stock"/>
<input type="submit" value="Afficher" />
</p>
