<?php
    include '../config.php';

    $product_id = $_POST['prod_id'];
    $product_name = $_POST['prod_name'];
    $product_type = $_POST['prod_type'];
    $product_desc = $_POST['prod_desc'];
    $product_stock = $_POST['prod_stock'];
    $product_price = $_POST['prod_price'];
    $product_image1 = $_POST['prod_image1'];
    $product_image2 = $_POST['prod_image2'];

    $query = "UPDATE product SET prod_name = '$product_name', prod_type = '$product_type', prod_desc = '$product_desc', prod_price = '$product_price' WHERE prod_id = '$product_id'";
    $statement = mysqli_prepare($connect, $query);
    mysqli_stmt_execute($statement);

    header("location: display_product.php");
?>