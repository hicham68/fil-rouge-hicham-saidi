<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    
    include_once './Database.php';
    include_once './coach.php';

    $db = DataBase::connect_db();
    $items = new Coach($db);

    $stmt = $items->getCoach();
    $itemCount = $stmt->rowCount();


    echo json_encode($itemCount, JSON_PRETTY_PRINT);

    if($itemCount > 0){
        
        $coachArr = array();
        $coachArr["body"] = array();
        $coachArr["itemCount"] = $itemCount;

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $e = array(
                "id" => $id,
                "name" => $nom,
                "age" => $age,
                "created" => $equipe
            );

            array_push($coachArr["body"], $e);
        }
        echo json_encode($coachArr, JSON_PRETTY_PRINT);
    }

    else{
        http_response_code(404);
        echo json_encode(
            array("message" => "No record found.")
        );
    }
?>