<?php 

    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Quote.php';

    // Database connection
    $database = new Database();
    $db = $database->connect();

    $quo = new Quote($db);

    //GET ID
    $quo->id = isset($_GET['id']) ? $_GET['id'] : die();
  
    //GET quote
    if ($quo->read_single())
        {
  
        //create array
        $quote_arr = array(
            'id' => $quo->id,
            'quote' => $quo->quote,
            'author' => $quo->author,
            'category' => $quo->category
            );
        } else 
            {
                $quote_arr = array(
                'message' => 'No Quotes Found'
                );
            }
  
        // Return JSON
        print_r(json_encode($quote_arr));
?>