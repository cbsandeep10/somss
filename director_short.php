<?php
require_once '../../CAS/config.php';
require_once $phpcas_path . 'CAS.php';

phpCAS::client(CAS_VERSION_2_0, $cas_host, $cas_port, $cas_context);
phpCAS::setNoCasServerValidation();
phpCAS::forceAuthentication();
phpCAS::handleLogoutRequests();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>FORM for Director</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  <!-- <script src="director_short_js.js"></script> -->
	<script src="https://crypto-js.googlecode.com/svn/tags/3.1.2/build/rollups/aes.js"></script>
	<style>
	.alert {
	  padding: 1px 35px 1px 1px;
	}
	</style>
	<script>
	var Asu_id = '<?php echo $ASU_ID= $_GET['ASU_ID']; ?>';
	</script>
	<script>
		function ViewForm(){
			window.location.href="https://mathcms.asu.edu/somss/director.php?ASU_ID="+Asu_id+"&key=2wsxZaq1";
			console.log("viewform");
		}
	
		function ApproveForm(){
			console.log("approveform");
			
			$.ajax({
				type: 'POST',
				url: 'director_data.php',
				data:{
					signature:"DirectApproval",
					asu_id:Asu_id,
					//index:Index,
					director_comments:"DirectApproval"
				},
				success: function(data){
				//alert(Director_Comments);
				alert("The progress report for the student has been approved!");
				window.location.href="https://mathcms.asu.edu/somss/director_home.php?key=2wsxZaq1";
				}
			});
			
		}
	</script>
