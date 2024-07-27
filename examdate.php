<?php
include_once 'db_connect.php';



$op=$_GET['Programcode'];
$examno=$_GET['examno'];

$sql=$mysqli->query("SELECT DISTINCT `DATE` FROM venuedataAllExam WHERE venue_no='$op' AND PROG_NO='$examno' AND DATE!='' and STR_TO_DATE(DATE, '%d/%m/%Y') > STR_TO_DATE('09/07/2024', '%d/%m/%Y')");
echo '<option disabled selected value>Select Exam Date</option>';
while($row=mysqli_fetch_array($sql))
{
	echo ' <option value="'.$row['DATE'].'" >'.$row['DATE'].' </option>';
}
?>
