<?php include($_SERVER['DOCUMENT_ROOT'] . '/templates/header.php')?>
<?php
include($_SERVER['DOCUMENT_ROOT'] . '/config/db_connect.php');

if (isset($_POST['signin-submit'])) {
    $email = $_POST["email"];
    $password = $_POST["password"];

    if (empty($email) || empty($password)) {
        echo("<script>location.href = '/signin.php?err=Empty fields';</script>");
        exit();
    } else {
        $sql = "SELECT * FROM users WHERE email=?";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            echo("<script>location.href = '/index.php?err=sqlerror';</script>");
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, 's', $email);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $userId, $userEmail, $userPassword, $col4);
            if (mysqli_stmt_fetch($stmt)) {
                $passwordCheck = password_verify($password, $userPassword);
                if ($passwordCheck == false) {
                    echo("<script>location.href = '/signin.php?err=Incorrect password';</script>");
                    echo $password . " " .$userPassword;
                    exit();
                } elseif ($passwordCheck == true) {
                    $_SESSION['userId'] = $userId;
                    echo("<script>location.href = '/index.php?signin=success';</script>");
                }
            } else {
                echo("<script>location.href = '/signin.php?err=User does not exist';</script>");
            }
        }
    }
}//end POST check
?>
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

<?php include($_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php') ?>
