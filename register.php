<?php
include('config/db_connect.php');
$email = $password = $confirmPassword = "";
$errors = array( 'email' => '', 'password' => '', 'confirmPassword' => '' );

if (isset($_POST['register-submit'])) {
    // validate form
    if (empty($_POST['email'])) {
        $errors['email'] = "An email is required";
    } else {
        $email = $_POST['email'];
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Invalid email format";
        }
    }

    if (empty($_POST['password'])) {
        $errors['password'] = "A password is required";
    } else {
        $password = $_POST['password'];
        if (strlen($password) < 6) {
            $errors['password'] = "Password must be atleast 6 characters";
        }
    }

    if ($_POST['confirmPassword'] !== $_POST['password']) {
        $errors['confirmPassword'] = "Passwords do not match";
    }

    // check errors
    if (array_filter($errors)) {
        $errQuery = '';
        foreach ($errors as $error => $errMsg) {
            if (!empty($errMsg)) {
                $errQuery .= "&" . $error . "err=" . $errMsg ;
            }
        }
        echo $errQuery;
        header("Location: register.php?" . $errQuery . "&email=" . $_POST['email']);
    } else {
        // check for existing email in db
        // prepare statement
        $sql = "SELECT id FROM users WHERE email=? ";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: register.php?err=sqlErr");
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            $resultCount = mysqli_stmt_num_rows($stmt);
            if ($resultCount > 0) {
                header("Location: register.php?emailerr=Email already in use");
                exit();
            } else {
                $sql = "INSERT INTO users (email , password) VALUES ( ? , ?)";
                $stmt = mysqli_stmt_init($conn);

                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    header("Location: register.php?err=sqlErr");
                    exit();
                } else {
                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                    mysqli_stmt_bind_param($stmt, "ss", $email, $hashedPassword);
                    mysqli_stmt_execute($stmt);
                    header("Location: index.php");
                }
            }
        }
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
} //end post check
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<?php include('./templates/header.php')?>
<div class="row sign-in-page">
	<div class="col s12">
		<form class=" white signin-form" method="POST" action="register.php">
			<h4 class='center'>Create account</h4>

			<!-- email -->
			<div class="input-field">
				<input type="email" name="email" autofocus value="<?php echo empty($_GET['email']) ? "" : $_GET['email'] ?>">
				<label for="email">Email</label>
			</div>
			<div class="red-text"><?php echo empty($_GET['emailerr']) ? null : $_GET['emailerr'] ?></div>

			<!-- password -->
			<div class="input-field">
				<input type="password" name="password">
				<label for="password">Password</label>
			</div>
			<div class="red-text"><?php echo empty($_GET['passworderr']) ? null : $_GET['passworderr'] ?></div>

			<!-- confirm password -->
			<div class="input-field">
				<input type="password" name="confirmPassword">
				<label for="confirmPassword">Re-enter password</label>
			</div>
			<div class="red-text"><?php echo empty($_GET['confirmPassworderr']) ? null : $_GET['confirmPassworderr'] ?></div>

			<!-- submit -->
			<br>
			<div class="center">
				<input type="submit" name="register-submit" class="btn brand z-depth-0">
			</div>
		</form>
		<br>
		<div class="signin-form signin-options white center">
			<h6>Already have an account?</h6>
			<br>
			<a class="btn brand z-depth-0" href="signin.php">Sign in</a>
		</div>
	</div>
</div>

<?php include('./templates/footer.php') ?>

</html>