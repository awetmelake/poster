<?php
include("../templates/header.php");
include($_SERVER['DOCUMENT_ROOT'] . "/config/db_connect.php");
// fetch favorites post_id's for current user
if (!isset($_SESSION['userId']) || !isset($_POST['add-favorites-submit'])) {
    $errmsg = isset($_SESSION['userId']) ? "user" : "nouser";
    echo $errmsg;
    echo("<script>location.href = '/?err=unauthorized';</script>");
} else {
    $userId = intval($_SESSION['userId']);
    $postId = intval($_GET['id']);
    $sql = "INSERT INTO favorite_posts (user_Id, post_id) VALUES (?,?)";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo("<script>location.href = '/?err=sqlerror';</script>");
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, 'ii', $userId, $postId);
        mysqli_stmt_execute($stmt);
        echo("<script>location.href = '/details?id=". $postId. "';</script>");
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
