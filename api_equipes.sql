CREATE DATABASE dbbasket;

CREATE TABLE Equipes(
    EquipeID INT NOT NULL,
    EquipeName VARCHAR(255) NOT NULL,
    EquipeLocalisation VARCHAR(255) NOT NULL,
    EquipeDivision VARCHAR(255) NOT NULL,
    EquipeColors VARCHAR(255) NOT NULL,
    EquipeLogo VARCHAR(255) NOT NULL,
    PRIMARY KEY(EquipeID)
);


CREATE TABLE Joueurs(
    JoueurID INT NOT NULL,
    JoueurName VARCHAR(255) NOT NULL,
    JoueurNo INT NOT NULL,
    Equipe INT NOT NULL,
    Taille FLOAT NOT NULL,
    Poids INT NOT NULL,
    PRIMARY KEY(JoueurID),
    FOREIGN KEY(Equipe) REFERENCES Equipes(EquipeID)
); 

ALTER TABLE Equipes ENGINE=InnoDB;
ALTER TABLE Joueurs ENGINE=InnoDB;

CREATE TABLE Colors(
    Colors VARCHAR(255) NOT NULL,
    ColorID INT NOT NULL,
    PRIMARY KEY(ColorID),
    FOREIGN KEY(Colors) REFERENCES Equipes(EquipeColors)
    );
