<?php
session_start();
?>

<h2>Stats recommandations analystes</h2>

<?php

include('dbconnect.php');

$result=$database->query("SELECT DISTINCT analyst FROM recommandations");
	global $analysts;
	while($data=$result->fetch())
	{
		$analysts[]=$data['analyst'];
	}


/*gestion des variables get et de session*/

/*MOMENTUMS*/

if(isset($_POST['momentum0903']))
{
	$_SESSION['momentum0903']=$_POST['momentum0903'];
}

if(isset($_POST['momentum0905']))
{
	$_SESSION['momentum0905']=$_POST['momentum0905'];
}

if(isset($_POST['momentum0910']))
{
	$_SESSION['momentum0910']=$_POST['momentum0910'];
}

/*CATEGORIES*/
if(isset($_POST['cat1']))
{
	$_SESSION['cat1']=$_POST['cat1'];
}

if(isset($_POST['cat2']))
{
	$_SESSION['cat2']=$_POST['cat2'];
}

if(isset($_POST['cat3']))
{
	$_SESSION['cat3']=$_POST['cat3'];
}

if(isset($_POST['minvolume']))
{
	$_SESSION['minvolume']=$_POST['minvolume'];
}

if(isset($_POST['maxvolume']))
{
	$_SESSION['maxvolume']=$_POST['maxvolume'];
}

/*FRAIS*/
if(isset($_POST['frais']))
{
	if($_POST['frais']=="")
	{
		$_SESSION['frais']=0;
	}
	else
	{
	$_SESSION['frais']=$_POST['frais'];
	}
}
else
{
	if(!isset($_SESSION['frais']))
	{
		$_SESSION['frais']=0;
	}
}

/*SPREAD*/
if(isset($_POST['spread']))
{
	if($_POST['spread']=="")
	{
		$_SESSION['spread']=0;
	}
	else
	{
	$_SESSION['spread']=$_POST['spread'];
	}
}
else
{
	if(!isset($_SESSION['spread']))
	{
		$_SESSION['spread']=0;
	}
}

/*X*/
if(isset($_POST['X']))
{
	if($_POST['X']=="")
	{
		$_SESSION['X']=1;
	}
	else
	{
	$_SESSION['X']=$_POST['X'];
	}
}
else
{
	if(!isset($_SESSION['X']))
	{
		$_SESSION['X']=1;
	}
}

/*Xfactor*/
if(isset($_POST['Xfactor']))
{
	if($_POST['Xfactor']=="")
	{
		$_SESSION['Xfactor']=1;
	}
	else
	{
	$_SESSION['Xfactor']=$_POST['Xfactor'];
	}
}
else
{
	if(!isset($_SESSION['Xfactor']))
	{
		$_SESSION['Xfactor']=1;
	}
}

/*Y*/
if(isset($_POST['Y']))
{
	if($_POST['Y']=="")
	{
		$_SESSION['Y']=1;
	}
	else
	{
	$_SESSION['Y']=$_POST['Y'];
	}
}
else
{
	if(!isset($_SESSION['Y']))
	{
		$_SESSION['Y']=1;
	}
}

/*Z*/
if(isset($_POST['Z']))
{
	if($_POST['Z']=="")
	{
		$_SESSION['Z']=1;
	}
	else
	{
	$_SESSION['Z']=$_POST['Z'];
	}
}
else
{
	if(!isset($_SESSION['Z']))
	{
		$_SESSION['Z']=3;
	}
}

/*LOGIQUE*/
/*Y*/
if(isset($_POST['logic']))
{
	if($_POST['logic']=="")
	{
		$_SESSION['logic']=1;
	}
	else
	{
	$_SESSION['logic']=$_POST['logic'];
	}
}
else
{
	if(!isset($_SESSION['logic']))
	{
		$_SESSION['logic']=1;
	}
}

/*OPTIONS AFFICHAGE*/
if(isset($_GET['simplified']))
	{
		if($_GET['simplified']==1)
		{
			$simplified=1;
		}
		else
		{
			$simplified=0;
		}
	}
else
	{
		$simplified=1;
	}
	
if(isset($_GET['display']))
	{
		if($_GET['display']=="all")
		{
			$display="all";
		}
		else
		{
			$display="week";
		}
	}
	else
	{
		$display="week";
	}

	
