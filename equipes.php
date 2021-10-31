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
    
    $connexion = DataBase::createMigration($SQL);
    $joueurs = json_decode(file_get_contents("https://filrouge.uha4point0.fr/basketball/joueurs")); // decode un fichier string JSON en tableau d'objet PHP
    $equipes = json_decode(file_get_contents("https://filrouge.uha4point0.fr/basketball/equipes")); // decode un fichier string JSON en tableau d'objet PHP
// var_dump($equipes);

$insertData = DataBase::insertData($joueurs,$equipes);



/// Recupère le nombre d'Equipe enregistrée en database
   // Pagination

  $rowsByPage=3;
  $pageNumber=ceil(DataBase::countAllTeams()/$rowsByPage); // calcule le nombre de page en fonction du nombre d'équipe enregistrées
  // var_dump(($pageNumber . "  : ". DataBase::countAllTeams()));
   if(isset($_GET["page"])){
    $page=$_GET["page"];
   }
   else{
     $page=1; // par default
   }

  //  $equipes = DataBase::getTeams();
  
   $equipes = DataBase::getTeamsByPage($page, $rowsByPage);
   $joueurs= DataBase::getAllPlayer();
//    $debut=($page-1)*$rowsByPage;

  

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
              
               <!-- Trigger/Open The Modal -->
               <br>
<button id=" <?php echo htmlspecialchars(strip_tags('myBtn'. $equipe["id"])); ?>" onclick="changeModalStatut(<?php echo htmlspecialchars(strip_tags($equipe['id'])); ?>)">Afficher les informations sur <?php echo htmlspecialchars(strip_tags($equipe['nom'])); ?> </button>



            </div>
        <?php } ?>
        <?php
       
        ?>
        <?php
        echo "<div  class='teamName'> ";
        for($i=1;$i<=$pageNumber;$i++){
          if($page == $i){
            $activeClass="activated";
          }
          else{
            $activeClass="";
          }
            
            echo "<a  href='?page=$i' ><button class='pagination $activeClass '  >$i</button> </a>";

        } 
        echo "</div>";
        ?>


        <a href="index.php" class="linkPage2"><h3>Joueurs</h3></a>
</div>
<!-- The Modal -->

<?php
  foreach ($equipes as $equipe) { 
      ?>
    <div id="<?php echo htmlspecialchars(strip_tags('myModal'. $equipe["id"]));?>" class="modal">
      <!-- Modal content -->
      <div class="modal-content">
        <span class="close" id="<?php echo htmlspecialchars(strip_tags('close'. $equipe["id"]));?>">&times;</span>
        <p>Some text in the Modal.. <?php echo htmlspecialchars(strip_tags('myModal'. $equipe["id"]));?> </p>

        <div class="teamName" >
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
                     <?php } ?> <br>
               <!-- Trigger/Open The Modal -->

            </div>
            <div class="teamName" id="<?php echo htmlspecialchars(strip_tags('coach'. $equipe["id"]));?>" >
                <!-- INFO API COATCH FROM JAVASCRIPT -->

            </div>


      </div>
    </div>

  <?php
  }
      ?>
<script src="./Js/modal.js"></script>
</body>

</html>
