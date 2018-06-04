<?php
$file = 'log.txt';
$current = file_get_contents($file);
$current.="\n";

if(isset($_GET['stock']))
{
	$current.=date("Y-m-d H:i:s")." type=".$_GET['type']." stock=".$_GET['stock']." size=".$_GET['size']." algo=".$_GET['algo']." max=".$_GET['max']." LastPrice=".$_GET['LastPrice'];
}

if(isset($_GET['cash']))
{
	$current.=date("Y-m-d H:i:s")." cash=".$_GET['cash'];
}


if(isset($_POST['message']))
{
	$current.=date("Y-m-d H:i:s").$_POST['message'];
}

file_put_contents($file, $current);

echo "success";