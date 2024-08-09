<?php
include 'connect.php';
$conn = new mysqli($hostname, $username, $password, $database);
if ($conn->connect_error) {
    echo $conn->connect_error;
    trigger_error('Database connection failed: ' . $conn->connect_error, E_USER_ERROR);
}
mysqli_set_charset($conn, "utf8");

if (isset($_POST['program'])) {
    $program = $conn->real_escape_string($_POST['program']);
    $query = "SELECT DISTINCT SEM FROM complete_syllabus WHERE PROG_NAME = '$program' ORDER BY SEM";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        echo '<option disabled selected value>Select Semester</option>';
        while($row = $result->fetch_assoc()) {
            echo '<option value="Sem' . $row['SEM'] . '">Semester ' . $row['SEM'] . '</option>';
        }
    } else {
        echo '<option disabled selected value>No Semesters Available</option>';
    }
}

$conn->close();
?>
