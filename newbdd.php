<?php
// Information de connexion à la base de données
$hote = "localhost";
$nomdb = "car";
$user = "root";
$password = "";
// Connexion
try
{
    $connect = new PDO("mysql:host=$hote;charset=utf8", $user, $password);
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}
// DROP de la base de données
$sql = "DROP DATABASE IF EXISTS car";
$query = $connect->prepare($sql);
$query->execute();
// Création de la base de données
$sql = "CREATE DATABASE IF NOT EXISTS car";
$query = $connect->prepare($sql);
$query->execute();
// connexion  à la base de données
try
{
    $connect = new PDO("mysql:host=$hote; dbname=car; charset=utf8", $user, $password);
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}
// Création de la table :
$sql = "CREATE TABLE constructeur
    (id int NOT NULL PRIMARY KEY,
    nom varchar(255) NOT NULL,
    creation int(11) NOT NULL,
    fondateur varchar(255) NOT NULL,
    pays varchar(255) NOT NULL)";
$query = $connect->prepare($sql);
$query->execute();
// Création de la table :
$sql = "CREATE TABLE voitures
    (id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    constructeur INT(15) NOT NULL,
    nom text NOT NULL,
    descript VARCHAR(255) NOT NULL,
    production INT(15) NOT NULL,
    images TEXT,
    CONSTRAINT voitures_constructeur FOREIGN KEY (constructeur) REFERENCES constructeur(id))";
$query = $connect->prepare($sql);
$query->execute();
// Création de la table de liaison voitures et usine
$sql = "CREATE TABLE usines
    (id INT NOT NULL AUTO_INCREMENT,
    nom VARCHAR(255) NOT NULL,
    PRIMARY KEY (id))";
$query = $connect->prepare($sql);
$query->execute();
// Création de la table des usines
$sql = "CREATE TABLE lienusines (
    idvoitures int(11) NOT NULL,
    idusines int(255) NOT NULL,
    PRIMARY KEY (idvoitures,idusines),
    CONSTRAINT lienvoiture FOREIGN KEY (idvoitures) REFERENCES voitures(id),
    CONSTRAINT lienusines FOREIGN KEY (idusines) REFERENCES usines(id))";
$query = $connect->prepare($sql);
$query->execute();
// connexion aux AP

    $donnee_constructeur = file_get_contents('https://filrouge.uha4point0.fr/Car/constructeurs');
    $constructeur_array = json_decode($donnee_constructeur,true);
   
       
    $donnee_voitures = file_get_contents('https://filrouge.uha4point0.fr/Car/voitures');
    $voitures_array = json_decode($donnee_voitures,true);
// Import des données de l'API catégories dans la table catégories de la base de données
foreach($constructeur_array as $constructeur){
$query = $connect->prepare('INSERT INTO constructeur(id, nom, creation, fondateur, pays) VALUES (:id, :nom, :creation, :fondateur, :pays)');
$query->execute(array(
    'id' => $constructeur['id'],
    'nom' => $constructeur['nom'],
    'creation' => $constructeur['creation'],
    'fondateur' => $constructeur['fondateur'],
    'pays' => $constructeur['pays']
));
}
// Import des données de l'API produits dans la table produits de la base de données
foreach($voitures_array as $car){
    $query = $connect->prepare('INSERT IGNORE INTO voitures(id, constructeur, nom, descript, production, images) VALUES (:id, :constructeur, :nom, :descript, :production, :images)');
    $query->execute(array(
        'id' => $car['id'],
        'constructeur' => $car['constructeur'],
        'nom' => $car['nom'],
        'descript' => $car['description'],
        'production' => $car['production'],
        'images' => $car['image']
    ));
}
foreach ($voitures_array as $car){
    foreach ($car['usines'] as $usines){
        $query = $connect->prepare('INSERT INTO usines(nom) VALUES(:nom)');
        $query->execute(array(
            'nom' => $usines
        ));
    }
}
// Liaison table groupes et genres
foreach ($voitures_array as $car){
    foreach ($car['usines'] as $usines){
// Recupération de l'ID
        $sql = ('SELECT id FROM usines WHERE nom = :nom');
        $query = $connect->prepare($sql);
        $query->execute(array(
            ':nom' => $usines));
        $id_usines = $query->fetch();
//Ajoute lesdonnées à la table
        $sql = "INSERT INTO lienusines(idvoitures,idusines) VALUES (:idvoitures, :idusines)";
        $query = $connect->prepare($sql);
        $query->execute(array(
            ':idvoitures' => $car['id'],
            ':idusines' => $id_usines['id']));
    }
}
echo "la bdd est crée";
?>