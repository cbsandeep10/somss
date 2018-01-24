<?php
require_once '../CAS/config.php';
require_once $phpcas_path . '../CAS/CAS.php';

phpCAS::client(CAS_VERSION_2_0, $cas_host, $cas_port, $cas_context);
phpCAS::setNoCasServerValidation();
phpCAS::forceAuthentication();
phpCAS::handleLogoutRequests();
?>

<!DOCTYPE html>
<html lang="en">
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
  <script src="director.js"></script>
<script src="https://crypto-js.googlecode.com/svn/tags/3.1.2/build/rollups/aes.js"></script>
<style>
.datepicker {
    display: none;
}
.alert {
  padding: 1px 35px 1px 1px;
}
</style>
<script>
var Asu_id = '<?php echo $ASU_ID= $_GET['ASU_ID']; ?>';
</script>
<?php
if($_GET['key']=='2wsxZaq1'){
include('connect.php');
$INDEX =$_GET['index'];
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
	echo "<p><h3><b><center>You have already approved the Progress Report for this student!</center></b></h3></p>";
}

//echo "fghfghf".$row['Director_Signature'];

//*********************************************************************************
//print_r($row['Signature']);
//$SIGNATURE=json_decode($row['Signature']);
//ksort($SIGNATURE);
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
  $row['Mail']=json_decode($row['Mail']);
    $row['Course'] =json_decode($row['Course']);
    $row['Grade']=json_decode($row['Grade']);
    $row['Course']=implode("<br>",$row['Course']);
    $row['Grade']=implode("<br>",$row['Grade']);
    $row['No_Course_Reason']=($row['No_Course_Reason'] == "" ? "Not Applicable" : $row['No_Course_Reason']);
