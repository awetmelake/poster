<?php
include('./config/db_connect.php');

if (isset($_POST['signin-submit'])) {
    $email = $_POST["email"];
    $password = $_POST["password"];

    if (empty($email) || empty($password)) {
        header("Location: signin.php?err=Empty fields");
        exit();
    } else {
        $sql = "SELECT * FROM users WHERE email=?";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: signin.php?err=sqlerror");
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, 's', $email);
            mysqli_stmt_execute($stmt);
            $result =  mysqli_stmt_get_result($stmt);
            if ($row = mysqli_fetch_assoc($result)) {
                $passwordCheck = password_verify($password, $row['password']);
                if ($passwordCheck == false) {
                    header("Location: signin.php?err=Incorrect password");
                    exit();
                } elseif ($passwordCheck == true) {
                    session_start();
                    $_SESSION['userId'] = $row["id"];
                    header("Location: index.php?signin=successful");
                }
            } else {
                header("Location: signin.php?err=User does not exist");
            }
        }
    }
}//end POST check
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<?php include('./templates/header.php')?>
<div class="row sign-in-page">
	<div class="col s12">
		<form class=" white signin-form" method="POST" action="signin.php">
			<div class="form-header center">
				<h4>Sign in</h4>
			</div>

			<!-- email -->
			<div class="input-field">
				<input type="email" name="email" autofocus>
				<label for="email">Email</label>
			</div>

			<!-- password -->
			<div class="input-field">
				<input type="password" name="password">
				<label for="password">Password</label>
			</div>

			<!-- error display -->
			<div class="red-text center">
				<?php echo empty($_GET['err']) ? null : $_GET['err']  ?>
			</div><br>
			<!-- submit -->
			<div class="center">
				<input class="btn brand z-depth-0" type="submit" value="sign in" name="signin-submit">
			</div>

		</form>
		<br>
		<div class="signin-form signin-options  white center p-1">
			<h6>Dont have an account? </h6>
			<br>
			<a class="btn brand z-depth-0" >Sign in a guest</a>
			<a href="register.php" class="btn brand z-depth-0" name="guest" value="Sign in a guest">Register</a>
		</div>
	</div>
</div>



<?php include('./templates/footer.php') ?>

</html>
