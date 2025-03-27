<?php 

    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: DELETE');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');


    include_once '../../config/Database.php';
    include_once '../../models/Quote.php';

    // Database connection
    $database = new Database();
    $db = $database->connect();

    //Instantiate blog quote object
    $quo = new Quote($db);

    //Retrieve the raw data
    $data = json_decode(file_get_contents("php://input"));

    // Error message if the data is missing required parameters
    if(!isset($data->id))
        {
            echo(json_encode(array('message' => 'Missing Required parameters')));
            exit();
        }

    // Update the ID
    $quo->id = $data->id;

    //delete post
    if($quo->delete())
        {
            echo json_encode(
            array('id' => $quo->id)
            );
        } else 
            {
                // Error message if the quote is not found
                echo json_encode(
                array('message' => 'No Quotes Found')
                );
            }
?>