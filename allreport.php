<?php
define('_MPDF_URI','./pdf/');
#Include the connect.php file
include_once 'db_connect.php';
//include_once 'functions.php';
include("./pdf/mpdf.php");
mysqli_set_charset($mysqli, "utf8");


//sec_session_start();

// if (login_check($mysqli) == true) {
    // ;
// } else {
    // header('Location: ../login.php');
    // exit;
// }
set_time_limit(900);
setlocale(LC_MONETARY, 'en_IN');
date_default_timezone_set("Asia/Kolkata");
#Connect to the database
/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

mysqli_set_charset($mysqli, "utf8");
$ip = $_SERVER['REMOTE_ADDR'];


function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
        }

      function makecomma($input) {
    // This function is written by some anonymous person - I got it from Google
	if (strlen($input) <= 2) {
		return $input;
    }
    $length = substr($input, 0, strlen($input) - 2);
    $formatted_input = makecomma($length) . "," . substr($input, -2);
    return $formatted_input;
}

function formatInIndianStyle($num) {
    // This is my function
    $pos = strpos((string) $num, ".");
    if ($pos === false) {
        $decimalpart = "00";
    } else {
        $decimalpart = substr($num, $pos + 1, 2);
        $num = substr($num, 0, $pos);
    }

    if (strlen($num) > 3 & strlen($num) <= 12) {
        $last3digits = substr($num, -3);
        $numexceptlastdigits = substr($num, 0, -3);
        $formatted = makecomma($numexceptlastdigits);
        $stringtoreturn = $formatted . "," . $last3digits . "." . $decimalpart;
    } elseif (strlen($num) <= 3) {
        $stringtoreturn = $num . "." . $decimalpart;
    } elseif (strlen($num) > 12) {
        $stringtoreturn = number_format($num, 2);
    }

    if (substr($stringtoreturn, 0, 2) == "-,") {
        $stringtoreturn = "-" . substr($stringtoreturn, 2);
    }

    return $stringtoreturn;
}

echo 
$veneuno = $_POST['exam'];
$examno = $_POST['examno'];
$examdate = $_POST['examdate'];


$feessqr = mysqli_query($mysqli,'select venue_name from venuedataAllExam where date="'.$examdate.'" AND venue_no="'.$veneuno.'" AND PROG_NO="'.$examno.'";');					
$resf = mysqli_fetch_assoc($feessqr);
$venuename = $resf['venue_name'];	

$report_query = "SELECT * FROM venuedataAllExam WHERE  Date='$examdate' AND venue_no='$veneuno' AND PROG_NO='$examno' and (SEAT_NO!=0 or SEAT_NO!='') ORDER BY QPCODE";

$result = $mysqli->query($report_query);

while($row = mysqli_fetch_array($result)) {
        $rows[] = $row;
		$exam=$row['EXAM'];
		
}


$mpdf = new mPDF('s', 'A4-L', '', '', 15, 15, 24, 12, 5, 5, 'L');

$mpdf->mirrorMargins = 1; // Use different Odd/Even headers and footers and mirror margins
$mpdf->progbar_heading = 'Generating PDF Please wait...';
$mpdf->StartProgressBarOutput(2);
$mpdf->debug  = true;
$header = '<table width="100%" style="border-bottom: 1px solid #000000; vertical-align: bottom; font-family: serif; font-size: 9pt;"><tr><td rowspan="2"><img src="images/mulogocolor.jpg" width="50px" /></td><td><p style="font-size: 20px;font-family: oldenglish">University of Mumbai</p></td><td rowspan="2"><p><span style="font-size: 7px">&nbsp;</span><span style="font-size: 40px"><strong>'.$_SESSION["collno"].'</strong></span></p></td></tr><tr><td><p style="font-size: 12px">Examination House, Vidyanagari Campus, Kalina, Santacruz (East), Mumbai-400098</p></td></tr></table>';
$footer = '<table width="100%" style="border-top: 1px solid #000000; vertical-align: bottom; font-family: serif; font-size: 7.5pt;"><tr>
<td width="50%"><span style="font-weight: bold;">Generated on: '.date("d M, Y H:i:s").' ('.$veneuno.'-'.$subno.'-'.$ip.')</span></td>
<td width="50%" style="text-align: right;">{PAGENO}/{nb}</td>
</tr></table>';




$mpdf->SetHTMLHeader($header);
$mpdf->SetHTMLHeader($header, 'E');
$mpdf->SetHTMLFooter($footer);
$mpdf->SetHTMLFooter($footer, 'E');


$headhtml = "<table width='100%'><tr><td>List Of Candidates (NEP Examination) ".$sess."</td><td align=right>Date : ". date("d M, Y")."</td></tr><tr><td>Vanue Code: ".$veneuno."</td></tr><tr><td>Venue Name: " . $venuename."</td></tr><tr><td>Exam Date: " . $examdate."</td></tr></table>";
$mpdf->WriteHTML($headhtml);

$html = "<br><br><table border=\"1\" cellpadding=\"2\" cellspacing=\"0\" stle='width:100%'>
<thead><tr bgcolor= \"#eeeeee\" style=\"vertical-align:middle; text-align:center\">
<th><strong>Programcode</strong></th><th><strong>Time</strong></th><th><strong>Subject Name</strong></th><th ><strong>Seat Number</strong></th><th ><strong>Name</strong></th></tr></thead><tbody>";
$i=0;
foreach ($rows as $row) {
	$i++;
		
	$html.="<tr bgcolor= \"#fff\" style=\"vertical-align:middle; text-align:center\"><td style=text-align:center><strong>".$row['PROG_NO']."</td><td style=text-align:center ><strong>".$row['TIME']."</td>
	<td style=text-align:left width = \"100%\"><strong>(".$row['QPCODE'].") ".$row['SUB_NAME']."</strong></td><td style=text-align:center><strong>".$row['SEAT_NO']."<td style=text-align:left><strong>".$row['NAME']."</strong></td></tr>";	
}

$html.="</tbody></table><br><br>";
$mpdf->WriteHTML($html);
$html2 = "<table width = \"100%\" border=\"1\" cellpadding=\"2\" cellspacing=\"0\"><tbody>";
$html2.="<tr nobr=\"true\"><td colspan=\"14\">Total Number of Candidates: <strong>$i</strong></td></tr>";
$html2.="</tbody></table>";

$mpdf->WriteHTML($html2);

$reportName = 'AR_' . $_SESSION["collno"] . '_' . date("dMY_His") . '.pdf';
$mpdf->Output($reportName,'I');
$mpdf->Output();
exit;
?>