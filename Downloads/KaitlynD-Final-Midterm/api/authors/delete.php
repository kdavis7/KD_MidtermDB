<?php
//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Methods, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

//required files
require('../../config/Database.php');
require('../../models/Author.php');

//Instantiate Db & connect
$database = new Database();
$db = $database->connect();

//Instantiate Author object
$author = new Author($db);

//Get raw posted data
$data = json_decode(file_get_contents("php://input"));

//Set the id
$author->id = $data->id;

//Delete author, turn the array into JSON data and return the id field. 
if($author->delete()) {
  
    echo json_encode(array("id"=>$author->id));

  //if author value is not empty then state Author was not deleted. 
} else if(!empty($data->author)){
    
    echo json_encode(array('message' => 'Author was not deleted.'));
  
}
