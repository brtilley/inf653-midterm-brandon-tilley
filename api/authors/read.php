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

    // Initiate the read function
    $result = $aut->read();

    // Retreive the number of rows
    $num = $result->rowCount();

    // Retreive the categories
    if($num>0)
    {
        // author array
        $author_arr = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC))
        {
            extract($row);

            $author_item = array(
                'id' => $id,
                'author' => $author
                );

            //push to the database
            array_push($author_arr, $author_item);
        }

    // Push to JSON
    echo json_encode($author_arr);
    } else {
        // Error message if author is not found
        echo json_encode(
        array('message' => 'author_id Not Found')
        );
    }
?>