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

    $item->nom = $data->nom;
    $item->age = $data->age;
    $item->equipe = $data->equipe;
    
    if($item->createCoach()){
        echo 'Coach created successfully.';
    } else{
        echo 'Coach could not be created.';
    }
?>