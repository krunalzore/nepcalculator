<?php
include 'connect.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);
$data = [];
$totalcredits = 0;

$op = $_POST['subname'];
$selectedCourses = explode(',', $op);

foreach ($selectedCourses as $course) {
    $sql = mysqli_query($conn, "SELECT COURSE_NAME, CREDIT FROM subjectmaster WHERE COURSE_NAME='$course'");         
    while ($resf = mysqli_fetch_assoc($sql)) {
        $credits = $resf['CREDIT'];                    
        $data[] = [
            "course" => $course,
            "credits" => $credits
        ];
        $totalcredits += $credits;
    }                 
}
$data[] = [
    "course" => "Total Credits",
    "credits" => $totalcredits
];

echo json_encode($data);
?>
