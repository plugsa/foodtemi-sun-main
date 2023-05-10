<?php
    include 'connection.php';
    //add product
    if (isset($_POST['add_product'])){
        $name = $_POST['p_name'];
        $price = $_POST['p_price'];
        $p_image = $_FILES['p_image']['name'];
        $p_image_temp_name =$_FILES['p_image']['tmp_name'];
        $p_image_folder = 'image/'.$p_image;

        $query = "INSERT INTO `products`(`name`, `price`, `image`) VALUES ('$name', '$price','$p_image')";
        $insert_query = mysqli_query($conn, $query);

        if ($insert_query){
            move_uploaded_file($p_image_temp_name, $p_image_folder);
            $message[] = 'product added sucessfully';
            header('location:admin.php');
        }else{
            $message[] = 'product did not added sucessfully';
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
    <style>
</style>
</head>
<body>
    <?php include 'header.php'; ?><!-- navbar-->

    <div class="form"><!--add product-->
        <form method="post" enctype="multipart/form-data">
            <h3>add a new product</h3>
            <input type="text" name="p_name" placeholder="enter product name" required>
            <input type="number" name="p_price" min="0" placeholder="enter product price" required>
            <input type="file" name="p_image" accept="image/png, image/jpg, image/jpeg" required>
            <input type="submit" name="add_product" value="add product" class="btn">
        </form>
    </div><!--add product-->
</body>
</html>