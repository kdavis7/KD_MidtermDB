<?php
//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

//required files
require('../../config/Database.php');
require('../../models/Category.php');

//Instantiate DB and connect
$database = new Database();
$db = $database->connect();

//Instantiate category object
$category = new Category($db);

//category query
$result = $category->read();

//Get row count
$num = $result->rowCount();

//Check for Categories
if($num > 0) {
    //Category array
    $cat_arr = array();
    

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $cat_item = array(
            'id'=>$id,
            'category'=>$category
        );

        //Push data
        array_push($cat_arr, $cat_item);
    }

if ($cat_arr){
    //turn to JSON and output data
    echo (json_encode($cat_arr));
}

} else {
    echo json_encode(array('message' => 'No Categories Found'));
}

?>