<?php
include($_SERVER['DOCUMENT_ROOT'] . '/config/db_connect.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/fetch-assoc.php');

if (isset($_GET['id'])) {
    $id =  $_GET['id'];
    $sql = "SELECT * FROM posts WHERE id = ?";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo("<script>location.href = '/index.php?err=sqlerror';</script>");
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "s", $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        $post = fetchAssocStatement($stmt);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