/*VARIATION RECO*/
if(isset($_POST['variationpos']))
{
	$_SESSION['variationpos']=$_POST['variationpos'];
}
if(isset($_POST['variationneg']))
{
	$_SESSION['variationneg']=$_POST['variationneg'];
}

/*ANALYSTE*/
if(isset($_POST['analyst']))
{
	$_SESSION['analyst']=$_POST['analyst'];
}
?>

<head>
<link rel="stylesheet" type="text/css" href="./getstockdata.css"/>
</head>



<?php 

function stattable($startdate,$enddate,$simplified)
{	

	$totalgain0900=0;
	$totalgain0905=0;
	$totalgain0910=0;
	$totalgainshort;
	$totalgainopti0900=0;
	$totalgainopti0905=0;
	$totalgainshortopti=0;
	$totaldiffgain0900=0;
	$totaldiffgain0905=0;
	$totaldiffgain0910=0;
	$daygain0900=0;
	$daygain0905=0;
	$totaldaygain0900=0;
	$totaldaygain0905=0;
	$daydate="";
	$stocknumber=1;
	$daytable0900="";
	$daytable0905="";
	
	include('dbconnect.php');
	include('colorvalue.php');
	include('sell.php');
	include('buy.php');
	include('optidegiro.php');
	
	

	if($simplified==0)
	{	
		$stattable=
		"
		<table id=results>
		<tr>
			<td>
			<p>#
			</td>
			<td>
			<p>Date
			</td>
			<td>
			<p>Action
			</td>
			<td>
			<p>Variation Reco
			</td>
			<td>
			<p>Site
			</td>
			<td>
			<p>Analyste
			</td>
			<td>
			<p>Vol. Moyen
			</td>
			<td>
			<p>GlobalBad
			</td>
			<td>
			<p>Fermeture
			</td>
			<td>
			<p>Ouverture
			</td>
			<td>
			<p>Fermeture veille
			</td>
			<td>
			<p>Minimum
			</td>
			<td>
			<p>Heure achat Google
			</td>
			<td>
			<p>Prix achat Google
			</td>
			<td>
			<p>Maximum
			</td>
			<td>
			<p>Heure vente Google
			</td>
			<td>
			<p>Prix vente Google
			</td>
			<td>
			<p>Heure vente Degiro
			</td>
			<td>
			<p>Prix vente Degiro
			</td>
			<td>
			<p>Variation journalière
			</td>
			<td>
			<p>Variation ouverture
			</td>
			<td>
			<p>Momentum 10J
			</td>
			<td>
			<p>Momentum 3J
			</td>
			<td>
			<p>Cours O+5
			</td>
			<td>
			<p>Cours O+10
			</td>
			<td>
			<p>Momentum O+5
			</td>
			<td>
			<p>Momentum O+10
			</td>
			<td>
			<p>Gain (O)
			</td>
			<td>
			<p>Gain (O+5)
			</td>
			<td>
			<p>Gain (O+10)
			</td>
			<td>
			<p>Gain O optimisé
			</td>
			<td>
			<p>Gain O+5 optimisé
			</td>
			<td>
			<p>Gain short</p>
			</td>
			<td>
			<p>Gain short opti</p>
			</td>
			<td>
			<p>Variation CAC40
			</td>
			<td>
			<p>Diff CAC40
			</td>
			<td>
			<p>Momentum CAC40 O+5
			</td>
			<td>
			<p>Momentum CAC40 O+10
			</td>
			<td>
			<p>Gain CAC40 (O)
			</td>
			<td>
			<p>Gain CAC40 (O+5)
			</td>
			<td>
			<p>Gain CAC40 (O+10)
			</td>
			<td>
			<p>Diff Gain (O)
			</td>
			<td>
			<p>Diff Gain (O+5)
			</td>
			<td>
			<p>Diff Gain (O+10)
			</td>
			<td>
			<p>Gain full opti
			</td>
			</tr>
		";
	}
	if($simplified==1)
	{
		$stattable=
		"
		<table id=results>
		<tr>
		<td>
		<p>#
		</td>
		<td>
		<p>Date
		</td>
		<td>
		<p>Action
		</td>
		<td>
		<p>Variation Reco
		</td>
		<td>
		<p>Site
		</td>
		<td>
		<p>Analyste
		</td>
		<td>
		<p>Vol. Moyen
		</td>
		<td>
		<p>Gain (O)
		</td>
		<td>
		<p>Gain O optimisé
		</td>
		<td>
		<p>Gain short
		</td>
		<td>
		<p>Gain short opti
		</td>
		</tr>
		";
	}

	/*CREATION DU TEXTE DE LA REQUETE*/
	
	$querytext="SELECT * FROM recommandations WHERE date>'$startdate' AND date<'$enddate'";
	
	if(isset($_SESSION['momentum0905']))
	{	
		if($_SESSION['momentum0905']!="")
		{
			$querytext=$querytext."AND momentum0905>'{$_SESSION['momentum0905']}'";
		}
		if($_SESSION['momentum0910']!="")
		{
			$querytext=$querytext."AND momentum0910>'{$_SESSION['momentum0910']}'";
		}
	}
	
	if(isset($_SESSION['variationpos'])&& isset($_SESSION['variationneg']))
	{	
		if($_SESSION['variationpos']!="" && $_SESSION['variationneg']!="")
		{
			$querytext=$querytext."AND variation NOT BETWEEN '{$_SESSION['variationneg']}' AND '{$_SESSION['variationpos']}'";
		}
		if($_SESSION['variationpos']!="" && $_SESSION['variationneg']=="")
		{
			$querytext=$querytext."AND variation > '{$_SESSION['variationpos']}'";
		}
		if($_SESSION['variationpos']=="" && $_SESSION['variationneg']!="")
		{
			$querytext=$querytext."AND variation < '{$_SESSION['variationneg']}'";
		}
	}
		
	if(isset($_SESSION['analyst']))
	{	
		if($_SESSION['analyst']!="")
		{
			$querytext=$querytext."AND analyst='{$_SESSION['analyst']}'";
		}
	}
	
	if(isset($_SESSION['cat1']))
	{
		if($_SESSION['cat1']!="")
		{
			$cat1=implode("','",explode(",",$_SESSION['cat1']));;
			$querytext=$querytext."AND cat1 IN ('{$cat1}')";
		}
		if($_SESSION['cat2']!="")
		{
			$cat2=implode("','",explode(",",$_SESSION['cat2']));;
			$querytext=$querytext."AND cat2 IN ('{$cat2}')";
		}
		if($_SESSION['cat3']!="")
		{
			$cat3=implode("','",explode(",",$_SESSION['cat3']));;
			$querytext=$querytext."AND cat3 IN ('{$cat3}')";
		}
	}
	
	if(isset($_SESSION['minvolume']))
	{
		if($_SESSION['minvolume']!="")
		{
			$minvolume=1000000*$_SESSION['minvolume'];
			$querytext=$querytext."AND volume > '$minvolume'";
		}
	}
	
	if(isset($_SESSION['maxvolume']))
	{
		if($_SESSION['maxvolume']!="")
		{
			$maxvolume=1000000*$_SESSION['maxvolume'];
			$querytext=$querytext."AND volume < '$maxvolume'";
		}
	}
	
	
	$querytext=$querytext."ORDER BY ID asc";
		
	/*echo $querytext;*/
	
	/*requête DB*/
	$result=$database->query($querytext);
	
	$line=1;
	
	while($data=$result->fetch())
	{
		
		/*calcul du gain achat+vente opti*/
		$buyprice=buy($data['data'],$_SESSION['Y'],1)['buyprice'];
		
		if($buyprice!=0&&$buyprice!="")
		{
			$sellfullopti=sell($data['data'],$_SESSION['X'],$_SESSION['Z'],$_SESSION['Xfactor'])['sellprice'];
			$gainfullopti=100*(($sellfullopti/$buyprice)-1);
			$gainfullopti=round($gainfullopti,2);
		}
		else
		{
			$gainfullopti=0;
		}	
		
		/*calcul du gain optimisé*/
		$sellprice=sell($data['data'],$_SESSION['X'],$_SESSION['Z'],$_SESSION['Xfactor'])['sellprice'];
		if($sellprice=="No data")
		{
			$gainopti0900=$data['gain0900'];
			$gainopti0905=$data['gain0905'];
		}
		else
		{
			if($data['open']!=0)
			{
			$gainopti0900=(($sellprice-$data['open'])/$data['open'])*100;
			}
			else
			{
				$gainopti0900=0;
			}
			
			if($data['price0905']!=0)
			{	
				$gainopti0905=(($sellprice-$data['price0905'])/$data['price0905'])*100;
			}
			else
			{
				$gainopti0905=0;
			}
			
			$gainopti0900=round($gainopti0900,2);
			$gainopti0905=round($gainopti0905,2);
		}
		
		/*calcul gain short*/
		if($data['variation']<0)
		{
			$gainshort=100*(($data['open']/$data['price'])-1);
			$gainshort=round($gainshort,2);
			if($buyprice!="")
			{
				$gainshortopti=100*(($data['open']/$buyprice)-1);
				$gainshortopti=round($gainshortopti,2);
			}
			else
			{
				$gainshortopti=$gainshort;
			}
			
			$gainopti0900=""; //annulation du gain normal
			$data['gain0900']="";
		}
		else
		{
			$gainshort="";
			$gainshortopti="";
		}
		
		
		/*calcul du gain par jour*/
		if(gmdate("d-m-Y",$data['date'])==$daydate) //si une nouvelle action à la même date est trouvée
		{
			$daygain0900=$daygain0900+$gainopti0900;
			$daygain0905=$daygain0905+$gainopti0905;
			$stocknumber=$stocknumber+1;
			$daytable0900=$daytable0900."<tr><td><p>&nbsp;</p></td></tr>";
			$daytable0905=$daytable0905."<tr><td><p>&nbsp;</p></td></tr>";
		}
	
		if(gmdate("d-m-Y",$data['date'])!=$daydate) //si une nouvelle date est trouvée
		{
			//enregistrement du gain jour précédent
			
			$totaldaygain0900=$totaldaygain0900+$daygain0900/$stocknumber-$_SESSION['frais']-$_SESSION['spread'];
			$totaldaygain0905=$totaldaygain0905+$daygain0905/$stocknumber-$_SESSION['frais']-$_SESSION['spread'];
			$daytable0900=$daytable0900."<tr>".colorvalue(round($daygain0900/$stocknumber-$_SESSION['frais']-$_SESSION['spread'],2))."</tr>";
			$daytable0905=$daytable0905."<tr>".colorvalue(round($daygain0905/$stocknumber-$_SESSION['frais']-$_SESSION['spread'],2))."</tr>";
						
			
			//lecture de la nouvelle date
			$stocknumber=1;
			$daygain0900=$gainopti0900;
			$daygain0905=$gainopti0905;
			$daydate=gmdate("d-m-Y",$data['date']);
		}
		
		
		/*affichage de la ligne*/
		if($simplified==0)
		{
			$datatable=
			"
			<tr>
			<td>".
			$line.
			"</td>
			<td>".
			gmdate("d-m-Y",$data['date'])
			.
			"</td>

			<td>
			<a href='https://finance.google.com/finance?q=epa%3A".
			$data['stock']
			."' target=_blank>
			".$data['stock']."</a>
			</td>

			".
			colorvalue($data['variation'])
			."
			
			<td>".
			$data['website']
			."
			</td>
			
			<td>".
			$data['analyst']
			."
			</td>
			
			<td>".
			round(($data['volume']/1000000),1)." M"
			."
			</td>
			
			<td>".
			$data['globalbad']
			."
			</td>
			
			<td>
			".
			$data['price']
			."
			</td>

			<td>
			".
			$data['open']
			."
			</td>
			
			<td>	
			".
			$data['closepreviousday']
			."
			</td>
			
			<td>	
			".
			buy($data['data'],$_SESSION['Y'],1)['min']
			."
			</td>
			
			<td>	
			".
			buy($data['data'],$_SESSION['Y'],1)['buytime']
			."
			</td>
			
			<td>	
			".
			buy($data['data'],$_SESSION['Y'],1)['buyprice']
			."
			</td>
			
			<td>	
			".
			sell($data['data'],$_SESSION['X'],$_SESSION['Z'],$_SESSION['Xfactor'])['max']
			."
			</td>
			
			<td>	
			".
			sell($data['data'],$_SESSION['X'],$_SESSION['Z'],$_SESSION['Xfactor'])['selltime']
			."
			</td>
			
			<td>	
			".
			sell($data['data'],$_SESSION['X'],$_SESSION['Z'],$_SESSION['Xfactor'])['sellprice']
			."
			</td>
			
			<td>	
			".
			optidegiro($data['datadegiro'],$data['data'],$_SESSION['X'], $_SESSION['Z'], $_SESSION['Xfactor'])['LastTime']
			."
			</td>
			
			<td>	
			".
			optidegiro($data['datadegiro'],$data['data'],$_SESSION['X'], $_SESSION['Z'], $_SESSION['Xfactor'])['LastPrice']
			."
			</td>
			
			".
			colorvalue($data['daychange'])
			."
			
			".
			colorvalue($data['openchange'])
			."
			
			".
			colorvalue($data['momentum10day'])
			."
			
			".
			colorvalue($data['momentum3day'])
			."
			
			<td>
			".
			$data['price0905']
			."
			</td>
			
			<td>
			".
			$data['price0910']
			."
			</td>
			
			".
			colorvalue($data['momentum0905'])
			."
			
			".
			colorvalue($data['momentum0910'])
			."
			
			".
			colorvalue($data['gain0900'])
			."
			
			".
			colorvalue($data['gain0905'])
			."
			
			".
			colorvalue($data['gain0910'])
			."
			
			".
			colorvalue($gainopti0900)
			."
			
			".
			colorvalue($gainopti0905)
			."
			
			".
			colorvalue($gainshort)
			."
			
			".
			colorvalue($gainshortopti)
			."
			
			".
			colorvalue($data['cac40change'])
			."
			
			".
			colorvalue($data['diffcac40'])
			."

			".
			colorvalue($data['cac40momentum0905'])
			."
			
			".
			colorvalue($data['cac40momentum0910'])
			."
			
			".
			colorvalue($data['cac40gain0900'])
			."
			
			".
			colorvalue($data['cac40gain0905'])
			."
			
			".
			colorvalue($data['cac40gain0910'])
			."
			
			".
			colorvalue($data['diffgain0900'])
			."
			
			".
			colorvalue($data['diffgain0905'])
			."
			
			".
			colorvalue($data['diffgain0910'])
			."
			
			".
			colorvalue($gainfullopti)
			."
			</tr>";
		}
		if($simplified==1)
		{
			$datatable=
			"
			<tr>
			<td>".
			$line.
			"</td>
			<td>".
			gmdate("d-m-Y",$data['date'])
			.
			"</td>

			<td>
			<a href='https://finance.google.com/finance?q=epa%3A".
			$data['stock']
			."' target=_blank>
			".$data['stock']."</a>
			</td>
			
			".
			colorvalue($data['variation'])
			."
			
			<td>".
			$data['website']
			."
			</td>
			
			<td>".
			$data['analyst']
			."
			</td>
			
			<td>".
			round(($data['volume']/1000000),1)." M"
			."
			</td>
			
			".
			colorvalue($data['gain0900'])
			."
			
			".
			colorvalue($gainopti0900)
			."
			
			".
			colorvalue($gainshort)
			."
			
			".
			colorvalue($gainshortopti)
			."
			</tr>";
		}

		$stattable=$stattable.$datatable;
		$totalgain0900=round($totalgain0900+$data['gain0900']-$_SESSION['frais']-$_SESSION['spread'],2);
		$totalgain0905=round($totalgain0905+$data['gain0905']-$_SESSION['frais']-$_SESSION['spread'],2);
		$totalgain0910=round($totalgain0910+$data['gain0910']-$_SESSION['frais']-$_SESSION['spread'],2);
		$totalgainshort=round($totalgainshort+$gainshort-$_SESSION['frais']-$_SESSION['spread'],2);
		$totalgainopti0900=round($totalgainopti0900+$gainopti0900-$_SESSION['frais']-$_SESSION['spread'],2);
		$totalgainopti0905=round($totalgainopti0905+$gainopti0905-$_SESSION['frais']-$_SESSION['spread'],2);
		$totalgainshortopti=round($totalgainshortopti+$gainshortopti-$_SESSION['frais']-$_SESSION['spread'],2);
		$totaldiffgain0900=round($totaldiffgain0900+$data['diffgain0900']-$_SESSION['frais']-$_SESSION['spread'],2);
		$totaldiffgain0905=round($totaldiffgain0905+$data['diffgain0905']-$_SESSION['frais']-$_SESSION['spread'],2);
		$totaldiffgain0910=round($totaldiffgain0910+$data['diffgain0910']-$_SESSION['frais']-$_SESSION['spread'],2);
		
	$line++;
	}

	/*ajout de la ligne total*/
	if($simplified==0)
	{
		$stattable=$stattable.
		"<tr>
		<td>Total</td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>"
		.colorvalue($totalgain0900)
		.colorvalue($totalgain0905)
		.colorvalue($totalgain0910)
		.colorvalue($totalgainopti0900)
		.colorvalue($totalgainopti0905)
		.colorvalue($totalgainshort)
		.colorvalue($totalgainshortopti).
		"<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>"
		.colorvalue($totaldiffgain0900)
		.colorvalue($totaldiffgain0905)
		.colorvalue($totaldiffgain0910)
		.
		"<td></td>
		</tr></table>
		";
	}
	if($simplified==1)
	{
		$stattable=$stattable.
		"<tr>
		<td>Total</td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		"
		.colorvalue($totalgain0900)
		.colorvalue($totalgainopti0900)
		.colorvalue($totalgainshort)
		.colorvalue($totalgainshortopti).
		"
		</tr></table>
		";
	}
	
	/*fin du tableau jour*/
	$totaldaygain0900=$totaldaygain0900+($daygain0900/$stocknumber);
	$daytable0900=$daytable0900."<tr>".colorvalue(round($daygain0900/$stocknumber-$_SESSION['frais']-$_SESSION['spread'],2))."</tr>";
	$daytable0900=$daytable0900."<tr>".colorvalue(round($totaldaygain0900,2))."</tr></table>";
	$daytable0900=strstr($daytable0900,"%</td>");
	$daytable0900=substr($daytable0900,6);
	$daytable0900="<table id=daytable><tr id=title><td>Gain Opti O".$daytable0900;
	
	
	$totaldaygain0905=$totaldaygain0905+($daygain0905/$stocknumber);
	$daytable0905=$daytable0905."<tr>".colorvalue(round($daygain0905/$stocknumber-$_SESSION['frais']-$_SESSION['spread'],2))."</tr>";
	$daytable0905=$daytable0905."<tr>".colorvalue(round($totaldaygain0905,2))."</tr></table>";
	$daytable0905=strstr($daytable0905,"%</td>");
	$daytable0905=substr($daytable0905,6);
	$daytable0905="<table id=daytable><tr id=title><td>Gain Opti O+5".$daytable0905;
	
	/*retour tableaux*/
	/*$stattable=$stattable.$daytable0900;*/
	/*$stattable=$stattable.$daytable0905;*/
	return $stattable;
}



