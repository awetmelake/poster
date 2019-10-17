<?php
include("../config/db_connect.php");
session_start();

// fetch favorites post_id's for current user
if (!isset($_SESSION['userId']) || !isset($_POST['favorites-submit'])) {
    header("Location: ../index.php?err=unauthorized");
} else {
    $userId = intval($_SESSION['userId']);
    $postId = intval($_GET['id']);
    $sql = "INSERT INTO favorite_posts (user_Id, post_id) VALUES (?,?)";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../index.php?err=sqlerror");
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, 'ii', $userId, $postId);
        mysqli_stmt_execute($stmt);
        header('Location: ../details.php?id=' . $postId);
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
