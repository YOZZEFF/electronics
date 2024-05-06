<?php
ob_start(); 

require('../includes/connectdb.php');
require('../includes/layouts/__header.php');



// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_to_cart'])) {
    // Retrieve product ID and quantity from the form
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];




    
    // Check if the product ID and quantity are valid
    if (!empty($product_id) && !empty($quantity) && is_numeric($product_id) && is_numeric($quantity) && $quantity > 0) {
        // Check if the user is logged in (you can add your authentication logic here)
        if (isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];

            // Check if the product already exists in the cart for this user to update
            $check_query = "SELECT * FROM cart WHERE user_id = $user_id AND product_id = $product_id";
            $check_result = mysqli_query($connection, $check_query);

            if (mysqli_num_rows($check_result) > 0) {
                // Update the quantity of the existing product in the cart
                $update_query = "UPDATE cart SET quantity = quantity + $quantity WHERE user_id = $user_id AND product_id = $product_id";
                mysqli_query($connection, $update_query);
            } else {
                // Insert the new product into the cart
                $insert_query = "INSERT INTO cart (user_id, product_id, quantity) VALUES ($user_id, $product_id, $quantity)";
                mysqli_query($connection, $insert_query);
            }

            // Redirect back to the shop page or wherever you want
            header("location: index.php");
            exit();
        } else {
            // Redirect to the login page if the user is not logged in
            header("location: login.php");
            exit();
        }
    } else {
        // Handle invalid input
        echo "Invalid product ID or quantity.";
    }
} else {
    // Handle form submission error
    echo "Error: Form not submitted.";
}
require('../includes/layouts/__footer.php');
ob_end_flush();

?>