/*affichage du formulaire*/

?>
<div id=header>
<div id=momentum>
<form method="post" action=
<?php
	echo "stats2.php?simplified=".$simplified."&display=".$display;
?>
>
Limite momentum O+5 :
<input type="text" value="<?php if(isset($_SESSION['momentum0905'])){echo $_SESSION['momentum0905'];}?>" name="momentum0905" />
%
<p>
Limite momentum O+10 :
<input type="text" value="<?php if(isset($_SESSION['momentum0910'])){echo $_SESSION['momentum0910'];}?>" name="momentum0910" />
%

</p>
<input type="submit" value="Valider">
</form>
</div>

<div id=categories>
<form method="post" action=
<?php
	echo "stats2.php?simplified=".$simplified."&display=".$display;
?>
>
Cat1 (N,S,M,C):
<input type="text" value="<?php if(isset($_SESSION['cat1'])){echo $_SESSION['cat1'];}?>" name="cat1" />
<p>
Cat2 (inf,0.25,1,10):
<input type="text" value="<?php if(isset($_SESSION['cat2'])){echo $_SESSION['cat2'];}?>" name="cat2" />
<p>
Cat3 (A,B,C):
<input type="text" value="<?php if(isset($_SESSION['cat3'])){echo $_SESSION['cat3'];}?>" name="cat3" />
<p>
Volume min:
<input type="text" value="<?php if(isset($_SESSION['minvolume'])){echo $_SESSION['minvolume'];}?>" name="minvolume" />
</p>
<p>
Volume max:
<input type="text" value="<?php if(isset($_SESSION['maxvolume'])){echo $_SESSION['maxvolume'];}?>" name="maxvolume" />

