<?php
session_start();
if(isset($_POST['firstName']) && isset($_POST['lastName']) && isset($_POST['email']) && isset($_POST['phone']) && isset($_POST['message'])){
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $message = $_POST['message'];

    try{
        $db = new mysqli('localhost', 'root', '', 'furnitureDB');
        $sql = "INSERT INTO reviews (first_name, last_name, rEmail, rPhone, rMsg, user_id) VALUES ('".$firstName."', '".$lastName."', '".$email."', '".$phone."', '".$message."', '" . $_SESSION['uId']. "')";
        $result = $db->query($sql);
        if ($result === TRUE) {
            echo '<script>alert("Message sent successfully!");</script>';
        } else {
            echo "Error: " . $sql . "<br>" . $db->error;
        }

        $db->close();
    }catch (Exception $e){

    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>FurniCo</title>

    <link rel="stylesheet" href="styleContactUs.css">
    <link rel="website icon" type="png" href="imgs/icon.png">
</head>
<body>
<header>
    <table width="100%">
        <tr>
            <td><a href="Home.html"><img src="imgs/logo1.jpg" alt="trial2" width="250" height="50"></a></td>
            <td>
                <nav>
                    <ul>
                        <li><a href="Home.html"> Home </a></li>
                        <li><a href="#aboutUs">About us </a></li>
                        <li><a href="page1.html"> Products </a></li>
                        <li><a href="#"> Contact us </a></li>
                    </ul>
                </nav>
            </td>
            <td width="50"><a href="shoppingCart.html"><img src="imgs/bag.png" class="icons" alt="trial2"align ="right"onmouseover="this.src='imgs/shopping-cart.png';" onmouseout="this.src='imgs/bag.png'"></a>
                <!--<img src="imgs/home.png" alt="trial2"align ="right">-->
            </td>
            <td width="40"><img src="imgs/heart.png" class="icons" alt="trial2"align ="right"onmouseover="this.src='imgs/heart2.png';" onmouseout="this.src='imgs/heart.png'"></td>
            <td width="40"><a href="Login.html"><img src="imgs/login.png" class="icons" alt="trial2"align ="right"onmouseover="this.src='imgs/login2.png';" onmouseout="this.src='imgs/login.png'"></a></td>

        </tr>
    </table>
</header>
<section class="contactSection">
    <div class="contactUs">
        <h3>Get in Touch with Us</h3>
        <h2>Contact Us</h2>
        <div class="line">
            <div></div>
            <div></div>
            <div></div>
        </div>
        <p class="text">
            At FurniCo, we are committed to providing exceptional
            customer service and high-quality furniture that enhances your living spaces.
            Whether you have questions about our products, need assistance with your order,
            or want to share your feedback, our dedicated team is here to help.
        </p>
    </div>

    <div class="contactBody">
        <div class="contactInfo">
            <div>
                <span><ion-icon name="phone-portrait-outline"></ion-icon></span>
                <span>Phone Number</span>
                <span class="text">059-9595555</span>
            </div>
            <div>
                <span><ion-icon name="mail-outline"></ion-icon></span>
                <span>E-mail</span>
                <span class="text">furniCo@gmail.com</span>
            </div>
            <div>
                <span><ion-icon name="location-outline"></ion-icon></ion-icon></span>
                <span>Address</span>
                <span class="text">Heifa Street, jenin, palestine</span>
            </div>
            <div>
                <span><ion-icon name="time-outline"></ion-icon></span>
                <span>Opening Hours</span>
                <span class="text">Monday-Friday (8am-8pm) <br>Saturday (9am-5:30pm)</span>
            </div>
        </div>
        <hr>
        <div class="contactForm">
            <form action="contactUs.php" method="post">
                <div>
                    <input type="text" class="formControl" name="firstName" placeholder="First Name">
                    <input type="text" class="formControl" name="lastName" placeholder="Last Name">
                </div>
                <div>
                    <input type="email" class="formControl" name="email" placeholder="E-mail">
                    <input type="text" class="formControl" name="phone" placeholder="Phone">
                </div>
                <textarea rows="5" cols="57" name="message" placeholder="Message" class="formControl"></textarea><br>
                <input type="submit" class="send" value="send message">

            </form>

            <div><img src="imgs/contactUs.webp" alt=""></div>

        </div>
    </div>
    <div class="map">
        <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d2844.413618403375!2d35.289030218525276!3d32.46853041854774!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sar!2s!4v1717252326774!5m2!1sar!2s"
                width="100%" height="450"
                style="border:0;" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
    <div class="contactFooter">
        <h3>Follow Us</h3>
        <div class="socialLinks">
            <a href="https://www.instagram.com/"><img src="imgs/instagram.png"></a>
            <a href="https://x.com/?lang=ar"><img src="imgs/twitter.png"></a>
            <a href="https://www.facebook.com/"><img src="imgs/facebook.png"></a>
            <a href="https://www.linkedin.com/"><img src="imgs/linkedin.png"></a>
            <a href="https://www.youtube.com/"><img src="imgs/youtube.png"></a>
        </div>
    </div>
</section>

<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>