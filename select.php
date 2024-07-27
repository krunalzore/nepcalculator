<?php
session_start();
include 'db_connect.php';
include 'crypt.php';



ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(E_ALL);




$today = date("Y-m-d");

?>


<!DOCTYPE html><html lang="en">
	<head>
		<meta charset="utf-8">
		<title>UOM-ADMISSIONS</title>
		<meta name="viewport" content="width=device-width,initial-scale=1">
		<meta content="Ph.D. Admission" name="description"> 
		<meta content="University of Mumbai" name="author">
      <link rel="stylesheet" type="text/css" href="assets/css/select2.min.css"> 
	  
	</head>
	<body>
	<!-- Top Bar Start -->
		
		
		<!-- Top Bar End -->
	
<div class="page-wrapper-img">
	<div class="sidebar-user media">
		<div class="media-body">
			<h4 class="text-light">Department Dashboard</h4>
		</div>
	</div>
</div>
		
										
										<div class="row form-group">
											<div class="col-md-4">
												<label class="form-label" for="courseid"> Select Programme Name </label>
												<select name="courseid" id="courseid" class="select2">
													<option value="">Select</option>
													<option value="0">All Courses</option>
													<?php
													$deptcourses = mysqli_query($mysqli,'SELECT DISTINCT Faculty,DEGNM,SUBDEGNM FROM convodata group by Faculty,DEGNM,SUBDEGNM');
													while($deptres = mysqli_fetch_assoc($deptcourses))
													{
														echo '<option value="'.$deptres['DEGNM'].'">'.$deptres['DEGNM'].'</option>';
													}
													
													?>
												</select><br/>
												<br/>
															<select class="select2" id="studexam" name="studexam">
				<?php 
				
				$sql=$mysqli->query("SELECT DISTINCT Faculty,DEGNM,SUBDEGNM FROM convodata group by Faculty,DEGNM,SUBDEGNM");
				echo'<option value="N">Select Exam Name</option>';
				while($row=mysqli_fetch_array($sql))
				{
					echo'<option value="'.$row['DEGNM'].'-'.$row['SUBDEGNM'].'">'.$row['DEGNM'].' - '.$row['SUBDEGNM'].'</option>';
				}
				
				
				?>
			</select>
											</div>
											
											
											
										
										</div>
										
										
										
			
	
	
							
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

<script type="text/javascript">
$(document).ready(function() {
	
	$('.select2').select2({
		width:'100%'
	});
	
	
	
	


} );
</script>	


	</body>
</html>