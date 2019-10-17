<?php
include("../config/db_connect.php");
session_start();

if (!isset($_SESSION['userId']) || !isset($_POST['remove-favorites-submit'])) {
    header("Location: ../index.php?err=unauthorized");
} else {
    $userId = intval($_SESSION['userId']);
    $postId = intval($_GET['id']);
    $sql = "DELETE FROM favorite_posts WHERE user_id = ? AND post_id = ?";
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
