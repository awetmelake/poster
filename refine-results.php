<?php
include($_SERVER['DOCUMENT_ROOT'] . "/includes/fetch-results.inc.php");
?>

<div class="refine-results p-1 left">
	<form class="refine-results-form" method="GET" action="index.php">
		<h5>Options</h5>
		<div class="divider"></div><br>

		<label>Location</label>
		<select name="l" >
      <option value=""  selected>Select location</option>
			<?php foreach ($locationOptions as $location): ?>
				<option value="<?php echo explode(',', $location)[0] ?>" <?php echo isset($_GET['l']) && $_GET['l'] == $location ? "selected" : null ?>><?php echo htmlspecialchars($location) ?></option><br>
			<?php endforeach; ?>
		</select><br>

		<label>Job Type</label>

    <?php if (isset($_GET['jt']) && $_GET['jt'] != '') : ?>
      <div >
        <?php echo htmlspecialchars($_GET['jt']); ?>
      </div>
    <?php else: ?>
      <div>
        <?php foreach ($typeOptions as $type): ?>
          <p>
            <label>
              <input name="jt" type="radio" value="<?php echo htmlspecialchars($type) ?>" />
              <span><?php echo htmlspecialchars($type) ?></span>
            </label>
          </p>
        <?php endforeach; ?>
      </div><br>
    <?php endif; ?>

		<label>Salary estimate</label>
		<select name="s" >
      <option value=""  selected>Select min salary</option>
			<?php foreach ($salaryOptions as $salary) :?>
					<option <?php echo isset($_GET['s']) && $_GET['s'] == $salary ? "selected" : null ?> value="<?php echo htmlspecialchars($salary) ?>"><?php echo htmlspecialchars($salary) ?></option><br>
			<?php endforeach ?>
		</select><br>

		<label >Sort by</label>
		<div class="input-field">
			<select  name="o">
				<?php foreach ($orderedOptions as $option): ?>
							<option <?php echo isset($_GET['o']) && $_GET['o'] == $option ? "selected" : null ?>   value="<?php echo $option ?>"><?php echo $option ?></option>
					<?php endforeach; ?>
				</select>
			</div>
		<div class="refine-results-btns ">
			<button class="btn green darken-2 z-depth-0" type="submit">Apply</button>
			<button class="btn red darken-2 z-depth-0" type="button" onclick="resetRefineResults()">Reset</button>
		</div>
	</form>
</div>
