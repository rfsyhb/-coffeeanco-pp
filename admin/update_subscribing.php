<?php
include '../config.php';

$id_subs = $_POST['id_subs'];
$email_subs = $_POST['email_subs'];

$query = "UPDATE subscribing SET email_subs = '$email_subs' WHERE id_subs = '$id_subs'";
$statement = mysqli_prepare($connect, $query);
mysqli_stmt_execute($statement);

header("location: display_subscribe.php");
?>