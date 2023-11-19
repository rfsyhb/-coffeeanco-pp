<?php
    include '../config.php';

    $product_id = $_GET['prod_id'];

    $query = "DELETE FROM product WHERE prod_id='$product_id'";
    $statement = mysqli_prepare($connect, $query);
    mysqli_stmt_execute($statement);

    if($statement) {
        echo "<script>alert('Product has been Deleted!'); window.location = 'display_product.php'</script>";
    } else {
        echo "<script>alert('Delete Product Failed!'); window.location = 'display_product.php'</script>";
    }
?>