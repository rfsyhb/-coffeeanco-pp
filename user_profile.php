<?php
session_start();

if (!isset($_SESSION['status']) || $_SESSION['status'] != "customer" || !isset($_SESSION['username'])) {
    header("location:login.php");
}

include "includes/config.php";
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
                        <?php
                        $select_data = mysqli_query($connect, "SELECT * FROM pengunjung");
                        if (mysqli_num_rows($select_data) > 0) {
                            while ($data = mysqli_fetch_array($select_data)) {
                                ?>
                                <div class="data-pelanggan">
                                    <?php
                                    echo "<h5>" . htmlspecialchars($data['cust_name']) . "</h5>";
                                    echo "<p>" . htmlspecialchars($data['cust_email']) . "</p>";
                                    echo "<p>" . htmlspecialchars($data['cust_address']) . "</p>";
                                    echo "<p>" . htmlspecialchars($data['cust_city']) . "</p>";
                                    echo "<p>" . htmlspecialchars($data['cust_province']) . "</p>";
                                    echo "<p>" . htmlspecialchars($data['cust_postalcode']) . "</p>";
                                    ?>
                                    <div class="action-profile mt-8">
                                        <a class="btn-edit"
                                            href="user_editprofile.php?cust_id=<?php echo $data['cust_id']; ?>">Edit</a>
                                    </div>
                                </div>
                                <?php
                            }
                        } else {
                            echo "<p>No records found.</p>";
                            ?>
                            <?php
                        }
                        ?>
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