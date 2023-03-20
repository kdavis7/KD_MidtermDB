<?php
//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Methods, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

//required files
require('../../config/Database.php');
require('../../models/Author.php');

//Instantiate DB and connection
$database = new Database();
$db = $database->connect();

//Instantiate Author object
$author = new Author($db);

//Get raw posted data
$data = json_decode(file_get_contents("php://input"));


//Check if data is not empty for author to update then update else display error message. 
if (!empty($data->author)) {
    //Set ID to Update Author
    $author->id = $data->id;
    $author->author = $data->author;

    //Update Author
    $author->update();
    echo json_encode(array("id"=>$author->id, "author"=>$author->author));
  
} else {
    echo json_encode(array('message' => 'Missing Required Parameters'));
}