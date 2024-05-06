<?php
ob_start(); 

require('../includes/layouts/__header.php');
require('../includes/connectdb.php');
?>

<?php

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Retrieve products from the cart for the logged-in user
    $cart_query = "SELECT p.*, c.quantity FROM products p JOIN cart c ON p.id = c.product_id WHERE c.user_id = $user_id";
    $cart_result = mysqli_query($connection, $cart_query);
?>

<h1  style="margin:100px;font-size:70px;">Cart</h1>

    <table class="table col-7" style="height:100vh;margin-top:100px;margin:auto;width:70%;font-size:20px;">

  <thead>
    <tr>
                <th>Product Name</th>
                <th>Image</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
                <th>Action</th> 
    </tr>
  </thead>
  <tbody>
            <?php
            $total_price = 0;
            while ($row = mysqli_fetch_assoc($cart_result)) {
                $total = $row['price'] * $row['quantity'];
                $total_price += $total;
            ?>
                <tr>
                    <td><?php echo $row['name']; ?></td>
                    <td><img src="./images/<?php echo $row['image']; ?>" style="width:150px;height:200px;"/></td>
                    <td>$<?php echo $row['price']; ?></td>
                    <td><?php echo $row['quantity']; ?></td>
                    <td>$<?php echo $total; ?></td>
                    <td>
                        <form action="remove_from_cart.php" method="post">
                            <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                            <button type="submit" name="remove_from_cart" class="btn btn-danger">Remove</button>
                        </form>
                    </td>
                </tr>
            <?php
            }
            ?>
            <tr>
                <td colspan="3">Total:</td>
                <td>$<?php echo $total_price; ?></td>
                <td></td> <!-- Empty cell for alignment -->
            </tr>
        </tbody>
</table>


<?php
} else {
    // Redirect to the login page if the user is not logged in
    header("location: login.php");
    exit();
}
?>

<?php
require('../includes/layouts/__footer.php');
ob_end_flush();

?>