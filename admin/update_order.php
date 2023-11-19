<?php
include '../config.php';

$order_id = $_POST['order_id'];
$cust_email = $_POST['cust_email'];
$cust_phone = $_POST['cust_phone'];
$cust_address = $_POST['cust_address'];
$prod_id = $_POST['prod_id'];

$query = "UPDATE orders SET cust_email = '$cust_email', cust_phone = '$cust_phone', cust_address = '$cust_address', prod_id = '$prod_id' WHERE order_id = '$order_id'";
$statement = mysqli_prepare($connect, $query);
mysqli_stmt_execute($statement);

header("location: display_order.php");
?>