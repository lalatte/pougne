<?php 
session_start();


/*gestion des variables get et de session*/

/*MOMENTUMS*/

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
	global $totalgainopti0900;
	$totalgainopti0900=0;
	$totalgainopti0905=0;
	$totaldiffgain0900=0;
	$totaldiffgain0905=0;
	$totaldiffgain0910=0;
	$totalgainfullopti=0;
	$daygain0900=0;
	$daygain0905=0;
	$globalgain=0;
	$totaldaygain0900=0;
	$totaldaygain0905=0;
	$totalglobalgain=0;
	$daydate="";
	$stocknumber=1;
	$stocknumberstrat=0;
	$daytable0900="";
	$daytable0905="";
	$daytableglobal="";
	
	include('dbconnect.php');
	include('colorvalue.php');
	include('sell.php');
	include('sell0905.php');
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
			<p>Trigger Google</p>
			</td>
			<td>
			<p>Maximum Google
			</td>
			<td>
			<p>Heure vente Google
			</td>
			<td>
			<p>Prix vente Google
			</td>
			<td>
			<p>Trigger Degiro</p>
			</td>
			<td>
			<p>Maximum Degiro
			</td>
			<td>
			<p>Heure vente Degiro
			</td>
			<td>
			<p>Prix vente Degiro
			</td>
			<td>
			<p>Max 09h05</p>
			</td>
			<td>
			<p>Heure vente 0905 Google</p>
			</td>
			<td>
			<p>Prix vente 0905 Google</p>
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
			<p>Variation CAC40
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
		<p>Vol. Moyen
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
		</tr>
		";
	}

	/*CREATION DU TEXTE DE LA REQUETE*/
	
	$querytext="SELECT * FROM news WHERE date>'$startdate' AND date<'$enddate'";
	
	if(isset($_SESSION['momentum0905']))
	{	
		if($_SESSION['momentum0905']!="")
		{
			$querytext=$querytext."AND momentum0905>='{$_SESSION['momentum0905']}'";
		}
		if($_SESSION['momentum0910']!="")
		{
			$querytext=$querytext."AND momentum0910>='{$_SESSION['momentum0910']}'";
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
		
	/*echo $querytext;/*
	
	/*requête DB*/
	$result=$database->query($querytext);
	
	$line=1;
	
	while($data=$result->fetch())
	{
		/*calcul du gain optimisé*/
		$resultdegiro=optidegiro($data['datadegiro'],$data['data'],$_SESSION['X'],$_SESSION['Z'], $_SESSION['Xfactor'], $data['gain0900']);
		$resultgoogle=sell($data['data'],$_SESSION['X'],$_SESSION['Z'],$_SESSION['Xfactor']);
		
		$selltimedegiro=$resultdegiro['LastTime']; //formatage heure vente degiro
		if($selltimedegiro=="No data")
		{
			$selltimedegiro="23:59:00";
		}
		if($selltimedegiro=="Fermeture")
		{
			$selltimedegiro="17:30:00";
		}
		if(strstr($selltimedegiro,"Fermeture")!=false)
		{
			$selltimedegiro=str_replace("Fermeture ","",$selltimedegiro);
		}
		$selltimedegiro=strtotime(date("H:i",strtotime($selltimedegiro)));
		
		
		$selltimegoogle=$resultgoogle['selltime']; //formatage heure vente google
		if($selltimegoogle=="Fermeture")
		{
			$selltimegoogle="17:30:00";
		}
		if(strstr($selltimegoogle,"Fermeture")!=false)
		{
			$selltimegoogle=str_replace("Fermeture ","",$selltimegoogle);
		}
		$selltimegoogle=strtotime(str_replace("h",":",$selltimegoogle));
		
		if($selltimedegiro<=$selltimegoogle) //choix de la vente la plus tôt entre degiro et google
		{
			$sellprice=$resultdegiro['LastPrice'];
			$colordegiro=1;
			$colorgoogle=2;
		}
		else
		{
			$sellprice=$resultgoogle['sellprice'];
			$colordegiro=2;
			$colorgoogle=1;
		}
		
			
		/*calcul du gain achat+vente opti*/
		$buyprice=buy($data['data'],$_SESSION['Y'],2)['buyprice'];
		
		if($buyprice!=0&&$buyprice!="")
		{
			$gainfullopti=100*(($sellprice/$buyprice)-1);
			$gainfullopti=round($gainfullopti,2);
		}
		else
		{
			$gainfullopti=0;
		}	
			
		if($data['open']!=0 && $sellprice!="No data")
		{
		$gainopti0900=(($sellprice-$data['open'])/$data['open'])*100;
		}
		else
		{
			$gainopti0900=0;
		}
				
		if($data['price0905']!=0 && $sellprice!="No data")
		{	
			$gainopti0905=(($sellprice-$data['price0905'])/$data['price0905'])*100;
		}
		else
		{
			$gainopti0905=0;
		}
		
		
		/*calcul du gain 0905*/
		
		$sellprice0905=sell0905($data['data'],$_SESSION['X'],$_SESSION['Z'])['sellprice'];
		
		/*calcul des gains opti*/
		
		if($data['open']!=0 && $sellprice!="No data")
		{
		$gainopti0900=(($sellprice-$data['open'])/$data['open'])*100;
		}
		else
		{
			$gainopti0900=0;
		}
		
		if($data['price0905']!=0 && $sellprice!="No data")
		{	
			$gainopti0905=(($sellprice0905-$data['price0905'])/$data['price0905'])*100;
		}
		else
		{
			$gainopti0905=0;
		}
				
		$gainopti0900=round($gainopti0900,2);
		$gainopti0905=round($gainopti0905,2);
		
		/*calcul du gain par jour*/
		if(gmdate("d-m-Y",$data['date'])==$daydate) //si une nouvelle action à la même date est trouvée
		{
			$daygain0900=$daygain0900+$gainopti0900;
			$daygain0905=$daygain0905+$gainopti0905;
			
			if($data['openchange']>-2 && $data['openchange']<7 && $data['globalbad']==0) //filtrage du fixing pour calcul du gain global
			{	
				if($data['cat2']=="0.25" || $data['cat2']=="1")
				{
					$globalgain=$globalgain+$gainopti0900;
					$stocknumberstrat=$stocknumberstrat+1;
				}
				if($data['cat2']=="10" && $data['momentum0905']>=0)
				{
					$globalgain=$globalgain+$gainopti0905;
					$stocknumberstrat=$stocknumberstrat+1;
				}
			}
				
			$stocknumber=$stocknumber+1;
			$daytable0900=$daytable0900."<tr><td><p>&nbsp;</p></td></tr>";
			$daytable0905=$daytable0905."<tr><td><p>&nbsp;</p></td></tr>";
			$daytableglobal=$daytableglobal."<tr><td><p>&nbsp;</p></td></tr>";
		}
		
		if(gmdate("d-m-Y",$data['date'])!=$daydate) //si une nouvelle date est trouvée
		{
			//enregistrement du gain jour précédent
			
			$totaldaygain0900=$totaldaygain0900+$daygain0900/$stocknumber-$_SESSION['frais']-$_SESSION['spread'];
			$totaldaygain0905=$totaldaygain0905+$daygain0905/$stocknumber-$_SESSION['frais']-$_SESSION['spread'];
			if($stocknumberstrat!=0) // si fixing dans les limites, ajout au gain global
			{
				$totalglobalgain=$totalglobalgain+$globalgain/$stocknumberstrat-$_SESSION['frais']-$_SESSION['spread'];
			}
			$daytable0900=$daytable0900."<tr>".colorvalue(round($daygain0900/$stocknumber-$_SESSION['frais']-$_SESSION['spread'],2))."</tr>";
			$daytable0905=$daytable0905."<tr>".colorvalue(round($daygain0905/$stocknumber-$_SESSION['frais']-$_SESSION['spread'],2))."</tr>";
			if($stocknumberstrat!=0) //si fixing dans les limites, affichage du gain strat 
			{
				$daytableglobal=$daytableglobal."<tr>".colorvalue(round($globalgain/$stocknumberstrat-$_SESSION['frais']-$_SESSION['spread'],2))."</tr>";
			}
			else // si fixing hors limite, afichage gain zéro
			{
				$daytableglobal=$daytableglobal."<tr>".colorvalue(0)."</tr>";
			}
						
			
			//lecture de la nouvelle date
			$stocknumber=1;
			$daygain0900=$gainopti0900; //reset des gains jour
			$daygain0905=$gainopti0905;
			if($data['openchange']>-2 && $data['openchange']<7 && $data['globalbad']==0) //filtrage du fixing pour calcul du gain global
			{	
				if($data['cat2']=="inf") // si stock inf, reset du gain global
				{
					$globalgain=0;
					$stocknumberstrat=0;
				}
				if($data['cat2']=="0.25" || $data['cat2']=="1")
				{
					$globalgain=$gainopti0900;
					$stocknumberstrat=1;
				}
				if($data['cat2']=="10")
				{
					if($data['momentum0905']>=0)
						{
							$globalgain=$gainopti0905;
							$stocknumberstrat=1;
						}
					if($data['momentum0905']<0) // si momentum négatif, reset du gain global
						{
							$globalgain=0;
							$stocknumberstrat=0;
						}
				}
			}
			else // si le fixing est hors limites, reset du gain global
			{
				$globalgain=0;
				$stocknumberstrat=0;
			}
			
			$daydate=gmdate("d-m-Y",$data['date']); //enregistrement de la nouvelle date
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
			buy($data['data'],$_SESSION['Y'],2)['min']
			."
			</td>
			
			<td>	
			".
			buy($data['data'],$_SESSION['Y'],2)['buytime']
			."
			</td>
			
			<td>	
			".
			buy($data['data'],$_SESSION['Y'],2)['buyprice']
			."
			</td>
			
			<td>	
			".
			$resultgoogle['trigger']
			."
			</td>
			
			<td>	
			".
			$resultgoogle['max']
			."
			</td>
			
			".
			colorvalue($resultgoogle['selltime'],$colorgoogle)
			."
			
			".
			colorvalue($resultgoogle['sellprice'],$colorgoogle)
			."
			
			<td>	
			".
			$resultdegiro['trigger']
			."
			</td>
			
			<td>	
			".
			$resultdegiro['max']
			."
			</td>
			
			".
			colorvalue($resultdegiro['LastTime'],$colordegiro)
			."
			
			".
			colorvalue($resultdegiro['LastPrice'],$colordegiro)
			."
			
			<td>
			".
			sell0905($data['data'],$_SESSION['X'],$_SESSION['Z'])['max']
			."
			</td>
			
			<td>
			".
			sell0905($data['data'],$_SESSION['X'],$_SESSION['Z'])['selltime']
			."
			</td>
			
			<td>
			".
			sell0905($data['data'],$_SESSION['X'],$_SESSION['Z'])['sellprice']
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
			colorvalue($data['cac40change'])
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
			
			<td>".
			round(($data['volume']/1000000),1)." M"
			."
			</td>
			
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
			</tr>";
		}

		$stattable=$stattable.$datatable;
		$totalgain0900=round($totalgain0900+$data['gain0900']-$_SESSION['frais']-$_SESSION['spread'],2);
		$totalgain0905=round($totalgain0905+$data['gain0905']-$_SESSION['frais']-$_SESSION['spread'],2);
		$totalgain0910=round($totalgain0910+$data['gain0910']-$_SESSION['frais']-$_SESSION['spread'],2);
		$totalgainfullopti=round($totalgainfullopti+$gainfullopti-$_SESSION['frais']-$_SESSION['spread'],2);
		$totalgainopti0900=round($totalgainopti0900+$gainopti0900-$_SESSION['frais']-$_SESSION['spread'],2);
		$totalgainopti0905=round($totalgainopti0905+$gainopti0905-$_SESSION['frais']-$_SESSION['spread'],2);
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
		<td></td>
		<td></td>
		<td></td>
		<td></td>"
		.colorvalue($totalgain0900)
		.colorvalue($totalgain0905)
		.colorvalue($totalgain0910)
		.colorvalue($totalgainopti0900)
		.colorvalue($totalgainopti0905).
		"<td></td>"
		.colorvalue($totalgainfullopti)
		."
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
		"
		.colorvaluebold($totalgain0900)
		.colorvaluebold($totalgain0905)
		.colorvaluebold($totalgain0910)
		.colorvaluebold($totalgainopti0900)
		.colorvaluebold($totalgainopti0905)
		."
		</tr>
		<tr>
		<td>Par ligne</td>
		<td>
		<td>
		<td>
		"
		.colorvalue(round($totalgain0900/($line-1),2))
		.colorvalue(round($totalgain0905/($line-1),2))
		.colorvalue(round($totalgain0910/($line-1),2))
		.colorvalue(round($totalgainopti0900/($line-1),2))
		.colorvalue(round($totalgainopti0905/($line-1),2))
		."
		</tr>
		</table>
		";
	}
	
	/*fin du tableau jour*/
	$totaldaygain0900=$totaldaygain0900+($daygain0900/$stocknumber);
	$daytable0900=$daytable0900."<tr>".colorvalue(round($daygain0900/$stocknumber-$_SESSION['frais']-$_SESSION['spread'],2))."</tr>";
	$daytable0900=$daytable0900."<tr>".colorvaluebold(round($totaldaygain0900,2))."</tr>"; //total
	$daytable0900=$daytable0900."<tr>".colorvalue(round(($totaldaygain0900/($line-1)),2))."</tr></table>"; //total par ligne
	$daytable0900=strstr($daytable0900,"</tr>"); // suppression du premier total jour
	$daytable0900=substr($daytable0900,5);
	$daytable0900="<table id=daytable><tr id=title><td>Gain Opti O".$daytable0900;
	
	
	$totaldaygain0905=$totaldaygain0905+($daygain0905/$stocknumber);
	$daytable0905=$daytable0905."<tr>".colorvalue(round($daygain0905/$stocknumber-$_SESSION['frais']-$_SESSION['spread'],2))."</tr>";
	$daytable0905=$daytable0905."<tr>".colorvaluebold(round($totaldaygain0905,2))."</tr>"; //total
	$daytable0905=$daytable0905."<tr>".colorvalue(round(($totaldaygain0905/($line-1)),2))."</tr></table>"; //total par ligne
	$daytable0905=strstr($daytable0905,"</tr>");   // suppression du premier total jour
	$daytable0905=substr($daytable0905,5);
	$daytable0905="<table id=daytable><tr id=title><td>Gain Opti O+5".$daytable0905;
	
	if($stocknumberstrat!=0)
	{
		$totalglobalgain=$totalglobalgain+($globalgain/$stocknumberstrat);
		$daytableglobal=$daytableglobal."<tr>".colorvalue(round($globalgain/$stocknumberstrat-$_SESSION['frais']-$_SESSION['spread'],2))."</tr>";
	}
	else
	{
		$daytableglobal=$daytableglobal."<tr>".colorvalue(0)."</tr>";
	}
	$daytableglobal=$daytableglobal."<tr>".colorvaluebold(round($totalglobalgain,2))."</tr>"; //total
	$daytableglobal=$daytableglobal."<tr>".colorvalue(round(($totalglobalgain/($line-1)),2))."</tr></table>"; //total par ligne
	$daytableglobal=strstr($daytableglobal,"</tr>");  // suppression du premier total jour
	$daytableglobal=substr($daytableglobal,5);
	$daytableglobal="<table id=daytable><tr id=title><td>Gain Strat".$daytableglobal;
	
	/*retour tableaux*/
	$stattable=$stattable.$daytable0900;
	$stattable=$stattable.$daytable0905;
	$stattable=$stattable.$daytableglobal;
	return $stattable;
}



/*affichage du formulaire*/

?>
<div id=header>
<div id=momentum>
<form method="post" action=
<?php
	echo "stats.php?simplified=".$simplified."&display=".$display;
?>
<p>
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
	echo "stats.php?simplified=".$simplified."&display=".$display;
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
	echo "stats.php?simplified=".$simplified."&display=".$display;
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
	echo "stats.php?simplified=".$simplified."&display=".$display;
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

<form method="post" action=
<?php
	echo "stats.php?simplified=".$simplified."&display=all";
?>
>
<input type="submit" value="Affichage global" />
</form>

<form method="post" action=
<?php
	echo "stats.php?simplified=".$simplified."&display=week";
?>
>
<input type="submit" value="Affichage par semaine" />
</form>

<form method="post" action=
<?php
	echo "stats.php?simplified=".!$simplified."&display=".$display;
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
<a href="./index.php">Retour</a>
</p>
</div>

<div id=stats>
<?php
/*affichage des données*/


if($display=="all")
	{
	$stattable=stattable(0,100000000000000,$simplified);
	}
	
echo "<h4>Total gain opti 0900 : ".$totalgainopti0900."</h4>";
echo $stattable;

if($display=="week")
{	
	$time=strtotime('next Monday');
	while($time>1502316000)
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
