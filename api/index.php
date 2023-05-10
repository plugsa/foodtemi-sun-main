<?php
    include 'connection.php';
    if (isset($_GET['delete_all'])) {
        mysqli_query($conn, "DELETE FROM `cart` ");
        header('location:index.php');
    }
    //add product
    if (isset($_POST['add_to_cart'])){
        $name = $_POST['name'];
        $price = $_POST['price'];
        $image = $_POST['image'];
        $quantity=1;

        $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE name='$name'");
        if (mysqli_num_rows($select_cart)>0) {
            $message[] = 'product already added in your cart';
        }else{
            $query = "INSERT INTO `cart`(`name`, `price`, `image`, `quantity`) VALUES ('$name', '$price', '$image', '$quantity')";
            $insert_query = mysqli_query($conn, $query);
            $message[] = 'product  added in your cart';
        }

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
    <?php
        if(isset($message)){
            foreach($message as $message) {
                echo '
                    <div class="message">
                        <span>'.$message.'<i class="bi bi-x"
                            onclick="this.parentElement.style.display=`none`"></i></span>
                    </div>
                ';
            }
        }
    ?>
    <div class="product-container">
        <h1>Menu</h1>
        <div class="product-item-container">
            <?php
                $select_products=mysqli_query($conn, "SELECT * FROM `products`");
                if (mysqli_num_rows($select_products)>0){
                    while($fetch_products=mysqli_fetch_assoc($select_products)){
            ?>
            <form method="post">
                <div class="box">
                    <img src="image/<?php echo $fetch_products['image']; ?>">
                    <h3><?php echo $fetch_products['name']; ?></h3>
                    <div class="price"><?php echo $fetch_products['price']; ?>.-</div>
                    <input type="hidden" name="name" value="<?php echo $fetch_products['name']; ?>">
                    <input type="hidden" name="price" value="<?php echo $fetch_products['price']; ?>">
                    <input type="hidden" name="image" value="<?php echo $fetch_products['image']; ?>">
                    <input type="submit" name="add_to_cart" value="add to cart" class="btn">
                </div><!-- box-->
            </form>
            <?php

                    }
                }
            ?>
        </div><!-- product-item-container-->
    </div><!-- product-container-->
</body>
</html>