<?php
include($_SERVER['DOCUMENT_ROOT'] . "/config/db_connect.php");
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/fetch-assoc.php');
$userId = $_GET['id'];
$createdPosts = array();
$sql = "SELECT * FROM posts WHERE created_by = ?";
$stmt = mysqli_stmt_init($conn);
if (!mysqli_stmt_prepare($stmt, $sql)) {
    echo("<script>location.href = '/?err=sqlerror';</script>");
    exit();
} else {
    // get created posts
    mysqli_stmt_bind_param($stmt, 'i', $userId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    while ($row = fetchAssocStatement($stmt)) {
        array_push($createdPosts, $row);
        // print_r($row);
    }
}