/*
    $row['Publications'] =json_decode($row['Publications']);
    $row['Presentations']=json_decode($row['Presentations']);
    $row['Publications']=(count($row['Publications']) == 0 ? "-":implode("<br>",$row['Publications']));
    $row['Presentations']=(count($row['Presentations']) == 0 ? "-":implode("<br>",$row['Presentations']));
*/
	$row['Publication_Name'] =json_decode($row['Publication_Name']);
    $row['Publication_Journal_Name'] =json_decode($row['Publication_Journal_Name']);
    $row['Publication_Status'] =json_decode($row['Publication_Status']);
    $row['Publication_DOI'] =json_decode($row['Publication_DOI']);
    $row['Publication_URL'] =json_decode($row['Publication_URL']);
    $row['Presentation_Type']=json_decode($row['Presentation_Type']);
    $row['Presentation_Title']=json_decode($row['Presentation_Title']);
    $row['Presentation_Place']=json_decode($row['Presentation_Place']);
    

    $row['Publication_Name']=(count($row['Publication_Name']) == 0 ? "-":implode("<br>",$row['Publication_Name']));
    $row['Publication_Journal_Name']=(count($row['Publication_Journal_Name']) == 0 ? "-":implode("<br>",$row['Publication_Journal_Name']));
    $row['Publication_Status'] = (count($row['Publication_Status']) == 0 ? "-":implode("<br>",$row['Publication_Status']));
    $row['Publication_DOI'] = (count($row['Publication_DOI'])) == 0 ? "-":implode("<br>",$row['Publication_DOI']);
	$row['Publication_URL'] = (count($row['Publication_URL'])) == 0 ? "-":implode("<br>",$row['Publication_URL']);
    
    $row['Presentation_Title']=(count($row['Presentation_Title']) == 0 ? "title":implode("<br>",$row['Presentation_Title']));
    $row['Presentation_Place']=(count($row['Presentation_Place']) == 0 ? "-":implode("<br>",$row['Presentation_Place']));
    $row['Presentation_Type'] = (count($row['Presentation_Type']) == 0 ? "-":implode("<br>",$row['Presentation_Type']));
    
    
    //$row['current_goal'] =json_decode($row['current_goal']);
    //$row['current_goal']=implode("<br>",$row['current_goal']);
    //$row['future_goal'] =json_decode($row['future_goal']);
    //$row['future_goal']=implode("<br>",$row['future_goal']);
    $row['Qualifying_Subjects'] =json_decode($row['Qualifying_Subjects']);
    $row['Qualifying_Grades']=json_decode($row['Qualifying_Grades']);
    $row['Qualifying_Subjects']=implode("<br>",$row['Qualifying_Subjects']);
    $row['Qualifying_Grades']=implode("<br>",$row['Qualifying_Grades']);
    $row['Written_Subjects'] =json_decode($row['Written_Subjects']);
    $row['Written_Grades']=json_decode($row['Written_Grades']);
    $row['Written_Subjects']=implode("<br>",$row['Written_Subjects']);
    $row['Written_Grades']=implode("<br>",$row['Written_Grades']);
    $row['Colloquium_Semester']=json_decode($row['Colloquium_Semester']);
    $row['Colloquium_Semester']=(count($row['Colloquium_Semester']) == 0 ? "-":implode("<br>",$row['Colloquium_Semester']));
    $Mail_length=sizeof(json_decode($row['Advisor_Mail'],true));
    $row['Advisor_Position'] =json_decode($row['Advisor_Position']);
    if($INDEX== $Mail_length){$POS[$Mail_length]="Graduate co-ordinator";}else{$POS=$row['Advisor_Position'];}
    $row['Advisor_Firstname']=json_decode($row['Advisor_Firstname']);
    $row['Advisor_Position']=implode("<br>",$row['Advisor_Position']);
    $row['Advisor_Firstname']=implode("<br>",$row['Advisor_Firstname']);
    $row['Advisor_Secondname'] =json_decode($row['Advisor_Secondname']);
    $row['Advisor_Mail']=json_decode($row['Advisor_Mail']);
    $row['Advisor_Secondname']=implode("<br>",$row['Advisor_Secondname']);
    $row['Advisor_Mail']=implode("<br>",$row['Advisor_Mail']);
	$row['No_Advisory_Committee_Reason']=($row['No_Advisory_Committee_Reason'] == "" ? "Not Applicable" : $row['No_Advisory_Committee_Reason']);

    $ADVISOR_TEAM=json_decode($row['Advisor_Team']);
    $row['Advisor_Team']=implode("<br>",$ADVISOR_TEAM);
    $APPROVAL=json_decode($row['Approved']);
    //$APPROVAL=implode("<br>",$APPROVAL);
    $MAIN_ADVISOR=$row['Admin_Advisor'];

    $FORM_ID=19*$ASU_ID;

	if($row['MS_In_Passing']==='1'){$MSINPASSING='Yes';}else{$MSINPASSING='No';};
	if($row['Graduation_Completed']==='1'){$GRAD_COMPLETED='Yes';}else{$GRAD_COMPLETED='No';};
	if(count($row['Course']) == 0){$COURSE_TAKEN = "No";}else{$COURSE_TAKEN = "Yes";};
    if($row['Written_Comprehensive']==='1'){$COMPREHENSIVE='Yes';}else{$COMPREHENSIVE='No';};
    if($row['Oral_Comprehensive']==='1'){$ORAL_COMPREHENSIVE='Yes';}else{$ORAL_COMPREHENSIVE='No';};
    if($row['Colloquium']==='1'){$COLLOQUIUM='Yes';}else{$COLLOQUIUM='No';};
    if($row['Adivisory_Committee']==='1'){$ADVISORY_COMMITTEE='Yes';}else{$ADVISORY_COMMITTEE='No';};
    if($row['Student_Advisory_Met']==='1'){$STUDENT_ADVISOR='Yes';}else{$STUDENT_ADVISOR='No';};
    if($row['Qualifying_Exam_Completed']==='1'){$QUALIFYING_EXAM='Yes';}else{$QUALIFYING_EXAM='No';};
    if(count($APPROVAL)==0){$Adv_Approved="No";}else{$Adv_Approved="Yes";};

$VALIDATE='true';
$AdvisorComments= " ";
/*
if($row['AdvisorComments']===NULL)
{
$AdvisorComments= "No Comments" ;
}else{ 
$AdvisorComments = json_decode($row['AdvisorComments'],true);
ksort($AdvisorComments);
$AdvisorComments=implode("<br>",$AdvisorComments);
}
*/

$AdvisorComments = json_decode($row['AdvisorComments'],true);
ksort($AdvisorComments);
$AdvisorComments=implode("<br>",$AdvisorComments);

//print_r(array_intersect($ADVISOR_TEAM,$APPROVAL));
$RESULT=array_diff($ADVISOR_TEAM,$APPROVAL);
if(!(empty($RESULT)))
                {
                       	$VALIDATE='false';
                       // print_r($VALIDATE);
                
                }


  echo"
