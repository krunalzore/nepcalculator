<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header("Content-type: text/html; charset=UTF-8");


include_once 'db_connect.php';

?>
<!DOCTYPE html>

<html lang="en-US">
<head>
	
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>NEP Credit Calculator</title>
    <link rel="shortcut icon" href="">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="assets/css/select2.min.css"> 
    <style>body{padding-top:60px;}.starter-template{padding:40px 15px;text-align:center;}</style>
	
	<style>
		.contents {
					width: 100%;
					//border: 1px solid;
					height: 800px;
					overflow: auto;
					text-align:center;
					}
					
			 th {
					  position: sticky;
					  top: 0;
					  background: #ffffff;
					}
			
		#instr {
			border: 1px solid;
			padding-left:  20px;
			padding-right: 0px;
			padding-bottom: 80px;
			padding-top: 20px;
			
			
		}
	</style>
    <!--[if IE]>
        <script src="https://cdn.jsdelivr.net/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://cdn.jsdelivr.net/respond/1.4.2/respond.min.js"></script>
    <![endif]-->


</head>

<body>
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#"></a>
            </div>

            <div class="collapse navbar-collapse">
			
			 <ul class="nav navbar-nav">
					<li class="active"><a href="#">Venue Wise</a></li>
                   
                </ul>
			
                
               
            </div><!--.nav-collapse -->
        </div>
    </nav>




    <div class="container" id="instr">
	 
		
		<form method="POST" target="_blank"  action="allreport.php">
		<h1>NEP Credit Calulator</h1><br/>
		  <div class="row">
		    <div class="col-xs-6">		  
			  <label for="examno">Select Exam Name:</label>
				<select class="select2" id="examno" name="examno[]" onchange="getVenue()" required multiple>
					<?php 
						$sql = $mysqli->query("SELECT DISTINCT COURSE_NAME FROM subjectmaster WHERE VERTICAL_NO=1");
						echo '<option disabled selected value>Select Programcode</option>';
						while ($row = mysqli_fetch_array($sql)) {
							echo '<option value="' . $row['COURSE_NAME'] . '">' . $row['COURSE_NAME'] . '</option>';
						}
					?>
				</select>
			</div>
			<div class="col-xs-6">		
				 <label for="credittotal">Credits:</label>
				<span style="color:red; font-size:22px;" id="credittotal" name="credittotal"></span>
			
			</div>		
		 </div>	<br/>
		  <div class="row">
		  <div class="col-xs-6">
		  <label for="exam">Select Venue:</label>		
			<select class="select2"  name="exam" id="exam" onchange="getEdate(this)" required>
				<?php
					echo'<option disabled selected value>Select Venue</option>';
				?>
			</select>
		 </div>	
		 </div>	<br/>
		  <div class="row">
		  <div class="col-xs-6">
		  <label for="examdate">Select Exam Date:</label>		
			<select class="select2"  name="examdate" id="examdate" required>
				<?php
					echo'<option disabled selected value>Select Exam Date</option>';
				?>
			</select>
		 </div>	
		 </div>	<br/>
		 <br/>
		 
		  <div class="form-group">
			<input type="submit" name="regisbtn" id="regisbtn" class="btn btn-primary" value="Get Venue Wise List">
		 </div>
		</form>
		 </div>	
		<br/>
	
   
 <!-- jQuery  -->
		<script src="assets/js/jquery.min.js"></script>
		<script src="assets/js/bootstrap.bundle.min.js"></script>
		<script src="assets/js/metisMenu.min.js"></script>
		<script src="assets/js/waves.min.js"></script>
		<script src="assets/js/jquery.slimscroll.min.js"></script>
		<script src="assets/plugins/moment/moment.js"></script>
		<script src="assets/plugins/dropify/js/dropify.min.js"></script>	
		
	<!--<script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script> -->	
		
		<script type="text/javascript" src="assets/js/select2.js"></script>
		
		<!-- App js -->
		<script src="assets/js/app.js"></script>
 
<script>
    function getVenue() {
        var selectElement = document.getElementById("examno");
        var selectedOptions = Array.from(selectElement.selectedOptions).map(option => option.value);
        var selectedString = selectedOptions.join(',');

        alert(selectedString); // Alert the selected values

        $.ajax({
            url: "getCredit.php",
            type: "post",
            data: { subname: selectedString },
            success: function(response) {
                // you will get response from your PHP page (what you echo or print)     
                $('#credittotal').html(response);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    }
</script>


</script>


		</script>

		
<script>
			function getEdate(dtp)
			{
				
				var selectedString = dtp.options[dtp.selectedIndex].value;
				var examno = document.getElementById('examno').value;
		//alert(examno);
				$.ajax({
					url: "examdate.php?Programcode="+selectedString+'&examno='+examno,
					type: "post",
					success: function (response) {
					   // you will get response from your php page (what you echo or print)     
					   
						$('#examdate').html(response);
					},
					error: function(jqXHR, textStatus, errorThrown) {
					   console.log(textStatus, errorThrown);
					}
				});
			}
		</script>
 
 
 <script type="text/javascript">
	$(document).ready(function() {
		
		$('.select2').select2({
			width:'100%'
		});
		
	});
</script>	
 
	<script type="text/javascript">
		function printDiv() {
			var divToPrint = document.getElementById('instr').innerHTML;
			document.getElementById('instr').innerHTML = "";
			window.print();
			document.getElementById('instr').innerHTML = divToPrint;
		}
	</script>
    <script>
		function myconfirm(form) {
		var v=document.forms['submitform'];
		var r = confirm("Click OK to confirm!");
		if (r == true) {
		   v.submit();
		} else {
		   
		}
		}
	</script>
	 <script>
	// function validSelect() {
		
	// var selectinput = $('#examno').val();
	// alert(selectinput);

		// if(selectinput == "N")
		// {
			// $('#error_select').html('Please Select Examno').css('color', 'red');
			// return false;	
		// }
		// else
		// {
			 // $('#error_select').html('').css('color', 'green');
				// return true;
				
		// }

	// }
	 </script>	
		
</body>
</html>
