

<?php
session_start();

if(isset($_POST['txtUserName']) && (isset($_POST['txtUserPass'])) && (isset($_POST['userEmail'])))
{
    $uname=$_POST['txtUserName'];
    $upass=$_POST['txtUserPass'];
    $uemail=$_POST['userEmail'];
    $emailUsed=0;


    try
    {
        $db=new mysqli('localhost','root','','furnitureDB');

        $res=$db->query("SELECT * FROM users");
        while ($row = $res->fetch_object()) {
            if ($uemail == $row->uEmail) {
                $emailUsed=1;
                break;
            }
        }
        if ($emailUsed==1) {
            echo '<script>alert("This email is used!");</script>';
            echo '<script>window.location.href="Login.html";</script>';
        }
        else{
        $qryStr="INSERT INTO `users` (`userId`, `uName`, `uPass`, `uLevel`,`uEmail`) VALUES (NULL, '".$uname."',sha1('".$upass."'), '0', '".$uemail."');";
        $res=$db->query($qryStr);

        $db->close();

        echo '<script>alert("Welcome in our  FURNICO!");</script>';
        echo '<script>window.location.href="Home.html";</script>';
        exit;
    }

    }
    catch (Exception $e){
        echo '<script>alert("An error occurred: ' . $e->getMessage() . '");</script>';
        echo '<script>window.location.href="Login.html";</script>';
    }
}

?>

