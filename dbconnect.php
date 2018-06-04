<?php
try
{
    $database = new PDO('mysql:host=localhost;dbname=stock;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

}
catch (Exception $exception)
{
        die('Erreur : ' . $exception->getMessage());
}
?>