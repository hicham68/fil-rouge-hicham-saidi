<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    include_once './Database.php';
    include_once './coach.php';
    
    $db = DataBase::connect_db();
    
    $item = new Coach($db);
    
    $data = json_decode(file_get_contents("php://input"));
    
    $item->id = $data->id;
    
    // employee values
    $item->nom = $data->nom;
    $item->age = $data->age;
    $item->equipe = $data->equipe;
    $item->created = date('Y-m-d H:i:s');
    
    if($item->updateCoach()){
        echo json_encode("Coach data updated.");
    } else{
        echo json_encode("Data could not be updated");
    }
?>