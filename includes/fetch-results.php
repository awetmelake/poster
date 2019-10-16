<?php
include("./config/db_connect.php");

// default query
$sql = "SELECT * FROM posts ORDER BY created_at DESC";

$result = mysqli_query($conn, $sql);
$posts = mysqli_fetch_all($result, MYSQLI_ASSOC);

$orderedOptions = array("new", "old" , "lowestpaying", "highestpaying");
$typeOptions = array("full-time", "contract" , "part-time");
$locationOptions = array();
$salaryOptions = array();
foreach ($posts as $post) {
    $city = $post['city'];
    $state = $post['state'];
    if ($post['hourly_max'] == 0) {
        $salary = ($post['salary_max'] + $post['salary_min']) / 2 ;
    } else {
        $salary = ($post['hourly_min'] + $post['hourly_max']) * 1000;
    }
    if ($post['hourly_max'] !== 0) {
        $salary = ($post['hourly_min'] + $post['hourly_max']) * 1040; // calculate yearly from hourly min and max
    } elseif ($post['salary_max'] != 0) {
        $salary =	 ($post['salary_max'] + $post['salary_min']) / 2;
    } else {
        $salary = null;
    }
    if (array_search($city, $locationOptions) !== 0) {
        array_push($locationOptions, $city);
    }
    if (array_search($salary, $salaryOptions) && $salary !== 0) {
        array_push($salaryOptions, $salary);
        if (isset($_GET['salary'])) {
            $salaryOptions = array($_GET['salary']);
        }
    }
}

if (isset($_GET['ordered'])) {
    switch ($_GET['ordered']) {
      case 'new':
      $sql = "SELECT * FROM posts ORDER BY created_at DESC";
        break;
      case 'old':
      $sql = "SELECT * FROM posts ORDER BY created_at";
        break;
      case 'lowestpaying':
        $sql = "SELECT * FROM posts ORDER BY (hourly_max + hourly_min) * 1000 DESC ";
        break;
      case 'highestpaying':
      $sql = "SELECT * FROM posts ORDER BY created_at DESC";
        break;
      default:
        header("Location: index.php");
        break;
    }
}

// filters from query params
if (isset($_GET['salary'])) {
    if ($_GET['salary'] != "") {
        $salary = mysqli_real_escape_string($conn, $_GET['salary']);
        $sql = "SELECT * FROM posts WHERE (salary_min + salary_max) / 2 >=  '$salary' OR (hourly_max + hourly_min) * 1000 > '$salary'";
    }
}

if (isset($_GET['location'])) {
    if ($_GET['location'] != "") {
        $location = mysqli_real_escape_string($conn, $_GET['location']);
        $sql = "SELECT * FROM posts WHERE BINARY city = '$location'";
    }
}

if (isset($_GET['type'])) {
    if ($_GET['location'] != "") {
        $type = mysqli_real_escape_string($conn, $_GET['location']);
        $sql = "SELECT * FROM posts WHERE city = '$location' or state = '$location'";
    }
}


$result = mysqli_query($conn, $sql);
$posts = mysqli_fetch_all($result, MYSQLI_ASSOC);


sort($salaryOptions);
mysqli_free_result($result);
mysqli_close($conn);
