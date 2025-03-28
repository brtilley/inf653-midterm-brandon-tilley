<?php

    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Category.php';

    // Database connection
    $database = new Database();
    $db = $database->connect();

    $cat = new Category($db);

    // Retrieve the raw data
    $data = json_decode(file_get_contents("php://input"));

    // Error message if the data is missing required parameters
    if(!isset($data->category))
        {
            echo json_encode(array('message' => 'Missing Required Parameters'));
        } else {
            $cat->category = $data->category;
            $cat->create();
            echo json_encode(array('id' => $db->lastInsertId(), 'category'=>$cat->category));
        }
?>