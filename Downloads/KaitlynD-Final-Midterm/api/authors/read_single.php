<?php
//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

//required files
require('../../config/Database.php');
require('../../models/Author.php');

//Instantiate DB and Connect
$database = new Database();
$db = $database->connect();

//Instantiate author object
$author = new Author($db);

//Get ID
$author->id = isset($_GET['id']) ? $_GET['id'] : die();

//GET Author
$author->read_single();

//Create array
$auth_arr = array(
    'id' => $author->id,
    'author' => $author->author
);

//check to see if Author is empty, if it is not empty then print JSON data else show author error message. 
if(!empty($author->author)){
    //Make JSON 
    echo json_encode($auth_arr);
}else{
    echo json_encode(array('message' => 'author_id Not Found'));
}

?>