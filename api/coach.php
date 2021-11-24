<?php
    class Coach{
       
        // Table
        private $db_table = "coach_equipe";

        // Columns
        public $id;
        public $nom;
        public $age;
        public $equipe;
                
        
        // GET ALL
        public function getCoach(){

            $sqlQuery = "SELECT id, nom, age, equipe FROM " . $this->db_table . "";
            $data= DataBase::getCoachDb( $sqlQuery);
            return $data;
        }

        // CREATE
        public function createCoach(){

            try {
                $connexion= DataBase::connect_db();
                $sqlQuery = "INSERT INTO
                            ". $this->db_table ."
                        SET
                            nom = :nom,  
                            age = :age, 
                            equipe = :equipe";
            
                $stmt = $connexion->prepare($sqlQuery);
            
                // sanitize
                $this->nom=htmlspecialchars(strip_tags($this->nom));
                $this->age=htmlspecialchars(strip_tags($this->age));
                $this->equipe=htmlspecialchars(strip_tags($this->equipe));
            
                // bind data
                $stmt->bindParam(":nom", $this->nom);
                $stmt->bindParam(":age", $this->age);
                $stmt->bindParam(":equipe", $this->equipe);
            
                if($stmt->execute()){
                   return true;
                }
                return false;
              } catch (PDOException $e) {
                echo "Create Coatch error: " . $e->getMessage();
              }


           
        }

        // READ single
        public function getSingleCoach(){
            $connexion= DataBase::connect_db();
            $sqlQuery = "SELECT
                        id, 
                        nom,  
                        age, 
                        equipe
                      FROM
                        ". $this->db_table ."
                    WHERE 
                       equipe = ?
                    LIMIT 0,1";

            $stmt = $connexion->prepare($sqlQuery);

            $stmt->bindParam(1, $this->id);

            $stmt->execute();

            $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $this->nom = $dataRow['nom'];
            $this->age = $dataRow['age'];
            $this->equipe = $dataRow['equipe'];
        }        

        // UPDATE
        public function updateCoach(){
            $connexion= DataBase::connect_db();
            $sqlQuery = "UPDATE
                        ". $this->db_table ."
                    SET
                        nom = :nom, 
                        age = :age, 
                        equipe = :equipe
                    WHERE 
                        id = :id";
        
            $stmt = $connexion->prepare($sqlQuery);
        
            $this->nom=htmlspecialchars(strip_tags($this->nom));
            $this->age=htmlspecialchars(strip_tags($this->age));
            $this->equipe=htmlspecialchars(strip_tags($this->equipe));
            $this->id=htmlspecialchars(strip_tags($this->id));
        
            // bind data
            $stmt->bindParam(":nom", $this->nom);
            $stmt->bindParam(":age", $this->age);
            $stmt->bindParam(":equipe", $this->equipe);
            $stmt->bindParam(":id", $this->id);
        
            if($stmt->execute()){
               return true;
            }
            return false;
        }

        // DELETE
        function deleteEmployee(){
            $connexion= DataBase::connect_db();
            $sqlQuery = "DELETE FROM " . $this->db_table . " WHERE id = ?";
            $stmt = $connexion->prepare($sqlQuery);
        
            $this->id=htmlspecialchars(strip_tags($this->id));
        
            $stmt->bindParam(1, $this->id);
        
            if($stmt->execute()){
                return true;
            }
            return false;
        }

    }
?>