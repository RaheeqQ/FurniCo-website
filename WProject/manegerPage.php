<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $db = new mysqli('localhost', 'root', '', 'furnitureDB');

        if ($db->connect_error) {
            throw new Exception('Connection failed: ' . $db->connect_error);
        }
        $id = $_POST['id'];
        $name = $_POST['productName'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $cateId = $_POST['cateId'];
        $stockQ = $_POST['stockQ'];
        $color = $_POST['color'];
        $img = $_POST['img'];

        $stmt = $db->prepare("INSERT INTO products (product_id, name, description, price, category_id, stock_quantity, color, image_url) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        if (!$stmt) {
            throw new Exception('Prepare statement failed: ' . $db->error);
        }

        $stmt->bind_param("issdiiss",$id, $name, $description, $price,$cateId, $stockQ, $color, $img);
        $stmt->execute();

        $productId = $stmt->insert_id;

        $_SESSION['productId']=$productId;

        $stmt->close();

    } catch (Exception $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
    echo '<script>window.location.href="manegerPage.php";</script>';
    exit;
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Furnico</title>
    <link rel="stylesheet" href="page1.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="website icon" type="png" href="imgs/icon.png">

    <script src="jsCart.js"></script>
    <script src="jsPage1.js"></script>

    <style>
        .clickToAdd {
            font-size: 18px;
            text-decoration: none;
            border: 2px solid #424530;
            color: #f1f1f1;
            background-color: #424530;
            border-radius: 10px;
            box-shadow: 3px 3px 3px #cd7307;
            padding: 10px 20px;
            cursor: pointer;
            margin-top: 10px;
        }
    </style>
</head>
<body>
<div>
    <table border="0" class="table1" cellspacing="0" cellpadding="0">
        <tr class="row1">
            <td class="col1">
                <!--            <h1 class="title"> Furnico</h1>-->
                <a href="Home.html"><img src="imgs/logo1.jpg" alt="trial2" width="250" height="50"></a>
            </td>
            <td class="col2">
                <div class="col2box">
                    <form action="">
                        <i class="fa fa-search"></i>
                        <input type="search" id="searchInput" placeholder="Search for products and ideas..." class="s1" style="color: #fffcf5" onkeyup="search()">
                    </form>
                </div>
            </td>
            <td class="col3">
                <div class="icons">
                    <label class="icon">
                        <a href="javascript:void(0)" onclick="window.open('shoppingCart.html')" ><i class="fa fa-cart-plus"></i></a>
                        <a href="#" > <i class="fa fa-heart"></i></a>
                        <a href="Login.html"> <i class="fa fa-user"></i></a>
                    </label>
                </div>
            </td>
        </tr>
    </table>
    <table class="table1">

        <tr class="row2">
            <td colspan="3">

                <div class="tab">
                    <button class="tablinks" id="kitchen2" onclick="openCity(event, 'Kitchen');"><b>Kitchen</b></button>
                    <button class="tablinks" onclick="openCity(event, 'Sofa')"><b>Sofa</b></button>
                    <button class="tablinks" onclick="openCity(event, 'Beds')"><b>Beds</b></button>
                    <button class="tablinks" onclick="openCity(event, 'Clocks')"><b>Clocks</b></button>
                    <button class="tablinks" onclick="openCity(event, 'Tables')"><b>Tables</b></button>
                    <button class="tablinks" onclick="openCity(event, 'Rugs')"><b>Rugs</b></button>
                    <button class="tablinks" onclick="openCity(event, 'Out Door')"><b>Out Door</b></button>
                </div>
            </td>
        </tr>

        <tr class="row3">
            <td colspan="3">
                <form>
                    <label><b>Sort By:</b></label>
                    <select name="sort" id="sortOptions" onchange="sortProducts()">
                        <option value="recommended">Recommended</option>
                        <option value="price high to low">Price High to Low</option>
                        <option value="price low to high">Price Low to High</option>
                    </select>
                </form>
            </td>
        </tr>
        <tr>
    </table>
</div>
<!--***********************************************************************************-->



<div id="productList">
    <div id="Kitchen" class="tabcontent" style="display: block;">
        <div class="container">
            <div class="box">

                <img src="imgs/bath1.jpg" id="product1" data-price="1500" onmouseover="this.src='imgs/bath2.jpg';" onmouseout="this.src='imgs/bath1.jpg'">
                <h2>GRAY WALL CABINET</h2>
                <p> Lorem ipsum dolor sit amet, consectetur adip sed te.</p>
                <span>1500$</span>
                <div class="rate">
                    <i class="fa fa-star checked"></i>
                    <i class="fa fa-star checked"></i>
                    <i class="fa fa-star checked"></i>
                    <i class="fa fa-star checked"></i>
                    <i class="fa fa-star checked"></i>
                </div>
                <div class="options">
                    <a href="#" class="a3"><i class="fa fa-heart-o"></i></a>
                    <a href="page2.html?category=kitchen&productId=1" class="a2"><i class='fa fa-angle-double-right'></i></a>
                    <a href="#" class="a1">Add to Cart</a>
                </div>
            </div>


            <div class="box" data-price="200">
                <img src="imgs/chair1.jpg" >
                <h2>Product 2</h2>
                <p> Lorem ipsum dolor sit amet, consectetur adip sed te.</p>
                <span>$200</span>
                <div class="rate">
                    <i class="fa fa-star checked"></i>
                    <i class="fa fa-star checked"></i>
                    <i class="fa fa-star checked"></i>
                    <i class="fa fa-star checked"></i>
                    <i class="fa fa-star checked"></i>
                </div>

                <div class="options">
                    <a href="#" class="a3"><i class="fa fa-heart-o"></i></a>
                    <a href="page2.html?category=kitchen&productId=2" class="a2"><i class='fa fa-angle-double-right'></i></a>
                    <a href="#" class="a1">Add to Cart</a>
                </div>

            </div>



            <div class="box" id="product3" data-price="500">
                <img src="imgs/11200x1200.jpg">
                <h2>Product 3</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adip sed te.</p>
                <span>$500</span>
                <div class="rate">
                    <i class="fa fa-star checked"></i>
                    <i class="fa fa-star checked"></i>
                    <i class="fa fa-star checked"></i>
                    <i class="fa fa-star checked"></i>
                    <i class="fa fa-star checked"></i>
                </div>
                <div class="options">
                    <a href="#" class="a3"><i class="fa fa-heart-o"></i></a>
                    <a href="page2.html?category=kitchen&productId=3" class="a2"><i class='fa fa-angle-double-right'></i></a>
                    <a href="#" class="a1 add-to-cart" data-product-name="Product 3 Kitchen">Add to Cart</a>
                </div>
            </div>


            <div class="box" id="product4" data-price="1500">
                <img src="imgs/1200x12010.jpg">
                <h2>Product 4</h2>
                <p> Lorem ipsum dolor sit amet, consectetur adip sed te.</p>
                <span>
              $1500
          </span>
                <div class="rate">
                    <i class="fa fa-star checked"></i>
                    <i class="fa fa-star checked"></i>
                    <i class="fa fa-star checked"></i>
                    <i class="fa fa-star checked"></i>
                    <i class="fa fa-star checked"></i>
                </div>
                <div class="options">
                    <a href="#" class="a3"><i class="fa fa-heart-o"></i></a>
                    <a href="page2.html?category=kitchen&productId=4" class="a2"><i class='fa fa-angle-double-right'></i></a>
                    <a href="#" class="a1 add-to-cart" data-product-name="Product 4 Kitchen">Add to Cart</a>
                </div>
            </div>


            <div class="box" id="product5" data-price="300">
                <img src="imgs/1200x12001.jpg">
                <h2>Product 5</h2>
                <p> Lorem ipsum dolor sit amet, consectetur adip sed te.</p>
                <span>
              $300
          </span>
                <div class="rate">
                    <i class="fa fa-star checked"></i>
                    <i class="fa fa-star checked"></i>
                    <i class="fa fa-star checked"></i>
                    <i class="fa fa-star checked"></i>
                    <i class="fa fa-star checked"></i>
                </div>
                <div class="options">
                    <a href="#" class="a3"><i class="fa fa-heart-o"></i></a>
                    <a href="page2.html?category=kitchen&productId=5" class="a2"><i class='fa fa-angle-double-right'></i></a>
                    <a href="#" class="a1 add-to-cart" data-product-name="Product 5 Kitchen">Add to Cart</a>
                </div>
            </div>


            <div class="box" id="product6" data-price="600">
                <img src="imgs/chair1.jpg">
                <h2>Product 6</h2>
                <p> Lorem ipsum dolor sit amet, consectetur adip sed te.</p>
                <span>$600</span>
                <div class="rate">
                    <i class="fa fa-star checked"></i>
                    <i class="fa fa-star checked"></i>
                    <i class="fa fa-star checked"></i>
                    <i class="fa fa-star checked"></i>
                    <i class="fa fa-star checked"></i>
                </div>
                <div class="options">
                    <a href="#" class="a3"><i class="fa fa-heart-o"></i></a>
                    <a href="page2.html?category=kitchen&productId=6" class="a2"><i class='fa fa-angle-double-right'></i></a>
                    <a href="#" class="a1 add-to-cart" data-product-name="Product 6 Kitchen">Add to Cart</a>
                </div>
            </div>
            <div class="productKitchen" style="display: none;"></div>
            <div class="box" id="product8">
                <form action="manegerPage.php" method="post">
                    <form action="manegerPage.php" method="post">
                        <input type="submit" value="submit">
                        <h2>Add new product</h2>
                        <input type="text" class="formControl" name="id" placeholder="Enter the product id">
                        <input type="text" class="formControl" name="productName" placeholder="Enter the name of the product">
                        <input type="text" class="formControl" name="description" placeholder="Enter description">
                        <div>
                            <input type="text" class="formControl2" name="price" placeholder="Enter price">
                            <input type="text" class="formControl2" name="cateId" placeholder="category id">
                        </div>
                        <div>
                            <input type="text" class="formControl2" name="stockQ" placeholder="stock quantity">
                            <input type="text" class="formControl2" name="color" placeholder="color">
                        </div>
                        <input type="text" class="formControl" name="img" placeholder="ImageURL">
                    </form>
                    <div><button onclick="display(1)" class="clickToAdd">click to add</button></div>
            </div>
            <!-- Add more products similarly -->


        </div>
    </div>

    <div id="Sofa" class="tabcontent">
        <div class="container">
            <div class="box" data-price="299.9">
                <img src="imgs/1.jpg" alt="bb" onmouseover="this.src='imgs/2.jpg';" onmouseout="this.src='imgs/1.jpg'">
                <h2>MORELLA DOUBLE SOFA BED</h2>
                <p> Lorem ipsum dolor sit amet, consectetur adip sed te.</p>
                <span>299.9$</span>
                <div class="rate">
                    <i class="fa fa-star checked"></i>
                    <i class="fa fa-star checked"></i>
                    <i class="fa fa-star checked"></i>
                    <i class="fa fa-star checked"></i>
                    <i class="fa fa-star checked"></i>
                </div>
                <div class="options">
                    <a href="#" class="a3"><i class="fa fa-heart-o"></i></a>
                    <a href="page2.html?category=bed&productId=1" class="a2"><i class='fa fa-angle-double-right'></i></a>
                    <a href="#" class="a1">Add to Cart</a>
                </div>
            </div>
            <div class="box">

                <img src="imgs/sofa1.jpg" alt="bb" onmouseover="this.src='imgs/sofa2.jpg';" onmouseout="this.src='imgs/sofa1.jpg'">
                <h2>TEDDY FUR ARMCHAIR CREAM</h2>
                <p> Lorem ipsum dolor sit amet, consectetur adip sed te.</p>
                <span>
            150₪
      </span>
                <div class="rate">
                    <i class="fa fa-star checked"></i>
                    <i class="fa fa-star checked"></i>
                    <i class="fa fa-star checked"></i>
                    <i class="fa fa-star checked"></i>
                    <i class="fa fa-star checked"></i>
                </div>
                <div class="options">
                    <a href="#" class="a3"><i class="fa fa-heart-o"></i></a>
                    <a href="page2.html?category=bed&productId=1" class="a2"><i class='fa fa-angle-double-right'></i></a>
                    <a href="#" class="a1">Add to Cart</a>
                </div>
            </div>
            <div class="box" data-price="220">
                <img src="imgs/5.jpg" onmouseover="this.src='imgs/55.jpg';" onmouseout="this.src='imgs/5.jpg'">
                <h2>ARMCHAIR WITH GOLD LEGS</h2>
                <p> Lorem ipsum dolor sit amet, consectetur adip sed te.</p>
                <span>220$</span>
                <div class="rate">
                    <i class="fa fa-star checked"></i>
                    <i class="fa fa-star checked"></i>
                    <i class="fa fa-star checked"></i>
                    <i class="fa fa-star checked"></i>
                    <i class="fa fa-star checked"></i>
                </div>
                <div class="options">
                    <a href="#" class="a3"><i class="fa fa-heart-o"></i></a>
                    <a href="page2.html?category=bed&productId=1" class="a2"><i class='fa fa-angle-double-right'></i></a>
                    <a href="#" class="a1">Add to Cart</a>
                </div>
            </div>

            <div class="box" data-price="220">
                <img src="imgs/1200x12001.jpg">
                <h2>WHITE CHAIR WITH WOOD LEGS</h2>
                <p> Lorem ipsum dolor sit amet, consectetur adip sed te.</p>
                <span>220$</span>
                <div class="rate">
                    <i class="fa fa-star checked"></i>
                    <i class="fa fa-star checked"></i>
                    <i class="fa fa-star checked"></i>
                    <i class="fa fa-star checked"></i>
                    <i class="fa fa-star checked"></i>
                </div>
                <div class="options">
                    <a href="#" class="a3"><i class="fa fa-heart-o"></i></a>
                    <a href="#" class="a2"><i class='fa fa-angle-double-right'></i></a>
                    <a href="#" class="a1">Add to Cart</a>
                </div>
            </div>

            <div class="productSofa" style="display: none;></div>
            <div class="box" id="product9">
                <form action="manegerPage.php" method="post">
                    <input type="submit" value="submit">
                    <h2>Add new product</h2>
                    <input type="text" class="formControl" name="id" placeholder="Enter the product id">
                    <input type="text" class="formControl" name="productName" placeholder="Enter the name of the product">
                    <input type="text" class="formControl" name="description" placeholder="Enter description">
                    <div>
                        <input type="text" class="formControl2" name="price" placeholder="Enter price">
                        <input type="text" class="formControl2" name="cateId" placeholder="category id">
                    </div>
                    <div>
                        <input type="text" class="formControl2" name="stockQ" placeholder="stock quantity">
                        <input type="text" class="formControl2" name="color" placeholder="color">
                    </div>
                    <input type="text" class="formControl" name="img" placeholder="ImageURL">
                </form>
                <div><button onclick="display(2)" class="clickToAdd">click to add</button></div>
            </div>
        </div>
    </div>
    <!---->

    <div id="Out Door" class="tabcontent">
        <div class="container">
            <div class="box" data-price="100">
                <img src="imgs/chair1.jpg" onmouseover="this.src = 'imgs/chair2.jpg';" onmouseout="this.src = 'imgs/chair1.jpg';">
                <h2>WILLOW GARDEN BENCH</h2>
                <p> Lorem ipsum dolor sit amet, consectetur adip sed te.</p>
                <span>100$</span>
                <div class="rate">
                    <i class="fa fa-star checked"></i>
                    <i class="fa fa-star checked"></i>
                    <i class="fa fa-star checked"></i>
                    <i class="fa fa-star checked"></i>
                    <i class="fa fa-star checked"></i>
                </div>
                <div class="options">
                    <a href="#" class="a3"><i class="fa fa-heart-o"></i></a>
                    <a href="page2.html?category=bed&productId=1" class="a2"><i class='fa fa-angle-double-right'></i></a>
                    <a href="#" class="a1">Add to Cart</a>
                </div>
            </div>

            <div class="box" data-price="220">
                <img src="imgs/1200x12001.jpg">
                <h2>WHITE CHAIR WITH WOOD LEGS</h2>
                <p> Lorem ipsum dolor sit amet, consectetur adip sed te.</p>
                <span>220$</span>
                <div class="rate">
                    <i class="fa fa-star checked"></i>
                    <i class="fa fa-star checked"></i>
                    <i class="fa fa-star checked"></i>
                    <i class="fa fa-star checked"></i>
                    <i class="fa fa-star checked"></i>
                </div>
                <div class="options">
                    <a href="#" class="a3"><i class="fa fa-heart-o"></i></a>
                    <a href="#" class="a2"><i class='fa fa-angle-double-right'></i></a>
                    <a href="#" class="a1">Add to Cart</a>
                </div>
            </div>
            <div class="productOutDoor" style="display: none;></div>
            <div class="box" id="product10">
                <form action="manegerPage.php" method="post">
                    <input type="submit" value="submit">
                    <h2>Add new product</h2>
                    <input type="text" class="formControl" name="id" placeholder="Enter the product id">
                    <input type="text" class="formControl" name="productName" placeholder="Enter the name of the product">
                    <input type="text" class="formControl" name="description" placeholder="Enter description">
                    <div>
                        <input type="text" class="formControl2" name="price" placeholder="Enter price">
                        <input type="text" class="formControl2" name="cateId" placeholder="category id">
                    </div>
                    <div>
                        <input type="text" class="formControl2" name="stockQ" placeholder="stock quantity">
                        <input type="text" class="formControl2" name="color" placeholder="color">
                    </div>
                    <input type="text" class="formControl" name="img" placeholder="ImageURL">
                </form>
                <div><button onclick="display(3)" class="clickToAdd">click to add</button></div>
            </div>
        </div>
    </div>
    <!---->
    <div id="Tables" class="tabcontent">
        <div class="container">
            <div class="box" data-price="350">

                <img src="imgs/4.png" onmouseover="this.src = 'imgs/44.png';" onmouseout="this.src = 'imgs/4.png';">
                <h2>MULTI STORAGE CABINET</h2>
                <p> Lorem ipsum dolor sit amet, consectetur adip sed te.</p>
                <span>350$</span>
                <div class="rate">
                    <i class="fa fa-star checked"></i>
                    <i class="fa fa-star checked"></i>
                    <i class="fa fa-star checked"></i>
                    <i class="fa fa-star checked"></i>
                    <i class="fa fa-star checked"></i>
                </div>
                <div class="options">
                    <a href="#" class="a3"><i class="fa fa-heart-o"></i></a>
                    <a href="page2.html?category=bed&productId=1" class="a2"><i class='fa fa-angle-double-right'></i></a>
                    <a href="#" class="a1">Add to Cart</a>
                </div>
            </div>

            <div class="box" data-price="100">

                <img src="imgs/table1.jpg" alt="bb" onmouseover="this.src='imgs/table2.jpg';" onmouseout="this.src='imgs/table1.jpg'">
                <h2>AMOS KIDS ACTIVITY TABLE</h2>
                <p> Lorem ipsum dolor sit amet, consectetur adip sed te.</p>
                <span>100$</span>
                <div class="rate">
                    <i class="fa fa-star checked"></i>
                    <i class="fa fa-star checked"></i>
                    <i class="fa fa-star checked"></i>
                    <i class="fa fa-star checked"></i>
                    <i class="fa fa-star checked"></i>
                </div>
                <div class="options">
                    <a href="#" class="a3"><i class="fa fa-heart-o"></i></a>
                    <a href="page2.html?category=bed&productId=1" class="a2"><i class='fa fa-angle-double-right'></i></a>
                    <a href="#" class="a1">Add to Cart</a>
                </div>
            </div>
            <div class="box" data-price="2200">
                <img src="imgs/disk1.jpg" alt="bb" onmouseover="this.src='imgs/disk2.jpg';" onmouseout="this.src='imgs/disk1.jpg'">
                <h2>APOLLO COMPUTER DESK</h2>
                <p> Lorem ipsum dolor sit amet, consectetur adip sed te.</p>
                <span>2200$</span>
                <div class="rate">
                    <i class="fa fa-star checked"></i>
                    <i class="fa fa-star checked"></i>
                    <i class="fa fa-star checked"></i>
                    <i class="fa fa-star checked"></i>
                    <i class="fa fa-star checked"></i>
                </div>
                <div class="options">
                    <a href="#" class="a3"><i class="fa fa-heart-o"></i></a>
                    <a href="#" class="a2"><i class='fa fa-angle-double-right'></i></a>
                    <a href="#" class="a1">Add to Cart</a>
                </div>
            </div>
            <div class="box" data-price="400">
                <img src="imgs/cupboard1.jpg" alt="bb" onmouseover="this.src='imgs/cupboard2.jpg';" onmouseout="this.src='imgs/cupboard1.jpg'">
                <h2>ACADIA PINE CUPBOARD</h2>
                <p> Lorem ipsum dolor sit amet, consectetur adip sed te.</p>
                <span>400$</span>
                <div class="rate">
                    <i class="fa fa-star checked"></i>
                    <i class="fa fa-star checked"></i>
                    <i class="fa fa-star checked"></i>
                    <i class="fa fa-star checked"></i>
                    <i class="fa fa-star checked"></i>
                </div>
                <div class="options">
                    <a href="#" class="a3"><i class="fa fa-heart-o"></i></a>
                    <a href="#" class="a2"><i class='fa fa-angle-double-right'></i></a>
                    <a href="#" class="a1">Add to Cart</a>
                </div>
            </div>
            <div class="productTables" style="display: none;></div>
            <div class="box" id="product11">
                <form action="manegerPage.php" method="post">
                    <input type="submit" value="submit">
                    <h2>Add new product</h2>
                    <input type="text" class="formControl" name="id" placeholder="Enter the product id">
                    <input type="text" class="formControl" name="productName" placeholder="Enter the name of the product">
                    <input type="text" class="formControl" name="description" placeholder="Enter description">
                    <div>
                        <input type="text" class="formControl2" name="price" placeholder="Enter price">
                        <input type="text" class="formControl2" name="cateId" placeholder="category id">
                    </div>
                    <div>
                        <input type="text" class="formControl2" name="stockQ" placeholder="stock quantity">
                        <input type="text" class="formControl2" name="color" placeholder="color">
                    </div>
                    <input type="text" class="formControl" name="img" placeholder="ImageURL">
                </form>
                <div><button onclick="display(4)" class="clickToAdd">click to add</button></div>
            </div>
        </div>
    </div>
    <!---->

    <div id="Beds" class="tabcontent">
        <div class="container">
            <div class="box" data-price="4000">

                <img src="imgs/bed.jpg" onmouseover="this.src = 'imgs/openBed.jpg';" onmouseout="this.src = 'imgs/bed.jpg';">
                <h2>WHITE CREAM OTTOMAN BED</h2>
                <p> Lorem ipsum dolor sit amet, consectetur adip sed te.</p>
                <span>4000$</span>
                <div class="rate">
                    <i class="fa fa-star checked"></i>
                    <i class="fa fa-star checked"></i>
                    <i class="fa fa-star checked"></i>
                    <i class="fa fa-star checked"></i>
                    <i class="fa fa-star checked"></i>
                </div>
                <div class="options">
                    <a href="#" class="a3"><i class="fa fa-heart-o"></i></a>
                    <a href="page2.html?category=bed&productId=1" class="a2"><i class='fa fa-angle-double-right'></i></a>
                    <a href="#" class="a1">Add to Cart</a>
                </div>
            </div>
            <div class="productBeds" style="display: none;></div>
            <div class="box" id="product12">
                <form action="manegerPage.php" method="post">
                    <input type="submit" value="submit">
                    <h2>Add new product</h2>
                    <input type="text" class="formControl" name="id" placeholder="Enter the product id">
                    <input type="text" class="formControl" name="productName" placeholder="Enter the name of the product">
                    <input type="text" class="formControl" name="description" placeholder="Enter description">
                    <div>
                        <input type="text" class="formControl2" name="price" placeholder="Enter price">
                        <input type="text" class="formControl2" name="cateId" placeholder="category id">
                    </div>
                    <div>
                        <input type="text" class="formControl2" name="stockQ" placeholder="stock quantity">
                        <input type="text" class="formControl2" name="color" placeholder="color">
                    </div>
                    <input type="text" class="formControl" name="img" placeholder="ImageURL">
                </form>
                <div><button onclick="display(5)" class="clickToAdd">click to add</button></div>
            </div>
        </div>
    </div>
    <div id="Clocks" class="tabcontent">
        <div class="container">
            <div class="box" data-price="4000">

                <img src="imgs/bed.jpg" onmouseover="this.src = 'imgs/openBed.jpg';" onmouseout="this.src = 'imgs/bed.jpg';">
                <h2>WHITE CREAM OTTOMAN BED</h2>
                <p> Lorem ipsum dolor sit amet, consectetur adip sed te.</p>
                <span>4000$</span>
                <div class="rate">
                    <i class="fa fa-star checked"></i>
                    <i class="fa fa-star checked"></i>
                    <i class="fa fa-star checked"></i>
                    <i class="fa fa-star checked"></i>
                    <i class="fa fa-star checked"></i>
                </div>
                <div class="options">
                    <a href="#" class="a3"><i class="fa fa-heart-o"></i></a>
                    <a href="page2.html?category=bed&productId=1" class="a2"><i class='fa fa-angle-double-right'></i></a>
                    <a href="#" class="a1">Add to Cart</a>
                </div>
            </div>
            <div class="productClocks" style="display: none;></div>
            <div class="box" id="product13">
                <!--                <button onclick="display()"><img src="imgs/add-image.png"></button>-->
                <form action="manegerPage.php" method="post">
                    <input type="submit" value="submit">
                    <h2>Add new product</h2>
                    <input type="text" class="formControl" name="id" placeholder="Enter the product id">
                    <input type="text" class="formControl" name="productName" placeholder="Enter the name of the product">
                    <input type="text" class="formControl" name="description" placeholder="Enter description">
                    <div>
                        <input type="text" class="formControl2" name="price" placeholder="Enter price">
                        <input type="text" class="formControl2" name="cateId" placeholder="category id">
                    </div>
                    <div>
                        <input type="text" class="formControl2" name="stockQ" placeholder="stock quantity">
                        <input type="text" class="formControl2" name="color" placeholder="color">
                    </div>
                    <input type="text" class="formControl" name="img" placeholder="ImageURL">
                </form>
                <div><button onclick="display(6)" class="clickToAdd">click to add</button></div>
            </div>
        </div>
    </div>
    <div id="Rugs" class="tabcontent">
        <div class="container">
            <div class="box" data-price="4000">

                <img src="imgs/bed.jpg" onmouseover="this.src = 'imgs/openBed.jpg';" onmouseout="this.src = 'imgs/bed.jpg';">
                <h2>WHITE CREAM OTTOMAN BED</h2>
                <p> Lorem ipsum dolor sit amet, consectetur adip sed te.</p>
                <span>4000$</span>
                <div class="rate">
                    <i class="fa fa-star checked"></i>
                    <i class="fa fa-star checked"></i>
                    <i class="fa fa-star checked"></i>
                    <i class="fa fa-star checked"></i>
                    <i class="fa fa-star checked"></i>
                </div>
                <div class="options">
                    <a href="#" class="a3"><i class="fa fa-heart-o"></i></a>
                    <a href="page2.html?category=bed&productId=1" class="a2"><i class='fa fa-angle-double-right'></i></a>
                    <a href="#" class="a1">Add to Cart</a>
                </div>
            </div>
            <div class="productRugs" style="display: none;></div>
            <div class="box" id="product7">
                <form action="manegerPage.php" method="post">
                    <input type="submit" value="submit">
                    <h2>Add new product</h2>
                    <input type="text" class="formControl" name="id" placeholder="Enter the product id">
                    <input type="text" class="formControl" name="productName" placeholder="Enter the name of the product">
                    <input type="text" class="formControl" name="description" placeholder="Enter description">
                    <div>
                        <input type="text" class="formControl2" name="price" placeholder="Enter price">
                        <input type="text" class="formControl2" name="cateId" placeholder="category id">
                    </div>
                    <div>
                        <input type="text" class="formControl2" name="stockQ" placeholder="stock quantity">
                        <input type="text" class="formControl2" name="color" placeholder="color">
                    </div>
                    <input type="text" class="formControl" name="img" placeholder="ImageURL">
                </form>
                <div><button onclick="display(7)" class="clickToAdd">click to add</button></div>
            </div>
        </div>
    </div>
</div>
<footer>
    <div class="group">
        <table width="100%" valign="top">
            <tr>
                <td valign="top">
                    <h2 class="h2"><u>Customer Service</u></h2>
                    <table width="90%">
                        <tr>
                            <td valign="top" width="40%">
                                <p>Call us toll-free <br>
                                    <img class="icons2" src="imgs/whatsapp.png" alt="cc">
                                    <span class="number"> 0599595555</span>
                                <hr>
                                </p>
                                <p> Call us worldwide <br>
                                    <img class="icons2" src="imgs/whatsapp.png" alt="cc">
                                    <span class="number"> 0599502202</span>
                                <hr>
                                </p>
                                <p> Call us worldwide <br>
                                    <img class="icons2" src="imgs/send.png" alt="cc">
                                    <span class="number"> furniCo@gmail.com</span>
                                </p>
                            </td>
                            <td class="line">
                                <p>&nbsp;&nbsp;Customer Service Hours:<br>
                                <p> &nbsp;&nbsp;Monday-Friday (8am-8pm CT) <br> &nbsp;&nbsp;Saturday (9am-5:30pm CT)</p>
                                <hr>
                                &nbsp;&nbsp;<a href="https://www.instagram.com/"><img src="imgs/instagram.png"></a>
                                &nbsp;&nbsp;<a href="https://x.com/?lang=ar"><img src="imgs/twitter.png"></a>
                                &nbsp;&nbsp;<a href="https://www.facebook.com/"><img src="imgs/facebook.png"></a>
                                &nbsp;&nbsp;<a href="https://www.linkedin.com/"><img src="imgs/linkedin.png"></a>
                                &nbsp;&nbsp;<a href="https://web.telegram.org/k/"><img src="imgs/telegram.png"></a>
                                &nbsp;&nbsp;<a href="https://www.youtube.com/"><img src="imgs/youtube.png"></a>
                                &nbsp;&nbsp;<a href="https://www.pinterest.com/"><img src="imgs/social.png"></a>
                                <p>&nbsp;&nbsp;<a href="#fourS">Help Section</a><br>
                                    &nbsp;&nbsp;<a href="#aboutUs">Refer FurniCo</a><br>
                                    &nbsp;&nbsp;Communication Preferences<br></p>
                                </p>

                            </td>
                        </tr>
                    </table>
                </td>
                <td valign="top">
                    <h2 class="h2"><u>Our Company</u></h2>
                    <table width="100%">
                        <tr>
                            <td valign="top" width="40%">
                                <p><a href="#aboutUs">About FurniCo </a><br>
                                    FurniCo Commitment<br>
                                    Our Services<br>
                                    Sustainability<br>
                                    Careers at FurniCo<br>
                                    Current Openings - Apply Here<br>
                                    FurniCo in the Community<br>
                                    Location Directory<br>
                                    FurniCo Clean Certified<br>
                                </p>
                            </td>
                        </tr>
                    </table>
                </td>

                <td valign="top">
                    <h2 class="h2"><u>Our Services</u></h2>
                    <table width="100%">
                        <tr>
                            <td valign="top" width="40%">
                                <p>Rent Home Furniture<br>
                                    Rent Furniture for Students<br>
                                    Rent Furniture for Military<br>
                                    Rent Office Furniture<br>
                                    Rent Event Furniture<br>
                                    Buy Furniture<br>
                                    Disaster Relief<br>
                                    Relocation Assistance<br>
                                    Search for Apartments<br>
                                </p>
                            </td>
                        </tr>
                    </table>
                </td>

                <td valign="top">
                    <h2 class="h2"><u>Our Sites</u></h2>
                    <table width="100%">
                        <tr>
                            <td valign="top" width="40%">
                                <p>FurniCo Furniture Rental<br>
                                    FurniCo Furniture Outlet<br>
                                    FurniCo Events<br>
                                    FurniCo Party Rental (WA)<br>
                                    FurniCo Destination Services<br>
                                    FurniCo Global Network<br>
                                    Roomservice by FurniCo<br>
                                    ApartmentSearch by FurniCo<br>
                                    4SITE by FurniCo<br>
                                </p>
                            </td>
                        </tr>
                    </table>
                </td>

            </tr>
        </table>
    </div>
</footer>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<!--<script-->
<!--        src="https://code.jquery.com/jquery-3.7.1.min.js"-->
<!--        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="-->
<!--        crossorigin="anonymous"></script>-->
<script>

    function openCity(evt, cityName) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(cityName).style.display = "block";
        evt.currentTarget.className += " active";
    }

    function renderProduct(data, categoryId) {
        let name = data.name;
        let price = data.price;
        let description = data.description;
        let imgUrl = data.image_url;

        if (name && price && description) {
            let div = document.createElement('div');
            let img = document.createElement('img');
            img.src = imgUrl;
            img.style.width = '300px';
            img.style.height = '300px';
            let h1 = document.createElement('h1');
            h1.innerText = name;
            let p1 = document.createElement('p');
            p1.innerText = description;
            let p2 = document.createElement('p');
            p2.innerText = price;
            p2.className = 'price';
            let button=document.createElement('button');
            button.innerText='Add To Cart';

            div.appendChild(img);
            div.appendChild(h1);
            div.appendChild(p1);
            div.appendChild(p2);
            div.appendChild(button);


            div.style.borderRadius = '10px';
            div.style.overflow = 'hidden';
            div.style.display = 'flex';
            div.style.flexDirection = 'column';
            div.style.alignItems = 'center';
            div.style.textAlign = 'center';
            div.style.boxShadow = '0 5px 10px #424530';
            div.style.gap = '17px';
            div.style.marginTop = '0';
            div.style.backgroundColor = '#e6e1dc';
            div.style.color = '#424530';

            button.innerText = 'Add to Cart';
            button.style.fontSize = '18px';
            button.style.textDecoration = 'none';
            button.style.border = '2px solid #424530';
            button.style.color = '#f1f1f1';
            button.style.backgroundColor = '#424530';
            button.style.borderRadius = '10px';
            button.style.boxShadow = '3px 3px 3px #cd7307';
            button.style.padding = '10px 20px';
            button.style.cursor = 'pointer';
            button.style.marginTop = '10px';
            button.style.marginBottom = '20px';



            /////////
            // Store data in local storage
            localStorage.setItem('addPro','1');
            localStorage.setItem('catId',""+categoryId);
            localStorage.setItem('productInfo', JSON.stringify({ name: name, price: price,description:description, imgUrl: imgUrl}));
            /////////

            let container;
            switch (categoryId) {
                case 1:
                    container = document.querySelector('.productKitchen');
                    break;
                case 2:
                    container = document.querySelector('.productSofa');
                    break;
                case 3:
                    container = document.querySelector('.productOutDoor');
                    break;
                case 4:
                    container = document.querySelector('.productTables');
                    break;
                case 5:
                    container = document.querySelector('.productBeds');
                    break;
                case 6:
                    container = document.querySelector('.productClocks');
                    break;
                case 7:
                    container = document.querySelector('.productRugs');
                    break;
                default:
                    alert("Invalid category ID");
                    return;
            }
            container.appendChild(div);
            container.style.display = 'inline-block';
        } else {
            alert("Data is not as expected: " + JSON.stringify(data));
        }
    }

    function display(categoryId) {
        $.ajax({
            url: 'forProducts.php',
            dataType: 'json', // Ensure the response is parsed as JSON
            success: function(data) {
                console.log(data); // Log the data to the console for inspection
                localStorage.setItem('productData', JSON.stringify({ data, categoryId })); // Store data and category in local storage
                renderProduct(data, categoryId);
            },
            error: function(xhr, status, error) {
                alert("An error occurred: " + status + " " + error);
            }
        });
    }

    // Call this function to load data from local storage on page load
    function loadFromLocalStorage() {
        let storedData = localStorage.getItem('productData');
        if (storedData) {
            let { data, categoryId } = JSON.parse(storedData);
            renderProduct(data, categoryId);
        }
    }

    // Load data from local storage when the page loads
    window.onload = loadFromLocalStorage;

</script>

</body>
</html>