</p>
<input type="submit" value="Valider">
</form>
</div>


<div id=frais>
<form method="post" action=
<?php
	echo "stats2.php?simplified=".$simplified."&display=".$display;
?>
>
Frais :
<input type="text" value="<?php if(isset($_SESSION['frais'])){echo $_SESSION['frais'];}?>" name="frais" />
%
<p>
Spread :
<input type="text" value="<?php if(isset($_SESSION['spread'])){echo $_SESSION['spread'];}?>" name="spread" />
%

</p>
<input type="submit" value="Valider">
</form>
</div>


<div id=X>
<form method="post" action=
<?php
	echo "stats2.php?simplified=".$simplified."&display=".$display;
?>
>
X= :
<input type="text" value="<?php if(isset($_SESSION['X'])){echo $_SESSION['X'];}?>" name="X" />
%
<p>
Xfactor= :
<input type="text" value="<?php if(isset($_SESSION['Xfactor'])){echo $_SESSION['Xfactor'];}?>" name="Xfactor" />
<p>
Y= :
<input type="text" value="<?php if(isset($_SESSION['Y'])){echo $_SESSION['Y'];}?>" name="Y" />
%
</p><p>
<p>
Z= :
<input type="text" value="<?php if(isset($_SESSION['Z'])){echo $_SESSION['Z'];}?>" name="Z" />
%
</p><p>
<input type="submit" value="Valider">
</p>
</form>
</div>