<p><h3><b><center>DIRECTOR APPROVAL FORM</center></b></h3></p> 
<p><h4><b><center>As the Director of the Department</center></b></h4></p>
<p><h5><b><center><i>Please approve the form for <u>{$row['First_Name']} {$row['Second_Name']}</u></i></center></b></h5></p>
<table align='center' border='2' style='width: auto;' class='table table-hover'>
";
echo"
<div class='container'><div class='col-md-12'><center><label>STUDENT FORM ID:</label><input type='text' name='random' id='random' readonly value = '$FORM_ID'><center></div></div>
<tr><th>Degree Program</th><td>{$row['Degree']}
<tr><th>Academic Year</th><td>{$row['Academic_Year']}
<tr><th>First Name</th><td>{$row['First_Name']}</td></tr>
<tr><th>Last Name</th><td>{$row['Second_Name']}</td></tr>
<tr><th>ASU ID/Student ID</th><td>{$row['ASU_ID']}</td></tr>
<tr><th>Program Start Date</th><td>{$row['Program_start_date']}</td></tr>
<tr><th>Semester In Progress</th><td>{$row['Semester_in_progress']}</td></tr>
<tr><th>CGPA</th><td>{$row['CGPA']}</td></tr>
<tr><th>Has the student completed Masters in passing?</th><td>$MSINPASSING</td></tr>
<tr><th>Has the student graduated?</th><td>$GRAD_COMPLETED</td></tr>
<tr><th>Has the student taken a Course during the current year?</th><td>$COURSE_TAKEN</td></tr>
<tr><th>Reason for not taking a Course</th><td>{$row['No_Course_Reason']}</td></tr>
<tr><th>Courses taken since last progress report with grades</th>
<td>
<table align='center' border='1' style='width: auto;' class='table table-bordered'>
<thead>
<tr>
<th>Course</th>
<th>Grade</th>
</tr>
</thead>
<tbody>
<tr>
<td>{$row['Course']}</td>
<td>{$row['Grade']}</td>

</tr>
</tbody>
</table>
</td>
</tr>
<tr><th>Advisory committee Formed?</th><td>$ADVISORY_COMMITTEE</td></tr>
<tr><th>Reason for not having Advisory Committee</th><td>{$row['No_Advisory_Committee_Reason']}</td></tr>
<tr><th>Members of the commitee</th>
<td>
<table align='center' border='1' style='width: auto;' class='table table-bordered'>
<thead>
<tr>
<th>Position</th>
<th>Firstname</th>
<th>Lastname</th>
<th>E-mail</th>
</tr>
</thead>
<tbody>
<tr>
<td>{$row['Advisor_Position']}</td>
<td>{$row['Advisor_Firstname']}</td>
<td>{$row['Advisor_Secondname']}</td>
<td>{$row['Advisor_Mail']}</td>
</tr>
</tbody>
</table>
</td>
</tr>
<tr><th>Has the Student Met the Chair during this academic year?</th><td>$STUDENT_ADVISOR</td></tr>
<tr><th>Reason for not meeting the Chair</th><td>{$row['Not_Met_Reason']}</td><tr>
<tr><th>Qualifying Exam Completed?</th><td>$QUALIFYING_EXAM</td></tr>

<tr><th>Qualifying Exam Subjects</th>
<td>
<table align='center' border='1' style='width: auto;' class='table table-bordered'>
<thead>
<tr>
<th>Qualifying Exam Courses</th>
<th>Qualifying Exam Grade</th>
</tr>
</thead>
<tbody>
<tr>
<td>{$row['Qualifying_Subjects']}</td>
<td>{$row['Qualifying_Grades']}</td>

</tr>
</tbody>
</table>
</td>
</tr>
<tr><th>Written Comprehensive Exam Completed?</th><td>$COMPREHENSIVE</td></tr>
<tr><th>Written Comprehensive Exam Subjects</th>
<td>
<table align='center' border='1' style='width: auto;' class='table table-bordered'>
<thead>
<tr>
<th>Written Comprehensive Exam Courses</th>
<th>Written Comprehensive Exam Grade</th>
</tr>
</thead>
<tbody>
<tr>
<td>{$row['Written_Subjects']}</td>
<td>{$row['Written_Grades']}</td>

</tr>
</tbody>
</table>
</td>
</tr>
<tr><th>Dissertation prospectus completed?</th><td>$ORAL_COMPREHENSIVE</td></tr>
<tr><th>Colloquium lecture attended?</th><td>$COLLOQUIUM</td></tr>
<tr><th>If Yes, then in which semesters were the lectures attended?</th><td>{$row['Colloquium_Semester']}</td></tr>

