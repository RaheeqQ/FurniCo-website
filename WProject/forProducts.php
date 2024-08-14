<?php
session_start();

if (isset($_SESSION['productId'])) {

    try {
        // Establish database connection
        $db = new mysqli('localhost', 'root', '', 'furnitureDB');

        // Check for connection errors
        if ($db->connect_error) {
            throw new Exception('Database connection error: ' . $db->connect_error);
        }

        // Use prepared statement to prevent SQL injection
        $stmt = $db->prepare("SELECT name, description, price, image_url FROM products WHERE product_id = ?");
        $stmt->bind_param("i", $_SESSION['productId']); // Assuming product_id is an integer
        $stmt->execute();
        $result = $stmt->get_result();
        $theProduct = $result->fetch_object();

        if ($theProduct) {
            $product = array(
                'name' => $theProduct->name,
                'description' => $theProduct->description,
                'price' => $theProduct->price,
                'image_url' => $theProduct->image_url
            );

            // Set correct content type for JSON
            header('Content-Type: application/json');
            echo json_encode($product);
        } else {
            echo json_encode(['error' => 'Product not found']);
        }

        // Close the statement and database connection
        $stmt->close();
        $db->close();

    } catch (Exception $e) {
        // Return error message in JSON format
        header('Content-Type: application/json');
        echo json_encode(['error' => $e->getMessage()]);
        exit;
    }

} else {
    // Return error message if session variable is not set
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Product ID not set in session']);
}


?>
