<?php 

if(isset($_GET['stock']))
{
	$stock=$_GET['stock'];
}


if(isset($_POST['stock']))
{
	$stock=$_POST['stock'];
}

if(isset($stock))
{
	$data=file_get_contents("./degiro/".$stock.".txt");
	$data=str_replace("\n","</br>",$data);
	echo $data;
}