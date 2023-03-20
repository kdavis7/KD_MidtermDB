<?php
//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Methods, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

//required files
require ('../../config/Database.php');
require ('../../models/Quote.php');

//Instantiate DB & connect
$database = new Database();
$db = $database->connect();

//Instantiate quote object
$quote = new Quote($db);

//Get the raw quote data
$data = json_decode(file_get_contents("php://input"));

//assign the data to quote
$quote->quote = $data->quote;
$quote->author_id = $data->author_id;
$quote->category_id= $data->category_id;

//if any fields missing, send error
if(!isset($data->id) || !isset($data->quote) || !isset($data->author_id) || !isset($data->category_id)) {
      echo json_encode(array('message' => 'Missing Required Parameters'));
      exit();
}
    

//Create quote
if($quote->create()) {
      echo json_encode(array("id"=>$quote->id,"quote"=>$quote->quote, "author_id"=>$quote->author_id, "category_id"=>$quote->category_id));
      return;
    }else{
        echo json_encode(array('message'=> 'No Quotes Found'));
    }
    
  
