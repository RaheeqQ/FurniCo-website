<?php
session_start();

if(isset($_POST)){
    $data=file_get_contents("php://input");
    $priceTot=json_decode($data,true);


    try {

        $db = new mysqli('localhost', 'root', '', 'furnitureDB');


        $qryStr = "UPDATE cart SET totPrice = ? WHERE productName = ? AND userId = ?";
        $stmt = $db->prepare($qryStr);
        $stmt->bind_param("isi", $priceTot["tot_price"], $priceTot["product_name"],$_SESSION['uId']);
        $res = $stmt->execute();


        $db->close();
        exit;
    }
    catch (Exception $e){}
}

?>
