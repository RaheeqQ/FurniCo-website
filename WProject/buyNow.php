
<?php
//session_start();
//
//try {
//    $db = new mysqli('localhost', 'root', '', 'furnitureDB');
//    if ($db->connect_error) {
//        die("Connection failed: " . $db->connect_error);
//    }
//
//    $qryStr = "SELECT * FROM users";
//    $res = $db->query($qryStr);
//    $openCheckOut = 0;
//
//    while ($row = $res->fetch_object()) {
//        if ($row->userId == $_SESSION['uId']) {
//            if ($row->uCardNo == 0) {
//                $openCheckOut = 1;
//            } else {
//                $openCheckOut = 0;
//            }
//            break;
//        }
//    }
//
//    $data = file_get_contents("php://input");
//    $fillOrder = json_decode($data, true);
//
//    // For table orders
//    if (isset($fillOrder['tot_price']) && $fillOrder['tot_price'] != 0) {
//        $qryStr3 = "INSERT INTO `orders` (`user_id`, `order_date`, `tot_amount`) VALUES ('" . $_SESSION['uId'] . "', CURDATE(), '" . $fillOrder['tot_price'] . "');";
//        $db->query($qryStr3);
//    }
//
//    // For table order items
//    $user_items = array();
//    $order_items = array();
//
//    $qryStr2 = "SELECT * FROM cart";
//    $res2 = $db->query($qryStr2);
//    while ($row2 = $res2->fetch_object()) {
//        if ($row2->userId == $_SESSION['uId']) {
//            $user_items[] = $row2;
//        }
//    }
//
//    $qryStr3 = "SELECT * FROM orders";
//    $res3 = $db->query($qryStr3);
//    while ($row3 = $res3->fetch_object()) {
//        if ($row3->user_id == $_SESSION['uId']) {
//            $order_items[] = $row3;
//        }
//    }
//
//    // Debugging output to verify arrays content
//    echo "<pre>";
//    print_r($user_items);
//    print_r($order_items);
//    echo "</pre>";
//
//    for ($i = 0; $i < count($order_items); $i++) {
//        $counter = 0;
//        $flag = -1; // Initialize flag to an invalid index
//
//        // Cache the count of user_items for efficiency
//        $user_items_count = count($user_items);
//
//        for ($j = 0; $j < $user_items_count; $j++) {
//            $counter += $user_items[$j]->totPrice;
//
//            if ($counter == $order_items[$i]->tot_amount ||
//                $counter == $order_items[$i]->tot_amount - 1 ||
//                $counter == $order_items[$i]->tot_amount + 1) {
//                $flag = $j;
//                break;
//            }
//        }
//        // Ensure flag is a valid index
//        if ($flag >= 0 && $flag < $user_items_count) {
//            for ($k = 0; $k <= $flag; $k++) {
//                $qryStr3 = "INSERT INTO `orderitems` (`order_id`, `product_id`, `qty`, `price_per_item`, `total_price`) VALUES (?, ?, ?, ?, ?)";
//                $stmt = $db->prepare($qryStr3);
//                if ($stmt === false) {
//                    die("Prepare failed: " . $db->error);
//                }
//                $stmt->bind_param(
//                    "isiid",
//                    $order_items[$i]->order_id,
//                    $user_items[$k]->productId,
//                    $user_items[$k]->qnt,
//                    $user_items[$k]->price,
//                    $user_items[$k]->totPrice
//                );
//                if (!$stmt->execute()) {
//                    die("Execute failed: " . $stmt->error);
//                }
//                $stmt->close();
//            }
//        }
//
//    }

//     To open thank you page or fill information page
//    if ($openCheckOut == 1) {
//        echo '<script>window.location.href="checkOut.html";</script>';
//    } else {
//        echo '<script>window.location.href="thanks.html";</script>';
//    }
//
//    $db->close();
//} catch (Exception $e) {
//    echo 'Caught exception: ', $e->getMessage(), "\n";
//}

session_start();

try {
    $db = new mysqli('localhost', 'root', '', 'furnitureDB');
    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    }

    $qryStr = "SELECT * FROM users";
    $res = $db->query($qryStr);
    $openCheckOut = 0;

    while ($row = $res->fetch_object()) {
        if ($row->userId == $_SESSION['uId']) {
            if ($row->uCardNo == 0) {
                $openCheckOut = 1;
            } else {
                $openCheckOut = 0;
            }
            break;
        }
    }

    $data = file_get_contents("php://input");
    $fillOrder = json_decode($data, true);

    $order__id = 0;

    // For table orders
    if (isset($fillOrder['tot_price']) && $fillOrder['tot_price'] != 0) {
        $qryStr3 = "INSERT INTO `orders` (`user_id`, `order_date`, `tot_amount`) VALUES (?, CURDATE(), ?)";
        $stmt3 = $db->prepare($qryStr3);
        $stmt3->bind_param("ii", $_SESSION['uId'], $fillOrder['tot_price']);
        if (!$stmt3->execute()) {
            die("Execute failed: " . $stmt3->error);
        }

        //////////////////////////////
        $qryStr5 = "SELECT * FROM orders";
        $res5 = $db->query($qryStr5);

        for ($i = 0; $i < $res5->num_rows; $i++) {

            $row5 = $res5->fetch_object();
            $order__id= $row5->order_id;
        }
        ////////////////////////
        $stmt3->close();

        // Update cart table with orderId
        $qryStr4 = "UPDATE cart SET orderId = ? WHERE userId = ? AND orderId = 0";
        $stmt4 = $db->prepare($qryStr4);
        $stmt4->bind_param("ii", $order__id, $_SESSION['uId']);
        if (!$stmt4->execute()) {
            die("Execute failed: " . $stmt4->error);
        }
        $stmt4->close();
    }

    // Fetch user_items from cart table
    $user_items = array();
    $qryStr2 = "SELECT * FROM cart WHERE userId = ? AND orderId = ?";
    $stmt2 = $db->prepare($qryStr2);
    $stmt2->bind_param("ii", $_SESSION['uId'], $order__id);
    if (!$stmt2->execute()) {
        die("Execute failed: " . $stmt2->error);
    }
    $res2 = $stmt2->get_result();
    while ($row2 = $res2->fetch_object()) {
        $user_items[] = $row2;
    }
    $stmt2->close();
//
//    echo "<pre>";
//    print_r($user_items);
//    echo "</pre>";

    // Insert into orderitems table
    foreach ($user_items as $item) {
        $qryStr5 = "INSERT INTO `orderitems` (`order_id`, `product_id`, `qty`, `price_per_item`, `total_price`) VALUES (?, ?, ?, ?, ?)";
        $stmt5 = $db->prepare($qryStr5);
        $stmt5->bind_param(
            "iiiii",
            $order__id,
            $item->productId,
            $item->qnt,
            $item->price,
            $item->totPrice
        );
        if (!$stmt5->execute()) {
            die("Execute failed: " . $stmt5->error);
        }
        $stmt5->close();
    }

    // Redirect to appropriate page
    if ($openCheckOut == 1) {
        echo '<script>window.location.href="checkOut.html";</script>';
    } else {
        echo '<script>window.location.href="thanks.html";</script>';
    }

    $db->close();
} catch (Exception $e) {
    echo 'Caught exception: ', $e->getMessage(), "\n";
}

?>