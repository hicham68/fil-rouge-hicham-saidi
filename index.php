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
require_once("./migration/migration.php");
require_once("./api/Database.php");

DataBase::createMigration($SQL); // == false première requete ok ?

// DECLARATION DES VARIABLES


 // decode un fichier string JSON en tableau d'objet PHP
// $joueurs = json_decode(file_get_contents("https://filrouge.uha4point0.fr/basketball/joueurs"));
// $equipes = json_decode(file_get_contents("https://filrouge.uha4point0.fr/basketball/equipes")); 

$joueurs = json_decode(file_get_contents("http://10.3.1.172:2222/basketball/joueurs"));
$equipes = json_decode(file_get_contents("http://10.3.1.172:2222/basketball/equipes")); 


$insertData = DataBase::insertData($joueurs,$equipes); // rtout ca s'est des requetes  lance a la suite les unes des autres 
$equipes = DataBase::getTeams();
$joueurs= DataBase::getAllPlayer();


$totalPlayerByTeam = 0 ;
   
?>

<body>
    <div class="divPage2">
        <header>
            <h1>Joueurs : </h1>
        </header>

        <?php
        foreach ($equipes as $equipe) {  ?>
            <div>
                <h2> <?php echo htmlspecialchars(strip_tags($equipe["nom"])); ?> :</h2>
                <img class="imageEquipe" src="<?php echo htmlspecialchars(strip_tags($equipe["logo"])); ?>" width="100px" height="100px" />
                
            <div class='conteneurJoueurs'>

            <?php foreach ($joueurs as $joueur){

            if($joueur['equipe'] == $equipe["id"] ){ 
                $totalPlayerByTeam ++;
                ?>
                
                    
                        <div class='element'><img src='https://cdn-icons-png.flaticon.com/512/2468/2468023.png' title='2' width="50px" height="50px" alt='<?php echo $joueur['nom']  ?>'>
                            <p> <strong> <?php echo  htmlspecialchars(strip_tags($joueur['nom'])); ?> </strong>  <br>
                                poids : <?php echo htmlspecialchars(strip_tags($joueur['poid'])); ?> kg <br>
                                taille :<?php echo htmlspecialchars(strip_tags($joueur['taille']));  ?> m <br>
                                numéro : <?php echo htmlspecialchars(strip_tags($joueur['numero']));  ?> <br>
                                poste : <?php echo  htmlspecialchars(strip_tags($joueur['position']));  ?></p>
                        </div>
                   
                <?php
             }

            }  

            if($totalPlayerByTeam == 0){?>
               <?php echo htmlspecialchars(strip_tags("Aucun joueur enregistré pour cette équipe  dans l'api")) ?> 
            <?php }
            $totalPlayerByTeam = 0;
            ?> 
            
            </div>
            </div>

            <br/>

           
        <?php } ?>


            <a href="equipes.php"><h3>Équipes</h3> </a>
            <a href="index.php"><h3>Refresh</h3> </a>

            </div>
</body>

</html>