<?php
include('dbconnect.php');

$request1=$database->query("SELECT * FROM news");

while ($data1=$request1->fetch())
{
	?><p><?php
	$request2=$database->query("SELECT * FROM codes WHERE code='".$data1['stock']."'");
	$data2=$request2->fetch();
	?><p><?php
	echo $data2['cat1'];
	$request3=$database->query("UPDATE news SET cat1='".$data2['cat1']."' WHERE stock='".$data1['stock']."'");
	$request3=$database->query("UPDATE news SET cat2='".$data2['cat2']."' WHERE stock='".$data1['stock']."'");
	$request3=$database->query("UPDATE news SET cat3='".$data2['cat3']."' WHERE stock='".$data1['stock']."'");
}
	