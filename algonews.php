<?php
include('simple_html_dom.php');
include('parsearticle.php');

$keyword="air+france";

$curl = curl_init('https://www.google.fr/search?q='.$keyword.'&ie=utf-8&oe=utf-8&tbm=nws');
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, false);

$curl_scraped_page = curl_exec($curl);

$url="http://www.google.fr";
$curl_scraped_page = preg_replace("<head>", "<head><base href='$url' />", $curl_scraped_page, 1);

curl_close($curl);

$html = new simple_html_dom();
$html->load($curl_scraped_page);


$newsrow=$html->find('.g');

?>
<html>
<head>
<base href="https://www.google.fr">
</head>
<?php

for($i=0;$i<sizeof($newsrow);$i++)
{	
	$news=$newsrow[$i]->find('td',0);
	$links=$news->find('a');
	$info=$news->find('.f');		
	
	for($j=0;$j<sizeof($links);$j++)
	{
		?><p><?php
		
		echo $links[$j];
		?></p><?php
		?><p><?php
		if(isset ($info[$j]))
		{
			echo $info[$j];
		}
		?></p><?php
		$str=substr(($links[$j]->href),7);
		$str = substr($str, 0, strpos($str, "sa=U"));
		$url=substr($str, 0, -5);
		
		echo parsearticle($url);
		
		
		
	
	}	
	
}
?>
</html>

