<?php
include($_SERVER['DOCUMENT_ROOT'] . "/config/db_connect.php");

// default base query substring
$sql = "SELECT * FROM posts ";

$result = mysqli_query($conn, $sql);
$posts = array();

while ($row = mysqli_fetch_assoc($result)) {
    $posts[] = $row;
}

$orderedOptions = array("new", "old" , "lowest", "highest");
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
    if (!in_array($city, $locationOptions)) {
        array_push($locationOptions, $city);
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
    if (!empty($_GET['s'])) {
        $salary = mysqli_real_escape_string($conn, $_GET['s']);
        $sql .= "WHERE (average_yearly_from_salary + average_yearly_from_hourly) > '$salary' ";
    }
}

if (isset($_GET['l']) && isset($_GET['s'])) {
    if (!empty($_GET['l'])) {
        $location = mysqli_real_escape_string($conn, $_GET['l']);
        $sql .= "AND BINARY city = '$location' ";
    }
} elseif (isset($_GET['l']) && !isset($_GET['s'])) {
    $sql .= "AND BINARY city = '$location' ";
}

if (isset($_GET['jt']) && isset($_GET['s']) || isset($_GET['l'])) {
    if (!empty($_GET['jt'])) {
        $type = mysqli_real_escape_string($conn, $_GET['jt']);
        $sql .= "AND type = '$type' ";
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
        $sql .= "ORDER BY (average_yearly_from_salary + average_yearly_from_hourly)";
        break;
      case 'highest':
        $sql .= "ORDER BY (average_yearly_from_salary + average_yearly_from_hourly) DESC";
        break;
      default:
        $sql .= "ORDER BY created_at DESC";
        break;
    }
} else {
    $sql .= "ORDER BY created_at DESC";
}


$result = mysqli_query($conn, $sql);
$posts = array();

while ($row = mysqli_fetch_assoc($result)) {
    $posts[] = $row;
}


sort($salaryOptions);
mysqli_free_result($result);
mysqli_close($conn);
