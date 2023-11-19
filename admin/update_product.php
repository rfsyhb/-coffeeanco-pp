<?php
    include '../config.php';

    $product_id = $_POST['prod_id'];
    $product_name = $_POST['prod_name'];
    $product_desc = $_POST['prod_desc'];
    $product_price = $_POST['prod_price'];

    $query = "UPDATE product SET prod_name = '$product_name', prod_desc = '$product_desc', prod_price = '$product_price' WHERE prod_id = '$product_id'";
    $statement = mysqli_prepare($connect, $query);
    mysqli_stmt_execute($statement);

    header("location: display_product.php");
?>