</head>
<body>
<?php
if($_GET['key']=='2wsxZaq1'){
include('connect.php');
$ASU_ID= $_GET['ASU_ID'];

$current_year = date('Y');
$current_month = date('m');

if($current_month < 7){
	$table_name = intval($current_year-1).'_'.$current_year; 
}
else{
	$table_name = $current_year.'_'.intval($current_year  + 1); 
}

//$ASU_ID='1208664752';
$sql = "SELECT * from ".$table_name." where ASU_ID='$ASU_ID'";
//$sql = "SELECT * from somss_test where ASU_ID='$ASU_ID'";
$retval = mysqli_query($conn,$sql);
if (!$retval) {
	echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
while($row = mysqli_fetch_array($retval, MYSQLI_ASSOC))
{
	if($row['Director_Signature']!=null|| $row['Director_Signature']!="" ||$row['Director_Signature']!=NULL){
		echo "<div class='director_approval'><p><h3><b><center>You have already approved the Progress Report for this student!</center></b></h3></p></div>
			<div class='director_submit' align='center'>
				<input type='button' class='btn btn-primary viewform' onclick='ViewForm()' value='View Form'>
			</div>
		";
		return;
	}
	
	//No Advisory Committee
	if($row['Adivisory_Committee'] !='1')
	{
		echo "<div class='advisor_approval'><p><h4><b><center>The student does not have a advisory committee</center></b></h4></p></div>
			<div class='director_submit' align='center'>
				<input type='button' class='btn btn-primary viewform' onclick='ViewForm()' value='View Form'>
				<input type='button' class='btn btn-success approveform' onclick='ApproveForm()' value='Approve Form'>
			</div>
		";
		return;
	}
	//Advisory committee is present
	else{
		$APPROVAL=json_decode($row['Approved']);
		if(count($APPROVAL)==0)
		{
			echo "<div class='advisor_approval'><p><h4><b><center>The approval of the Chair/Co-Chair is pending</center></b></h4></p></div>
				<div class='director_submit' align='center'>
					<input type='button' class='btn btn-primary viewform' onclick='ViewForm()' value='View Form'>
					<input type='button' class='btn btn-success approveform' onclick='ApproveForm()' value='Approve Form'>
				</div>
			";
			return;
		}
		else
		{
			$SIGNATURE=json_decode($row['Signature'],true);
			ksort($SIGNATURE);
			$SIGNATURE=implode("<br>",$SIGNATURE);
			$RATING_ADVISOR=array();
			$APPROVER_LIST=array();
			$STUDENT_RATING=json_decode($row['Student_Rating']);
			$APPROVAL=json_decode($row['Advisor_Firstname']);
			foreach($STUDENT_RATING as $APPROVAL=>$RATING)
			{
			//	print_r("entering");
				if($RATING==='1')
				{	
					$APPROVER_LIST= array_merge($APPROVER_LIST,array($APPROVAL));
					$RATING_ADVISOR= array_merge($RATING_ADVISOR,array("Excellent"));
				}
				else if($RATING==='2')
				{
					$APPROVER_LIST= array_merge($APPROVER_LIST,array($APPROVAL));
					$RATING_ADVISOR=array_merge($RATING_ADVISOR,array("Good"));
				}
				else if($RATING==='3')
				{
					$APPROVER_LIST= array_merge($APPROVER_LIST,array($APPROVAL));
					$RATING_ADVISOR=array_merge($RATING_ADVISOR,array("Marginal(In need of Improvement)"));
				}
				else if($RATING==='4')
				{
					$APPROVER_LIST= array_merge($APPROVER_LIST,array($APPROVAL));
					$RATING_ADVISOR=array_merge($RATING_ADVISOR, array("Unsatisfactory(Student does not meet minimum requirement)"));
		
				}

			  else{
				$APPROVER_LIST= array_merge($APPROVER_LIST,array($APPROVAL));
				$RATING_ADVISOR=array_merge($RATING_ADVISOR, array("Did not mention any rating."));

			  }

			}

			$APPROVER_LIST=implode("<br>",$APPROVER_LIST);
			$RATING_ADVISOR=implode("<br>",$RATING_ADVISOR);
			
			$AdvisorComments = json_decode($row['AdvisorComments'],true);
			ksort($AdvisorComments);
			$AdvisorComments=implode("<br>",$AdvisorComments);
			
			echo "
				<div class='advisor_feedback'>
					<table align='center' border='2' style='width: auto;' class='table table-hover'>
					<div class='container' align='center'><label>Advisor Feedback</label></div>
						<tr>
						<th>Student Rating by Advisor</th>
						<td>
						  <table align='center' border='1' style='width: auto;' class='table table-bordered'>
						  <thead>
						  <tr>
							<th>Advisor</th>
							<th>Ratings</th>
						  </tr>
						  </thead>
						  <tbody>
						  <tr>
							<td>$APPROVER_LIST</td>
							<td><b>{$RATING_ADVISOR}</b></td>
						  </tr>
						  </tbody>
						</table>
						</td>
						</tr>

						<tr>
						<th>Signature of Advisors</th>
						<td>
							<table align='center' border='1' style='width: auto;' class='table table-bordered'>
							<thead>
							<tr>
								<th>Advisor</th>
								<th>Signature</th>
							</tr>
							</thead>
							<tbody>
							<tr>
								<td>$APPROVER_LIST</td>
								<td><b>{$SIGNATURE}</b></td>
							</tr>
							</tbody>
							</table>
						</td>
						</tr>

						<tr>
						<th>Advisor Comments</th>
						<td>
							<table align='center' border='1' style='width: auto;' class='table table-bordered'>
							<thead>
							<tr>
								<th>Advisor</th>
								<th>Comments</th>
							</tr>
							</thead>
							<tbody>
							<tr>
								<td>$APPROVER_LIST</td>
								<td><b>{$AdvisorComments}</b></td>
							</tr>
							</tbody>
							</table>
						</td>
						</tr>
					</table>
				</div>
				<div class='director_submit' align='center'>
					<input type='button' class='btn btn-primary viewform' onclick='ViewForm()' value='View Form'>
					<input type='button' class='btn btn-success approveform' onclick='ApproveForm()' value='Approve Form'>
				</div>
			";
		}

	}
}
}
else{
	echo "You have no acess to this page";
}

?>
