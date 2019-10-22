<?php
include($_SERVER['DOCUMENT_ROOT']  . "/templates/header.php");
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/fetch-assoc.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/fetch-details.inc.php');
?>

<?php if (!isset($_SESSION['userId']) || !isset($_SESSION['userId']) && !isset($_POST['delete-post-submit'])): ?>
  <?php echo("<script>location.href = '/index.php?err=unauthorized';</script>");
  exit(); ?>
<?php elseif (isset($_SESSION['userId']) && isset($_POST['delete-post-submit'])): ?>
  <?php
  include($_SERVER['DOCUMENT_ROOT'] . "/config/db_connect.php");
  $postId = $_GET['id'];
  $sql = "DELETE FROM posts WHERE id = ?";
  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt, $sql)) {
      // echo("<script>location.href = '/index.php?err=sqlerror';</script>");
      echo mysqli_error($conn);
      exit();
  } else {
      mysqli_stmt_bind_param($stmt, 'i', $postId);
      mysqli_stmt_execute($stmt);
      echo("<script>location.href = '/index.php?post=deleted';</script>");
  }
  mysqli_stmt_close($stmt);
  mysqli_close($conn);
   ?>
<?php elseif (isset($_SESSION['userId']) && !isset($_POST['delete-post-submit'])): ?>
  <div class="center v-align">
    <h5 class="p-1">Are you sure you want to delete this post?</h5>
    <div class="row post-card ">
      <div class="col s12 ">
        <div class="card z-depth-0" >
          <div class="card-content left-align">
            <h5><?php echo htmlspecialchars($post['title'])?></h5>
            <div><?php echo htmlspecialchars($post['company'])?></div>
            <div><?php echo htmlspecialchars($post['city']) . ", " . htmlspecialchars($post['state'])?></div>
            <span class="truncate grey-text"> <?php echo htmlspecialchars($post['description']) ?></span>
            <div class="post-card-createdat grey-text">Posted: <?php echo htmlspecialchars(substr($post['created_at'], 0, 10)) ?></div>
          </div>
          <div class=" center card-action">
            <form class="form-button" action="delete-post.inc.php?id=<?php echo htmlspecialchars($post['id']) ?>" method="post">
              <input class="btn red darken-2 z-depth-0" type="submit" name="delete-post-submit" value="Im sure">
            </form>
            <a class="btn brand z-depth-0" onclick="history.back()">nevermind</a>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php endif; ?>
