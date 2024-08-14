<?php
session_start();

try {
    $db = new mysqli('localhost', 'root', '', 'furnitureDB');
    $qryStr = "SELECT * FROM products";

    $productDataList = array();

    $res = $db->query($qryStr);

    for ($i = 0; $i < $res->num_rows; $i++) {
        $row = $res->fetch_object();
        $productDataList[$i] = $row;
    }

    $db->close();
//    $_SESSION['products'] = $Products3;

    // Output JSON data
    header('Content-Type: application/json');
    echo json_encode($productDataList);

    exit;
} catch (Exception $e) {
    // Handle exception
}
?>
