<?php

  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/Author.php';
  
  // Database connection
  $database = new Database();
  $db = $database->connect();

  $aut = new Author($db);

  //Retrieve the raw data
  $data = json_decode(file_get_contents("php://input"));

  //If missing required parameters, send error message
  if(!isset($data->author))
      {
      echo json_encode(array('message' => 'Missing Required Parameters'));
      exit();
      } else {
            $aut->author = $data->author;
            $aut->create();
            echo json_encode(array('id' => $db->lastInsertId(), 'author'=>$aut->author));
             }
?>