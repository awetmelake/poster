<?php include($_SERVER['DOCUMENT_ROOT'] . '/templates/header.php') ?>

<?php
// protect route
if (!isset($_SESSION['userId'])) {
    echo("<script>location.href = '/index.php?err=Must be signed in to access that page';</script>");
}

include($_SERVER['DOCUMENT_ROOT'] . '/config/db_connect.php');

$title = $description = $company = $city = $state = $zipcode = $phone  = $email = $preferred = $requirements = "";
$salary_max = $salary_min = $hourly_max = $hourly_min = 0;

$errors = array(
  "company"=>"",
  "city" => "",
  "state" => "",
  "zipcode" => "",
  "title" => "",
  "salary" => "",
  "hourly" => "",
  "phone" => "",
  "email" => ""
);

if (isset($_POST['post-submit'])) {
    $description = $_POST["description"];
    $type =  $_POST["type"];
    $preferred = $_POST["preferred"];
    $requirements = $_POST["requirements"];
    $createdBy = intval($_SESSION['userId']);

    // check if payment inputs are empty and that max > min
    if ($_POST["salary_min"] > 0 || $_POST["salary_max"] > 1) {
        if ($_POST["salary_min"] > $_POST["salary_max"]) {
            $errors['salary'] = "Salary min must be less than salary max";
        } else {
            $salary_min = $_POST["salary_min"] * 1000;
            $salary_max = $_POST["salary_max"] * 1000;
        }
    } else {
        $salary_min = 0;
        $salary_max = 0;
    }

    if ($_POST["hourly_min"] > 0  || $_POST["hourly_max"] > 1) {
        if ($_POST["hourly_min"] > $_POST["hourly_max"]) {
            $errors['hourly'] = "Hourly min must be less than hourly max";
        } else {
            $hourly_max = $_POST["hourly_max"];
            $hourly_min = $_POST["hourly_min"];
        }
    } else {
        $hourly_max = 0;
        $hourly_min = 0;
    }

    if (empty($_POST['title'])) {
        $errors['title'] = "A title is required <br>";
    } else {
        $title = $_POST["title"];
        if (!preg_match('/^[a-zA-Z\s]+$/', $title)) {
            $errors['title'] = "Title must be letters and spaces only";
        }
    }

    if (empty($_POST['city'])) {
        $errors['city'] = "A city is required <br>";
    } else {
        $city = $_POST["city"];
        if (!preg_match('/^[a-zA-Z\s.,&:;]+$/', $city)) {
            $errors['city'] = "City must be letters and spaces only";
        }
    }

    if (empty($_POST['state'])) {
        $errors['state'] = "A state is required <br>";
    } else {
        $state = $_POST["state"];
        if (!preg_match('/^[a-zA-Z\s]+$/', $state)) {
            $errors['state'] = "State must be letters and spaces only";
        }
    }

    if (empty($_POST['company'])) {
        $errors['company'] = "A company is required <br>";
    } else {
        $company = $_POST["company"];
        if (!preg_match('/^[a-zA-Z\s]+$/', $company)) {
            $errors['company'] = "Company must be letters and spaces only";
        }
    }

    $phone = $_POST["phone"];
    if (!empty($_POST['phone']) && !preg_match('/\d{0,1}-?\d{0,3}-?\d{0,3}-?\d{4}/', $phone)) {
        $errors['phone'] = "Invalid phone number format";
    }

    if (empty($_POST["email"])) {
        $errors['email'] = "An email is required";
    } else {
        $email = $_POST['email'];
        if (!preg_match('/^[a-zA-Z0-9.!#$%&’*+\=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/', $email)) {
            $errors['email'] = "Invalid email format";
        }
    }

    if (empty($_POST['zipcode'])) {
        $errors['zipcode'] = "A zipcode is required <br>";
    } else {
        $zipcode = $_POST["zipcode"];
        if (!preg_match('/\d{5}$/', $zipcode)) {
            $errors['zipcode'] = "Zipcode must be 5 digits";
        }
    }

    if (!array_filter($errors)) {
        $stmt = mysqli_stmt_init($conn);
        $sql = "INSERT INTO posts(title, description, city, company, hourly_min, hourly_max, phone, salary_max, salary_min, state, zipcode, type, preferred, requirements, email, created_by ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            echo("<script>location.href = '/index.php?err=sqlerror';</script>");
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, 'ssssiisiisissssi', $title, $description, $city, $company, $hourly_min, $hourly_max, $phone, $salary_max, $salary_min, $state, $zipcode, $type, $preferred, $requirements, $email, $createdBy);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            echo("<script>location.href = '/index.php?post=success';</script>");
        }
    }
} // end POST check

?>

