<?php
session_start();

try {
    $db = new mysqli('localhost', 'root', '', 'furnitureDB');
    $sql = "SELECT * FROM products";
    $Products2 = array();
    $result = $db->query($sql);
    for($i = 0; $i < $result->num_rows; $i++){
        $row = $result->fetch_object();
        $Products2[$i] = $row;
    }

    $db->close();
    $_SESSION['products'] = $Products2;

    header('Content_Type: application/json');
    echo json_encode($Products2);
    exit();
}catch (Exception $e){
    echo $e->getMessage();
}

?>
