<?php

/**
 * class DataBase qui permet de se connecter a la DB,
 * D'insérer les données de l'API dans la DB,
 * et enfin de récupérer les données de la DB
 *
 * 
 *
 * @copyright  2006 Zend Technologies
 * @license    http://www.zend.com/license/3_0.txt   PHP License 3.0
 * @link       http://dev.zend.com/package/PackageName
 */

class DataBase
{

  public static $firstConnexion = true;

  public static function connect_db()
  {

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "basketdb";


    if (self::$firstConnexion == true) {
      try {
        $conn = new PDO("mysql:host=$servername;charset=utf8", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      } catch (PDOException $e) {
        echo " first Connection failed: " . $e->getMessage();
      }
    } else {
      try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
      }
    }

    self::$firstConnexion = false; // la premiere connection c'est de
    return  $conn;
  }

  public static function createMigration($listOfQueries)
  {
    foreach ($listOfQueries as $query) {
      try {
        $connexion = self::connect_db(); // cest la que ca fait la premiere connection == false 
        // stmt recupere toutes les requetes sql
        $stmt = $connexion->prepare($query);
        $stmt->execute();
        // $connexion = null;

      } catch (PDOException $e) {
        echo "Migration error: " . $e->getMessage();
      }
    }
  }



  /**
   *
   * insert et crée la base de donnée si elle n'existe pas encore 
   *
   * @param    object  $object The object to convert
   * @return   array
   *
   */
  public static function insertData($joueurs, $equipes)
  {
    try {
      $connexion = self::connect_db(); // == true a partir de la 

      // AJOUTE LES EQUIPES :
      foreach ($equipes as $equipe) {
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
        foreach ($equipe->couleurs as $couleur) {
          $sql = "INSERT IGNORE INTO couleurs (couleur) VALUES (:couleur)";
          $query = $connexion->prepare($sql);
          $query->bindValue(":couleur", $couleur);
          $query->execute();
        }

        // AJOUTE LES FOREIGN KEY DANS LA TABLE INTERMEDIAIRE 
        foreach ($equipe->couleurs as $couleur) {
          $sql = "INSERT IGNORE INTO couleur_equipe (id_couleur,id_equipe) VALUES ((SELECT couleurs.id FROM couleurs WHERE couleurs.couleur = :couleur),:id_equipe)";
          $query = $connexion->prepare($sql);
          $query->bindValue(":couleur", $couleur);
          $query->bindValue(":id_equipe", $equipe->id);
          $query->execute();
        }
      }

      // AJOUTE LES JOUEURS
      foreach ($joueurs as $joueur) {
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

      // AJOUTE LES Coach

      $query = $connexion->exec('INSERT  IGNORE INTO coach_equipe(id, nom, age, equipe) 
            VALUES 
           

            (
              1,
              "James Borrego",
              43,
              1
            ), 
            
            (
              2,
              "Ime Udoka",
              44,
              2
            ),
            
            (
              3,
              "Phil Jackson",
              76,
              3
            ),

            (
              4,
              "Erik Spoelstra",
              50,
              4
            ),

            (
              5,
              "Willie Green",
              40,
              5
            ),

            (
              6,
              "Jason Kidd",
              48,
              6
            )
            
            
           ');
    } catch (PDOException $e) {
      echo "insertion in database error: " . $e->getMessage();
    }
  }


  public static function getTeams()
  {
    
    try {
      // Récupere les équipes
      $connexion = self::connect_db();
      $sql = "SELECT * FROM equipes";
      $query = $connexion->prepare($sql);
      $query->execute();
      $data = $query->fetchAll(PDO::FETCH_ASSOC);
      $connexion = null;
      return $data;
      
    } catch (PDOException $e) {
      echo "Get Teams error: " . $e->getMessage();
    }
      
  }

  public static function getTeamsByPage($page, $rowsByPage)
  {
    try{
     
      $start_from = ($page-1) * $rowsByPage; // Permet de calculer la ligne de la premiere equipe affichée
      //Récupere le nombre d'equipes
      $connexion= self::connect_db();
      # Retrieve rows 6-15
      $count=$connexion->prepare("SELECT * FROM equipes LIMIT $start_from, $rowsByPage");
      $count->setFetchMode(PDO::FETCH_ASSOC);
      $count->execute();
      $data = $count->fetchAll();
      $connexion = null;
      return $data;
     
    
    } catch(PDOException $e){
      echo "Get number Teams error: " . $e->getMessage();
    }
      
  }

  public static function countAllTeams(): int
  {
    try{
      //Récupere le nombre d'equipes
      $connexion= self::connect_db();
      $count=$connexion->prepare("SELECT COUNT(*) FROM equipes");
      $count->execute();
      return $count->fetchColumn();
    
    } catch(PDOException $e){
      echo "Get number Teams error: " . $e->getMessage();
    }
  }

  public static function getAllPlayer()
  {

    try {
      $connexion = self::connect_db();
      $sql = "SELECT * FROM joueurs ";
      $query = $connexion->prepare($sql);
      $query->execute();
      return $query->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      echo "Get all player error: " . $e->getMessage();
    }
  }


  public static function getCoachDb($sql)
  {
    try {
      $connexion = self::connect_db();
      $stmt = $connexion->prepare($sql);
      $stmt->execute();
      echo ' var dump';
      var_dump($stmt);
      return $stmt;

    } catch (PDOException $e) {
      echo "Get all Coatch error: " . $e->getMessage();
    }
  }


  public static function getColorsByTeam($equipes)
  {

    try {
      $connexion = self::connect_db();
      $sql = "SELECT couleurs.couleur FROM couleurs INNER JOIN couleur_equipe ON couleur_equipe.id_couleur = couleurs.id INNER JOIN equipes ON equipes.id = couleur_equipe.id_equipe WHERE equipes.id = :equipe";
      $query = $connexion->prepare($sql);
      $query->bindValue(":equipe", $equipes, PDO::PARAM_INT);
      $query->execute();
      return $query->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      echo "Get colors error: " . $e->getMessage();
    }
  }


  public static function getPlayerByTeam($team)
  {

    try {
      $connexion = self::connect_db();
      $sql = "SELECT * FROM joueurs WHERE equipe = :equipe";
      $query = $connexion->prepare($sql);
      $query->bindValue(":equipe", $team, PDO::PARAM_INT);
      $query->execute();
      return $query->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      echo "Get Teams error: " . $e->getMessage();
    }
  }
}
