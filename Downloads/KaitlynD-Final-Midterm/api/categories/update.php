<?php
//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Methods, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

//required files
require('../../config/Database.php');
require('../../models/Category.php');

//Instantiate DB and connect
$database = new Database();
$db = $database->connect();

//Instantiate Category object
$category = new Category($db);

//Get raw posted data
$data = json_decode(file_get_contents("php://input"));


//Check if data is not empty for categories to update then update else display error message. 
if (!empty($data->category)) {
    //Set ID to Update
    $category->id = $data->id;
    $category->category = $data->category;

    //Update Category 
    $category->update();
    echo json_encode(array("id"=>$category->id, "category"=>$category->category));
  
} else { 
    echo json_encode(array('message' => 'Missing Required Parameters'));
}
