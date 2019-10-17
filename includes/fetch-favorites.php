<?php
// retrieve favorites for current logged in users
include("./config/db_connect.php");

if (isset($_SESSION['userId'])) {
    $userId = intval($_SESSION['userId']);
    $sql = "SELECT post_id FROM favorite_posts WHERE user_id = ? ";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: index.php?err=sqlerror");
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, 'i', $userId);
        mysqli_stmt_execute($stmt);
        $result =  mysqli_stmt_get_result($stmt);
        $favorites = array();
        while ($row = mysqli_fetch_assoc($result)) {
            foreach ($row as $r) {
                array_push($favorites, $r);
            }
        }
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
