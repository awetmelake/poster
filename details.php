<?php include($_SERVER['DOCUMENT_ROOT'] . '/templates/header.php') ?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/fetch-details.inc.php')?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/fetch-favorites.php')?>

<div class="row post-details">
	<div class="col s12 card z-depth-0">
		<?php if ($post): ?>
			<!-- post header -->
			<div class="card-content z-depth-0 pl-4 ">
					<h4 ><?php echo htmlspecialchars($post['title']) ?></h4>
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
					<h5>Pay</h5>
					<?php if ($post['hourly_min'] > 0): ?>
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
					<div class=" card-action ">
						<div class="center white text right ">
              <?php if (isset($_SESSION['userId']) && $_SESSION['userId'] == $post['created_by']): ?>
                <form method="POST" action="edit-post.php?id=<?php echo $_GET['id'] ?>" class="form-button edit-post">
                  <input type="submit" class="btn brand z-depth-0"  name="edit-post-submit" value="edit"/>
                </form>
              <?php elseif (!empty($favorites) && in_array($post['id'], $favorites)) : ?>
                <form method="POST" action="./includes/remove-favorites.inc.php?id=<?php echo $_GET['id'] ?>" class="form-button edit-post">
                  <input type="submit" class="btn red darken-2 z-depth-0"  name="remove-favorites-submit" value="Remove from favorites"/>
                </form>
              <?php else: ?>
                <form method="POST" action="./includes/add-favorites.inc.php?id=<?php echo $_GET['id']?>" class="form-button add-favorites">
                  <input type="submit" class="btn brand z-depth-0" value="Save" name="favorites-submit"/>
                </form>
              <?php endif; ?>
						</div>
            <div class="clearfix"></div>
            <div class="center" > <?php echo htmlspecialchars($post['created_at']) ?></div>
					</div>

					<?php else : ?>
						<h2>404</h2>
						<p>Sorry that post doesn't exist</p>
					<?php endif; ?>
			</div>

<?php include($_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php') ?>
