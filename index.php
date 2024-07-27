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
    <title>Venue Wise List</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/select2.min.css">
</head>
<body class="bg-gray-100">
    <nav class="bg-gray-800 p-4">
        <div class="container mx-auto flex justify-between items-center">
            <a class="text-white text-xl font-bold" href="#"><img class="w-52" src="http://www.mumresults.in/images/University-logo321.png" alt=""></img></a>
            <div class="space-x-4">
                <a class="text-white" href="#">Home</a>
            </div>
        </div>
    </nav>
    <div class="container mx-auto p-6" id="instr">
        <form method="POST" target="_blank" action="allreport.php">
            <h1 class="text-3xl font-bold mb-6">NEP Examination</h1>
            <div class="grid grid-cols-1 gap-6">
                <?php
                $subjquery = mysqli_query($conn, 'SELECT DISTINCT(VERTICAL_NO) FROM subjectmaster WHERE PROG_NAME="B.Com." order by VERTICAL_NO');
                while($resedu = mysqli_fetch_assoc($subjquery)) {
                    $verticalno = $resedu['VERTICAL_NO'];
                    echo '<div class="bg-white p-6 rounded-lg shadow-md flex items-start">
                            <div class="w-1/2 mr-4">
                                <label for="vertical1" class="block font-medium text-gray-700">Select VERTICAL '.$verticalno.':</label>
                                <select class="select2 w-full mt-2" id="vertical'.$verticalno.'" name="vertical'.$verticalno.'[]" onchange="getVenue('.$verticalno.')" required multiple>
                                    <option disabled selected value>Select Subjects</option>';
                                    $sql = mysqli_query($conn, "SELECT DISTINCT COURSE_NAME FROM subjectmaster WHERE VERTICAL_NO='$verticalno'");
                                    while ($row = mysqli_fetch_assoc($sql)) {
                                        echo '<option value="' . $row['COURSE_NAME'] . '">' . $row['COURSE_NAME'] . '</option>';
                                    }
                    echo '      </select>
                            </div>
                            <div class="w-1/2">
                                <table id="credittotal'.$verticalno.'" name="credittotal'.$verticalno.'" class="min-w-full bg-white border border-gray-300 rounded-md">
                                </table>
                            </div>
                          </div>';
                }
                ?>
            </div>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="assets/js/select2.js"></script>
    <script>
        const colors = ["bg-red-200", "bg-green-200", "bg-blue-200", "bg-yellow-200", "bg-purple-200", "bg-pink-200", "bg-indigo-200"];

        function getVenue(vertno) {
            var selectElement = document.getElementById("vertical" + vertno);
            var selectedOptions = Array.from(selectElement.selectedOptions).map(option => option.value);
            var selectedString = selectedOptions.join(',');

            // Assign colors to selected options
            selectedOptions.forEach((option, index) => {
                var colorClass = colors[index % colors.length];
                $(`#vertical${vertno} option[value='${option}']`).attr('class', colorClass);
            });

            $.ajax({
                url: "getCredit.php",
                type: "post",
                dataType: "json",
                data: { subname: selectedString },
                success: function(response) {
                    var tableContent = response.join('');
                    $('#credittotal' + vertno).html(tableContent);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            });
        }

        $(document).ready(function() {
            $('.select2').select2({
                width: '100%',
                templateSelection: function (data, container) {
                    // Add classes to <option> tag within <select>
                    var colorClass = $(data.element).attr('class');
                    if (colorClass) {
                        $(container).addClass(colorClass);
                    }
                    return data.text;
                }
            });
        });
    </script>
</body>
</html>
