<?php include($_SERVER['DOCUMENT_ROOT'] . '/templates/header.php')?>

<!-- output messages -->
<div class="red-text center"><br>
<?php if (isset($_GET['err'])): ?>
  <?php  $message = $_GET['err']; ?>
  <?php if ($message === "sqlerror"): ?>
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
  <?php elseif ($message === 'deleted'): ?>
    <?php echo "Successfully deleted post"?>
  <?php endif; ?>
<?php endif; ?>
</div>

<?php include($_SERVER['DOCUMENT_ROOT'] . '/refine-results.php')?>
<?php if (empty($posts)): ?>
  <div class="center">
    <h4>No matching results</h4>
  </div>
<?php endif; ?>

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
            <a href="details?id=<?php echo $post["id"]?>" class="brand-text">More info</a>
          </div>
        </div>
      </div>
    </div>
    <div class="clearfix"></div>
  <?php endforeach ?>
</div>

<?php include($_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php') ?>
