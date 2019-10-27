<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Postr</title>
  <!-- materialize css -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <!-- material icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" href="/css/main.css">
</head>
<body class="grey lighten-3">
  <nav class="white z-depth-0">
    <div class="container">
      <a href="/" class="brand-logo brand-text">Postr</a>
      <a href="#" data-target="nav-mobile" class="sidenav-trigger"><i class="material-icons black-text">menu</i></a>

      <!-- main nav -->
      <ul class="right hide-on-med-and-down">
        <?php if (isset($_SESSION['userId'])) :?>
          <!-- post btn -->
          <li><a href="/add" class="btn brand z-depth-0" title="Create a post"><i class="material-icons">post_add</i></a></li>

          <!-- profile btn -->
          <li><a class="btn brand z-depth-0"  href="/profile?id=<?php echo htmlspecialchars($_SESSION['userId'])?>" title="Go to user profile"><i class="material-icons">perm_identity</i></a></li>

          <!-- logout btn -->
          <li>
            <form class="p-0 form-button" action="./logout" method="POST">
              <button class="btn red darken-2 z-depth-0" type="submit" role="button" name="logout-submit">Log out</button>
            </form>
          </li>

        <?php else : ?>
          <!-- sign in btn -->
          <li><a href="/signin" class="btn brand z-depth-0">Sign in</a></li>
        <?php endif;?>
      </ul>

      </div>
    </nav>

    <!-- mobile nav -->
    <ul id="nav-mobile" class="sidenav">
      <?php if (isset($_SESSION['userId'])) :?>
        <!-- post btn -->
        <li><a href="/add" class="btn brand z-depth-0">Post</a></li>

        <!-- profile btn -->
        <li><a class="btn brand z-depth-0"  href="/profile?id=<?php echo htmlspecialchars($_SESSION['userId'])?>">Profile</a></li>

        <!-- logout btn -->
        <li>
          <form class="p-0 form-button" action="./logout" method="POST">
            <button class="btn red darken-2 z-depth-0" type="submit" role="button" name="logout-submit">Log out</button>
          </form>
        </li>

      <?php else : ?>
        <!-- sign in btn -->
        <li><a href="/signin" class="btn brand z-depth-0">Sign in</a></li>
      <?php endif;?>
    </ul>

  <main class="container p-0 ">
