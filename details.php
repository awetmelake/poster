<?php
include($_SERVER['DOCUMENT_ROOT'] . '/templates/header.php');
include($_SERVER['DOCUMENT_ROOT'] .'/includes/fetch-details.inc.php');
if (isset($_SESSION['userId'])) {
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/fetch-favorites.php');
}
?>

<div class="row post-details">
	<div class="col s12 card z-depth-0">
		<?php if ($post): ?>
			<!-- post header -->
			<div class="card-content z-depth-0 pl-4 ">
					<h4 ><?php echo htmlspecialchars($post['title']) ?>
            <!-- post save edit delete btn -->
            <div class="center white text right ">
              <?php if (isset($_SESSION['userId']) && $_SESSION['userId'] == $post['created_by']): ?>
                <form method="POST" action="edit-post.php?id=<?php echo $_GET['id'] ?>" class="form-button edit-post">
                  <button title="Edit this post" type="submit" class="btn brand z-depth-0"  name="edit-post-submit" value="edit"><i class="material-icons ">edit</i></button>
                </form>
                  <a title="Delete this post" role="button" href="/includes/delete-post.inc.php?id=<?php echo htmlspecialchars($post['id']) ?>" class="right btn red darken-2 z-depth-0"><i class="material-icons ">delete_forever</i></a>
              <?php elseif (in_array($post['id'], $favorites)) : ?>
                <form method="POST" action="/includes/remove-favorites.inc.php?id=<?php echo htmlspecialchars($_GET['id']) ?>" class="form-button edit-post">
                  <button class="btn red darken-2 z-depth-0" type="submit" name="remove-favorites-submit" title="Remove post from favorites"><i class="material-icons">favorite</i>
                  </button>
                </form>
              <?php elseif (!in_array($post['id'], $favorites) || !isset($_SESSION['userId'])): ?>
                <form method="POST" action="/includes/add-favorites.inc.php?id=<?php echo htmlspecialchars($_GET['id'])?>" class="form-button add-favorites">
                  <button type="submit" class="btn green z-depth-0" value="Save" name="add-favorites-submit" title="Add post to favorites"><i class="material-icons">favorite_outline</i></button>
                </form>
              <?php endif; ?>
            </div>
            <div class="clearfix"></div>

          </h4>
					<div><?php echo htmlspecialchars($post['company']) ?></div>
					<div >
						<?php echo htmlspecialchars($post['city']) ?>,
						<?php echo htmlspecialchars($post['state']) ?>
						(<?php echo htmlspecialchars($post['zipcode']) ?>)
					</div>
					<div>
						<?php echo htmlspecialchars($post['type']) ?>
					</div>
          <br>

				<div class="divider"></div>

				<!-- post body -->
				<div class="section">
					<h5>Job description</h5>
					<?php if (!empty($post['description'])): ?>
						<p><?php echo htmlspecialchars($post['description']) ?></p>
					<?php else: ?>
						<p><i>no description available</i></p>
					<?php endif; ?>
				</div>

					<?php if (!empty($post['requirements'])): ?>
            <div class="section">
              <!-- requirements -->
            <h5>Required</h5>
            <ul>
              <?php
               $reqs = explode(",", $post['requirements']);
               foreach ($reqs as $req) {
                   if (!empty($req)) {
                       echo "<li>" . htmlspecialchars($req) . "</li>";
                   }
               }?>
            </ul>
          </div>
					<?php endif; ?>

            <?php if (!empty($post['preferred'])): ?>
              <!-- preferred -->
              <div class="section">
              <h5>Preferred</h5>
              <ul>
                <?php
                 $prefs = explode(",", $post['preferred']);
                 foreach ($prefs as $pref) {
                     if (!empty($pref)) {
                         echo "<li>" . htmlspecialchars($pref) . "</li>";
                     }
                 }?>
              </ul>
            </div>
            <?php endif; ?>

				<!-- pay -->
				<div class="section">
					<?php if ($post['hourly_min'] > 0): ?>
						<h5>Pay</h5>
						<p>
							<!-- hourly -->
							Hourly:
							<?php echo  "$" . htmlspecialchars($post['hourly_min']) . " -" ?>
							<?php echo "$" . htmlspecialchars($post['hourly_max']) ?>
						</p>

						<?php elseif ($post['salary_min'] > 0): ?>
							<!-- salary -->
							<p>
								Salary:
								<?php echo "$" . htmlspecialchars($post['salary_min']) . " -" ?>
								<?php echo "$" . htmlspecialchars($post['salary_max']) ?>
							</p>
						<?php endif; ?>
					</div>

					<!-- contact -->
					<div class="section">
						<h5>Contact</h5>
						<?php if (!empty($post['phone'])) :  ?>
							<span class="mr-1">
								<label>Phone</label>
								<?php echo htmlspecialchars($post['phone']) ?>
							</span>
						<?php endif;  ?>
            		<?php if (!empty($post['email'])) :  ?>
							<span>
								<label>Email</label>
								<?php echo htmlspecialchars($post['email']) ?>
							</span>
            <?php endif;  ?>
					</div>
        </div>

					<!-- post footer -->
					<div class="card-action ">
            <div class="center" > <?php echo htmlspecialchars($post['created_at']) ?></div>
					</div>

					<?php else : ?>
						<h2>404</h2>
						<p>Sorry that post doesn't exist</p>
					<?php endif; ?>
			</div>

<?php include($_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php') ?>
