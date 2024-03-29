<?php
session_start();

// Memeriksa status pengguna; jika bukan admin, alihkan ke halaman login
if ($_SESSION['status'] != "admin") {
    header("Location: ../login.php");
    exit;
}

require_once "../includes/config.php";

// Cek jika ada aksi 'delete' dan 'prod_id' yang diberikan
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['prod_id'])) {
    $prod_id = $_GET['prod_id'];

    // Menggunakan prepared statement untuk menghapus produk
    $query = "DELETE FROM produk WHERE prod_id = ?";
    $statement = mysqli_prepare($connect, $query);
    mysqli_stmt_bind_param($statement, "s", $prod_id);
    mysqli_stmt_execute($statement);

    // Memberikan feedback kepada admin
    if ($statement) {
        echo "<script>alert('Product has been Deleted!'); window.location = 'display_product.php'</script>";
    } else {
        echo "<script>alert('Delete Product Failed!'); window.location = 'display_product.php'</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <link rel="icon" href="assets/img/database.svg">
    <title>Dashboard - Products</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">

    <link href="../assets/css/admin.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>

</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="index.php"><i class=""></i>Admin Dashboard
        </a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i
                class="fas fa-bars"></i></button>
        <!-- Navbar Search-->

        <!-- Navbar-->
        <ul class="navbar-nav d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown"
                    aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="../includes/logout.php">Logout</a></li>
                </ul>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">

                        <a class="nav-link mt-3" href="index.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>
                        <!-- produk -->
                        <a class="nav-link collapsed" href="display_product.php" role="button">
                            <i class="fas fa-store-alt me-2"></i>Products
                        </a>
                        <!-- order -->
                        <a class="nav-link collapsed" href="display_order.php" role="button">
                            <i class="fas fa-shopping-cart me-2"></i>Orders
                        </a>
                        <!-- order -->
                        <a class="nav-link collapsed" href="display_orderdetails.php" role="button">
                            <i class="fas fa-book me-2"></i>Order Details
                        </a>
                        <!-- pengunjung -->
                        <a class="nav-link collapsed" href="display_customer.php" role="button">
                            <i class="fas fa-sharp fa-solid fa-circle-user me-2"></i>Customer
                        </a>
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Logged in as:</div>
                    <i class=""></i>
                    <?php
                    $query = mysqli_prepare($connect, "SELECT name FROM admin WHERE username=?");
                    mysqli_stmt_bind_param($query, "s", $_SESSION['username']);
                    mysqli_stmt_execute($query);
                    $result = mysqli_stmt_get_result($query);
                    $data = mysqli_fetch_array($result);
                    echo $data['name'];
                    ?>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="row mx-5 mt-5">
                    <h3 class="fs-4 mb-3 ">Kelola Data Produk</h3>
                    <div class="col">
                        <table class="table bg-white rounded shadow-sm  table-hover">
                            <thead>
                                <tr>
                                    <th scope="col" width="60">ID</th>
                                    <th scope="col">Product</th>
                                    <th scope="col">Type</th>
                                    <th scope="col">Description</th>
                                    <th scope="col" style="text-align: center;">Stock</th>
                                    <th scope="col" width="80" style="text-align: center;">Price</th>
                                    <th scope="col" width="55" style="text-align: center;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $datas = mysqli_query($connect, "SELECT * FROM produk");
                                while ($data = mysqli_fetch_array($datas)) {
                                    ?>
                                    <tr>
                                        <td>
                                            <?php echo $data['prod_id']; ?>
                                        </td>
                                        <td>
                                            <?php echo $data['prod_name']; ?>
                                        </td>
                                        <td>
                                            <?php echo $data['prod_type']; ?>
                                        </td>
                                        <td>
                                            <?php echo $data['prod_desc']; ?>
                                        </td>
                                        <td style="text-align: center;">
                                            <?php echo $data['prod_stock']; ?>
                                        </td>
                                        <td style="text-align: right;">
                                            <?php echo number_format($data['prod_price'], 0, ',', '.'); ?>
                                        </td>
                                        <td style="text-align: right;">
                                            <a href="update_product.php?prod_id=<?php echo $data['prod_id']; ?> "
                                                class="btn-sm btn-primary">
                                                <span class="fas fa-edit">
                                            </a>
                                            <a href="display_product.php?action=delete&prod_id=<?php echo $data['prod_id']; ?>"
                                                class="btn-sm btn-danger">
                                                <span class="fas fa-trash">
                                            </a>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                        <!-- Button to add a new product -->
                        <a href="add_product.php" class="btn btn-light btn-outline-dark mt-3">Add New Product</a>
            </main>
            <footer class="py-4 bg-light mt-1">
                <div class="container-fluid px-4">
                    <div class=" text-center text-secondary">
                        <div class="text-muted">Copyright &copy; Rafi Syihab 2023</div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
    <!-- jQuery dimuat terlebih dahulu -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>

    <script src="../assets/js/script.js"></script>
    <script>
        $(document).ready(function () {
            $('.table').DataTable();
        });
    </script>

</body>

</html>