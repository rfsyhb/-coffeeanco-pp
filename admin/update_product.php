<?php
session_start();

// Memastikan hanya admin yang bisa mengakses halaman ini
if ($_SESSION['status'] != "admin") {
    header("Location: ../login.php");
    exit;
}

require_once "../includes/config.php";

// Memeriksa apakah form telah disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Mengambil detail produk dari POST request
    $product_id = $_POST['prod_id'];
    $product_name = $_POST['prod_name'];
    $product_type = $_POST['prod_type'];
    $product_desc = $_POST['prod_desc'];
    $product_stock = $_POST['prod_stock'];
    $product_price = $_POST['prod_price'];

    // Fungsi untuk mengelola upload gambar
    function uploadImage($image, $target_dir)
    {
        $target_file = $target_dir . basename($_FILES[$image]["name"]);
        if (move_uploaded_file($_FILES[$image]["tmp_name"], $target_file)) {
            return basename($_FILES[$image]["name"]);
        }
        return false;
    }

    // Direktori tempat menyimpan gambar yang diupload
    $target_dir = "../assets/images/uploaded/";

    // Mengelola upload untuk prod_image1 dan prod_image2
    $product_image1 = uploadImage('prod_image1', $target_dir);
    $product_image2 = uploadImage('prod_image2', $target_dir);

    if ($product_image1 && $product_image2) {
        $query = "UPDATE produk SET prod_name = ?, prod_type = ?, prod_desc = ?, prod_stock = ?, prod_price = ?, prod_image1 = ?, prod_image2 = ? WHERE prod_id = ?";
        $statement = mysqli_prepare($connect, $query);
        mysqli_stmt_bind_param($statement, 'sssissss', $product_name, $product_type, $product_desc, $product_stock, $product_price, $product_image1, $product_image2, $product_id);

        $result = mysqli_stmt_execute($statement);

        if ($result) {
            echo "<script>alert('Product has been updated!'); window.location = 'display_product.php'</script>";
        } else {
            echo "<script>alert('Update product failed!'); window.location = 'display_product.php'</script>";
        }
    } else {
        echo "<script>alert('Upload image failed!'); window.location = 'display_product.php'</script>";
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
    <title>Dashboard - Update Products</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />

    <link href="../assets/css/admin.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    <style>
        .required-asterisk {
            color: red;
            display: none;
        }
    </style>
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
                <div class="container-fluid px-4 mt-4">
                    <?php
                    $id = $_GET['prod_id'];
                    $query = mysqli_query($connect, "SELECT * FROM produk WHERE prod_id='$id'");
                    $data = mysqli_fetch_array($query);
                    ?>
                    <h2>Update Product</h2>
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label>ID Product <span class="required-asterisk">*</span></label>
                            <input type="text" name="prod_id" id="prod_id" value="<?php echo $data['prod_id']; ?>"
                                class="form-control" readonly>
                        </div>
                        <div class="mb-3">
                            <label>Product Name <span class="required-asterisk">*</span></label>
                            <input type="text" name="prod_name" id="prod_name" value="<?php echo $data['prod_name']; ?>"
                                class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Product Type <span class="required-asterisk">*</span></label>
                            <select name="prod_type" id="prod_type" class="form-control my-2 py-2" required>
                                <option value="">Pilih tipe produk biji kopi!</option>
                                <option value="Arabika" <?php echo $data['prod_type'] == 'Arabika' ? 'selected' : ''; ?>>
                                    Arabika</option>
                                <option value="Robusta" <?php echo $data['prod_type'] == 'Robusta' ? 'selected' : ''; ?>>
                                    Robusta</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label>Description (maksimal 255 huruf) <span class="required-asterisk">*</span></label>
                            <textarea name="prod_desc" id="prod_desc" class="form-control my-2 py-2" required
                                maxlength="255"><?php echo htmlspecialchars($data['prod_desc']); ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label>Stock <span class="required-asterisk">*</span></label>
                            <input type="text" name="prod_stock" id="prod_stock"
                                value="<?php echo $data['prod_stock']; ?>" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Price <span class="required-asterisk">*</span></label>
                            <input type="text" name="prod_price" id="prod_price"
                                value="<?php echo $data['prod_price']; ?>" class="form-control" required>
                        </div>
                        <!-- new -->
                        <div class="mb-3">
                            <label>Image 1 <span class="required-asterisk">*</span></label>
                            <input type="file" name="prod_image1" id="prod_image1" class="form-control"
                                value="<?php echo $data['prod_image1']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label>Image 2 <span class="required-asterisk">*</span></label>
                            <input type="file" name="prod_image2" id="prod_image2" class="form-control"
                                value="<?php echo $data['prod_image2']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <input type="submit" value="Update Product" class="btn btn-sm btn-primary" />&nbsp;
                        </div>
                    </form>
                </div>
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
    <script src="../assets/js/script.js"></script>
    <script src="../assets/js/required.js"></script>
</body>

</html>