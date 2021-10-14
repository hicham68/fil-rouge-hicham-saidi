<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maquette fil rouge</title>
    <link rel="stylesheet" href="./css/page_api2.css" />
    <?php
    require_once("./migration/migration.php");
    require_once("./api/Database.php");
    
    $connexion= DataBase::createMigration($SQL);
    $joueurs = json_decode(file_get_contents("https://filrouge.uha4point0.fr/basketball/joueurs")); // decode un fichier string JSON en tableau d'objet PHP
    $equipes = json_decode(file_get_contents("https://filrouge.uha4point0.fr/basketball/equipes")); // decode un fichier string JSON en tableau d'objet PHP
// var_dump($equipes);

$insertData = DataBase::insertData($joueurs,$equipes);
$equipes = DataBase::getTeams();
$joueurs= DataBase::getAllPlayer();

?>
</head>
  <body>
    <div class="divPage1">
    <header>
       <h1 style="text-align: center;" >Équipes : </h1>
    </header> 
    <?php
    foreach ($equipes as $equipe) {
        $team_color = DataBase::getColorsByTeam($equipe["id"]);  ?>
            <div class="teamName">
            <h2> <?php echo htmlspecialchars(strip_tags($equipe['nom'])); ?> :</h2> 
                <img src="<?php echo htmlspecialchars(strip_tags($equipe['logo'])); ?>"/>
                <p> <strong> Localisation : <?php echo htmlspecialchars(strip_tags($equipe['localisation'])); ?><br>
                     Division :<?php echo htmlspecialchars(strip_tags($equipe['division'])); ?> <br>
                    Date de création :<?php echo htmlspecialchars(strip_tags($equipe['creation'])); ?> <br></strong></p> 
   
                
                 <p>Couleurs des maillots :</p>
              <?php  
              foreach($team_color as $couleur){
                    ?>
                     <?php  echo htmlspecialchars(strip_tags($couleur['couleur'])); ?> 
                     <?php } ?>
               
            </div>
        <?php } ?>
    
        <a href="index.php" class="linkPage2"><h3>Joueurs</h3></a>
</div>

</body>

</html>
