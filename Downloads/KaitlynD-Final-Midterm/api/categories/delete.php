<?php
//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
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

//Set ID to update
$category->id = $data->id;

//Delete the Category and return category id. 
if($category->delete()) {
  
    echo json_encode(array("id"=>$category->id));

  //if category value is not empty then state Category was not deleted. 
} else if(!empty($data->category)){
    
    echo json_encode(array('message' => 'Category was not deleted.'));
  
}
        