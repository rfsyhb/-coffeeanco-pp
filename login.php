<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous" />

    <link rel="stylesheet" href="assets/css/login.css">
    <title>Document</title>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center align-items-center" style="height: 100vh;">
            <!-- Centering the form vertically and horizontally -->
            <div class="login-form">
                <form action="path_to_your_authentication_script.php" method="post">
                    <h3>LOGIN</h3>
                    <div class="form-row d-flex flex-column flex-md-row"> <!-- Flex container for the form row -->
                        <div class="form-group me-md-2 flex-grow-1"> <!-- Container for the input fields -->
                            <input type="text" name="username" class="form-control my-2 py-2" placeholder="Username" />
                            <input type="text" name="password" class="form-control my-2 py-2" placeholder="Password" />
                        </div>
                        <div class="form-action"> <!-- Container for the button -->
                            <button class="btn btn-brown">Login</button>
                        </div>
                        <a href="path_to_your_registration_script.php" class="register-link text-decoration-none">Register</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>

</html>