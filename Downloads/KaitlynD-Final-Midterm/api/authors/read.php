<?php
//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

//required files
require('../../config/Database.php');
require('../../models/Author.php');

//Instantiate DB and connect
$database = new Database();
$db = $database->connect();

//Instantiate Author object
$author = new Author($db);

//Author read query
$result = $author->read();

//Get row count
$num = $result->rowCount();

//Check for authors
if($num > 0) {
    //Author array, took out data array due to errors with testing. 
    $auth_arr = array();
   

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $auth_item = array(
            'id'=> $id,
            'author'=> $author
        );

        //Push the data, Do not include ['data'] due to errors with testing. 
        array_push($auth_arr, $auth_item);
    }

    //turn to JSON and output data
    echo (json_encode($auth_arr));

} else {
    //No Authors Found error message 
    echo json_encode(array('message' => 'No Authors Found'));
}

?>