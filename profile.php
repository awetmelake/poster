<!DOCTYPE html>
<html lang="en" dir="ltr">

<?php include('./templates/header.php')?>

<!-- protected route -->
<?php if (!isset($_SESSION["userId"])) {
    header("Location: index.php?err=Must be signed in to access that page");
} ?>


<?php include('./templates/footer.php') ?>

</html>
