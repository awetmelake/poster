<?php
include($_SERVER['DOCUMENT_ROOT']  . "/config/db_connect.php");
session_start();

if (!isset($_SESSION['userId']) || !isset($_POST['remove-favorites-submit'])) {
    echo("<script>location.href = '/index.php?err=unauthorized';</script>");
    echo "failed";
} else {
    $userId = intval($_SESSION['userId']);
    $postId = intval($_GET['id']);
    $sql = "DELETE FROM favorite_posts WHERE user_id = ? AND post_id = ?";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo("<script>location.href = '/index.php?err=sqlerror';</script>");
        exit();
    } else {
        echo "passed";
        mysqli_stmt_bind_param($stmt, 'ii', $userId, $postId);
        mysqli_stmt_execute($stmt);
        echo("<script>location.href = '/details.php?id=" . $postId . "';</script>");
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
