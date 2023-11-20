<?php
session_start();

if (!isset($_SESSION['status']) || $_SESSION['status'] != "customer" || !isset($_SESSION['username'])) {
    header("location:login.php");
    exit;
}

include "includes/config.php";

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Extract pengunjung details from POST request
    $cust_id = $_POST['cust_id'];
    $cust_name = $_POST['cust_name'];
    $cust_email = $_POST['cust_email'];
    $cust_phone = $_POST['cust_phone'];
    $cust_address = $_POST['cust_address'];
    $cust_city = $_POST['cust_city'];
    $cust_province = $_POST['cust_province'];
    $cust_postalcode = $_POST['cust_postalcode'];

    // Update query
    $query = "UPDATE pengunjung SET cust_name = '$cust_name', cust_email = '$cust_email', cust_phone = '$cust_phone', cust_address = '$cust_address', cust_city = '$cust_city', cust_province = '$cust_province', cust_postalcode = '$cust_postalcode' WHERE cust_id = '$cust_id'";
    $statement = mysqli_prepare($connect, $query);
    mysqli_stmt_execute($statement);

    if ($statement) {
        echo "<script>alert('User has been updated!'); window.location = 'user_profile.php'</script>";
    } else {
        echo "<script>alert('Update user failed!'); window.location = 'user_profile.php'</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/navbar.css">
    <link rel="stylesheet" href="assets/css/footer.css">
    <link rel="stylesheet" href="assets/css/uprofile.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <title>Document</title>
</head>

<body>
    <!-- navbar -->
    <?php include 'includes/navbar.php'; ?>
    <!-- End of the navbar section -->

    <div id="contents">
        <div class="container account-page mt-40">
            <div class="row">
                <div class="col-md-8">
                    <h2 class="mb-28">My Account</h2>
                    <div class="user-info fs-sm">
                        <div class="data-pelanggan">
                            <?php
                            $id = $_GET['cust_id'];
                            $query = mysqli_query($connect, "SELECT * FROM pengunjung WHERE cust_id='$id'");
                            $data = mysqli_fetch_array($query);
                            ?>
                            <h2>Update User</h2>
                            <form action="" method="POST" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <input type="hidden" name="cust_id"
                                        value="<?php echo htmlspecialchars($data['cust_id']); ?>">
                                </div>
                                <div class="mb-3">
                                    <input type="text" name="cust_name" id="cust_name"
                                        value="<?php echo $data['cust_name']; ?>" class="form-control" require>
                                </div>
                                <div class="mb-3">
                                    <input type="text" name="cust_email" id="cust_email"
                                        value="<?php echo $data['cust_email']; ?>" class="form-control" require>
                                </div>
                                <div class="mb-3">
                                    <input type="text" name="cust_phone" id="cust_phone"
                                        value="<?php echo $data['cust_phone']; ?>" class="form-control" require>
                                </div>
                                <div class="mb-3">
                                    <input type="text" name="cust_address" id="cust_address"
                                        value="<?php echo $data['cust_address']; ?>" class="form-control" require>
                                </div>
                                <div class="mb-3">
                                    <input type="text" name="cust_city" id="cust_city"
                                        value="<?php echo $data['cust_city']; ?>" class="form-control" require>
                                </div>
                                <div class="mb-3">
                                    <input type="text" name="cust_province" id="cust_province"
                                        value="<?php echo $data['cust_province']; ?>" class="form-control" require>
                                </div>
                                <div class="mb-3">
                                    <input type="text" name="cust_postalcode" id="cust_postalcode"
                                        value="<?php echo $data['cust_postalcode']; ?>" class="form-control" require>
                                </div>
                                <div class="action-profile mb-3">
                                    <input type="submit" value="Edit" class="btn-edit" />
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 account-actions">
                    <a class="btn btn-edit fs-8" href="#">My Orders</a>
                    <a class="btn btn-edit fs-8" href="includes/logout.php">Log out</a>
                </div>
            </div>
        </div>
    </div>

    <footer id="footers">
        <?php include 'includes/footer.php'; ?>
    </footer>

    <script type="text/javascript" src="assets/js/navbarscript.js"></script>
</body>

</html>