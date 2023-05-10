<?php
    include 'connection.php';

    //delete product
    if (isset($_GET['delete'])){
        $delete_id = $_GET['delete'];
        $delete_query = mysqli_query($conn, "DELETE FROM `products` WHERE id=$delete_id") or die('query failed');
        if ($delete_query){
            $message[]='product deleted sucessfully';
            
        }else{
            $message[]='product did not deleted sucessfully';
        }
    }   
    //update product
    if (isset($_POST['update_product'])){
        $update_p_id = $_POST['update_p_id'];
        $update_p_name = $_POST['update_p_name'];
        $update_p_price = $_POST['update_p_price'];
        $update_p_img = $_FILES['update_p_image']['name'];
        $update_p_img_tmp_name = $_FILES['update_p_image']['tmp_name'];
        $update_p_folder = 'image/'.$update_p_img;

        $update_query = mysqli_query($conn, "UPDATE `products` SET id='$update_p_id', name='$update_p_name', price='
            $update_p_price', image='$update_p_img' WHERE id = '$update_p_id '") or die('query failed');
        if ($update_query){
            move_uploaded_file($update_p_img_tmp_name,$update_p_folder);
            $message[]='product has been updated sucessfully';
            header('location:admin.php');
        }else{
            $message[]='product could not updated sucessfully';
        }
    
    }

?>
<!DOCTYPE html>
<html>
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
    <a href="product_form.php" class="add">+</a>
    <section class="show-product"><!-- show product-->
        <table>
            <thead>
                <th>image</th>
                <th>name</th>
                <th>price</th>
                <th>action</th>
            </thead>
            <tbody>
                <?php
                    $select_products = mysqli_query($conn, "SELECT * FROM `products`") or die('query failed');
                    if (mysqli_num_rows($select_products) > 0 ){
                        while ($row = mysqli_fetch_assoc($select_products)){

                ?>
                <tr>
                    <td><img src="image/<?php echo $row['image']; ?>"></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['price']; ?>.-</td>
                    <td>
                        <a href="admin.php?delete=<?php echo $row['id']; ?>" class="delete-btn"><i class="bi bi-trash"
                        onclick="return confirm('are you sure yon wamt to delete this item')"></i>delete</a>
                        <a href="admin.php?edit=<?php echo $row['id']; ?>" class="option-btn"><i class="bi bi-pencil"></i>Update</a>
                    </td>
                </tr>
                <?php         
                        }
                    }
                ?>
            </tbody>
        </table>
    </section><!-- show product-->
    <section class="edit-form"><!-- update product-->
        <?php
            if (isset($_GET['edit'])) {
                $edit_id = $_GET['edit'];
                $edit_query = mysqli_query($conn, "SELECT * FROM `products` WHERE id=$edit_id") or die('guery failed');
                if (mysqli_num_rows($edit_query) > 0){
                    while($fetch_edit = mysqli_fetch_assoc($edit_query)){
         ?>
         <form method="post" enctype="multipart/form-data">
            <h3>update product</h3>
            <img src="image/<?php echo $fetch_edit['image']; ?>">
            <input type="hidden" name="update_p_id" value="<?php echo $fetch_edit['id']; ?>">
            <input type="text" name="update_p_name" value="<?php echo $fetch_edit['name']; ?>" required>
            <input type="number" name="update_p_price" min="0" value="<?php echo $fetch_edit['price']; ?>" required>
            <input type="file" name="update_p_image" accept="image/png, image/jpg, image/jpeg" required>
            <input type="submit" name="update_product" value="update product" class="btn update">
            <input type="reset" value="cancle" class="btn cancle" id="close-edit">
        </form>
        <?php               
                    }
                } 
                echo "<script>document.querySelector('.edit-form').style.display = 'block'</script>";
            }
        ?>
    </section><!-- update product-->
    <script type="text/javascript">
        const closeBtn = document.querySelector('#close-edit');

        closeBtn.addEventListener('click',()=>{
            document.querySelector('.edit-form').style.display = 'none'
        })
    </script> 
</body>
</html>