<?php
include("./includes/fetch-results.php");
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<?php include('./templates/header.php')?>

<!-- output messages -->
<div class="red-text center"><br>
<?php if (isset($_GET['err'])): ?>
  <?php  $message = $_GET['err']; ?>
  <?php if ($message === "sqlerror" || $message === "sqlerr"): ?>
    <?php  echo "Something went wrong, database connection failed"; ?>
  <?php elseif ($message === "unauthorized"): ?>
    <?php  echo "Must be signed in to preform that action"; ?>
  <?php endif; ?>
<?php endif; ?>
<?php if (isset($_GET['post'])): ?>
  <?php $message = $_GET['post']; ?>
  <?php if ($message === 'postsuccess'): ?>
    <?php echo "Successfully added new post"?>
  <?php elseif ($message === 'editsuccess'): ?>
    <?php echo "Saved changes"?>
  <?php endif; ?>
<?php endif; ?>
</div>

<?php include('./refine-results.php')?>

<div class="posts right">
  <?php foreach ($posts as $post): ?>
    <div class="row post-card right">
      <div class="col s12 ">
        <div class="card z-depth-0" >
          <div class="card-content">
            <h5><?php echo htmlspecialchars($post['title'])?></h5>
            <div><?php echo htmlspecialchars($post['company'])?></div>
            <div><?php echo htmlspecialchars($post['city']) . ", " . htmlspecialchars($post['state'])?></div>
            <span class="post-card-description truncate grey-text"> <?php echo htmlspecialchars($post['description']) ?></span>
            <div class="post-card-createdat grey-text">Posted: <?php echo htmlspecialchars(substr($post['created_at'], 0, 10)) ?></div>
          </div>
          <div class="card-action">
            <!-- <a href="apply.php?apply=<?php echo $post["id"]?>" class="green-text">Save</a> -->
            <a href="details.php?id=<?php echo $post["id"]?>" class="brand-text">More info</a>
          </div>
        </div>
      </div>
    </div>
    <div class="clearfix"></div>
  <?php endforeach ?>
</div>

<?php include('./templates/footer.php') ?>

</html>
