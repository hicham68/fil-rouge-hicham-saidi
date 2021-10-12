<?php

$SQL = array(
"DROP DATABASE IF EXISTS basketdb;
CREATE DATABASE basketdb;
USE basketdb;",
    
"CREATE TABLE equipes (
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    nom VARCHAR(400) UNIQUE,
    localisation VARCHAR(400),
    division VARCHAR(400),
    creation INT(11),
    logo VARCHAR(400)
);

CREATE TABLE joueurs (
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    nom VARCHAR(400) UNIQUE,
    position VARCHAR(400),
    numero VARCHAR(400),
    equipe INT,
    taille FLOAT,
    poid INT(11)
);

CREATE TABLE couleurs (
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    couleur VARCHAR(400) NOT NULL UNIQUE
);

CREATE TABLE couleur_equipe (
    id_couleur INT NOT NULL,
    id_equipe INT NOT NULL
);

ALTER TABLE equipes AUTO_INCREMENT = 1;
ALTER TABLE joueurs AUTO_INCREMENT = 1;
ALTER TABLE couleurs AUTO_INCREMENT = 1;

ALTER TABLE couleur_equipe ADD PRIMARY KEY (id_couleur,id_equipe);

ALTER TABLE joueurs
ADD FOREIGN KEY (equipe) REFERENCES equipes(id);

ALTER TABLE couleur_equipe 
ADD FOREIGN KEY (id_couleur) REFERENCES couleurs(id);

ALTER TABLE couleur_equipe 
ADD FOREIGN KEY (id_equipe) REFERENCES equipes(id);"

);

?>
