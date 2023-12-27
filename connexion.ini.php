<?php
try{
    $connexion = new PDO("mysql:host=localhost;dbname=basevol","root","");
}
catch (PDOException $exception){
    echo $exception->getMessage();
}
$query = $connexion->prepare("SELECT * FROM avions");
$query->setFetchMode(PDO::FETCH_BOTH);
$query->execute();

function CloseDB($connexion){
    $connexion = null;
}
?>