<div id=logic>
Logique de vente
<form method="post">
<p><input type= "radio" name="logic" value="1" <?php if($_SESSION['logic']==1){echo "checked";}?>> 1 : Vente à partir de 9h00</p>
<p><input type= "radio" name="logic" value="2" <?php if($_SESSION['logic']==2){echo "checked";}?>> 2 : Vente à partir de 9h05</p>
<p><input type= "radio" name="logic" value="3" <?php if($_SESSION['logic']==3){echo "checked";}?>> 3 : Vente à partir de l'achat opti</p>
<p><input type= "radio" name="logic" value="4" <?php if($_SESSION['logic']==4){echo "checked";}?>> 4 : Vente à partir 9h05 et après achat opti </p>
<p><input type="submit" value="Valider"></p>
</form>
</div>


<div id=variation>
<form method="post" action=
<?php
	echo "stats2.php?simplified=".$simplified."&display=".$display;
?>
>
Variation reco + :
<input type="text" value="<?php if(isset($_SESSION['variationpos'])){echo $_SESSION['variationpos'];}?>" name="variationpos" />
%
<p></p>
Variation reco - :
<input type="text" value="<?php if(isset($_SESSION['variationneg'])){echo $_SESSION['variationneg'];}?>" name="variationneg" />
%
<p></p>
<input type="submit" value="Valider">
</form>


