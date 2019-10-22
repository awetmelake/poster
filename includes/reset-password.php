<?php
include($_SERVER['DOCUMENT_ROOT'] . '/templates/header.php');

?>

<div class="">
    <h3>Reset your password</h3>
    <p>An e-mail will be sent to you with instructions on how to reset your password</p>
    <form class="" action="includes/reset-request.inc.php" method="post">
      <input type="text" name="" value="">
      <button type="submit" name="reset-request-submit">Receive a new password by email</button>
    </form>
</div>
