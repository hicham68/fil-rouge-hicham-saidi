<?php

$SQL = array(
"CREATE DATABASE IF NOT EXISTS basketdb;
USE basketdb;",
    
"CREATE TABLE IF NOT EXISTS equipes (
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    nom VARCHAR(400) UNIQUE,
    localisation VARCHAR(400),
    division VARCHAR(400),
    creation INT(11),
    logo VARCHAR(400)
);

CREATE TABLE IF NOT EXISTS joueurs (
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    nom VARCHAR(400) UNIQUE,
    position VARCHAR(400),
    numero VARCHAR(400),
    equipe INT,
    taille FLOAT,
    poid INT(11)
);

CREATE TABLE IF NOT EXISTS couleurs (
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    couleur VARCHAR(400) NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS couleur_equipe (
    id_couleur INT NOT NULL,
    id_equipe INT NOT NULL
);

CREATE TABLE IF NOT EXISTS coach_equipe (
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    nom VARCHAR(400) NOT NULL,
    age INT NOT NULL,
    equipe INT
);


ALTER TABLE equipes AUTO_INCREMENT = 1;
ALTER TABLE joueurs AUTO_INCREMENT = 1;
ALTER TABLE couleurs AUTO_INCREMENT = 1;
ALTER TABLE coach_equipe AUTO_INCREMENT = 1;

ALTER TABLE couleur_equipe ADD PRIMARY KEY (id_couleur,id_equipe);

ALTER TABLE joueurs
ADD FOREIGN KEY (equipe) REFERENCES equipes(id);

ALTER TABLE coach_equipe
ADD FOREIGN KEY (equipe) REFERENCES equipes(id);

ALTER TABLE couleur_equipe 
ADD FOREIGN KEY (id_couleur) REFERENCES couleurs(id);

ALTER TABLE couleur_equipe 
ADD FOREIGN KEY (id_equipe) REFERENCES equipes(id);"

);

?>
