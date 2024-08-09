<?php
include 'connect.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

$data = [];
$totalcredits = 0;

$op = $_POST['subname'];
$selectedCourses = explode(',', $op);

// Initialize an array to hold debug messages
$debugMessages = [];

foreach ($selectedCourses as $course) {
    $course = trim($course); // Trim to avoid any leading/trailing spaces
    $sql = mysqli_query($conn, "SELECT COURSE_NAME, CREDIT FROM complete_syllabus WHERE COURSE_NAME='$course'");

    // Check if the query returns any results
    if (!$sql) {
        $debugMessages[] = "Query Error for $course: " . mysqli_error($conn);
    } else if (mysqli_num_rows($sql) === 0) {
        $debugMessages[] = "No results found for course: $course";
    }

    while ($resf = mysqli_fetch_assoc($sql)) {
        $credits = $resf['CREDIT'];
        $data[] = [
            "course" => $course,
            "credits" => $credits
        ];
        $totalcredits += $credits;
    }
}

// Adding total credits to the response
$data[] = [
    "course" => "Total Credits",
    "credits" => $totalcredits
];


// Encode the final response as JSON
echo json_encode($data);
?>
