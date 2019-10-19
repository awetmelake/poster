<?php
include($_SERVER['DOCUMENT_ROOT'] . "/config/db_connect.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/includes/fetch-assoc.php");

// default base query substring
$sql = "SELECT * FROM posts ";

$stmt = mysqli_stmt_init($conn);
if (!mysqli_stmt_prepare($stmt, $sql)) {
    echo("<script>location.href = '/index.php?err=sqlerror';</script>");
    exit();
} else {
    $posts = array();
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    while ($row = fetchAssocStatement($stmt)) {
        array_push($posts, $row);
    }
}

// populate select options from current db data
$orderedOptions = array("new", "old" , "lowest pay", "highest pay");
$typeOptions = array("full-time", "contract" , "part-time");
$locationOptions = array();
$salaryOptions = array();
foreach ($posts as $post) {
    $city = $post['city'];
    $state = $post['state'];
    $state = $post['state'];
    if ($post['hourly_max'] !== 0 || $post['salary_max'] !== 0) {
        $salary =  (($post['salary_max'] + $post['salary_min']) / 2) + (($post['hourly_max'] + $post['hourly_min']) * 1040);
    } else {
        $salary = null;
    }
    if (!in_array($city, $locationOptions)) {
        array_push($locationOptions, $city . ", " . $state);
    }
    if (!in_array($salary, $salaryOptions) && $salary !== 0) {
        array_push($salaryOptions, $salary);
        if (isset($_GET['s'])) {
            $salaryOptions = array($_GET['s']);
        }
    }
}

// filters from query params
if (isset($_GET['s'])) {
    $salary = mysqli_real_escape_string($conn, $_GET['s']);
    if (!empty($_GET['s'])) {
        $sql .= "WHERE (((salary_max + salary_min) / 2) + ((hourly_max + hourly_min) * 1040)) > '$salary' ";
    }
}

if (isset($_GET['l'])) {
    $location = mysqli_real_escape_string($conn, $_GET['l']);
    if (!empty($location) && !empty($salary)) {
        $sql .= "AND BINARY city = '$location' ";
    } elseif (!empty($location) && empty($salary)) {
        $sql .= "WHERE BINARY city = '$location' ";
    }
}

if (isset($_GET['jt'])) {
    $type = mysqli_real_escape_string($conn, $_GET['jt']);
    if (!empty($type) && !empty($salary) || !empty($location)) {
        $sql .= "AND type = '$type' ";
    } elseif (!empty($type) && empty($salary) && empty($location)) {
        $sql .= "WHERE type = '$type' ";
    }
}

// lastly order
if (isset($_GET['o'])) {
    switch ($_GET['o']) {
      case 'new':
      $sql .= "ORDER BY created_at DESC";
        break;
      case 'old':
      $sql .= "ORDER BY created_at";
        break;
      case 'lowest':
        $sql .= "ORDER BY (((salary_max + salary_min) / 2) + ((hourly_max + hourly_min) * 1040))";
        break;
      case 'highest':
        $sql .= "ORDER BY (((salary_max + salary_min) / 2) + ((hourly_max + hourly_min) * 1040)) DESC";
        break;
      default:
        $sql .= "ORDER BY created_at DESC";
        break;
    }
} else {
    $sql .= "ORDER BY created_at DESC";
}

$stmt = mysqli_stmt_init($conn);
if (!mysqli_stmt_prepare($stmt, $sql)) {
    echo("<script>location.href = '/index.php?err=sqlerror';</script>");
    exit();
} else {
    $posts = array();
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    while ($row = fetchAssocStatement($stmt)) {
        array_push($posts, $row);
    }
}
sort($salaryOptions);
mysqli_stmt_close($stmt);
mysqli_close($conn);
