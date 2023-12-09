<?php
    $server = "localhost";
    $username = "root";
    $password = "";
    $db_name = "coffeeanco";

    $connect = mysqli_connect($server, $username, $password, $db_name);

    if(!$connect) {
        die(
            "<script>
                alert('Connection to Database Failed!')
            </script>"
        );
    }
?>