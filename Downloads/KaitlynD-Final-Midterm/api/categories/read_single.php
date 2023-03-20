<?php
//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

//required files
require('../../config/Database.php');
require('../../models/Category.php');

//Instantiate DB and connect
$database = new Database();
$db = $database->connect();

//Instantiate Category object
$category = new Category($db);

//Get ID
$category->id = isset($_GET['id']) ? $_GET['id'] : die();

//GET Category
$category->read_single();

//Create array
$cat_arr = array(
    'id' => $category->id,
    'category' => $category->category
);

//check to see if Category is empty, if it is not empty then print JSON data else show category error message. 
if(!empty($category->category)){
    //Make JSON 
    echo json_encode($cat_arr);
}else{
      echo json_encode(array('message' => 'category_id Not Found'));
}


?>
  