<section class="grey-text">
  <div class="row center">
    <h4 >Add and job posting</h4>
  </div>

  <div class="row">
    <form class="col s12 offset-3 white" action="add.php" method="POST" autocomplete="on">

      <div class="row">
        <!-- company -->
        <div class="input-field col s12 m4">
          <label>Company (required)</label>
          <input type="text" name="company" value="<?php echo htmlspecialchars($company)?>"  autofocus>
          <div class="red-text"><?php echo $errors['company']?></div>
        </div>

        <!-- title -->
        <div class="input-field col s12 m4">
          <label>Job title (required)</label>
          <input type="text" name="title" value="<?php echo htmlspecialchars($title)?>"  >
          <div class="red-text"><?php echo $errors['title']?></div>
        </div>

        <!-- type -->
        <div class="input-field col s12 m4">
          <span>
            <label>
              <input name="type" type="radio" checked value="Full-time" />
              <span>Full-time</span>
            </label>
          </span><span>
            <label>
              <input name="type" type="radio" value="Part-time" />
              <span>Part-time</span>
            </label>
          </span>
          <span>
            <label>
              <input name="type" type="radio" value="Contract" />
              <span>Contract</span>
            </label>
          </span>
        </div>
      </div>

      <div class="row">
        <!-- city -->
        <div class="input-field col s12 m4">
          <label>City (required)</label>
          <input type="text" name="city" value="<?php echo htmlspecialchars($city)?>" >
          <div class="red-text"><?php echo $errors['city']?></div>
        </div>

        <!-- state -->
        <div class="input-field col s12 m4">
          <label for="state">State (required)</label>
          <input type="text" name="state" value="<?php echo htmlspecialchars($state)?>" >
          <div class="red-text"><?php echo $errors['state']?></div>
        </div>

        <!-- zipcode -->
        <div class="input-field col s12 m4">
          <label>Zipcode (optional)</label>
          <input type="number" name="zipcode" value="<?php echo htmlspecialchars($zipcode)?>"  >
          <div class="red-text"><?php echo $errors['zipcode']?></div>
        </div>
      </div>

      <div class="row">
        <!-- email -->
        <div class="input-field col s12 m6">
          <label for="email">Email (required)</label>
          <input type="email" name="email" value="<?php echo htmlspecialchars($email)?>" >
          <div class="red-text"><?php echo $errors['email']?></div>
        </div>

        <!-- phone -->
        <div class="input-field col s12 m6">
          <label for="phone">Phone (optional)</label>
          <input type="text" name="phone" value="<?php echo htmlspecialchars($phone)?>" >
        </div>
        <div class="red-text"><?php echo $errors['phone']?></div>
      </div>

        <!-- description -->
      <div class="row">
        <div class="input-field col s12">
          <label>Description (optional)</label>
          <textarea class="materialize-textarea" type="text-field" name="description" value="<?php echo htmlspecialchars($description)?>"></textarea>
        </div>
      </div>
      <!-- requirements -->
      <div class="row">
        <div class="input-field col s12">
          <label>Requirements (optional, comma seperated list)</label>
          <textarea class="materialize-textarea" type="text-field" name="requirements" value="<?php echo htmlspecialchars($requirements)?>"></textarea>
        </div>
      </div>

      <!-- preferred -->
      <div class="row">
        <div class="input-field col s12">
          <label>Preferred (optional, comma seperated list)</label>
          <textarea class="materialize-textarea" type="text-field" name="preferred" value="<?php echo htmlspecialchars($preferred)?>"></textarea>
        </div>
      </div>

      <!-- salary-->
      <div class="row">
        <!-- switch -->
        <div class=" input-field col s12 l4 ">
          <p>
            Salary (optional)
          </p>
          <div class="switch">
            <label>
             Off
             <input type="checkbox" id="toggle-salary" value="off">
             <span class="lever"></span>
             On
           </label>
         </div>
       </div>

       <!-- min -->
       <div class="input-field col s12 l4 " id="salary_min"  hidden>
        <p class="range-field">
          <label for="salary_minSlider">Salary Min (thousand), > 0</label>
          <input type="range"  min="0" max="200" name="salary_min" id="salary_minSlider" value=0>
        </p>
      </div>

      <!-- max -->
      <div class="input-field col s12 l4 " id="salary_max"  hidden>
       <p class="range-field">
        <label for="salary_maxSlider">Salary Max (thousand), > 0</label>
        <input type="range"  min="0" max="200" name="salary_max" id="salary_maxSlider" value=0 >
      </p>
      <!-- err -->
      <div class="red-text"><?php echo $errors['salary']?></div>
    </div>
  </div>

  <!-- hourly -->
  <div class="row">
    <!-- switch -->
    <div class=" input-field col s12 l4">
      <p>
        Hourly (optional)
      </p>
      <div class="switch">
        <label>
         Off
         <input type="checkbox" id="toggle-hourly" value="off">
         <span class="lever"></span>
         On
       </label>
     </div>
   </div>

   <!-- min -->
   <div class="input-field col s12 l4 " id="hourly_min" hidden>
    <p class="range-field">
      <label for="hourly_minSlider">Hourly min, > 0</label>
      <input type="range"  min="0" max="100" name="hourly_min" id="hourly_minSlider" value=0 >
    </p>
  </div>

  <!-- max -->
  <div class=" input-field col s12 l4" id="hourly_max" hidden>
   <p class="range-field">
     <label for="hourly_maxSlider">Hourly Max, > 0</label>
     <input type="range"  min="0" max="100" name="hourly_max" id="hourly_maxSlider"  value=0  >
   </p>
 </div>

 <!-- err -->
 <div class="red-text"><?php echo $errors['hourly']?></div>
</div>

<div class="center">
  <input value="post" type="submit" name="post-submit" class="btn brand z-depth-0">
</div>
</form>
</div>
</div>
</section>

<script src="js/post-form-listeners.js" charset="utf-8"></script>
<?php include($_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php') ?>
