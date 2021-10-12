<?php
// DECLARATION DES VARIABLES
$hote = "localhost";
$nomdb = "basketdb" ;
$user = "root";
$password = "";
try{
    $connect = new PDO("mysql:host=$hote;charset=utf8", $user, $password);
}
catch(Exception $e){

        die('Erreur : '.$e->getMessage());
}
// Drop de la base de données
$sql = "DROP DATABASE IF EXISTS basketdb";
$query = $connect->prepare($sql);
$query->execute();
// Création de la base de données
$sql = "CREATE DATABASE IF NOT EXISTS car";
$query = $connect->prepare($sql);
$query->execute();
//Connexion à la base de données
try{
    $connect = new PDO("mysql:host=$hote; dbname=car; charset=utf8", $user, $password);

}
catch(Exception $e){
    die('Erreur : '.$e->get)
}