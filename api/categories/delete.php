<?php

    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: DELETE');
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
    if(!isset($data->id))
        {
            echo(json_encode(array('message' => 'Missing Required Parameters')));
            exit();
        //else delete
        } else {
            $cat->id = $data->id;
            $cat->delete();
            echo(json_encode(array('id' => $cat->id)));
        }
?>