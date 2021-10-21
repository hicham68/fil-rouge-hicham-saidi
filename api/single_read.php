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

    $item->id = isset($_GET['id']) ? $_GET['id'] : die();
  
    $item->getSingleCoach();

    if($item->nom != null){
        // create array
        $emp_arr = array(
            "id" =>  $item->id,
            "name" => $item->nom,
            "age" => $item->age,
            "equipe" => $item->equipe
        );
      
        http_response_code(200);
        echo json_encode($emp_arr);
    }
      
    else{
        http_response_code(404);
        echo json_encode("Coach not found.");
    }
?>