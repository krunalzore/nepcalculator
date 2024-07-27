<?php
include 'connect.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);
$data = [];
$totalcredits = 0;

$op = $_POST['subname'];
$selectedCourses = explode(',', $op);

$data[] = "<tr><th class='px-4 py-2'>Subject Name</th><th class='px-4 py-2'>Credits</th></tr>";
$credits = 0;
foreach ($selectedCourses as $course) {
    $sql = mysqli_query($conn, "SELECT COURSE_NAME, CREDIT FROM subjectmaster WHERE COURSE_NAME='$course'");         
    while ($resf = mysqli_fetch_assoc($sql)) {
        $credits = $resf['CREDIT'];                    
        $data[] = "<tr class='bg-gray-100'>
            <td class='border px-4 py-2'>$course</td>
            <td class='border px-4 py-2 text-center'>$credits</td>
        </tr>";
        
        $totalcredits += $credits;
        
        $vertquery = mysqli_query($conn, "SELECT CREDITS FROM totalverticalcredits WHERE VERTICAL_NAME = 'Vertical1'");
        $subrow = mysqli_fetch_assoc($vertquery);
        $vertcredits = $subrow['CREDITS'];
        
        if ($vertcredits == $totalcredits) {
            break 2;                
        }            
    }                 
}
$data[] = "<tr class='bg-gray-200'>
    <td class='border px-4 py-2 font-bold'>Total Credits</td>
    <td class='border px-4 py-2 text-center font-bold'>$totalcredits</td>
</tr>";  
echo json_encode($data);
?>
