<?php


class DataBase {

public static function connect_db(){

  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "basketdb";

  try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
  } catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
  }
  return  $conn ;
}

public static function createMigration( $listOfQueries){
   foreach($listOfQueries as $query){
    try {
        $connexion= DataBase::connect_db();
        // stmt recupere tous les stands
        $stmt = $connexion->prepare($query);
        $stmt->execute();
        // $connexion = null;
        // echo "Connected  a jojoworld successfully";
      } catch(PDOException $e) {
        echo "Migration error: " . $e->getMessage();
      }
   }
}




public static function insertData($joueurs,$equipes){
    try {
         $connexion= DataBase::connect_db();
         
         // AJOUTE LES EQUIPES :
         foreach($equipes as $equipe){
            $query = $connexion->prepare('INSERT IGNORE  INTO equipes(id, nom, localisation, division, creation, logo ) VALUES (:id, :nom, :localisation, :division , :creation,  :logo)');
            $query->execute(array(
            'id' => $equipe->id,
            'nom' => $equipe->nom,
            'localisation' => $equipe->localisations,
            'division' => $equipe->division,
            'creation' => $equipe->creation,
            'logo' => $equipe->logo
            ));

            // AJOUTE LES COULEURS
            foreach ($equipe->couleurs as $couleur){
                $sql = "INSERT IGNORE INTO couleurs (couleur) VALUES (:couleur)";
                $query = $connexion->prepare($sql);
                $query->bindValue(":couleur",$couleur);
                $query->execute();
            }

            // AJOUTE LES FOREIGN KEY DANS LA TABLE INTERMEDIAIRE 
            foreach ($equipe->couleurs as $couleur){
                $sql = "INSERT IGNORE INTO couleur_equipe (id_couleur,id_equipe) VALUES ((SELECT couleurs.id FROM couleurs WHERE couleurs.couleur = :couleur),:id_equipe)";
                $query = $connexion->prepare($sql);
                $query->bindValue(":couleur",$couleur);
                $query->bindValue(":id_equipe",$equipe->id);
                $query->execute();
            }

        }

        // AJOUTE LES JOUEURS
        foreach($joueurs as $joueur){
            $query = $connexion->prepare('INSERT  IGNORE INTO joueurs(id, nom, position, numero, equipe, taille, poid) VALUES (:id, :nom, :position, :numero , :equipe,  :taille, :poid)');
            $query->execute(array(
            'id' => $joueur->id,
            'nom' => $joueur->nom,
            'position' => $joueur->position,
            'numero' => $joueur->No,
            'equipe' => $joueur->equipe,
            'taille' => $joueur->taille,
            'poid' => $joueur->poid
            ));
        }

       
       } catch(PDOException $e) {
         echo "insertion in database error: " . $e->getMessage();
       }

    
}


public static function getTeams(){
    
     try {
        $connexion= DataBase::connect_db();
        $sql = "SELECT * FROM equipes";
        $query = $connexion->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
       } catch(PDOException $e) {
         echo "Get Teams error: " . $e->getMessage();
       }
    
}
 
public static function getAllPlayer(){

    try {
        $connexion= DataBase::connect_db();
        $sql = "SELECT * FROM joueurs ";
        $query = $connexion->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
         echo "Get Teams error: " . $e->getMessage();
    }
    
    
}


public static function getPlayerByTeam($team){

    try {
        $connexion= DataBase::connect_db();
        $sql = "SELECT * FROM joueurs WHERE equipe = :equipe";
        $query = $connexion->prepare($sql);
        $query->bindValue(":equipe",$team,PDO::PARAM_INT);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
         echo "Get Teams error: " . $e->getMessage();
    }
   
}




}

?>