<?php
 include('./config/db_connect.php');

// check GET  id param
if (isset($_GET['id'])) {
    $id =  $_GET['id'];
    $sql = "SELECT * FROM posts WHERE id = ?";
    $stmt = mysqli_stmt_init($conn);

    // prepare stmt and check for connection , redirect and exit on fail
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: index.php?err=sqlerror");
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "s", $id); //bind variable $id to stmt, protect from sql injection
        mysqli_stmt_execute($stmt); // execute the prepared query
        $result =  mysqli_stmt_get_result($stmt); //store query result in $post variable
        $post = mysqli_fetch_assoc($result); // fetch as assoc array
    }

    // close statement and db connection
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
