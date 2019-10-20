<?php
if (isset($_POST['logout-submit'])) {
    session_start();
    session_unset();
    session_destroy();
    echo("<script>location.href = '/index.php?logout=success';</script>");
} else {
    echo("<script>location.href = '/index.php';</script>");
}
