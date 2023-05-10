<?php
    include 'connection.php';
    if (isset($_POST['order_btn'])) {
        $name = $_POST['name'];
        $table_number = $_POST['table-number'];

        $cart_query = mysqli_query($conn, "SELECT * FROM `cart`");
        $price_total = 0;
        if (mysqli_num_rows($cart_query)>0){
            while($product_item=mysqli_fetch_assoc($cart_query)){
                $product_name[]=$product_item['name'].' ('.$product_item['quantity'].')';
                $product_price=number_format($product_item['price']*$product_item['quantity']);
                $price_total+=$product_price;
            }
        }
        $total_product=implode(',', $product_name);
        $detail_query = mysqli_query($conn, "INSERT INTO `orders`(`name`, `table_number`, `total_products`, `total_price`) VALUES ('$name','$table_number','$total_product',' $price_total')" ) or die('query failed');
       
        if ($cart_query && $detail_query) {
            echo"
                <div class='order-comfirm-container'>
                     <div class='message-containe'>
                        <h3>thank yon for shopping</h3>
                        <div class='order-detail'>
                            <span>".$total_product."</span>
                            <span class='total'>total : ".$price_total.".-</span>
                        </div><!--order-detail-->
                        <div class='customer-details'>
                            <p class='pay'>Your name : <span>".$name."</span></p>
                            <p class='pay'>Your table number : <span>".$table_number."</span></p>
                            <p class='pay'>(*Pay when you finish eating*)</p>
                        </div><!--customer-details-->
                        <a href='index.php' class='btn'><i class='bi bi-arrow-left'></i>continue shopping</a>
                        <a href='index.php?delete_all='onclick='return confirm('confirm');' class='btn'>cancle</a> 
                    </div><!--message-containe-->
                 </div><!--order-confirm-container-->
            ";
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
    <h1>Order Summary</h1>
    <div class="checkout-form">
        <div class="display-order">
            <?php
                $select_cart = mysqli_query($conn, "SELECT * FROM `cart`");
                $total=0;
                $grand_total=0;
                if (mysqli_num_rows($select_cart)>0){
                    while($fetch_cart=mysqli_fetch_assoc($select_cart)){
                        $total_price = $fetch_cart['price']* $fetch_cart['quantity'];
                        $grand_total = $total += $total_price;
                 
                ?>
                <span><?= $fetch_cart['name']; ?>(<?= $fetch_cart['quantity']; ?>)</span>
                <?php 
                    }
                }
            ?>
            <span class="grand-total">Total amount payable : <?= $grand_total; ?>.-</span>
        </div><!-- display-order-->
        <form method="post">
            <div class="input-field">
                <span>your name</span>
                <input type="text" name="name" placeholder="Enter your name" required>
            </div>
            <div class="input-field">
                <span>your table number</span>
                <select name="table-number">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                </select>
            </div>
            <input type="submit" name="order_btn" value="order now" class="btn" >
        </form>
    </div><!--checkout-form-->

</body>
</html>
