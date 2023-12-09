<?php
session_start();

// Memeriksa apakah pengguna adalah admin, jika tidak, mengarahkan ke halaman login
if ($_SESSION['status'] != "admin") {
    header("Location: ../login.php");
    exit;
}

require_once "../includes/config.php"; // Menghubungkan ke konfigurasi database

// Cek jika aksi dan order_id diterima melalui GET request
if (isset($_GET['action']) && isset($_GET['order_id'])) {
    $order_id = $_GET['order_id']; // Ambil order_id dari GET request
    $action = $_GET['action']; // Mendapatkan aksi yang diminta

    // Prepared statement untuk berbagai aksi
    switch ($action) {
        case 'fail':
        case 'process':
        case 'delay':
        case 'complete':
            $new_status = ($action == 'fail') ? 'digagalkan' :
                (($action == 'process') ? 'sedang diproses' :
                    (($action == 'delay') ? 'delayed' : 'selesai'));
            $stmt = mysqli_prepare($connect, "UPDATE orders SET order_status = ? WHERE order_id = ?");
            mysqli_stmt_bind_param($stmt, 'ss', $new_status, $order_id);
            mysqli_stmt_execute($stmt);
            break;
        case 'delete':
            // Menghapus order_details dan orders
            $stmt = mysqli_prepare($connect, "DELETE FROM order_details WHERE order_id = ?");
            mysqli_stmt_bind_param($stmt, 's', $order_id);
            mysqli_stmt_execute($stmt);

            $stmt = mysqli_prepare($connect, "DELETE FROM orders WHERE order_id = ?");
            mysqli_stmt_bind_param($stmt, 's', $order_id);
            mysqli_stmt_execute($stmt);
            break;
        default:
            // Jika aksi tidak valid, matikan eksekusi script
            die('Invalid action.');
    }

    // Redirect kembali ke halaman ini untuk menghindari eksekusi ulang URL saat refresh
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
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
    <title>Dashboard - Admin</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">
    <link href="../assets/css/admin.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>

</head>

<body class="sb-nav-fixed">
    <!-- Navbar atas -->
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="index.php"><i class=""></i>Admin Dashboard
        </a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i
                class="fas fa-bars"></i></button>
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

    <!-- Sidebar navigasi -->
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

        <!-- Koten utama halaman -->
        <div id="layoutSidenav_content">
            <main>
                <!-- Wrapper konten utama -->
                <div id="page-content-wrapper">
                    <div class="container-fluid px-4">
                        <!-- Sertakan file container_fluid.php untuk konten dinamis -->
                        <?php
                        include 'container_fluid.php';
                        ?>

                        <!-- Tabel untuk menampilkan status pemesanan -->
                        <div class="row">
                            <div class="col-md-10 offset-md-1 mt-5">
                                <!-- Judul dan tabel status pemesanan -->
                                <h3 class="fs-3 mb-3 ">Status Pemesanan</h3>
                                <table class="table bg-white rounded shadow-sm table-hover pad">
                                    <thead>
                                        <tr>
                                            <th scope="col">Nama Customer</th>
                                            <th scope="col" width="55">Total</th>
                                            <th scope="col" width="150">Order ID</th>
                                            <th scope="col" width="70">Order Date</th>
                                            <th scope="col" width="215">Order Status</th>
                                            <th scope="col" width="145">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $datas = mysqli_query($connect, "SELECT pengunjung.cust_name, orders.total_amount, orders.order_id, orders.order_date, orders.order_status FROM orders INNER JOIN pengunjung ON orders.cust_username = pengunjung.cust_username WHERE orders.order_status != 'selesai'");
                                        while ($data = mysqli_fetch_array($datas)) {
                                            ?>
                                            <tr>
                                                <td>
                                                    <?php echo $data['cust_name']; ?>
                                                </td>
                                                <td style="text-align: right;">
                                                    <?php echo number_format($data['total_amount'], 0, ',', '.'); ?>
                                                </td>
                                                <td>
                                                    <a
                                                        href="display_orderdetails.php?order_id=<?php echo $data['order_id']; ?>">
                                                        <?php echo $data['order_id']; ?>
                                                    </a>
                                                </td>
                                                <td>
                                                    <?php echo $data['order_date']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $data['order_status']; ?>
                                                </td>
                                                <td>
                                                    <a href="?action=fail&order_id=<?php echo $data['order_id']; ?>"
                                                        class="btn-sm btn-primary">
                                                        <span class="fa-regular fa-calendar-xmark">
                                                    </a>
                                                    <a href="?action=process&order_id=<?php echo $data['order_id']; ?>"
                                                        class="btn-sm btn-primary">
                                                        <span class="fa-regular fa-calendar-plus">
                                                    </a>
                                                    <a href="?action=delay&order_id=<?php echo $data['order_id']; ?>"
                                                        class="btn-sm btn-primary">
                                                        <span class="fa-regular fa-calendar-minus">
                                                    </a>
                                                    <a href="?action=complete&order_id=<?php echo $data['order_id']; ?>"
                                                        class="btn-sm btn-danger">
                                                        <span class="fa-regular fa-calendar-check">
                                                    </a>
                                                    <a href="?action=delete&order_id=<?php echo $data['order_id']; ?>"
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

                                <!-- Judul dan tabel status pemesanan -->
                                <h3 class="fs-3 mb-3 mt-5">Status Pemesanan (Selesai)</h3>
                                <table class="table bg-white rounded shadow-sm table-hover pad">
                                    <thead>
                                        <tr>
                                            <th scope="col">Nama Customer</th>
                                            <th scope="col" width="55">Total</th>
                                            <th scope="col" width="150">Order ID</th>
                                            <th scope="col" width="70">Order Date</th>
                                            <th scope="col" width="215">Order Status</th>
                                            <th scope="col" width="145">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $datas_selesai = mysqli_query($connect, "SELECT pengunjung.cust_name, orders.total_amount, orders.order_id, orders.order_date, orders.order_status FROM orders INNER JOIN pengunjung ON orders.cust_username = pengunjung.cust_username WHERE orders.order_status = 'selesai'");
                                        while ($data = mysqli_fetch_array($datas_selesai)) {
                                            ?>
                                            <tr>
                                                <td>
                                                    <?php echo $data['cust_name']; ?>
                                                </td>
                                                <td style="text-align: right;">
                                                    <?php echo number_format($data['total_amount'], 0, ',', '.'); ?>
                                                </td>
                                                <td>
                                                    <a
                                                        href="display_orderdetails.php?order_id=<?php echo $data['order_id']; ?>">
                                                        <?php echo $data['order_id']; ?>
                                                    </a>
                                                </td>
                                                <td>
                                                    <?php echo $data['order_date']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $data['order_status']; ?>
                                                </td>
                                                <td>
                                                    <a href="?action=fail&order_id=<?php echo $data['order_id']; ?>"
                                                        class="btn-sm btn-primary">
                                                        <span class="fa-regular fa-calendar-xmark">
                                                    </a>
                                                    <a href="?action=process&order_id=<?php echo $data['order_id']; ?>"
                                                        class="btn-sm btn-primary">
                                                        <span class="fa-regular fa-calendar-plus">
                                                    </a>
                                                    <a href="?action=delay&order_id=<?php echo $data['order_id']; ?>"
                                                        class="btn-sm btn-primary">
                                                        <span class="fa-regular fa-calendar-minus">
                                                    </a>
                                                    <a href="?action=complete&order_id=<?php echo $data['order_id']; ?>"
                                                        class="btn-sm btn-danger">
                                                        <span class="fa-regular fa-calendar-check">
                                                    </a>
                                                    <a href="?action=delete&order_id=<?php echo $data['order_id']; ?>"
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

                            </div>
                        </div>
                    </div>
                </div>
            </main>

            <!-- Footer halaman -->
            <footer class="py-4 bg-light mt-1">
                <div class="container-fluid px-4">
                    <div class=" text-center text-secondary">
                        <div class="text-muted">Copyright &copy; Rafi Syihab 2023</div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- Script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
    <script src="../assets/js/script.js"></script>
    <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script type="text/javascript" charset="utf8"
        src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.js"></script>
    <script>
        $(document).ready(function () {
            $('.table').DataTable();
        });
    </script>
</body>

</html>