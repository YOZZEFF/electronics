<?php
ob_start(); 

require('../includes/layouts/__header.php');
require('../includes/connectdb.php');

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    if (isset($_POST['remove_from_cart']) && isset($_POST['product_id'])) {
        $user_id = $_SESSION['user_id'];
        $product_id = $_POST['product_id'];

        // Remove the product from the cart
        $remove_query = "DELETE FROM cart WHERE user_id = $user_id AND product_id = $product_id";
        $remove_result = mysqli_query($connection, $remove_query);

        if ($remove_result) {
            // Redirect back to the cart page after successful removal
            header("location: view_cart.php");
            exit();
        } else {
            // Handle error if removal fails
            echo "Error: Unable to remove item from cart.";
        }
    } else {
        // Redirect to the cart page if the necessary parameters are not set
        header("location: view_cart.php");
        exit();
    }
} else {
    // Redirect to the login page if the user is not logged in
    header("Location: login.php");
    exit();
}
require('../includes/layouts/__footer.php');
ob_end_flush();

?>
