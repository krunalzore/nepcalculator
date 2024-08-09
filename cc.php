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

$program = $_POST['program'] ?? null;
$semester = $_POST['semester'] ?? null;

// Strip the "Sem" prefix to get the numeric value
if ($semester) {
    $semester = ltrim($semester, 'Sem');
}

if ($program && $semester) {
    // Fetch distinct vertical numbers based on the selected program and semester
    $subjquery = mysqli_query($conn, "SELECT DISTINCT VERTICAL_NO FROM complete_syllabus WHERE PROG_NAME='$program' AND SEM='$semester' ORDER BY VERTICAL_NO");

    if (!$subjquery) {
        echo "<p>Query Error: " . mysqli_error($conn) . "</p>";
    } else {
        $numRows = mysqli_num_rows($subjquery);

        if ($numRows > 0) {
            while ($resedu = mysqli_fetch_assoc($subjquery)) {
                $verticalno = $resedu['VERTICAL_NO'];

                echo '<div class="bg-white p-6 rounded-lg shadow-md flex flex-col items-start">';
                echo '<h2 class="text-lg font-semibold mb-4">VERTICAL ' . $verticalno . '</h2>';

                if ($verticalno == 4 || $verticalno == 5) {
                    // Show different majors for vertical 4 and 5
                    $majorsQuery = mysqli_query($conn, "SELECT DISTINCT MAJOR_NAME FROM complete_syllabus WHERE VERTICAL_NO='$verticalno' AND PROG_NAME='$program' AND SEM='$semester' ORDER BY MAJOR_NAME");

                    if ($majorsQuery && mysqli_num_rows($majorsQuery) > 0) {
                        while ($majorRow = mysqli_fetch_assoc($majorsQuery)) {
                            $majorName = $majorRow['MAJOR_NAME'];
                            echo '<div class="mb-4 w-full">';
                            echo '<label for="vertical' . $verticalno . 'major' . $majorName . '" class="block font-medium text-gray-700">Select ' . $majorName . ':</label>';
                            echo '<select class="select2 w-full mt-2" id="vertical' . $verticalno . 'major' . $majorName . '" name="vertical' . $verticalno . 'major' . $majorName . '[]" onchange="getVenue(' . $verticalno . ', \'' . $program . '\', ' . $semester . ')" required multiple>';
                            echo '<option disabled selected value>Select Subjects</option>';

                            $coursesQuery = mysqli_query($conn, "SELECT COURSE_NAME FROM complete_syllabus WHERE VERTICAL_NO='$verticalno' AND MAJOR_NAME='$majorName' AND PROG_NAME='$program' AND SEM='$semester' ORDER BY COURSE_NAME");
                            while ($courseRow = mysqli_fetch_assoc($coursesQuery)) {
                                echo '<option value="' . $courseRow['COURSE_NAME'] . '">' . $courseRow['COURSE_NAME'] . '</option>';
                            }
                            echo '</select>';
                            echo '</div>';
                        }
                    }
                } else {
                    // Show all course names for other verticals
                    echo '<div class="mb-4 w-full">';
                    echo '<label for="vertical' . $verticalno . '" class="block font-medium text-gray-700">Select Courses:</label>';
                    echo '<select class="select2 w-full mt-2" id="vertical' . $verticalno . '" name="vertical' . $verticalno . '[]" onchange="getVenue(' . $verticalno . ', \'' . $program . '\', ' . $semester . ')" required multiple>';
                    echo '<option disabled selected value>Select Subjects</option>';

                    $coursesQuery = mysqli_query($conn, "SELECT COURSE_NAME FROM complete_syllabus WHERE VERTICAL_NO='$verticalno' AND PROG_NAME='$program' AND SEM='$semester' ORDER BY COURSE_NAME");
                    while ($courseRow = mysqli_fetch_assoc($coursesQuery)) {
                        echo '<option value="' . $courseRow['COURSE_NAME'] . '">' . $courseRow['COURSE_NAME'] . '</option>';
                    }
                    echo '</select>';
                    echo '</div>';
                }

                // Display a single table for all selected subjects and credits within this vertical
                echo '<div class="w-full">';
                echo '<table id="credittotal' . $verticalno . '" class="min-w-full border-collapse border border-gray-400 mt-4">';
                echo '<thead class="bg-gray-200">';
                echo '<tr>';
                echo '<th scope="col" class="px-6 py-3 text-left text-m font-medium text-white bg-green-400 uppercase tracking-wider">Subjects</th>';
                echo '<th scope="col" class="px-6 py-3 text-left text-m font-medium text-white bg-green-400 uppercase tracking-wider">Credits</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody class="bg-white divide-y divide-gray-400">';
                echo '</tbody>';
                echo '</table>';
                echo '</div>';

                echo '</div>'; // End of vertical card
            }
        }
    }
}
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
            <a class="text-white text-xl font-bold" href="#"><img class="w-52" src="http://www.mumresults.in/images/University-logo321.png" alt=""></a>
            <div class="space-x-4">
                <a class="text-white" href="#">Home</a>
            </div>
        </div>
    </nav>
    <div class="container mx-auto p-6" id="instr">
        <form method="POST" target="_blank" action="allreport.php">
            <h1 class="text-3xl font-bold mb-6">NEP Examination</h1>
            <div class="grid grid-cols-1 gap-6">
                <!-- The dynamic content for verticals and majors will be injected here -->
                <?php
                // The PHP logic above will inject the content here
                ?>
            </div>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="assets/js/select2.js"></script>
    <script>
    const colors = ["bg-red-200", "bg-green-200", "bg-blue-200", "bg-yellow-200", "bg-purple-200", "bg-pink-200", "bg-indigo-200"];
    const maxCredits = 6; // Example total credit limit for the vertical

    function getVenue(vertno, program, semester) {
        var selectedOptions = [];
        var selectedMajors = $(`#vertical${vertno} select.select2`);
        
        // Collect all selected subjects from all majors within this vertical
        selectedMajors.each(function() {
            selectedOptions = selectedOptions.concat(Array.from(this.selectedOptions).map(option => option.value));
        });

        var selectedString = selectedOptions.join(',');

        // Assign colors to selected options
        selectedMajors.each(function(index, element) {
            var majorSelect = $(element);
            majorSelect.find('option:selected').each(function(optionIndex, option) {
                var colorClass = colors[(index + optionIndex) % colors.length];
                $(option).attr('class', colorClass);
            });
        });

        $.ajax({
            url: "getCredit.php",
            type: "post",
            dataType: "json",
            data: { subname: selectedString, program: program, semester: semester, vertical: vertno },
            success: function(response) {
                var totalCredits = 0;
                var tableContent = response.map(item => {
                    if (item.course !== "Total Credits") {
                        totalCredits += parseInt(item.credits, 10);
                        return `<tr><td class="px-6 py-4 whitespace-nowrap ">${item.course}</td><td class="px-6 py-4 whitespace-nowrap">${item.credits}</td></tr>`;
                    } else {
                        return `<tr class="font-bold"><td class="bg-gray-200 px-6 py-4 whitespace-nowrap">${item.course}</td><td class="bg-gray-200 px-6 py-4 whitespace-nowrap">${item.credits}</td></tr>`;
                    }
                }).join('');

if (totalCredits > maxCredits) {
    alert('Credit limit exceeded for VERTICAL ' + vertno + '. Maximum allowed credits: ' + maxCredits);
    // Remove the last selected options to stay within limit
    selectedOptions.pop();
    $(`#vertical${vertno} select.select2`).val(selectedOptions).trigger('change');
    return;
}

$('#credittotal' + vertno + ' tbody').html(tableContent);
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
var colorClass = $(data.element).attr('class');
if (colorClass) {
    $(container).addClass(colorClass);
}
return data.text;
}
});

// Trigger getVenue when selections change
$('select.select2').change(function() {
var vertno = $(this).closest('.bg-white').find('h2').text().replace('VERTICAL ', '');
var program = $('input[name="program"]').val(); // Assuming program is passed as a hidden input or similar
var semester = $('input[name="semester"]').val(); // Assuming semester is passed as a hidden input or similar

getVenue(vertno, program, semester);
});
});
</script>

</body>
</html>

<?php
$conn->close();
?>