<!-- <tr><th>Outline the goals met in this reporting period</th><td>{$row['current_goal']}</td></tr> -->
<!-- <tr><th>Publications</th><td>{$row['Publications']}</td></tr>
<tr><th>Presentations</th><td>{$row['Presentations']}</td></tr> -->
<tr>
<th>Publications</th>
<td>
<table align='center' border='1' style='width:auto;' class='table table-bordered'>
<thead>
<tr>
<th>Publication</th>
<th>Journal</th>
<th>Status</th>
<th>DOI</th>
<th>URL</th>
</tr>
</thead>
<tbody>
<tr>
<td>{$row['Publication_Name']}</td>
<td>{$row['Publication_Journal_Name']}</td>
<td>{$row['Publication_Status']}</td>
<td>{$row['Publication_DOI']}</td>
<td>{$row['Publication_URL']}</td>
</tr>
</tbody>
</table
</td>
</tr>

<tr>
<th>Presentations</th>
<td>
<table align='center' border='1' style='width:auto;' class='table table-bordered'>
<thead>
<tr>
<th>Type</th>
<th>Title</th>
<th>Place</th>


</tr>
</thead>
<tbody>
<tr>
<td>{$row['Presentation_Type']}</td>
<td>{$row['Presentation_Title']}</td>
<td>{$row['Presentation_Place']}</td>

</tbody>
</table
</td>
</tr>

<!-- <tr><th>Outline the goals for the next academic year</th><td>{$row['future_goal']}</td></tr> -->

<tr><th>Additonal Details/Information by Student</th><td>{$row['Extra']}</td></tr>
<tr><th>Has the CHAIR/CO-CHAIR of the student's Advisory Committee approved the form?</th><td>$Adv_Approved</td></tr>

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

<tr><th>Signature of Advisors</th>
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

<tr><th>Advisor Comments</th>
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
</tr>";

if($row['Director_Signature']!=null|| $row['Director_Signature']!='' ||$row['Director_Signature']!=NULL)
{
echo "<tr><th>Director Comments</th><td>{$row['Director_Comments']}</td></tr>
<tr><th>Director Signature</th><td>{$row['Director_Signature']}</td></tr>";
}

echo "</table></div>
<div id='prompt_password' style='display:none'><p> Enter the password provided in the email</p>PASSWORD:<input type='password' id='advisor_password'/></div>
";

echo"
</table>
";

//echo($ADVISOR_TEAM == $APPROVAL);

$dt= date("m-d-Y");


if($row['Director_Signature']== null || $row['Director_Signature']=="" ||$row['Director_Signature']==NULL){
echo"
<div class='container'>
<form class='form-horizontal' role='form' method='POST' action=''>

<div class='row'>
<div class='form-group'>

      <label class='control-label col-md-4'><h4><b>Graduate Director's Comments<b></h4></label>
      <div class='col-md-6'>
  <textarea rows='5' cols='95' id='director_comments'> </textarea>
      </div>
 </div>
 	<div class='alert alert-danger alert-dismissible col-md-3' id='noDirectorCommentsAlertDiv' role='alert' style='display:none'>
		<button type='button' class='alert-close close' ><span aria-hidden='true'>&times;</span></button>
		<p id='noDirectorCommentsAlertMsg'></p>
	</div>
</div>
<p><h3><b>Section E |Director's Signature</b></h3></p>
<div class='row'>
<div class='form-group'>
      <label class='control-label col-md-32' for='main_advisor'>Please sign here</label>
    <table id='permanent_adv'>
       <thead>
         <tr>
           <th><label for='signature'>MEMBER</label></th>
           <th><label for='signature'>NAME</label></th>
           <th><label for='signature'><center>SIGNATURE</center></label></th>
           <th><center for='signature'><center>DATE</center></label></th>
        </tr>
        </thead>
        <tbody id='permanent_advi'>
        <tr class='signature'>
           <th type='text' class='member' value='GRADUATE DIRECTOR'>GRADUATE DIRECTOR</th>
           <td> <input  name='name' class='name'  type='text' size='45'> </td>
           <td><input  name='1' class='password' id='password' type='text' size='45' readonly></td>
           <td> <input  class='date' type='text' size='30' value='$dt' readonly></td>
        </tr>
    </tbody>
</table>
</div>
<div class='alert alert-danger alert-dismissible col-md-3' id='noSignatureAlertDiv' role='alert' style='display:none'>
	<button type='button' class='alert-close close' ><span aria-hidden='true'>&times;</span></button>
	<p id='noSignatureAlertMsg'></p>
</div>
</div>
<div class='form-group'><input type ='submit'  class='submit'/ value='Submit'></div>

</form>
</div>";
}

echo "</html>";
mysqli_close($conn);
}
}
else{
	echo "You have no acess to this page";
}

?>