<form method="post" action=
<?php
	echo "stats2.php?simplified=".$simplified."&display=".$display;
?>
>
<p>
Analyste : 
     <select name="analyst">
	 <option value="" <?php if($_SESSION['analyst']==""){echo 'selected="selected"';}?>>Tous</option>
	 <?php
	 foreach ($analysts as $key)
	{
		?>
		<option value="<?php echo $key?>"<?php if($_SESSION['analyst']==$key){echo 'selected="selected"';}?>><?php echo $key;?></option>
		<?php
	}
	 ?>
     </select>
	<p></p>
     <input type="submit" value="Valider" title="Analyste" />

</p>
</form>
</div>

<form method="post" action=
<?php
	echo "stats2.php?simplified=".$simplified."&display=all";
?>
>
<input type="submit" value="Affichage global" />
</form>

<form method="post" action=
<?php
	echo "stats2.php?simplified=".$simplified."&display=week";
?>
>
<input type="submit" value="Affichage par semaine" />
</form>

<form method="post" action=
<?php
	echo "stats2.php?simplified=".!$simplified."&display=".$display;
?>
>
<input type="submit" value=
<?php
if($simplified==1)
	{echo "'Mode simplifié On'";}
if($simplified==0)
	{echo "'Mode simplifié Off'";}
?>
/>
</form>
<p>&nbsp;</p>
</div>

<div id=retour>
<p>
<a href="./index2.php">Retour</a>
</p>
</div>


<div id=stats>
<?php
/*affichage des données*/
if($display=="all")
	{
	echo stattable(0,100000000000000,$simplified);
	}


if($display=="week")
{	
	$time=strtotime('next Monday');
	while($time>1511996400)
	{
		?>
		<p>
		Semaine du <?php
		echo date("d-m-Y",$time-(7*24*3600));
		?> au <?php
		echo date("d-m-Y",$time-1);
		
		?>
		</p><div id=week><?php
		echo stattable($time-(7*24*3600),$time,$simplified);
		$time=$time-(7*24*3600);
		?>
		</div>
		<?php
	}
}

?>
</div>

<div id=retour>
<p>
<a href="./index2.php">Retour</a>
</p>
</div>