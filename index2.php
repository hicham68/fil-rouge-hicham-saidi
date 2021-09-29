<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maquette fil rouge</title>
    <link rel="stylesheet" href="./css/page_api2.css" />
    <?php
    $url = "https://filrouge.uha4point0.fr/basketball/equipes"; /// url de l'api 
$json = file_get_contents($url); //
$equipes = json_decode($json); // decode un fichier string JSON en tableau d'objet PHP
// var_dump($equipes);
?>
</head>
  <body>
    <div class="divPage1">
    <header>
       <h1 style="text-align: center;" >Équipes : </h1>
    </header> 
    <?php
    foreach ($equipes as $equipe) {   
        // mise a jours 10?>
            <div class="teamName">
            <h2> <?php echo $equipe->nom; ?> :</h2> 
                <img src="<?php echo $equipe->logo; ?>"/>
                <p> <strong> Localisation : <?php echo $equipe->localisations; ?><br>
                     Division :<?php echo $equipe->division ?> <br>
                    Date de création :<?php echo $equipe->creation ?> <br>
                    Couleurs des maillots : <?php foreach($equipe->couleurs as $couleur){ echo $couleur." ";} ?> </strong></p> 
                

               
            </div>
        <?php } ?>
    
        <a href="index.php" class="linkPage2"><h3>Joueurs</h3></a>
</div>

</body>

</html>
<!-- "localisations": "Charlotte, North Carolina",
    "division": "Southeast",
    "creation": "1988",
    "couleurs" -->