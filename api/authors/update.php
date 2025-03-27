<?php

    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: PUT');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Author.php';

    // Database connection
    $database = new Database();
    $db = $database->connect();

    $aut = new Author($db);

    //Retrieve the raw data
    $data = json_decode(file_get_contents("php://input"));

    // Error message if the data is missing required parameters
    if(!isset($data->id) || !isset($data->author))
    {
        echo json_encode(array('message' => 'Missing Required Parameters'));
        exit();
    }

    // Update the author ID
    $aut->id = $data->id;
    $aut->author = $data->author;

    // Update the author
    if($aut->update())
    {
        echo json_encode(
        array(
            'id' => $aut->id,
            'author' => $aut->author
            ));
    } else {
            // Error message if the author ID is not found
            echo json_encode(
            array(
            'message' => 'author_id Not Found'
            ));
    }
?>