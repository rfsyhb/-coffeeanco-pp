<?php
session_start();

if ($_SESSION['status'] != "admin") {
    header("Location: ../login.php");
    exit;
}

include "../includes/config.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    $id = $_GET['prod_id'];
    $query = mysqli_query($connect, "SELECT * FROM produk WHERE prod_id='$id'");
    $data = mysqli_fetch_array($query);
    ?>
    <img src="../assets/images/uploaded/<?php echo $data['prod_image1']; ?>" alt="">
</body>

</html>