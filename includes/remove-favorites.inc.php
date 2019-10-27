<?php
include($_SERVER['DOCUMENT_ROOT'] . '/templates/header.php');
include($_SERVER['DOCUMENT_ROOT']  . "/config/db_connect.php");

if (!isset($_POST['remove-favorites-submit']) && !isset($_POST['profile-remove-favorites-submit'])) {
    echo("<script>location.href = '/?err=unauthorized';</script>");
    exit();
} else {
    $userId = intval($_SESSION['userId']);
    $postId = intval($_GET['id']);
    $sql = "DELETE FROM favorite_posts WHERE user_id = ? AND post_id = ?";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo("<script>location.href = '/?err=sqlerror';</script>");
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, 'ii', $userId, $postId);
        mysqli_stmt_execute($stmt);
        if (isset($_POST['profile-remove-favorites-submit'])) {
            echo("<script>location.href = '/profile.php?id=" . $userId . "&post=removed';</script>");
        } else {
            echo("<script>location.href = '/details?id=" . $postId . "';</script>");
        }
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
