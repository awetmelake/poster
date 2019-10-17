<?php
session_start();
include('./includes/fetch-favorites.php');
?>
<head>
  <meta charset="utf-8">
  <title>Postr</title>
  <!-- materialize css -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <!-- material icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" href="css/main.css">
</head>
<body class="grey lighten-3">
  <nav class="white z-depth-0">
    <div class="container">
      <a href="index.php" class="brand-logo brand-text">Postr</a>

      <!-- nav -->
      <ul id="nav-mobile" class="right hide-on-small-and-down">
        <?php if (isset($_SESSION['userId'])) :?>
          <!-- post btn -->
          <li><a href="add.php" class="btn brand z-depth-0">Post</a></li>

          <!-- profile btn -->
          <li><a class="btn brand z-depth-0"  href="profile.php?id=<?php echo htmlspecialchars($_SESSION['userId'])?>">Profile</a></li>

          <!-- logout btn -->
          <li>
          <form class="p-0 form-button" action="./logout.php" method="POST">
            <button class="btn brand z-depth-0" type="submit" role="button" name="logout-submit">Log out</button>
          </form>
          </li>

          <?php else : ?>
            <!-- sign in btn -->
            <li><a href="signin.php" class="btn brand z-depth-0">Sign in</a></li>
          <?php endif;?>
        </ul>
      </div>
    </nav>

    <main class="container p-0 ">
