<?php
if (isset($_POST['logout-submit'])) {
    session_start();
    session_unset();
    session_destroy();
    echo("<script>location.href = '/?logout=success';</script>");
} else {
    echo("<script>location.href = '/';</script>");
}
