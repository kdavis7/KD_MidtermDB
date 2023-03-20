<?php
//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

//required files
require('../../config/Database.php');
require('../../models/Quote.php');

//Instantiate DB and connect
$database = new Database();
$db = $database->connect();

//Instantiate quote object
$quote = new Quote($db);

// get data
$quote->id = isset($_GET['id']) ? $_GET['id']: die();

//GET quote
$quote->read_single();

//Create array
$quote_arr = array(
    'id' => $quote->id,
    'quote'=> $quote->quote,
    'author' => $quote->author,
    'category'=> $quote->category
);

//check to see if quote is empty, if it is not empty then print JSON data else show quote error message. 
if(!empty($quote->quote)){
    //Make JSON 
    echo json_encode($quote_arr);
}else{
    echo json_encode(array('message' => 'No Quotes Found'));
}








?>