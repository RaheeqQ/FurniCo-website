<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['txtUserName']) && isset($_POST['txtUserPass'])) {
        $uname = $_POST['txtUserName'];
        $upass = $_POST['txtUserPass'];

        try {
            $db = new mysqli('localhost', 'root', '', 'furnitureDB');
            if ($db->connect_error) {
                die("Connection failed: " . $db->connect_error);
            }

            $qryStr = "SELECT * FROM users WHERE uName = ?";
            $stmt = $db->prepare($qryStr);
            if (!$stmt) {
                die("Prepare statement failed: " . $db->error);
            }

            $stmt->bind_param("s", $uname);
            $stmt->execute();
            $res = $stmt->get_result();

            $_SESSION['loginFail'] = 0;

            while ($row = $res->fetch_object()) {
                if (sha1($upass) == $row->uPass) {
                    if ($row->isManeger == 1) {
                        echo '<script>alert("Welcome Manager!");</script>';
                        echo '<script>window.location.href="manegerPage.php";</script>';
                        exit;
                    } else {
                        $_SESSION['loginFail'] = 1;
                        $_SESSION['uId'] = $row->userId;

                        echo '<script>alert("Login successful!");</script>';
                        echo '<script>window.location.href="Home.html";</script>';
                        exit;
                    }
                }
            }

            $stmt->close();
            $db->close();

            if ($_SESSION['loginFail'] == 0) {
                echo '<script>alert("Incorrect username or password!");</script>';
                echo '<script>window.location.href="Login.html";</script>';
            }

        } catch (Exception $e) {
            echo '<script>alert("An error occurred: ' . $e->getMessage() . '");</script>';
        }
    } else {
        echo '<script>alert("Username and Password are required!");</script>';
    }
} else {
    echo '<script>alert("Invalid request method!");</script>';
}
?>

