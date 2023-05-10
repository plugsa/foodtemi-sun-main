<?php
    include 'connection.php';
    if (isset($_POST['update_btn'])) {
        $update_value = $_POST['update_quantity'];
        $update_id = $_POST['update_quantity_id'];

        $update_query = mysqli_query($conn, "UPDATE `cart` SET quantity='$update_value' WHERE id='$update_id'") or die('query failed');
        if ($update_query) {
            header('location:cart.php');
        }
    }
    if (isset($_GET['remove'])) {
        $remove_id = $_GET['remove'];
        mysqli_query($conn, "DELETE FROM `cart` WHERE id='$remove_id'");
        header('location:cart.php');
    }
    if (isset($_GET['delete_all'])) {
        mysqli_query($conn, "DELETE FROM `cart` ");
        header('location:cart.php');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" />
 
    <!-- Bootstrap Font Icon CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" />
    <!-- custom css file link  -->
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Foodies</title>

</head>
<body>
    <?php include 'header.php'; ?><!-- navbar-->
    <div class="cart-container">
        <h1>shopping cart</h1>
        <table>
            <thead>
                <th>image</th>
                <th>name</th>
                <th>price</th>
                <th>quantity</th>
                <th>total</th>
                <th>action</th>
            </thead>
            <tbody>
                <?php 
                    $select_cart = mysqli_query($conn, "SELECT * FROM `cart`");
                    $grand_total=0;
                    if (mysqli_num_rows($select_cart)>0) {
                        while($fetch_cart=mysqli_fetch_assoc($select_cart)){
                ?>
                <tr>
                    <td><img src="image/<?php echo $fetch_cart['image']; ?>"></td>
                    <td><?php echo $fetch_cart['name']; ?></td>
                    <td><?php echo $fetch_cart['price']; ?>.-</td>
                    <td class="quantity">
                        <form method="post">
                            <input type="hidden" name="update_quantity_id" value="<?php echo $fetch_cart['id']; ?>" >
                            <input type="number" min="1" name="update_quantity" value="<?php echo $fetch_cart['quantity']; ?>" >
                            <input type="submit" name="update_btn" value="update">
                        </form>
                    </td>
                    <td><?php echo $sub_total = $fetch_cart['price']*$fetch_cart['quantity']; ?>.-</td>
                    <td><a href="cart.php?remove=<?php echo $fetch_cart['id']; ?>"
                     onclick="return confirm('remove item from cart');" class="delete-btn" ><i class="bi bi-trash">remove</a></td>
                </tr>
                <?php
                    $grand_total+=$sub_total;
                        }
                    }
                ?>
                <tr class="table-bottom">
                    <td><a href="index.php" class="option-btn"><i class="bi bi-arrow-left"></i>continue shopping</a></td>
                    <td colspan="3"><h4>total amount payable</h4></td>
                    <td style="font-weight: bold;"><?php echo $grand_total; ?>.-</td>
                    <td><a href="cart.php?delete_all="onclick="return confirm('are you sure you want to delete all item from cart');" class="delete-btn"><i class="bi bi-trash">dalete all</a></td>
                </tr>             
            </tbody>
        </table>
        <div class="checkout-btn" >
            <a href="checkout.php" class="btn <?=($grand_total>1)?'':'disabled'?>">procced to checkout</a>
        </div><!--checkout-btn-->
    </div><!--cart-container-->
</body>
</html>