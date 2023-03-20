<?php
//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Methods, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

//required files
require('../../config/Database.php');
require('../../models/Category.php');

//Database
$database = new Database();
$db = $database->connect();

//Instantiate Category object
$category = new Category($db);

//Get raw posted data
$data = json_decode(file_get_contents("php://input"));


//checks to see if data is set for CATEGORY, if it is not set then echo error message. 
if (!empty($data->category)) 
{
    $category->category = $data->category;
  
    //Create Category, echo id and author.
    $category->create();
    //Use lastInsertId() to pull the last inserted value of the row or value.
    echo json_encode(array("id"=> $db->lastInsertId(), "category"=>$category->category));
  
} else {
    //Missing required information error message. 
    echo json_encode(array('message' => 'Missing Required Parameters'));
  
}