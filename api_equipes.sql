CREATE DATABASE basketDB;
CREATE TABLE Joueurs (
    JoueurID int NOT NULL,
    JoueurName varchar(255) NOT NULL,
    JoueurNo int NOT NULL,
    Equipe int NOT NULL,
    Taille float NOT NULL,
    Poids int NOT NULL,
    PRIMARY KEY (JoueurID),
    FOREIGN KEY (Equipe) REFERENCES Equipes(EquipeID)
);
CREATE TABLE Equipes (
    EquipeID int NOT NULL,
    EquipeName varchar(255) NOT NULL,
    EquipeLocalisation varchar(255) NOT NULL,
    EquipeDivision varchar(255) NOT NULL,
    EquipeColors varchar(255) NOT NULL,
    EquipeLogo varchar(255) NOT NULL,
    PRIMARY KEY (EquipeID),
    FOREIGN KEY (EquipeColors)
);
CREATE TABLE Colors (
  Colors varchar(255) NOT NULL,

);
