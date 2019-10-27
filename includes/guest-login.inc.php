<?php
include($_SERVER['DOCUMENT_ROOT'] . '/templates/header.php');
include($_SERVER['DOCUMENT_ROOT'] . '/config/db_connect.php');

if (isset($_POST['guest-signin-submit'])) {
    $email = 'guest@guest.com';
    $password = "guest123";

    if (empty($email) || empty($password)) {
        echo("<script>location.href = '/signin?err=Empty fields';</script>");
        exit();
    } else {
        $sql = "SELECT * FROM users WHERE email=?";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            echo("<script>location.href = '/?err=sqlerror';</script>");
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, 's', $email);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $userId, $userEmail, $userPassword, $col4, $col5);
            if (mysqli_stmt_fetch($stmt)) {
                $passwordCheck = password_verify($password, $userPassword);
                if ($passwordCheck == false) {
                    echo("<script>location.href = '/signin?err=Incorrect password';</script>");
                    echo $password . " " .$userPassword;
                    exit();
                } elseif ($passwordCheck == true) {
                    $_SESSION['userId'] = $userId;
                    echo("<script>location.href = '/?signin=success';</script>");
                }
            } else {
                echo("<script>location.href = '/signin?err=User does not exist';</script>");
            }
        }
    }
}//end POST check
