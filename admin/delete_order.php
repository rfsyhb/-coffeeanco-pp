<?php
    include '../config.php';

    $order_id = $_GET['order_id'];

    $query = "DELETE FROM orders WHERE order_id='$order_id'";
    $statement = mysqli_prepare($connect, $query);
    mysqli_stmt_execute($statement);

    if($statement) {
        echo "<script>alert('Order has been Deleted!'); window.location = 'display_order.php'</script>";
    } else {
        echo "<script>alert('Delete Order Failed!'); window.location = 'display_order.php'</script>";
    }
?>