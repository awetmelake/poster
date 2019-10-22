<?php
include($_SERVER['DOCUMENT_ROOT'] . "/config/db_connect.php");
session_start();
  if (!isset($_POST['save-settings-submit']) || !isset($_SESSION['userId'])) {
      echo("<script>location.href = '/index.php?err=unauthorized';</script>");
      exit();
  } else {
      $sql  = "UPDATE users SET private = ? WHERE id = ?";
      $stmt = mysqli_stmt_init($conn);
      $private = $_POST['toggle-privacy'] === "off" ? 1 : 0;
      print_r($_POST);
      $userId = intval($_SESSION['userId']);
      if (!mysqli_stmt_prepare($stmt, $sql)) {
          // echo("<script>location.href = '/index.php?err=sqlerror';</script>");
          echo mysqli_error($conn);
          exit();
      } else {
          mysqli_stmt_bind_param($stmt, 'ii', $private, $userId);
          mysqli_stmt_execute($stmt);
          // echo("<script>location.href = '/profile.php?id=". $userId ."';</script>");
      }
      mysqli_stmt_close($stmt);
      mysqli_close($conn);
  }
