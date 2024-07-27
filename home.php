<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'connect.php';
$conn = new mysqli($hostname, $username, $password, $database);
if ($conn->connect_error) {
    echo $conn->connect_error;
    trigger_error('Database connection failed: ' . $conn->connect_error, E_USER_ERROR);
}
mysqli_set_charset($conn, "utf8");
?>
<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Select Program and Semester</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/select2.min.css">
</head>
<body class="bg-gray-100">
    <nav class="bg-gray-800 p-4">
        <div class="container mx-auto flex justify-between items-center">
            <a class="text-white text-xl font-bold" href="#"><img class="w-52" src="http://www.mumresults.in/images/University-logo321.png" alt="University Logo"></a>
            <div class="space-x-4">
                <a class="text-white" href="#">Home</a>
            </div>
        </div>
    </nav>
    <div class="container mx-auto p-6">
        <form method="POST" target="_blank" action="allreport.php">
            <h1 class="text-3xl font-bold mb-6">Select Program and Semester</h1>
            <div class="grid grid-cols-2 gap-6">
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <label for="program" class="block font-medium text-gray-700">Select Program:</label>
                    <select class="select2 w-full mt-2" id="program" name="program" required>
                        <option disabled selected value>Select Program</option>
                        <option value="B.Com.">B.Com.</option>
                        <option value="B.Sc.">B.Sc.</option>
                        <!-- Add more programs as needed -->
                    </select>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <label for="semester" class="block font-medium text-gray-700">Select Semester:</label>
                    <select class="select2 w-full mt-2" id="semester" name="semester" required>
                        <option disabled selected value>Select Semester</option>
                        <option value="Sem1">Semester 1</option>
                        
                        <!-- Add more semesters as needed -->
                    </select>
                </div>
            </div>
            <div class="text-center mt-8">
                <p class="text-lg font-semibold">Based on that verticals will be displayed</p>
            </div>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="assets/js/select2.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                width: '100%'
            });
        });
    </script>
</body>
</html>
