
<?php

require_once '../CAS/config.php';
require_once $phpcas_path . '../CAS/CAS.php';

phpCAS::client(CAS_VERSION_2_0, $cas_host, $cas_port, $cas_context);
phpCAS::setNoCasServerValidation();
phpCAS::forceAuthentication();
phpCAS::handleLogoutRequests();

echo '<html>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src = "./student_id_check.js"></script>
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  <link rel="stylesheet" type="text/css" href="app.css">

<div class="container">
 	<div class="row">
 		<div class="col-lg-12">
 			<div class="content">
 				<a href="https://math.asu.edu/"><img src="asu.png" /></a>
 				<h3>School of Mathematical and Statistical Sciences</h3>
                <h3>PhD Program Student Report Form</h3>
 				<hr>

				<form class="form-horizontal" method="POST">
				<fieldset>

				<!-- Multiple Radios -->
				<div class="form-group">
				  <label class="col-md-6 control-label" for="student_form_details"><font size="4">Previously submitted form?</font></label>
				  <div class="col-md-2">
					  <div class="radio">
						<label for="student_form_details-0">
						  <input type="radio" name="student_form_details" id="student_form_details-0" value="1" onclick="Formsubmit()">
						  Yes
						</label>
					  </div>
					  <div class="radio">
						<label for="student_form_details-1">
						  <input type="radio" name="student_form_details" id="student_form_details-1" value="2" onclick="Formsubmit()">
						  No
						</label>
					  </div>
				  </div>
				</div>

				<!-- Search input-->
				<div class="form-group" id="form_student_id" style="display:none">
				  <label class="col-md-4 control-label" for="asu_id">ASU ID</label>
				  <div class="col-md-4">
					<input id="asu_id" name="asu_id" type="search" placeholder="Enter your ASU ID" class="form-control input-md">
					<!-- <p class="help-block">Enter the ASU ID</p> -->
				  </div>
				</div>

				<!-- Button -->
				<div class="form-group">
				  <!-- <label class="col-md-4 control-label" for="submit">Submit</label> -->
				  <label class="col-md-5 control-label" for="submit">&nbsp;</label>
				  <div class="col-md-4">
					<button id="submit" name="submit" class="btn btn-default" >Submit</button>
				  </div>
				</div>


				</fieldset>
				</form>
			</div>
 		</div>
 	</div>
 </div>

</html>
';

if(isset($_POST['submit']))
{
  if(!empty($_POST['asu_id'])){
    $test = $_POST['asu_id'];	
    //echo"'<script>console.log(\"$test\")</script>'";
    include('connect.php');
    $ID=$_POST['asu_id'];

$current_year = date('Y');
$current_month = date('m');
if($current_month<7)
{
	$current_year = intval($current_year-1);
}

//Fetch records for the current year if they exist
$tablename=$current_year.'_'.intval($current_year+1);
$sql = "SELECT * from ".$tablename." where ASU_ID=".$ID;
  	//$sql = "SELECT ASU_ID from SOMSS.somss_test where ASU_ID='$ID'";
	echo"<script>console.log(\"$sql\")</script>";
  	$retval = mysqli_query($conn,$sql);
	//echo"'<script>console.log(\"$retval\")</script>'";
  	if (!$retval) {
		echo'<script>alert("Student information not found")</script>';
  		//echo "Error: <br> Not Valid ASU ID";
  	}
	
  	while($row = mysqli_fetch_array($retval, MYSQLI_ASSOC))
  	{
		//echo'<script>console.log("hello")</script>';
  		if($row['ASU_ID']==$ID)
  		{
        $valid=1;
  			echo'<script>window.location="studentform_v1.php?valid='.$valid.'&ID='.$ID.'"</script>';
        unset($ID);
  		}
  		else
  		{
        
        unset($ID);
			echo'<script>alert("Student information not found")</script>';
  			//echo 'No student information found';
  		}
  	}
  }
  else
  {
      $valid=0;
      echo'<script>window.location="studentform_v1.php?valid='.$valid.'";</script>';
  }
}



?>
