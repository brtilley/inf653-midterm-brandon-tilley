<?php

    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Author.php';

    // Database connection
    $database = new Database();
    $db = $database->connect();

    $aut = new Author($db);

    //Retreive the ID
    $aut->id = isset($_GET['id']) ? $_GET['id'] : die();// gets the value of that id

    //Retrieve the author
    if( $aut->read_single())
    {
        echo json_encode(array(
            'id' => $aut->id,
            'author' => $aut->author
            ));
    }
    //Error message if the author is not found
    else {
        echo json_encode(array(
        'message' => 'author_id Not Found'
        ));
    }
?>