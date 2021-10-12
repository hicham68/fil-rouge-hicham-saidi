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
    // stmt recupere tous les stands
    // echo "Connected  a jojoworld successfully";
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
        $stmt = $connexion->prepare( $query);
        $stmt->execute();
        // $connexion = null;
        // echo "Connected  a jojoworld successfully";
      } catch(PDOException $e) {
        echo "Migration error: " . $e->getMessage();
      }
   }
}




public static function insertData($joueurs,$equipes ){
    try {
         $connexion= DataBase::connect_db();
         // stmt recupere tous les stands
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













// public static function affichageStand(){
  
//   try {
//     $connexion= DataBase::connect_db();
//     // stmt recupere tous les stands
//     $stmt = $connexion->prepare("SELECT * FROM `stand` WHERE 1");
//     $stmt->execute();
  
//      // set the resulting array to associative
//      $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
//      $allJojoStands = array();
//      foreach($stmt->fetchAll() as $v) { // $stmt->fetchAll() tableau associatif 
      
//       $nouveauStand= new Stand($v['modal_id'], // création de l'objet à partir du tableau associatif créer à partir de la base de donnée.
//                               $v['name'],
//                               $v['manieur'],
//                               $v['image_miniature'],
//                               $v['image_modal'],
//                               $v['description'],
//                               $v['premiere_apparition'],
//                               $v['categorie']);
//       $allJojoStands[] = $nouveauStand; // rajoute un nouvel objet dans le tableau 
//      }
//     // echo "Connected  a jojoworld successfully";
//   } catch(PDOException $e) {
//     echo "Connection failed: " . $e->getMessage();
//   }

//   return  $allJojoStands;
// }






















public static function createStand($data){

  $connexion= DataBase::connect_db();

  $randomString='gjkghqkgdqsdmqdj@_mooqhjdiquezgf46945314857';

  $sql="INSERT INTO all_stands(modal_id,name,manieur,image_miniature,image_modal,description,premiere_apparition,categorie  ) values (?,?,?,?,?,?,?,?)";
  $stmt=$connexion->prepare($sql);
  $stmt->execute(array( str_shuffle($randomString),$data['name'], $data['manieur'], 'assets/img/portfolio/'.$data['img_miniature'], 'assets/img/portfolio/'.$data['img_modal'],$data['description'] , $data['premiere_apparition'],$data['categorie']));

  
  try {

   echo "SUCCES de l'AJOU DANS  la base de donnée";
  } catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
  }
  

}


}

?>