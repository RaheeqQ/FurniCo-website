<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['email']) && isset($_POST['password']) && isset($_POST['confirmPassword'])) {
        $uEmail = $_POST['email'];
        $uPassword = $_POST['password'];
        $uConfirmPassword = $_POST['confirmPassword'];

        if ($uPassword == $uConfirmPassword) {
            try {
                $db = new mysqli('localhost', 'root', '', 'furnitureDB');

                if ($db->connect_error) {
                    die("Connection failed: " . $db->connect_error);
                }

                $hashedPassword = sha1($uPassword);
                $qryStr = "UPDATE users SET uPass = ? WHERE uEmail = ?";
                $stmt = $db->prepare($qryStr);

                if (!$stmt) {
                    die("Prepare statement failed: " . $db->error);
                }

                $stmt->bind_param("ss", $hashedPassword, $uEmail);
                $res = $stmt->execute();

                if (!$res) {
                    die("Query failed: " . $stmt->error);
                }

                $stmt->close();
                $db->close();

                echo '<script>alert("Password has been successfully updated!");</script>';
                echo '<script>window.location.href="Login.html";</script>';
                exit;
            } catch (Exception $e) {
                echo '<script>alert("An error occurred: ' . $e->getMessage() . '");</script>';
                echo '<script>window.location.href="Login.html";</script>';
            }
        } else {
            echo '<script>alert("Passwords do not match!");</script>';
        }
    } else {
        echo '<script>alert("Please fill in all fields!");</script>';
    }
}
?>


