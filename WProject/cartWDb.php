<?php
session_start();
//$arr=explode(",",$_GET['cartItems']);
//print_r($arr);
//echo "hhii";

if(isset($_POST)){
    $data=file_get_contents("php://input");
    $user=json_decode($data,true);

    $v1="";

    try {

        $db = new mysqli('localhost', 'root', '', 'furnitureDB');

        $qryStr1 = "SELECT * FROM products";

        $res1= $db->query($qryStr1);

        for ($i = 0; $i < $res1->num_rows; $i++) {
            $row = $res1->fetch_object();
            if( $user["pname"]==$row->name){
                $v1=$row->product_id;
            }
        }


        $qryStr2 = "SELECT * FROM cart";

        $res2 = $db->query($qryStr2);

        $toAdd=1;
        for ($i2 = 0; $i2 < $res2->num_rows; $i2++) {
            $row2 = $res2->fetch_object();
            if( $user["pname"]==$row2->productName && $v1==$row2->productId && $row2->userId==$_SESSION['uId']){
                $toAdd=0;
            }
        }

        if($toAdd==1){
            $qryStr3 = "INSERT INTO `cart` (`userId`, `productId`,`productName`,`qnt`,`price`,`totPrice`) VALUES ('" . $_SESSION['uId']. "',$v1,'" . $user["pname"] . "','" . $user["pqty"] . "','" . $user["pprice"] . "','" . $user["pprice"]*  $user["pqty"] . "');";
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