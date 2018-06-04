<?php
$file = 'log.txt';
$current = file_get_contents($file);
$current.="\n";
$log=str_replace("\n","<br>",$current); 
echo $log;