<?php
include($_SERVER['DOCUMENT_ROOT'] . "/config/db_connect.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/includes/fetch-assoc.php");
$userId = $_SESSION['userId'];
$sql = "SELECT post_id FROM favorite_posts WHERE user_id = ? ";
$stmt = mysqli_stmt_init($conn);
if (!mysqli_stmt_prepare($stmt, $sql)) {
    echo("<script>location.href = '/?err=sqlerror';</script>");
    exit();
} else {
    mysqli_stmt_bind_param($stmt, 'i', $userId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    $favorites = array();
    while ($row = fetchAssocStatement($stmt)) {
        array_push($favorites, $row['post_id']);
    }
}
mysqli_stmt_close($stmt);
mysqli_close($conn);
