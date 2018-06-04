<head>
<link rel="stylesheet" type="text/css" href="./getstockdata.css"/>
</head>

<?php
include('simple_html_dom.php');
include('getprice.php');
include('displaytable.php');

$changecac40=0;
?>
<div class="buttons">
<form method="post" action="stats.php">
<input type="submit" name="Statistiques" value="Statistiques" />
</form>
<form method="post" action="index2.php">
<input type="submit" name="Page recommandations analystes" value="Page recommandations analystes" />
</form>
<form method="post" action="readlog.php">
<input type="submit" name="Log" value="Log" />
</form>
<form method="post" action="viewdata.php">
<input type="submit" name="Cours Degiro" value="Cours Degiro" />
</form>
<a href=http://stocky.us-west-2.elasticbeanstalk.com/ui?date=<?php echo date("Y-m-d");?> target="_blank">
News
</a>
</div>
<div class="buttons2">
<form method="post" action="charts.php?date=today">
<input type="submit" name="Graphes du jour" value="Graphes du jour" />
</form>
<form method="post" action="charts.php">
<input type="submit" name="Graphes 1-25M" value="Graphes 1-25M" />
</form>
</div>

<p></p>

<form method="post" action="index.php">
Actions à afficher : (ex AC,AI,AIR)
<input type="text" value="<?php if(isset($_POST['stocklist'])){echo $_POST['stocklist'];}?>" name="stocklist" />
<input type="submit" name="Afficher" value="Afficher" />



<?php

/*affichage du cac40*/
?>
<p>
CAC 40
<p>
<?php
echo displaytable("PX1");
?>
</p>

<?php

/*affichage des cours renvoyés par l'API*/
?>
<p>
Résultats API :
</p>
<?php

include('api.php');

/*
include('apiechos.php');

if(isset($listrecos)&&isset($stocklist)) //ajout recos à la liste des stocks si variation >7%
{
	foreach($listrecos as $key=>$array)
	{
		if($array['variation']>=7)
		{
			$stocklist[]=$array['stock'];
		}
	}
}
*/

if(isset($stocklist))
{
	foreach ($stocklist as $stock)
	{
		echo displaytable($stock);
	}
}

/*affichage des cours envoyés par le formulaire*/
if(isset($_POST['stocklist'])&&$_POST['stocklist']!="")
{
	$watchlist=explode(',',$_POST['stocklist']);

	foreach ($watchlist as $stock)
	{
		echo displaytable($stock);
	}
}

?>
<p>
<input type="submit" name="Enregistrer" value="Enregistrer actions affichées" />
</form>
</p>



