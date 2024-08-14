<?php
session_start();

if(isset($_POST)){
    $data3=file_get_contents("php://input");
    $deleteProductData=json_decode($data3,true);


    try {

        $db = new mysqli('localhost', 'root', '', 'furnitureDB');


        $qryStr = "DELETE FROM favourite WHERE productName = ? AND userId = ?";
        $stmt = $db->prepare($qryStr);
        $stmt->bind_param("si", $deleteProductData["productName"], $_SESSION['uId']); // s for string, i for integer
        $res = $stmt->execute();


        $qryStr2 = "SET @num := 0;";
        $qryStr3= "UPDATE favourite SET favId = @num := (@num+1)";
        $qryStr4=  "ALTER TABLE `favourite` AUTO_INCREMENT = 1;";

        $db->query($qryStr2);
        $db->query($qryStr3);
        $db->query($qryStr4);

        $db->close();
        exit;
    }
    catch (Exception $e){}
}

?>
