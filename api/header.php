<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Foodies</title>
</head>
<body>
    <header>
        <div class="flex">
            <a href="index.php" class="logo">foodies</a>
            <div class="navbar">
                <a href="admin.php">view products</a>
                <a href="index.php">shop</a>
            </div> <!--class navbar-->
            <!--quantity-->
            <?php
                $select_rows = mysqli_query($conn, "SELECT * FROM `cart`") or die('query failed');
                $row_count = mysqli_num_rows($select_rows);
            ?>
            <!--<img src="image/image2.png"  width="25" height="25">-->
            <a href="cart.php" class="cart" ><i class="bi bi-cart-check-fill"></i><span><?php echo $row_count ;?></span></a>
        </div> <!--class fiex-->
    </header>
</body>
</html>