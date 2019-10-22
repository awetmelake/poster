 <?php
 include($_SERVER['DOCUMENT_ROOT'] . '/templates/header.php');
 include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/fetch-assoc.php');
 include($_SERVER['DOCUMENT_ROOT'] . '/includes/fetch-favorites.php');
 include($_SERVER['DOCUMENT_ROOT'] . '/includes/fetch-user-posts.inc.php');


 $userId = $_GET['id'];
 $sql = "SELECT * FROM users WHERE id = ?";
 $stmt = mysqli_stmt_init($conn);

 if (!mysqli_stmt_prepare($stmt, $sql)) {
     echo("<script>location.href = '/index.php?err=sqlerror';</script>");
     exit();
 } else {
     // get user info
     mysqli_stmt_bind_param($stmt, 'i', $userId);
     mysqli_stmt_execute($stmt);
     mysqli_stmt_store_result($stmt);
     $userInfo = fetchAssocStatement($stmt);
 }
 mysqli_stmt_close($stmt);
 mysqli_close($conn);


include($_SERVER['DOCUMENT_ROOT'] . "/config/db_connect.php");
$sql = "SELECT * FROM posts WHERE id = ?";
$stmt = mysqli_stmt_init($conn);
$favPosts = array();

if (!mysqli_stmt_prepare($stmt, $sql)) {
    echo("<script>location.href = '/index.php?err=sqlerror';</script>");
    exit();
} else {
    // get saved posts
    foreach ($favorites as $id) {
        mysqli_stmt_bind_param($stmt, 'i', $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        while ($row = fetchAssocStatement($stmt)) {
            array_push($favPosts, $row);
        }
    }
}
 ?>

<div class="center red-text">
  <br>
  <?php if (isset($_GET['post'])): ?>
    <?php $msg = $_GET['post'] ?>
    <?php if ($msg === "removed"): ?>
      <?php echo "Successfully removed post" ?>
    <?php endif; ?>
  <?php endif; ?>
</div>

<div class="profile">
  <?php if ($userInfo["private"] === 1 && ((isset($_SESSION["userId"]) && $_SESSION["userId"] != $_GET['id']) || !isset($_SESSION["userId"]))): ?>
    <div class="center grey-text v-align">
      <h3>This user's profile is private</h3>
      <br>
      <a href="/index.php" class="btn brand z-depth-0">home</a>
      <br>
    </div>
    <?php else: ?>
    <?php if (isset($_SESSION['userId']) && $_SESSION['userId'] === intval($_GET['id'])): ?>
      <div class="profile-settings">
      <!-- settings -->
      <div class="center grey-text ">
          <h4>Settings</h4><br>
      </div>
      <div class="clearfix"></div>
      <div class="row">
        <div class="col s12 m10 offset-m1 l8 offset-l2">
          <form class="card z-depth-0 " action="/includes/save-settings-submit.inc.php" method="POST">
            <div class="card-content">
              <div class="row">
                <div class="col s12">
                  <h5>Privacy</h5>
                  <div class="divider"></div>
                </div>

              </div>

              <div class="row">
                <div class="col s12">
                  <p>Allow other users to view your profile</p>
                  <div class="switch">
                    <label>
                      Off
                      <input type="checkbox" value=<?php echo $userInfo['private'] === 1 ? 'off': 'on'?> id="privacy-toggle" />
                      <span class="lever"></span>
                      On
                    </label>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col s12">
                    <h5>Account</h5>
                    <div class="divider"></div>

                </div>
              </div>
              <div class="row">
                <div class="col s12">
                    <p>Email: <?php echo htmlspecialchars($userInfo['email']) ?>
                    </p><br>
                    <!-- <p>Password: ********** -->
                      <!-- <form class="form-button" action="/includes/reset-request.inc.php" method="post">
                        <button class="btn-small red darken-2 z-depth-0 right" type="button" name="show-password">Change</button>
                      </form> -->
                      <div class="clearfix"></div>
                    </p>
                </div>
              </div>
            </div>
            <div class="center p-1">
              <input type="submit" class="brand btn z-depth-0" name="save-settings-submit" id="save-changes" value="Save changes" disabled>
              <input type="hidden" name="toggle-privacy" id="privacy-value" value=<?php echo htmlspecialchars($userInfo['private']) ?>/>
            </div>
          </form>
        </div>
      </div>
    </div>
  <?php endif; ?>

  <!-- saved posts -->
  <?php if (empty($favPosts)): ?>
    <h4 class="grey-text center">No saved posts</h4><br>
  <?php else: ?>
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
              <button type="button" class="right btn-small red darken-2 z-depth-0">Remove</button>
            </div>
            <div class="clearfix"></div>
          </div>
        </div>
      </div>
    <?php else: ?>
    <div class="row post-card">
      <div class="col s12">
        <div class="card z-depth-0 ">
          <div class="card-content col s12 m7">
            <span><?php echo htmlspecialchars($post['title'] . " - " . $post['company'])?></span>
            <span class="grey-text"><?php echo  htmlspecialchars($post['city'] . ", " . $post['state']) ?></span>
          </div>
          <div class=" col s12 m5 card-footer saved-posts-post-btns">
            <form class="form-button"  action="includes/remove-favorites.inc.php?id=<?php echo htmlspecialchars($post['id']) ?>" method="post">
              <button type="submit" name="profile-remove-favorites-submit" class="right btn-small red darken-2 z-depth-0"><i class="material-icons left">delete</i>remove</button>
            </form>
            <a role="button" href="details.php?id=<?php echo htmlspecialchars($post['id']) ?>" class="right btn-small brand z-depth-0"><i class="material-icons left">navigate_next</i>details</a>
          </div>
          <div class="clearfix"></div>
        </div>
      </div>
    </div>
    <?php endif; ?>
  <?php endforeach; ?>
  <?php endif; ?>

    <?php if (empty($createdPosts)): ?>
      <h4 class="grey-text center">No created posts</h4><br>
    <?php else: ?>
      <!-- Created posts -->
      <div class="center grey-text">
          <h4>Created posts</h4><br>
      </div>
      <?php foreach ($createdPosts as $post): ?>
        <div class="row post-card">
          <div class="col s12">
            <div class="card z-depth-0 ">
              <div class="card-content col s12 m7">
                <span><?php echo htmlspecialchars($post['title'] . " - " . $post['company'])?></span>
                <span class="grey-text"><?php echo htmlspecialchars($post['city'] . ", " . $post['state']) ?></span>
              </div>
              <div class=" col s12 m5 card-footer saved-posts-post-btns">
                <a  role="button" href="includes/delete-post.inc.php?id=<?php echo htmlspecialchars($post['id']) ?>" class="right btn-small red darken-2 z-depth-0"><i class="material-icons left">delete_forever</i>Delete</a>
                <a role="button"  href="details.php?id=<?php echo htmlspecialchars($post['id']) ?>" class="right btn-small brand z-depth-0"><i class="material-icons left">edit</i>Edit</a>
              </div>
              <div class="clearfix"></div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  <?php endif; ?>
</div>

<?php include($_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php') ?>
<script type="text/javascript">
  let privacySwitch = document.querySelector('#privacy-toggle');
  let privacyVal = document.querySelector('#privacy-value');
  if(privacySwitch.value === "on"){
    privacySwitch.click();
  }
  let saveChanges = document.querySelector('#save-changes');
  saveChanges.disabled = true;

  privacySwitch.addEventListener('click', (e) => {
    e.target.value = e.target.value === "off" ? "on" : "off";
    privacyVal.value = e.target.value === "off" ? 1 : 0;
    saveChanges.disabled = !saveChanges.disabled;
    console.log(e.target.value);
  });
  console.log(privacySwitch.value);
</script>
