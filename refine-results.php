<?php
include("./includes/fetch-results.php");
?>

<div class="refine-results p-1 left">
	<form class="refine-results-form" method="GET" action="index.php">
		<h5>Options</h5>
		<div class="divider"></div><br>

		<label>Location</label>
		<select name="location" >
      <option value=""  selected>Select location</option>
			<?php foreach ($locationOptions as $location): ?>
				<option <?php echo isset($_GET['location']) && $_GET['location'] == $location ? "selected" : null ?>><?php echo htmlspecialchars($location) ?></option><br>
			<?php endforeach; ?>
		</select><br>

		<label>Job Type</label>

    <?php if (isset($_GET['type']) && $_GET['type'] != '') : ?>
      <div class="">
        <?php echo htmlspecialchars($_GET['type']); ?>
      </div>
    <?php else: ?>
      <div name="type" >
        <?php foreach ($typeOptions as $type): ?>
          <p>
            <label>
              <input name="type" type="radio" value="<?php echo htmlspecialchars($type) ?>" />
              <span><?php echo htmlspecialchars($type) ?></span>
            </label>
          </p>
        <?php endforeach; ?>
      </div><br>
    <?php endif; ?>

		<label>Salary estimate</label>
		<select name="salary_min" >
      <option value=""  selected>Select min salary</option>
			<?php foreach ($salaryOptions as $salary) :?>
					<option <?php echo isset($_GET['salary_min']) && $_GET['salary_min'] == $salary ? "selected" : null ?> value="<?php echo htmlspecialchars($salary) ?>"><?php echo htmlspecialchars($salary) ?></option><br>
			<?php endforeach ?>
		</select><br>

		<label >Sort by</label>
		<div class="input-field">
			<select  name="ordered">
				<?php foreach ($orderedOptions as $option): ?>
							<option <?php echo isset($_GET['ordered']) && $_GET['ordered'] == $option ? "selected" : null ?>   value="<?php echo $option ?>"><?php echo $option ?></option>
					<?php endforeach; ?>
				</select>
			</div>
		<div class="refine-results-btns ">
			<button class="btn-small green z-depth-0" type="submit">Apply</button>
			<button class="btn-small red z-depth-0" type="button" onclick="resetRefineResults()">Reset</button>
		</div>
	</form>
</div>
