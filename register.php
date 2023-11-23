<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous" />

    <link rel="stylesheet" href="assets/css/register.css">
    <title>Regiter Account</title>
</head>

<body>
    <div class="container mb-5">
        <div class="row justify-content-center align-items-center" style="height: 100vh;">
            <div class="register-form">
                <form action="" method="post">
                    <h3>Daftar User</h3>
                    <div class="form-group">
                        <input type="text" id="name" name="name" class="form-control my-2 py-2" placeholder="Name"
                            required>
                    </div>
                    <div class="form-group">
                        <input type="text" id="email" name="email" class="form-control my-2 py-2" placeholder="Email"
                            required>
                    </div>
                    <div class="form-group">
                        <input type="text" id="username" name="username" class="form-control my-2 py-2"
                            placeholder="Username" required>
                    </div>
                    <div class="form-group">
                        <input type="password" id="password" name="password" class="form-control my-2 py-2"
                            placeholder="Password" required>
                    </div>
                    <div class="form-group">
                        <input type="tel" id="phone" name="phone" class="form-control my-2 py-2" placeholder="Phone"
                            required>
                    </div>
                    <div class="form-group">
                        <input type="text" id="address" name="address" class="form-control my-2 py-2"
                            placeholder="Address" required>
                    </div>
                    <div class="form-group">
                        <input type="text" id="city" name="city" class="form-control my-2 py-2" placeholder="City"
                            required>
                    </div>
                    <div class="form-group">
                        <input type="text" id="province" name="province" class="form-control my-2 py-2"
                            placeholder="Province" required>
                    </div>
                    <div class="form-group">
                        <input type="text" id="postalcode" name="postalcode" class="form-control my-2 py-2"
                            placeholder="Postal Code" required>
                    </div>
                    <div class="form-action d-flex justify-content-end mt-3"> <!-- Container for the button -->
                        <button class="btn btn-brown shadow">Register</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>

<?php
include 'includes/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = "TES01";
    $name = $_POST["name"];
    $email = $_POST["email"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $phone = $_POST["phone"];
    $address = $_POST["address"];
    $city = $_POST["city"];
    $province = $_POST["province"];
    $postalcode = $_POST["postalcode"];

    // Hash password sebelum disimpan di database (disarankan)
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Query SQL untuk memasukkan data admin ke dalam tabel Admin
    $sql = "INSERT INTO pengunjung (cust_name, cust_email, cust_username, cust_password, cust_phone, cust_address, cust_city, cust_province, cust_postalcode) VALUES ('$name', '$email', '$username', '$hashed_password', '$phone', '$address', '$city', '$province', '$postalcode')";

    if ($connect->query($sql) === TRUE) {
        echo "Pendaftaran pengunjung berhasil.";
        header("location:index.php");
    } else {
        echo "Error: " . $sql . "<br>" . $connect->error;
    }
}
?>