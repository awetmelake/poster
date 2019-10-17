<!DOCTYPE html>
<html lang="en" dir="ltr">

<?php include('./templates/header.php')?>
<!-- protect route -->
<?php if (!isset($_SESSION["userId"])) {
    header("Location: index.php?err=Must be signed in to access that page");
} ?>

<?php include('./includes/fetch-favorites.php') ?>

<?php
include("./config/db_connect.php");
$sql = "SELECT * FROM posts WHERE id = ?";
$stmt = mysqli_stmt_init($conn);
$favPosts = array();

if (!mysqli_stmt_prepare($stmt, $sql)) {
    header("Location: index.php?err=slqerr");
    exit();
} else {
    // get saved posts
    foreach ($favorites as $post) {
        mysqli_stmt_bind_param($stmt, 'i', intval($post));
        mysqli_stmt_execute($stmt);
        $result =  mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        array_push($favPosts, $row);
    }
}

$userId = $_SESSION['userId'];
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = mysqli_stmt_init($conn);

if (!mysqli_stmt_prepare($stmt, $sql)) {
    header("Location: index.php?err=slqerr");
    exit();
} else {
    // get user info
    mysqli_stmt_bind_param($stmt, 'i', intval($userId));
    mysqli_stmt_execute($stmt);
    $result =  mysqli_stmt_get_result($stmt);
    $userInfo =  mysqli_fetch_assoc($result);
}

 ?>

<div class="profile">
  <div class="profile-settings">
    <div class="center grey-text ">
        <h4>Settings</h4><br>
    </div>
    <div class="clearfix"></div>
    <div class="row">
      <div class="col s12 m10 offset-m1 l8 offset-l2">
        <form class="card z-depth-0 grey-text" action="save-settings-submit" method="post">
          <div class="card-content">
            <div class="row">
              <div class="col s12">
                <h5>Privacy</h5>
              </div>
            </div>

            <div class="row">
              <div class="col s12">
                <p>Allow users to view your profile</p>
                <div class="switch">
                  <label>
                    Yes
                    <input type="checkbox">
                    <span class="lever"></span>
                    No
                  </label>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col s12">
                  <h5>Account</h5>
              </div>
            </div>
            <div class="row">
              <div class="col s12">
                  <p>Email: <?php echo htmlspecialchars($userInfo['email']) ?>
                  </p><br>
                  <p>Password: **********
                    <button class="btn-small red darken-3 z-depth-0 right" type="button" name="show-password">Change</button>
                    <div class="clearfix"></div>
                  </p>
              </div>
            </div>
          </div>
          <div class="center p-1">
            <input type="submit" class="brand btn z-depth-0" name="save-settings-submit" value="Save changes">
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="center grey-text">
      <h4>Saved posts</h4><br>
  </div>
  <?php foreach ($favPosts as $post): ?>
    <?php if (empty($post['id'])): ?>
      <div class="row post-card">
        <div class="col s12">
          <div class="card z-depth-0 ">
            <div class="card-content col s12 l8 grey-text">
                Removed by the poster
            </div>
            <div class=" col s12 l4 card-footer p-1">
              <button type="button" name="button" class="right btn-small red darken-3 z-depth-0">Remove</button>
            </div>
            <div class="clearfix"></div>
          </div>
        </div>
      </div>
    <?php else: ?>
    <div class="row post-card">
      <div class="col s12">
        <div class="card z-depth-0 ">
          <div class="card-content col s12 l8">
            <span><?php echo $post['title'] . " - " . $post['company']?></span>
            <span class="grey-text"><?php echo  $post['city'] . ", " . $post['state'] ?></span>
          </div>
          <div class=" col s12 l4 card-footer p-1">
            <button type="button" name="button" class="right btn-small red darken-3 z-depth-0">Remove</button>
            <button type="button" name="button" class="right btn-small brand z-depth-0">See post</button>
          </div>
          <div class="clearfix"></div>
        </div>
      </div>
    </div>
    <?php endif; ?>
  <?php endforeach; ?>
</div>

<?php include('./templates/footer.php') ?>

</html>
