<?php
include($_SERVER['DOCUMENT_ROOT'] . "/config/db_connect.php");
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/fetch-assoc.php');

if (!isset($POST['reset-request-submit'])) {
    echo("<script>location.href = '/?err=unauthorized';</script>");
    exit();
} else {
    $selector = bin2hex(random_bytes(8));
    $token = random_bytes(32);
    $url = "https://www.postr.awettech.com/forgottenpassword/create-new-password.php?selector=" . $selector . "&validator=" . bin2hex($token);
    $expires = date("U") + 1800;
    $userEmail = $_POST['email'];
    $sql  = "DELETE FROM loginsystem WHERE pwdResetEmail = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo("<script>location.href = '/?err=sqlerror';</script>");
        exit();
    } else {
        $hashedToken = password_hash($token, PASSWORD_DEFAULT);
        mysqli_stmt_bind_param($stmt, 'ssss', $userEmail, $selector, $hashedToken, $expires);
        mysqli_stmt_execute($stmt);
    }
    $sql = "INSERT INTO loginsystem (pwdResetEmail, pwdResetSelector, pwdResetToken, pwdResetExpires) VALUES (?,?,?,?)";
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    $to = $userEmail;
    $subject = "Reset your password";
    $message = "<p>We recieved a password reset request. The link to reset your password is below. If you did not make this request, you can ignore this email.</p>";
    $message .= "<p>Here is you password reset link: <br /> </p>"
    $message .= "<a href = '" . $url . "'>" . $url . "</a>";
    $headers = "From: Postr <awetmelake@awettech.com>\r\n";
    $headers .= "Reply-To:  awetmelake@awettech.com\r\n";
    $headers .= "Content-type : text/html\r\n";
    mail($to, $subject, $message, $headers);
    echo("<script>location.href = '/reset-password.php?resetpassword=success';</script>");
}
