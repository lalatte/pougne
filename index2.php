<head>
<link rel="stylesheet" type="text/css" href="./getstockdata.css"/>
</head>

<p><h2>Recommandations analystes</h2></p>
<?php


include('simple_html_dom.php');
include('getprice.php');
include('displaytable3.php');

$changecac40=0;
?>

<form method="post" action="stats2.php">
<input type="submit" name="Statistiques" value="Statistiques" />
</form>
<form method="post" action="index.php">
<input type="submit" name="Page principale" value="Page principale" />
</form>
<a href="https://investir.lesechos.fr/marches/les-recos-des-analystes/index.php"  target = "_blank">
Site Les Echos</a>
<p></p>

<form method="post" action="index2.php">
Actions à afficher : (ex AC,AI,AIR)
<input type="text" value="<?php if(isset($_POST['stocklist'])){echo $_POST['stocklist'];}?>" name="stocklist" />
<input type="submit" name="Afficher" value="Afficher" />



<?php

/*affichage du cac40*/
?>
<h3>
CAC 40
<p>
<?php
echo displaytable3("PX1",0);
?>
</p>

<h3>
Résultats Recos :
</h3>

<h4>
Echos
</h4>
<?php
include('apiechos.php');

if(isset($listechos))
{
	foreach ($listechos as $stock)
	{
		echo displaytable3($stock['stock'],$stock['variation'],$stock['analyst'],"Echos");
	}
}

?>
<h4>
Boursier
</h4>
<?php
include('apiboursier.php');

if(isset($listboursier))
{
	foreach ($listboursier as $stock)
	{
		echo displaytable3($stock['stock'],$stock['variation'],$stock['analyst'],"Boursier");
	}
}

/*affichage des cours envoyés par le formulaire*/
if(isset($_POST['stocklist'])&&$_POST['stocklist']!="")
{
	$watchlist=explode(',',$_POST['stocklist']);

	foreach ($watchlist as $stock)
	{
		echo displaytable3($stock,0);
	}
}

?>
<p>
<input type="submit" name="Enregistrer" value="Enregistrer actions affichées" />
</form>
</p>



