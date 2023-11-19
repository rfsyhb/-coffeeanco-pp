<?php
    include '../config.php';

    $id_subs = $_GET['id_subs'];

    $query = "DELETE FROM subscribing WHERE id_subs='$id_subs'";
    $statement = mysqli_prepare($connect, $query);
    mysqli_stmt_execute($statement);

    if($statement) {
        echo "<script>alert('Subscriber has been Deleted!'); window.location = 'display_subscribe.php'</script>";
    } else {
        echo "<script>alert('Delete Subscriber Failed!'); window.location = 'display_subscribe.php'</script>";
    }
?>