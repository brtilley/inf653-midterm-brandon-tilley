<?php

  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/Category.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate Category object
  $category = new Category($db);

  // Get ID
  $category->id = isset($_GET['id']) ? $_GET['id'] : die();

    //GET category
    if( $cat->read_single()){
      echo json_encode(array(
          'id' => $cat->id,
          'category' => $cat->category
      ));
 }
//cannot find id
 else {
  echo json_encode(array(
      'message' => 'category_id Not Found'
  ));
 }