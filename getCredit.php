<?php
include 'connect.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json'); // Ensure content type is JSON

$data = [];
$totalcredits = 0;

$op = $_POST['subname'] ?? null;
$program = $_POST['program'] ?? null;
$semester = $_POST['semester'] ?? null;

if (!$op || !$program || !$semester) {
    echo json_encode(['error' => 'Missing required parameters']);
    exit;
}

$selectedCourses = explode(',', $op);

foreach ($selectedCourses as $course) {
    $course = trim($course); // Trim to avoid any leading/trailing spaces

    $sql = mysqli_query($conn, "SELECT COURSE_NAME, CREDIT FROM complete_syllabus WHERE COURSE_NAME = '$course' AND PROG_NAME = '$program' AND SEM = '$semester'");

    if (!$sql) {
        $data[] = [
            "course" => "Error for $course",
            "credits" => "N/A"
        ];
    } else if (mysqli_num_rows($sql) === 0) {
        $data[] = [
            "course" => "$course not found in $program, Semester $semester",
            "credits" => "N/A"
        ];
    } else {
        while ($resf = mysqli_fetch_assoc($sql)) {
            $credits = $resf['CREDIT'];
            $data[] = [
                "course" => $resf['COURSE_NAME'],
                "credits" => $credits
            ];
            $totalcredits += $credits;
        }
    }
}

// Adding total credits to the response after processing all courses
$data[] = [
    "course" => "Total Credits",
    "credits" => $totalcredits
];

echo json_encode($data);
?>
