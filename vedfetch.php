<?php
include('simple_html_dom.php');

$curl = curl_init('http://www.google.fr/search?q=bnp+paribas&hl=fr&ie=utf-8&oe=utf-8');
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, false);

$curl_scraped_page = curl_exec($curl);

curl_close($curl);

$html = new simple_html_dom();
$html->load($curl_scraped_page);

$newsdiv=$html->find('*[class="_sxc"]', 3);
$link=$newsdiv->find('*[class="_UXb _Jhd"]', 0);
echo $link;
