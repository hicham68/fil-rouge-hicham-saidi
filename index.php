<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maquette page 2</title>
    <link rel="stylesheet" href="./css/page_api.css" />
    <link rel="stylesheet" media="screen and (max-width: 1280px)" href="petite_resolution.css" />
</head>

<?php
// DECLARATION DES VARIABLES

$url = "https://filrouge.uha4point0.fr/basketball/joueurs"; /// url de l'api 
$json = file_get_contents($url); //
$joueurs = json_decode($json); // decode un fichier string JSON en tableau d'objet PHP


$url = "https://filrouge.uha4point0.fr/basketball/equipes"; /// url de l'api 
$json = file_get_contents($url); //
$equipes = json_decode($json); // decode un fichier string JSON en tableau d'objet PHP
// var_dump($equipes);
$totalPlayerByTeam = 0 ;

?>

<body>
    <div class="divPage2">
        <header>
            <h1>Joueurs : </h1>
        </header>
        <!-- {
    "id": 12,
    "nom": "Barea, J. J.",
    "position": "G",
    "No": 5,
    "equipe": 6,
    "taille": 1.83,
    "poid": 84
  }, -->
        <?php
        foreach ($equipes as $equipe) {  ?>
            <div>
                <h2> <?php echo htmlspecialchars($equipe->nom); ?> :</h2>
                <img class="imageEquipe" src="<?php echo htmlspecialchars($equipe->logo); ?>" width="100px" height="100px" />
                
            <div class='conteneurJoueurs'>

            <?php foreach ($joueurs as $joueur){

            if($joueur->equipe == $equipe->id ){ 
                $totalPlayerByTeam ++;
                ?>
                
                    
                        <div class='element'><img src='https://cdn-icons-png.flaticon.com/512/2468/2468023.png' title='2' width="50px" height="50px" alt='<?php echo $joueur->nom  ?>'>
                            <p> <strong> <?php echo htmlspecialchars($joueur->nom); ?> </strong>  <br>
                                poids : <?php echo htmlspecialchars($joueur->poid); ?> kg <br>
                                taille :<?php echo htmlspecialchars($joueur->taille);  ?> m <br>
                                numéro : <?php echo htmlspecialchars($joueur->No);  ?> <br>
                                poste : <?php echo  htmlspecialchars($joueur->position);  ?></p>
                        </div>
                   
                <?php
             }

            }  

            if($totalPlayerByTeam == 0){?>
               <?php echo htmlspecialchars("Aucun joueur enregistré pour cette équipe  dans l'api") ?> 
            <?php }
            $totalPlayerByTeam = 0;
            ?> 
            
            </div>
            </div>

            <br/>

           
        <?php } ?>


            <!--  
   
  echo " -->






            <a href="index2.php"><h3>Équipes</h3> </a>
            </div>
</body>

</html>