<?php
function displaytable3($stock,$variation,$analyst,$website)

{	
	include('dbconnect.php');
	include('colorvalue.php');
	/*include('testgoogle.php');*/

	global $globalbad;
	global $cac40change;
	global $cac40momentum0905;
	global $cac40momentum0910;
	global $cac40gain0900;
	global $cac40gain0905;
	global $cac40gain0910;
	
	$globalbad=0;
	
	$variation=round($variation, 2);
	
	$file="./degiro/".$stock.".txt";
	$datadegiro=file_get_contents($file);
	
	/*récupération de la requête à google finance*/
	
	if($stock=="PX1")
	{
		$curl = curl_init('https://finance.google.com/finance/getprices?q='.$stock.'&x=INDEXEURO&i=60&p=11d&f=d,c,h,l,o,v');
	}
	else
	{
		$curl = curl_init('https://finance.google.com/finance/getprices?q='.$stock.'&x=EPA&i=60&p=11d&f=d,c,h,l,o,v');
	}

	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, false);

	$curl_scraped_page = curl_exec($curl);

	curl_close($curl);

	$lines = new simple_html_dom();
	$lines->load($curl_scraped_page);
	
	/*$lines->load($datagoogle);*/
	
	$lines=(string)$lines;
	
	$lines=str_replace("TIMEZONE_OFFSET=120","", $lines);
	$lines=str_replace("TIMEZONE_OFFSET=-120","", $lines);

	//test longueur de la réponse
	$new=preg_replace('/\s+/', '<p>', $lines);
	$count=explode('<p>',$new);
	if(count($count)<20)
	{	
		?><p>Cours : <?php echo $stock;
		?></p><?php
		return "Stock not found";
	}

	/*affichage résultats*/
	
	if($stock!="PX1")
	{
		?><p>Cours : <?php echo $stock;
		?></p><?php
	}
	
	$price=getprice(date("d"),"close",$lines);
	$open=getprice(date("d"),"open",$lines);
	$closepreviousday=getprice(date("d",strtotime("-1 weekdays")),"close",$lines);
	$daychange=(($price-$closepreviousday)/$closepreviousday)*100;
	$openchange=(($open-$closepreviousday)/$closepreviousday)*100;
		
	/*récupération prix et calcul des gains*/
	
	if($open!=0)
	{
		$gain0900=($price-$open)/$open*100;
	}
	else
	{
		$gain0900=0;
	}
	
	$price0903=getprice(date("d"),3,$lines);	
	if($price0903=="Price not found")
	{
		$gain0903=0;
	}
	else
	{
		$gain0903=(($price-$price0903)/$price0903)*100;
	}
	
	$price0905=getprice(date("d"),5,$lines);	
	if($price0905=="Price not found")
	{
		$gain0905=0;
	}
	else
	{
		$gain0905=(($price-$price0905)/$price0905)*100;
	}
	
	$price0910=getprice(date("d"),10,$lines);	
	if($price0910=="Price not found")
	{
		$gain0910=0;
	}
	else
	{
		$gain0910=(($price-$price0910)/$price0910)*100;
	}
	
	$price10day=getprice(date("d",strtotime("-10 weekdays")),"open",$lines);
	$price3day=getprice(date("d",strtotime("-3 weekdays")),"open",$lines);
	
	/*calcul des momentums*/
	if($price0903!="Price not found")
	{
		$momentum0903=round(($price0903-$open)/$open*100,2);
	}
	else
	{
		$momentum0905="Error";
	}
	
	if($price0905!="Price not found")
	{
		$momentum0905=round(($price0905-$open)/$open*100,2);
	}
	else
	{
		$momentum0905="Error";
	}
	
	if($price0905!="Price not found"&&$price0910!="Price not found")
	{
		$momentum0910=round(($price0910-$price0905)/$price0905*100,2);
	}
	else
	{
		$momentum0910="Error";
	}

	if($price10day!="Price not found")
	{
		$momentum10day=round(($open-$price10day)/$price10day*100,2);
	}
	else
	{
		$momentum10day="Error";
	}
	
	if($price3day!="Price not found")
	{
		$momentum3day=round(($open-$price3day)/$price3day*100,2);
	}
	else
	{
		$momentum3day="Error";
	}
	
	/*enregistrement valeurs cac40*/
	if($stock=="PX1")
	{
		$cac40change=$daychange;
		$cac40momentum0905=$momentum0905;
		$cac40momentum0910=$momentum0910;
		$cac40gain0900=$gain0900;
		$cac40gain0905=$gain0905;
		$cac40gain0910=$gain0910;
		
	}
	
	$diffcac40=($daychange-$cac40change);
	$diffgain0900=$gain0900-$cac40gain0900;
	$diffgain0905=$gain0905-$cac40gain0905;
	$diffgain0910=$gain0910-$cac40gain0910;
	
	/*affichage du tableau*/
	$table=
	"<table id=results>
	<tr>
	<td>
	<p>Reco
	</td>
	<td>
	<p>Analyste
	</td>
	<td>
	<p>Cours actuel
	</td>
	<td>
	<p>Ouverture
	</td>
	<td>
	<p>Fermeture veille
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
	<p>Cours O+3
	</td>
	<td>
	<p>Cours O+5
	</td>
	<td>
	<p>Cours O+10
	</td>
	<td>
	<p>Momentum O+3
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
	<p>Gain (O+3)
	</td>
	<td>
	<p>Gain (O+5)
	</td>
	<td>
	<p>Gain (O+10)
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
	</tr>

	<tr>
	
	".
	colorvalue($variation)
	."
	
	<td>".
	$analyst
	.
	"</td>
	
	<td>".
	$price
	.
	"</td>

	<td>".
	
	$open
	."
	</td>

	<td>
	".
	$closepreviousday
	."
	</td>

	".
	colorvalue(round($daychange,2))
	."
	
	".
	colorvalue(round($openchange,2))
	."
	
	".
	colorvalue($momentum10day)
	."
	
	".
	colorvalue($momentum3day)
	."
	
	<td>
	".
	$price0903
	."
	</td>
	
	<td>
	".
	$price0905
	."
	</td>

	<td>
	".
	$price0910
	."
	</td>
	
	".
	colorvalue($momentum0903)
	."
	
	".
	colorvalue($momentum0905)
	."
	
	".
	colorvalue($momentum0910)
	."
	
	".
	colorvalue(round($gain0900,2))
	."
	
	".
	colorvalue(round($gain0903,2))
	."
	
	".
	colorvalue(round($gain0905,2))
	."

	".
	colorvalue(round($gain0910,2))
	."
	
	".
	colorvalue(round($cac40change,2))
	."
	
	".
	colorvalue(round($diffcac40,2))
	."
	
	".
	colorvalue(round($cac40momentum0905,2))
	."
	
	".
	colorvalue(round($cac40momentum0910,2))
	."
	
	".
	colorvalue(round($cac40gain0900,2))
	."
	
	".
	colorvalue(round($cac40gain0905,2))
	."
	
	".
	colorvalue(round($cac40gain0910,2))
	."
	
	".
	colorvalue(round($diffgain0900,2))
	."
	
	".
	colorvalue(round($diffgain0905,2))
	."
	
	".
	colorvalue(round($diffgain0910,2))
	."
	</tr></table>";
	
				
	/*enregistrement base de données*/
	if($stock!="PX1"&&(isset($_POST['Enregistrer'])||isset($_GET['Enregistrer']))) //si le stock n'est pas le cac40 et que l'on a cliqué sur enregistrer
	{
		$timelimit=strtotime('Today');
		$request1=$database->query("SELECT * FROM recommandations WHERE stock='$stock' AND date>'$timelimit'");
		
		$request2=$database->query("SELECT * FROM codes WHERE code='".$stock."'");
		$data2=$request2->fetch();
		$cat1=$data2['cat1'];
		$cat2=$data2['cat2'];
		$cat3=$data2['cat3'];
		$volume=$data2['volume'];
		
		if(!isset($website))
		{
			$website="manual";
		}
	
		if($request1->fetch()==FALSE) //si aucune news enregistrée correspondant à la date
		{
			$request = $database->prepare('INSERT INTO recommandations (date, stock, website, analyst, variation, cat1, cat2, cat3, volume, data, datadegiro, globalbad, price, open, closepreviousday, daychange, openchange, cac40change, diffcac40, cac40momentum0905, cac40momentum0910, cac40gain0900, cac40gain0905, cac40gain0910, momentum10day, momentum3day, price0903, price0905, price0910, momentum0903, momentum0905, momentum0910, gain0900, gain0903, gain0905, gain0910, diffgain0900, diffgain0905, diffgain0910) 
											VALUES (:date, :stock, :website, :analyst, :variation, :cat1, :cat2, :cat3, :volume, :data, :datadegiro, :globalbad, :price, :open, :closepreviousday, :daychange, :openchange, :cac40change, :diffcac40, :cac40momentum0905, :cac40momentum0910, :cac40gain0900, :cac40gain0905, :cac40gain0910, :momentum10day, :momentum3day, :price0903, :price0905, :price0910, :momentum0903, :momentum0905, :momentum0910, :gain0900, :gain0903, :gain0905, :gain0910, :diffgain0900, :diffgain0905, :diffgain0910);');
			
			try 
			{	
				$request->execute(array(
				'date' => time(),
				'stock' => $stock,
				'variation' => $variation,
				'website' => $website,
				'analyst' => $analyst,
				'cat1' => $cat1,
				'cat2' => $cat2,
				'cat3' => $cat3,
				'volume' => $volume,
				'data' => $lines,
				'datadegiro' => $datadegiro,
				'globalbad' => $globalbad,
				'price' => $price,
				'open' => $open,
				'closepreviousday' => $closepreviousday,
				'daychange' => round($daychange,2),
				'openchange' => round($openchange,2),
				'cac40change' => round($cac40change,2),
				'diffcac40' => round($diffcac40,2),
				'cac40momentum0905' => round($cac40momentum0905,2),
				'cac40momentum0910' => round($cac40momentum0910,2),
				'cac40gain0900' => round($cac40gain0900,2),
				'cac40gain0905' => round($cac40gain0905,2),
				'cac40gain0910' => round($cac40gain0910,2),
				'momentum10day' => round($momentum10day,2),
				'momentum3day' => round($momentum3day,2),
				'price0903' => $price0903,
				'price0905' => $price0905,
				'price0910' => $price0910,
				'momentum0903' => round($momentum0903,2),
				'momentum0905' => round($momentum0905,2),
				'momentum0910' => round($momentum0910,2),
				'gain0900' => round($gain0900,2),
				'gain0903' => round($gain0903,2),
				'gain0905' => round($gain0905,2),
				'gain0910' => round($gain0910,2),
				'diffgain0900' => round($diffgain0900,2),
				'diffgain0905' => round($diffgain0905,2),
				'diffgain0910' => round($diffgain0910,2),
				));
			}
				
			catch (Exception $exception) 
			{
				die('Erreur : ' . $exception->getMessage());
			}
		}
		else //si une valeur déjà enregistrée est trouvée, mise à jour
		{
			$request1=$database->query("SELECT * FROM recommandations WHERE stock='$stock' AND date>'$timelimit'");
			$data1=$request1->fetch();
			$ID=$data1['ID'];
			
			
			$request = $database->prepare("	UPDATE recommandations 
											SET date= :date, stock = :stock, website= :website, analyst= :analyst, variation= :variation, cat1= :cat1, cat2= :cat2, cat3= :cat3, data = :data, datadegiro= :datadegiro, globalbad = :globalbad, price = :price, open = :open, closepreviousday = :closepreviousday, daychange = :daychange, openchange = :openchange, cac40change = :cac40change, diffcac40 = :diffcac40, cac40momentum0905 = :cac40momentum0905, cac40momentum0910 = :cac40momentum0910, cac40gain0900 = :cac40gain0900, cac40gain0905 = :cac40gain0905, cac40gain0910 = :cac40gain0910, momentum10day = :momentum10day, momentum3day = :momentum3day, price0903= :price0903, price0905 = :price0905, price0910 = :price0910, momentum0903 = :momentum0903, momentum0905 = :momentum0905, momentum0910 = :momentum0910, gain0900 = :gain0900, gain0903= :gain0903, gain0905 = :gain0905, gain0910 = :gain0910, diffgain0900 = :diffgain0900, diffgain0905 = :diffgain0905, diffgain0910 = :diffgain0910
											WHERE ID= :ID");
			
			try 
			{	
				$request->execute(array(
				'date' => time(),
				'stock' => $stock,
				'variation' => $variation,
				'website' => $website,
				'analyst' => $analyst,
				'cat1' => $cat1,
				'cat2' => $cat2,
				'cat3' => $cat3,
				'data' => $lines,
				'datadegiro' => $datadegiro,
				'globalbad' => $globalbad,
				'price' => $price,
				'open' => $open,
				'closepreviousday' => $closepreviousday,
				'daychange' => round($daychange,2),
				'openchange' => round($openchange,2),
				'cac40change' => round($cac40change,2),
				'diffcac40' => round($diffcac40,2),
				'cac40momentum0905' => round($cac40momentum0905,2),
				'cac40momentum0910' => round($cac40momentum0910,2),
				'cac40gain0900' => round($cac40gain0900,2),
				'cac40gain0905' => round($cac40gain0905,2),
				'cac40gain0910' => round($cac40gain0910,2),
				'momentum10day' => round($momentum10day,2),
				'momentum3day' => round($momentum3day,2),
				'price0903' => $price0903,
				'price0905' => $price0905,
				'price0910' => $price0910,
				'momentum0903' => round($momentum0903,2),
				'momentum0905' => round($momentum0905,2),
				'momentum0910' => round($momentum0910,2),
				'gain0900' => round($gain0900,2),
				'gain0903' => round($gain0903,2),
				'gain0905' => round($gain0905,2),
				'gain0910' => round($gain0910,2),
				'diffgain0900' => round($diffgain0900,2),
				'diffgain0905' => round($diffgain0905,2),
				'diffgain0910' => round($diffgain0910,2),
				'ID' => $ID,
				));
			}
			catch (Exception $exception) 
			{
				die('Erreur : ' . $exception->getMessage());
			}
		}
	}
	
	
	return $table;

}
