<?php
// Error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include the database connection file
include 'connect.php';

// Check if the connection was successful
if (isset($conn) && $conn->connect_error) {
    echo $conn->connect_error;
    trigger_error('Database connection failed: ' . $conn->connect_error, E_USER_ERROR);
}
mysqli_set_charset($conn, "utf8");

// Retrieve POST variables if they are set
$program = $_POST['program'] ?? null;
$semester = $_POST['semester'] ?? null;

// Ensure $program and $semester are defined before using them
if ($semester) {
    $semester = ltrim($semester, 'Sem');
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
            <a class="text-white text-xl font-bold" href="/nepcalculator"><img class="w-52" src="http://www.mumresults.in/images/University-logo321.png" alt=""></a>
            <div class="space-x-4">
                <a class="text-white" href="#">Home</a>
            </div>
        </div>
    </nav>
    
    <div class="container mx-auto p-6" id="instr">
        <form method="POST" target="_blank" action="allreport.php">
            <h1 class="text-3xl font-bold mb-6">NEP Examination</h1>
            <!-- Hidden fields to store program and semester -->
            <input type="hidden" name="program" id="program" value="<?php echo $program; ?>">
            <input type="hidden" name="semester" id="semester" value="<?php echo $semester; ?>">

            <div class="grid grid-cols-1 gap-6">
                <?php
                if ($program && $semester) {
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

                                echo '<div class="flex flex-row w-full space-x-6">'; // Start flex row container
                                echo '<div class="flex-1">'; // Left side: Dropdowns

                                if ($verticalno == 4 || $verticalno == 5) {
                                    $majorsQuery = mysqli_query($conn, "SELECT DISTINCT MAJOR_NAME FROM complete_syllabus WHERE VERTICAL_NO='$verticalno' AND PROG_NAME='$program' AND SEM='$semester' ORDER BY MAJOR_NAME");

                                    if ($majorsQuery && mysqli_num_rows($majorsQuery) > 0) {
                                        while ($majorRow = mysqli_fetch_assoc($majorsQuery)) {
                                            $majorName = $majorRow['MAJOR_NAME'];
                                            echo '<div class="mb-4 w-full">';
                                            echo '<label for="vertical' . $verticalno . 'major' . $majorName . '" class="block font-medium text-gray-700">Select ' . $majorName . ':</label>';
                                            echo '<select class="select2 w-full mt-2" id="vertical' . $verticalno . 'major' . $majorName . '" name="vertical' . $verticalno . 'major' . $majorName . '">';
                                            echo '<option disabled selected value>Select Subject</option>';

                                            $coursesQuery = mysqli_query($conn, "SELECT COURSE_NAME FROM complete_syllabus WHERE VERTICAL_NO='$verticalno' AND MAJOR_NAME='$majorName' AND PROG_NAME='$program' AND SEM='$semester' ORDER BY COURSE_NAME");
                                            while ($courseRow = mysqli_fetch_assoc($coursesQuery)) {
                                                echo '<option value="' . $courseRow['COURSE_NAME'] . '">' . $courseRow['COURSE_NAME'] . '</option>';
                                            }
                                            echo '</select>';
                                            echo '</div>';
                                        }
                                    }
                                } else {
                                    echo '<div class="mb-4 w-full">';
                                    echo '<label for="vertical' . $verticalno . '" class="block font-medium text-gray-700">Select Courses:</label>';
                                    echo '<select class="select2 w-full mt-2" id="vertical' . $verticalno . '" name="vertical' . $verticalno . '[]" multiple>';
                                    echo '<option disabled selected value>Select Subjects</option>';

                                    $coursesQuery = mysqli_query($conn, "SELECT COURSE_NAME FROM complete_syllabus WHERE VERTICAL_NO='$verticalno' AND PROG_NAME='$program' AND SEM='$semester' ORDER BY COURSE_NAME");
                                    while ($courseRow = mysqli_fetch_assoc($coursesQuery)) {
                                        echo '<option value="' . $courseRow['COURSE_NAME'] . '">' . $courseRow['COURSE_NAME'] . '</option>';
                                    }
                                    echo '</select>';
                                    echo '</div>';
                                }

                                echo '</div>'; // End left side: Dropdowns

                                echo '<div class="flex-1">'; // Right side: Table
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
                                echo '</div>'; // End right side: Table

                                echo '</div>'; // End flex row container

                                echo '</div>';
                            }
                        }
                    }
                } else {
                    echo "<p>No program or semester specified.</p>";
                }
                ?>
            </div>
            <!-- Button to calculate total credits -->
            <button type="button" id="calculate-total" class="bg-blue-500 text-white px-4 py-2 rounded-md mt-4">Calculate Total Credits</button>
            <!-- Display total credits across all verticals -->
            <div id="total-credits" class="text-right text-xl font-bold mt-6"></div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="assets/js/select2.js"></script>
    <script>
        const maxCreditsDefault = 6;
        const maxCreditsVertical3 = 4;
        let creditsPerVertical = {}; // Store credits per vertical

        function getVenue(vertno, program, semester, selectedOptions) {
            console.log("Received selected options:", selectedOptions);

            if (selectedOptions.length === 0) {
                console.warn("No options selected for VERTICAL " + vertno);
                return; // Exit early if no options are selected
            }

            var selectedString = selectedOptions.join(',');

            $.ajax({
                url: "getCredit.php",
                type: "post",
                dataType: "json",
                data: { subname: selectedString, program: program, semester: semester, vertical: vertno },
                success: function(response) {
                    console.log("Response from getCredit.php:", response); // Debugging output

                    var totalCredits = 0;
                    var tableContent = '';

                    if (Array.isArray(response)) {
                        tableContent = response.map(item => {
                            if (item.course !== "Total Credits") {
                                totalCredits += parseInt(item.credits, 10);
                                return `<tr><td class="px-6 py-4 whitespace-nowrap ">${item.course}</td><td class="px-6 py-4 whitespace-nowrap">${item.credits}</td></tr>`;
                            } else {
                                return `<tr class="font-bold"><td class="bg-gray-200 px-6 py-4 whitespace-nowrap">${item.course}</td><td class="bg-gray-200 px-6 py-4 whitespace-nowrap">${item.credits}</td></tr>`;
                            }
                        }).join('');
                    } else {
                        console.error('Unexpected response format:', response);
                    }

                    // Determine the max credits based on the vertical number
                    const maxCredits = vertno == 3 ? maxCreditsVertical3 : maxCreditsDefault;

                    if (totalCredits > maxCredits) {
                        alert('Credit limit exceeded for VERTICAL ' + vertno + '. Maximum allowed credits: ' + maxCredits);
                        // If credit limit is exceeded, remove the last selected option
                        selectedOptions.pop();
                        $(`#vertical${vertno} select.select2`).val(selectedOptions).trigger('change');
                        return;
                    }

                    // Store the total credits for the vertical
                    creditsPerVertical[vertno] = totalCredits;
                    $('#credittotal' + vertno + ' tbody').html(tableContent);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log("AJAX Error:", textStatus, errorThrown); // Debugging output
                }
            });
        }

        $(document).ready(function() {
            $('.select2').select2({
                width: '100%'
            });

            $(document).on('change', 'select.select2', function() {
                var vertno = $(this).closest('.bg-white').find('h2').text().replace('VERTICAL ', '');
                var program = $('#program').val(); // Get program from hidden input field
                var semester = $('#semester').val(); // Get semester from hidden input field

                var selectedOptions = [];
                // For verticals 4 and 5, collect the selected option from each major
                if (vertno == 4 || vertno == 5) {
                    $(`#instr select[id^="vertical${vertno}major"]`).each(function() {
                        var selectedVal = $(this).val();
                        if (selectedVal) {
                            selectedOptions.push(selectedVal);
                        }
                    });
                } else {
                    selectedOptions = $(this).val();
                }

                console.log("Selected options:", selectedOptions); // Debug the selected options

                getVenue(vertno, program, semester, selectedOptions);
            });

            // Calculate total credits when the button is clicked
            $('#calculate-total').on('click', function() {
                let totalAllVerticals = 0;
                for (const vertno in creditsPerVertical) {
                    totalAllVerticals += creditsPerVertical[vertno];
                }
                $('#total-credits').text('Total Credits across all Verticals: ' + totalAllVerticals);
            });
        });
    </script>
</body>
</html>

<?php
// Only close the connection if it was successfully initialized
if (isset($conn)) {
    $conn->close();
}
?>
