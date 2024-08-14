<?php
session_start();

try {
    $db = mysqli_connect("localhost", "root", "", "furnitureDB");
    $qryStr = "SELECT * FROM products";

    $Products = array();

    $res = $db->query($qryStr);

    for ($i = 0; $i < $res->num_rows; $i++) {
        $row = $res->fetch_object();
        $Products[$i] = $row;
    }

    $db->close();
    $_SESSION['products'] = $Products;

    // Output JSON data
    header('Content-Type: application/json');
    echo json_encode($Products);

    exit();
} catch (Exception $e) {
    // Handle exception
}
?>