<?php
session_start();

if(isset($_POST)){
    $data=file_get_contents("php://input");
    $productData=json_decode($data,true);

    $v1="";

    try {

        $db = new mysqli('localhost', 'root', '', 'furnitureDB');

        $qryStr1 = "SELECT * FROM products";

        $res1= $db->query($qryStr1);

        for ($i = 0; $i < $res1->num_rows; $i++) {
            $row = $res1->fetch_object();
            if( $productData["productName"]==$row->name){
                $v1=$row->product_id;
            }
        }


        $qryStr2 = "SELECT * FROM favourite";

        $res2 = $db->query($qryStr2);

        $toAdd2=1;
        for ($i2 = 0; $i2 < $res2->num_rows; $i2++) {
            $row2 = $res2->fetch_object();
            if( $productData["productName"]==$row2->productName && $v1==$row2->productId && $row2->userId==$_SESSION['uId']){
                $toAdd2=0;
            }
        }

        if($toAdd2==1){
            $qryStr3 = "INSERT INTO `favourite` (`userId`, `productId`,`productName`,`price`) VALUES ('" . $_SESSION['uId']. "',$v1,'" . $productData["productName"] . "','" . $productData["productPrice"] . "');";
            $res3 = $db->query($qryStr3);
        }


        $db->close();
        exit;


    }
    catch (Exception $e){
        echo '<script>alert("An error occurred: ' . $e->getMessage() . '");</script>';

    }
}

?>
