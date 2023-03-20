<?php
//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Methods, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

//required files
require('../../config/Database.php');
require('../../models/Author.php');

//Instantiate DB and Connect
$database = new Database();
$db = $database->connect();

//Instantiate Author object
$author = new Author($db);

//Get raw posted data
$data = json_decode(file_get_contents("php://input"));


//checks to see if data is set for Author, if it is not set then echo error message. 
if (!empty($data->author)) 
{
    $author->author = $data->author;
  
    //Create Author, echo id and author.
    $author->create();
    //Use lastInsertId() to pull the last inserted value of the row or value.
    echo json_encode(array("id"=> $db->lastInsertId(), "author"=>$author->author));
  
} else {
    //Missing required information error message. 
    echo json_encode(array('message' => 'Missing Required Parameters'));
  
}
