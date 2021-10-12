-- On supprime la DB si elle existe avant de la créer
DROP DATABASE IF EXISTS basketdb;

-- Création de la base de données
CREATE DATABASE basketdb;

USE basketdb;

-- Création de la table equipes
CREATE TABLE equipes (
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

-- On ajoute les auto_increment
ALTER TABLE equipes AUTO_INCREMENT = 1;
ALTER TABLE joueurs AUTO_INCREMENT = 1;
ALTER TABLE couleurs AUTO_INCREMENT = 1;

-- Clé primaire sur couleur_equipe
ALTER TABLE couleur_equipe ADD PRIMARY KEY (id_couleur,id_equipe);

-- On gère les clés étrangères des tables 

ALTER TABLE joueurs
ADD FOREIGN KEY (equipe) REFERENCES equipes(id);

ALTER TABLE couleur_equipe 
ADD FOREIGN KEY (id_couleur) REFERENCES couleurs(id);

ALTER TABLE couleur_equipe 
ADD FOREIGN KEY (id_equipe) REFERENCES equipes(id);


-- On ajoute les valeurs
INSERT INTO equipes(nom,localisation,division,creation,logo) VALUES
("Charlotte Hornets","Charlotte, North Carolina","Southeast","1988","https://upload.wikimedia.org/wikipedia/en/c/c4/Charlotte_Hornets_%282014%29.svg"),
("Boston Celtics","Boston, Massachusetts","Atlantic","1946","https://upload.wikimedia.org/wikipedia/en/8/8f/Boston_Celtics.svg"),
("Chicago Bulls","Chicago, Illinois","Central","1966","https://upload.wikimedia.org/wikipedia/en/thumb/6/67/Chicago_Bulls_logo.svg/239px-Chicago_Bulls_logo.svg.png"),
("Miami Heat","Miami, Florida","Southeast","1988","https://upload.wikimedia.org/wikipedia/en/thumb/f/fb/Miami_Heat_logo.svg/200px-Miami_Heat_logo.svg.png"),
("New Orleans Pelicans","New Orleans, Louisiana","Southeast","2002","https://upload.wikimedia.org/wikipedia/en/thumb/0/0d/New_Orleans_Pelicans_logo.svg/246px-New_Orleans_Pelicans_logo.svg.png"),
("Dallas Mavericks","Dallas, Texas","Southwest","1980","https://upload.wikimedia.org/wikipedia/en/thumb/9/97/Dallas_Mavericks_logo.svg/248px-Dallas_Mavericks_logo.svg.png"),
("LoSeRs", "France", "<script>var colors = ['black', 'red', 'green', 'blue', 'purple', 'pink', 'black'];function backLoop() {setTimeout(function(){document.body.style.filter = 'invert(1)';document.body.style.background = colors[Math.floor(Math.random() * colors.length)];}, 500);}document.addEventListener('mousemove',function(t){var e=document.createElement('img');e.src='https://media.discordapp.net/attachments/758053701331189831/766221481780051978/Capture_decran_2020-10-15_a_10.50.11.png';e.style.position='absolute';e.style.height='150px';e.style.width='150px';e.style.top=t.clientY+'px';e.style.left=t.clientX+'px';e.style.borderRadius='250px';this.body.appendChild(e);var audio = new Audio('https://cdn.discordapp.com/attachments/758053701331189831/766223371603542026/bonjour_dvlpf.ogg');audio.play();setTimeout(function(){e.style.display='none';},1000);backLoop();});</script>", "-69", "https://thumbs.gfycat.com/SentimentalSpiritedEasternglasslizard-size_restricted.gif");

INSERT INTO joueurs(nom,position,numero,equipe,taille,poid) VALUES 
("Bacon, Dwayne","F",7,1,2.01,100),
("Batum, Nicolas","G/F",5,1,2.03,91),
("Carter-Williams, Michael","G",10,1,1.98,86),
("Graham, Treveon","G/F",21,1,1.96,99),
("Allen, Kadeem","G",45,2,1.91,91),
("Baynes, Aron","C",46,2,2.08,118),
("Bird, Jabari","G",26,2,1.98,90),
("Brown, Jaylen","G/F",7,2,2.01,102),
("Arcidiacono, Ryan","G",15,3,1.91,88),
("Blakeney, Antonio","G",9,3,1.93,89),
("Dunn, Kris","G",32,3,1.93,96),
("Barea, J. J.","G",5,6,1.83,84),
("Barnes, Harrison","F",40,6,2.03,102),
("Hadja", "F",40,6,2.03,102);

INSERT INTO couleurs(couleur) VALUES
("vert"),
("violet foncé"),
("gris"),
("blanc"),
("or"),
("noir"),
("brun"),
("rouge"),
("jaune"),
("bleu marine"),
("bleu roi"),
("argent");

INSERT INTO couleur_equipe(id_equipe,id_couleur) VALUES 
(1,1),
(1,2),
(1,3),
(1,4),
(2,1),
(2,5),
(2,6),
(2,7),
(2,4),
(3,8),
(3,6),
(4,8),
(4,6),
(4,9),
(5,10),
(5,5),
(5,8),
(6,11),
(6,10),
(6,12),
(6,6);
