<?php

session_start();


if (isset($_POST['firstname']) && isset($_POST['address']) && isset($_POST['city']) && isset($_POST['state'])
    && isset($_POST['zip']) && isset($_POST['cardname']) && isset($_POST['cardnumber']) && isset($_POST['expmonth'])
    && isset($_POST['expyear']) && isset($_POST['cvv'])) {

    $uname = $_POST['firstname'];
    $uadd = $_POST['address'];
    $ucity = $_POST['city'];
    $ustate = $_POST['state'];
    $uzip = $_POST['zip'];
    $ucardname = $_POST['cardname'];
    $ucardnum = $_POST['cardnumber'];
    $uexpm = $_POST['expmonth'];
    $uexpy = $_POST['expyear'];
    $ucvv = $_POST['cvv'];

    $uid2=$_SESSION['uId'];

    try {
        $db = new mysqli('localhost', 'root', '', 'furnitureDB');

        $qryStr = "UPDATE users
                   SET uFullName = ?, 
                       uAddress = ?,
                       uCity = ?,
                       uState = ?,
                       uZip = ?,
                       uCardName = ?,
                       uCardNo = ?,
                       uExpM = ?,
                       uExpY = ?,
                       uCvv = ?
                   WHERE userId = ?";

        $stmt = $db->prepare($qryStr);
        if (!$stmt) {
            throw new Exception('Prepare failed: ' . $db->error);
        }

        $stmt->bind_param("ssssssssssi", $uname, $uadd, $ucity, $ustate, $uzip, $ucardname, $ucardnum, $uexpm, $uexpy, $ucvv, $uid2);

        if (!$stmt->execute()) {
            throw new Exception('Execute failed: ' . $stmt->error);
        }

        $stmt->close();
      //  $db->query($qryStr);
        $db->close();

        echo '<script>alert("Information Added Successfully");</script>';
        echo '<script>window.location.href="thanks.html";</script>';



    } catch (Exception $e) {
        echo '<script>alert("An error occurred: ' . $e->getMessage() . '");</script>';
    }

}

?>
