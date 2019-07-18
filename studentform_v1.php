<?php
require_once '../../CAS/config.php';
require_once $phpcas_path . 'CAS.php';

phpCAS::client(CAS_VERSION_2_0, $cas_host, $cas_port, $cas_context);
phpCAS::setNoCasServerValidation();
phpCAS::forceAuthentication();
phpCAS::handleLogoutRequests();

$record_exists = false;
//$_GET['valid'] = 1;
if($_GET['valid'] == 1){
//Connect to the database
include('connect.php');

//Fetch information for the below ASU ID from the database to populate in the form
//$ASU_ID = 1209365010; //1206109121 1205222274
$ASU_ID = $_GET['ID'];
$current_year = date('Y');
$current_month = date('m');
if($current_month<7)
{
	$current_year = intval($current_year-1);
}

//Fetch records for the current year if they exist
$tablename=$current_year.'_'.intval($current_year+1);
$tablename="2018_2019";
$sql = "SELECT * from ".$tablename." where ASU_ID='$ASU_ID'";
//$sql = "SELECT * from archives where ASU_ID='$ASU_ID'";

$retval = mysqli_query($conn,$sql);
if(!$retval){
echo "Error: ".$sql."<br>".mysqli_error($conn);
}
while($row = mysqli_fetch_array($retval, MYSQLI_ASSOC))
{
	$record_exists = true;
	$AcademicYear=$row['Academic_Year'];
	$Degree_program=$row['Degree'];
	$MS_In_Passing=$row['MS_In_Passing'];
	$Graduation_Completed=$row['Graduation_Completed'];
	$FirstName=$row['First_Name'];
	$SecondName=$row['Second_Name'];
	$ASU_ID=$row['ASU_ID'];
	$ASURITE=$row['ASURITE'];
	$CGPA=$row['CGPA'];
	$SemesterProgress=$row['Semester_in_progress'];
	$ProgramStart=$row['Program_start_date'];
	$NoCourseReason = $row['No_Course_Reason'];
	$Course_details=json_decode($row['Course']);
  	$Grade_details=json_decode($row['Grade']);
  	$AdvisoryComPresent=$row['Adivisory_Committee'];
  	$NoAdvCommReason = $row['No_Advisory_Committee_Reason'];
	$AdvisorPosition=json_decode($row['Advisor_Position']);
	$AdvisorFirstName=json_decode($row['Advisor_Firstname']);
	$AdvisorLastName=json_decode($row['Advisor_Secondname']);
	$AdvisorEmailID=json_decode($row['Advisor_Mail']);
	$MetChair=$row['Student_Advisory_Met'];
    $NotMetReason=$row['Not_Met_Reason'];
    $QualExamComp=$row['Qualifying_Exam_Completed'];
    $Qualifying_subjects=json_decode($row['Qualifying_Subjects']);
  	$Qualifying_subjects_grades=json_decode($row['Qualifying_Grades']);
  	$ComprehensiveExamCompleted=$row['Written_Comprehensive'];
  	$ComprehensiveExamSubjects=json_decode($row['Written_Subjects']);
  	$ComprehensiveExamGrades=json_decode($row['Written_Grades']);
  	$DissertationProspectus=$row['Oral_Comprehensive'];
  	$Colloquium_Attended=$row['Colloquium'];
  	$Colloquium_Semesters=json_decode($row['Colloquium_Semester']);
  	//$Current_Goals=json_decode($row['current_goal']);
  	//$cur=json_decode($row['current_goal'])[0];
  	//$Publications=json_decode($row['Publications']);
  	//$Presentations=json_decode($row['Presentations']);
  	$Publication_Name=json_decode($row['Publication_Name']);
  	$Publication_Journal_Name=json_decode($row['Publication_Journal_Name']);
  	$Publication_Status=json_decode($row['Publication_Status']);
  	$Publication_DOI=json_decode($row['Publication_DOI']);
  	$Publication_URL=json_decode($row['Publication_URL']);
  	$Presentation_Type=json_decode($row['Presentation_Type']);
  	$Presentation_Title=json_decode($row['Presentation_Title']);
  	$Presentation_Place=json_decode($row['Presentation_Place']);
  	$Awards = json_decode($row['Awards']);
  	$Comments = $row['Extra'];
  	
  	//$Future_Goals=json_decode($row['future_goal']);
	//foreach($Publication_DOI as $pubs)
		//echo "'<script>console.log(\"$pubs\")</script>'";
	
}

//Fetch records for the last 5 years
$current_year = $current_year - 1;
$count=5;
$Course_details_PrevYears = array();
$Grade_details_PrevYears = array();
$Qualifying_subjects_PrevYears = array();
$Qualifying_subjects_grades_PrevYears = array();
$ComprehensiveExamSubjects_PrevYears = array();
$ComprehensiveExamGrades_PrevYears = array();
$Current_Goals_PrevYears = array();
//$Publications_PrevYears = array();
//$Presentations_PrevYears = array();
$Publication_Name_PrevYears = array();
$Publication_Journal_Name_PrevYears = array();
$Publication_Status_PrevYears = array();
$Publication_DOI_PrevYears = array();
$Publication_URL_PrevYears = array();
$Presentation_Title_PrevYears = array();
$Presentation_Place_PrevYears = array();
$Presentation_Type_PrevYears = array();
$Awards_PrevYears = array();
$Future_Goals_PrevYears = array();
while($count>0)
{
$tablename=($current_year).'_'.intval($current_year+1);
$tablename="2018_2019";
$sql = "SELECT * from ".$tablename." where ASU_ID='$ASU_ID'";
$retval = mysqli_query($conn,$sql);
if (!$retval) {
//echo "Error: " . $sql . "<br>" . mysqli_error($conn);
	$current_year = $current_year - 1;
	$count = $count - 1;
continue;
}


while($row = mysqli_fetch_array($retval, MYSQLI_ASSOC))
{

	$Course_details_PrevYears=array_merge($Course_details_PrevYears,json_decode($row['Course']));
  	$Grade_details_PrevYears=array_merge($Grade_details_PrevYears,json_decode($row['Grade']));
  	//$AdvisoryComPresent=$row['Adivisory_Committee'];
	//$AdvisorPosition=json_decode($row['Advisor_Position']);
	//$AdvisorFirstName=json_decode($row['Advisor_Firstname']);
	//$AdvisorLastName=json_decode($row['Advisor_Secondname']);
	//$AdvisorEmailID=json_decode($row['Advisor_Mail']);
	//$MetChair=$row['Student_Advisory_Met'];
    //$NotMetReason=$row['Not_Met_Reason'];
    //$QualExamComp=$row['Qualifying_Exam_Completed'];
    $Qualifying_subjects_PrevYears=array_merge($Qualifying_subjects_PrevYears,json_decode($row['Qualifying_Subjects']));
  	$Qualifying_subjects_grades_PrevYears=array_merge($Qualifying_subjects_grades_PrevYears,json_decode($row['Qualifying_Grades']));
  	//$ComprehensiveExamCompleted=$row['Written_Comprehensive'];
  	$ComprehensiveExamSubjects_PrevYears=array_merge($ComprehensiveExamSubjects_PrevYears,json_decode($row['Written_Subjects']));
  	$ComprehensiveExamGrades_PrevYears=array_merge($ComprehensiveExamGrades_PrevYears,json_decode($row['Written_Grades']));
  	//$DissertationProspectus=$row['Oral_Comprehensive'];
  	//$Colloquium_Attended=$row['Colloquium'];
  	//$Colloquium_Semesters=json_decode($row['Colloquium_Semester']);
  	//$Current_Goals_PrevYears=array_merge($Current_Goals_PrevYears,json_decode($row['current_goal']));
  	//$cur=json_decode($row['current_goal'])[0];
  	//$Publications_PrevYears=array_merge($Publications_PrevYears,json_decode($row['Publications']));
  	//$Presentations_PrevYears=array_merge($Presentations_PrevYears,json_decode($row['Presentations']));
  	$Publication_Name_PrevYears = array_merge($Publication_Name_PrevYears,json_decode($row['Publication_Name']));
	$Publication_Journal_Name_PrevYears = array_merge($Publication_Journal_Name_PrevYears,json_decode($row['Publication_Journal_Name']));
	$Publication_Status_PrevYears = array_merge($Publication_Status_PrevYears,json_decode($row['Publication_Status']));
	$Publication_DOI_PrevYears = array_merge($Publication_DOI_PrevYears,json_decode($row['Publication_DOI']));
	$Publication_URL_PrevYears = array_merge($Publication_URL_PrevYears,json_decode($row['Publication_URL']));
	$Presentation_Type_PrevYears = array_merge($Presentation_Type_PrevYears,json_decode($row['Presentation_Type']));
	$Presentation_Title_PrevYears = array_merge($Presentation_Title_PrevYears,json_decode($row['Presentation_Title']));
	$Presentation_Place_PrevYears = array_merge($Presentation_Place_PrevYears,json_decode($row['Presentation_Place']));
	$Awards_PrevYears=array_merge($Awards_PrevYears,json_decode($row['Awards']));
  	//$Future_Goals_PrevYears=array_merge($Future_Goals_PrevYears,json_decode($row['future_goal']));
	//foreach($Course_details as $course)
		//echo "'<script>console.log(\"$NotMetReason\")</script>'";
}
	$current_year = $current_year - 1;
	$count = $count - 1;
	
}
}
//List of degree programs
$degree_program_list = array('Applied Mathematics','Mathematics','Mathematics Education','Statistics');

//List of semester number
$semester_number_list = array('1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30');

//List of Grades
$grade_list = array('A+','A','A-','B+','B','B-','C+','C','D','E','EN','I','NR','P','W','X','Y','Z','XE');
$comprehensive_exam_grade_list = array('Pass','Fail');

//List of Advisor Positions
$advisor_position_list = array('Advisor','Co-Advisor');

/*
//List of publication statuses
$publication_status = array('Submitted','Accepted','published');

//List of Presentation areas
$presentation_areas = array('Conference talk','Poster presentation','Seminar','Other');
*/

$test = "Test";
?>
<html lang='en'>
<head>
	<title>FORM</title>
	<meta charset='utf-8'>
	<meta name='viewport' content='width=device-width, initial-scale=1'>

	<!-- jQuery-UI js should be loaded before Bootstrap js for Bootstrap tooltip(in Advisory Committee) to work -->
	<script src='https://code.jquery.com/jquery-1.12.4.min.js'></script>
	<link rel='stylesheet' href='https://code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css'>
	<script src='https://code.jquery.com/ui/1.12.1/jquery-ui.min.js'></script>
	<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css'>
	<script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js'></script>
	<script src = './student_v1.js'></script>
        <!-- -->
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">
	<!-- BOOTSTRAP TABLE CDN -->
	<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.0/bootstrap-table.min.css'>
	<script src='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.0/bootstrap-table.min.js'></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/css/select2.min.css" />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/js/select2.min.js"></script>
	<!-- <script src=https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment.min.js"></script> -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.0/extensions/select2-filter/bootstrap-table-select2-filter.min.js"></script> 
	<script src="//rawgit.com/vitalets/x-editable/master/dist/bootstrap3-editable/js/bootstrap-editable.js"></script>
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.0/extensions/editable/bootstrap-table-editable.js"></script>
	
	<script>
		// var Asu_id = <?php echo $ASU_ID= $_GET['ID']; ?>;
		function displayHiddenCourseTable(){
			$('#coursesTable').show();
		}
	</script>
	
	
	
<style>
.content{
	padding-top: 5%;
	text-align: center;
    color: gray;
    text-shadow: 0px 4px 3px rgba(0,0,0,0.1),
                 0px 8px 13px rgba(0,0,0,0.1),
                 0px 18px 23px rgba(0,0,0,0.1);
}
.hide-calendar .ui-datepicker-calendar {
    display: none;
}
.star
{
  color:red;
}
.fixed-table-body {
    overflow-x: auto;
    overflow-y: auto;
    height: auto; /* auto */ 
}
.col-md-off-4 {
  margin-right: 25%;
  margin-left: 25%;
}
.alert {
  padding: 1px 35px 1px 1px;
  /*2px 35px 8px 14px;*/
}
hr{
	display: block;
	border-color: #428bca;
}
.pad{
  margin-left : 40px;
}
a {text-align:center;}
</style>
</head>

<!--
<body onload='setCourseTableTemplate_PY();AddCourses_PY(<?php echo json_encode($Course_details_PrevYears) ?>,<?php echo json_encode($Grade_details_PrevYears) ?>);setCourseTableTemplate();AddCourses(<?php echo json_encode($Course_details) ?>,<?php echo json_encode($Grade_details) ?>);setAdvisorTableTemplate();AddAdvisors(<?php echo json_encode($AdvisorPosition) ?>,<?php echo json_encode($AdvisorFirstName) ?>,<?php echo json_encode($AdvisorLastName) ?>,<?php echo json_encode($AdvisorEmailID) ?>);setQualifyingExamTableTemplate_PY();AddQualifyingSubjects_PY(<?php echo json_encode($Qualifying_subjects_PrevYears)?>,<?php echo json_encode($Qualifying_subjects_grades_PrevYears)?>);setQualifyingExamTableTemplate();resetQualifyingExamTable(<?php echo json_encode($Degree_program) ?>);AddQualifyingSubjects(<?php echo json_encode($Qualifying_subjects)?>,<?php echo json_encode($Qualifying_subjects_grades)?>);ChairMet(<?php echo json_encode($NotMetReason)?>);setComprehensiveExamTableTemplate_PY();AddComprehensiveExams_PY(<?php echo json_encode($ComprehensiveExamSubjects_PrevYears) ?>,<?php echo json_encode($ComprehensiveExamGrades_PrevYears) ?>);setComprehensiveExamTableTemplate();AddComprehensiveExams(<?php echo json_encode($ComprehensiveExamSubjects) ?>,<?php echo json_encode($ComprehensiveExamGrades) ?>);Check_Colloquium_Attended();setCurrentGoalsTableTemplate_PY();AddCurrentGoals_PY(<?php echo json_encode($Current_Goals_PrevYears) ?>);setCurrentGoalsTableTemplate();AddCurrentGoals(<?php echo json_encode($Current_Goals) ?>);setPublicationsTableTemplate_PY();AddPublications_PY(<?php echo json_encode($Publications_PrevYears) ?>);setPublicationsTableTemplate();AddPublications(<?php echo json_encode($Publications) ?>);setPresentationsTableTemplate_PY();AddPresentations_PY(<?php echo json_encode($Presentations_PrevYears) ?>);setPresentationsTableTemplate();AddPresentations(<?php echo json_encode($Presentations) ?>);setFutureGoalsTableTemplate_PY();AddFutureGoals_PY(<?php echo json_encode($Future_Goals_PrevYears) ?>);setFutureGoalsTableTemplate();AddFutureGoals(<?php echo json_encode($Future_Goals) ?>);'>
-->

<body onload='setCourseTableTemplate_PY();AddCourses_PY(<?php echo json_encode($Course_details_PrevYears) ?>,<?php echo json_encode($Grade_details_PrevYears) ?>);setCourseTableTemplate_PS();AddCourses_PS(<?php echo json_encode($Course_details) ?>,<?php echo json_encode($Grade_details) ?>);setCourseTableTemplate();setAdvisorTableTemplate_PS();AddAdvisors_PS(<?php echo json_encode($AdvisorPosition) ?>,<?php echo json_encode($AdvisorFirstName) ?>,<?php echo json_encode($AdvisorLastName) ?>,<?php echo json_encode($AdvisorEmailID) ?>);setAdvisorTableTemplate();setQualifyingExamTableTemplate_PY();AddQualifyingSubjects_PY(<?php echo json_encode($Qualifying_subjects_PrevYears)?>,<?php echo json_encode($Qualifying_subjects_grades_PrevYears)?>);setQualifyingExamTableTemplate_PS();AddQualifyingSubjects_PS(<?php echo json_encode($Qualifying_subjects)?>,<?php echo json_encode($Qualifying_subjects_grades)?>);setQualifyingExamTableTemplate();resetQualifyingExamTable(<?php echo json_encode($Degree_program) ?>);ChairMet(<?php echo json_encode($NotMetReason)?>);setComprehensiveExamTableTemplate_PY();AddComprehensiveExams_PY(<?php echo json_encode($ComprehensiveExamSubjects_PrevYears) ?>,<?php echo json_encode($ComprehensiveExamGrades_PrevYears) ?>);setComprehensiveExamTableTemplate_PS();AddComprehensiveExams_PS(<?php echo json_encode($ComprehensiveExamSubjects) ?>,<?php echo json_encode($ComprehensiveExamGrades) ?>);setComprehensiveExamTableTemplate();Check_Colloquium_Attended();setPublicationsTableTemplate_PY();AddPublications_PY(<?php echo json_encode($Publication_Name_PrevYears) ?>,<?php echo json_encode($Publication_Journal_Name_PrevYears) ?>,<?php echo json_encode($Publication_Status_PrevYears) ?>,<?php echo json_encode($Publication_DOI_PrevYears) ?>, <?php echo json_encode($Publication_URL_PrevYears) ?>);setPublicationsTableTemplate_PS();AddPublications_PS(<?php echo json_encode($Publication_Name) ?>,<?php echo json_encode($Publication_Journal_Name) ?>,<?php echo json_encode($Publication_Status) ?>,<?php echo json_encode($Publication_DOI) ?>, <?php echo json_encode($Publication_URL) ?>);setPublicationsTableTemplate();setPresentationsTableTemplate_PY();AddPresentations_PY(<?php echo json_encode($Presentation_Title_PrevYears) ?>,<?php echo json_encode($Presentation_Place_PrevYears) ?>,<?php echo json_encode($Presentation_Type_PrevYears) ?>);setPresentationsTableTemplate_PS();AddPresentations_PS(<?php echo json_encode($Presentation_Title) ?>,<?php echo json_encode($Presentation_Place) ?>,<?php echo json_encode($Presentation_Type) ?>);setPresentationsTableTemplate();setAwardsTableTemplate_PY();AddAwards_PY(<?php echo json_encode($Awards_PrevYears) ?>);setAwardsTableTemplate_PS();AddAwards_PS(<?php echo json_encode($Awards) ?>);setAwardsTableTemplate();'>

	<div class='container'>
		<div style="text-align: center;" class="col-md-12">
			<a href="https://math.asu.edu/" ><img src="asu.png" /></a>
		</div>
		<!-- HEADING -->
		<div class="content">
        <h1><center>SCHOOL OF MATHEMATICAL & STATISTICAL SCIENCES</center></h1>
		<h2><center>PhD Program Report Form</center></h2>
		</div>
        <br></br>
		
		<!-- FORM STARTS -->
		<form class='form-horizontal' role='form' method='POST'  id="progressReportForm" enctype='multipart/form-data'  action=''>
			<!-- INTRO SECTION-->
			<div class="panel panel-primary">
					<div class="panel-heading">Introductory Section</div>
					<div class="panel-body">
			
						<!-- SELECT DEGREE PROGRAM -->
						<div class="row">
							<div class='form-group' id='degree_program'>
								<div class="col-md-4 pad">
									<label class='control-label' for='degree_select'>Doctoral Degree Program<sup class='star'>*</sup></label>
								</div>							
								<div class='col-md-4'>
									<select class='form-control ' id='degree_select' name='degree_select' onchange='onDegreeProgramChange(<?php echo json_encode($Degree_program) ?>,<?php echo json_encode($Qualifying_subjects)?>,<?php echo json_encode($Qualifying_subjects_grades)?>)' <?php if($_GET['valid']==1) echo "style='background-color:#FCF5D8'" ?> required>
										<option disabled selected value=''> -- select a Degree Program -- </option>
										<?php foreach($degree_program_list as $degree_name)
											if($Degree_program===$degree_name)
												echo "<option value='$degree_name' selected>$degree_name</option>";
											else
												echo "<option value='$degree_name'>$degree_name</option>";
										?>
									</select>
									<div class="alert alert-danger alert-dismissible" id="degreeProgramAlertDiv" role="alert" style="display:none">
										<button type="button" class="alert-close close" ><span aria-hidden="true">&times;</span></button>
										<p id="degreeProgramAlertMsg"></p>
									</div>
							   </div>
							</div>
		                </div>
						<!-- END SELECT DEGREE PROGRAM>
		
						<!-- MASTERS IN PASSING -->
		                <div class="row">
							<div class="form-group">
						    	<div class="col-md-4 pad">
									<label class='control-label' for='MS_In_Passing'>Have you applied for Masters in Passing?<sup class='star'>*</sup></label>
								</div>		
			                    <div id='MS_In_Passing_div'> 
									<label class='control-label col-md-1'>Yes</label>
									<div class='col-md-1'>
										<input type='radio' name='MS_In_Passing' class='MS_In_Passing' onclick='MsInPassingChange()' id='MS_In_Passing_yes' value='1' <?php if($MS_In_Passing==='1')echo "checked='checked' "?>  >
									</div>

									<label class='control-label col-md-1'>No</label>
									<div class='col-md-1'>
										<input type='radio' name='MS_In_Passing' class='MS_In_Passing' onclick='MsInPassingChange()' id='MS_In_Passing_no' value='0' <?php if($MS_In_Passing==='0')echo "checked='checked' " ?> >
									</div>
									<div class="alert alert-danger alert-dismissible col-md-3" id="MsInPassingAlertDiv" role="alert" style="display:none">
										<button type="button" class="alert-close close" ><span aria-hidden="true">&times;</span></button>
										<p id="MsInPassingAlertMsg"></p>
									</div>
								</div>
							</div>
						</div>
						<!-- END MASTERS IN PASSING>
		
						<!-- Graduation Completed -->
		 				<div class="row">
							<div class="form-group">
								<div class="col-md-4 pad">
								<label class='control-label' for='Graduation_Completed'>Are you graduating this year(including summer)?<sup class='star'>*</sup></label>
								</div>						
									<div id='Graduation_Completed_div'> 
									<label class='control-label col-md-1'>Yes</label>
									<div class='col-md-1'>
										<input type='radio' name='Graduation_Completed' class='Graduation_Completed' onclick='GraduationCompletedChange()' id='Graduation_Completed_yes' value='1' <?php if($Graduation_Completed==='1')echo "checked='checked' "?>  >
									</div>

									<label class='control-label col-md-1'>No</label>
									<div class='col-md-1'>
										<input type='radio' name='Graduation_Completed' class='Graduation_Completed' onclick='GraduationCompletedChange()' id='Graduation_Completed_no' value='0' <?php if($Graduation_Completed==='0')echo "checked='checked' " ?>  >
									</div>
									<div class="alert alert-danger alert-dismissible col-md-3" id="GraduationCompletedAlertDiv" role="alert" style="display:none">
										<button type="button" class="alert-close close" ><span aria-hidden="true">&times;</span></button>
										<p id="GraduationCompletedAlertMsg"></p>
									</div>
								</div>	
							</div>
						</div>
						<!-- END GRADUATION COMPLETED -->
				</div>
				<!-- END PANEL BODY -->
			</div>
			<!-- END PANEL -->
			
			<!-- GRADUATION SURVEY -->
			<div id="survey_div" style="display: none;">
				<label><font size="2"><i><u>Please fill the survey below</u></i></font></label>
				<div class="panel panel-primary">
					<div class="panel-heading">Survey</div>
					<div class="panel-body">
					
						<!-- EMAIL-->
						<div class="form-group" >
							<div class="col-md-6">
								<!-- <label class='control-label' for='survey_email'>1. Please give us an email-id where you can be contacted after you leave ASU<sup class='star'>*</sup></label> -->
								<label class='control-label' for='survey_email'>1. Please give us an email-id where you can be contacted after you leave ASU</label>
							</div>
							<!--
							<div id='survey_email_div'> 
								<label class='control-label col-md-1'>Yes</label>
								<div class='col-md-1'>
									<input type='radio' name='survey_email' class='survey_email' onclick='SurveyEmail()' id='survey_email_yes' value='1'>
								</div>
			
								<label class='control-label col-md-1'>No</label>
								<div class='col-md-1'>
									<input type='radio' name='survey_email' class='survey_email' onclick='SurveyEmail()' id='survey_email_no' value='0'>
								</div>
								<div class="alert alert-danger alert-dismissible col-md-4" id="surveyEmailAlertDiv" role="alert" style="display:none">
									<button type="button" class="alert-close close" ><span aria-hidden="true">&times;</span></button>
									<p id="surveyEmailAlertMsg"></p>
								</div>
							</div>
							-->
							<div class='col-md-6' id='survey_email_text_div'>
								<input type='text' class='form-control' name='survey_email_text' id='survey_email_text' placeholder='Enter your email-id'>
							</div>
						</div>

										
						<!-- ALERT FOR NO Email-ID -->
						<div class="row">
							<div class="alert alert-danger alert-dismissible col-md-4" id="surveyEmailTextAlertDiv" role="alert" style="display:none">
								<button type="button" class="alert-close close" ><span aria-hidden="true">&times;</span></button>
								<p id="surveyEmailTextAlertMsg"></p>
							</div>
						</div>
						<!-- END ALERT -->
				

						
						
						<!-- END EMAIL-->
						
						<!-- EMPLOYMENT-->
						<div class="form-group" >
							<div class="col-md-6">
							<!--	<label class='control-label' for='survey_employment'>2. Do you have employment after graduation?<sup class='star'>*</sup></label> -->
								<label class='control-label' for='survey_employment'>2. Do you have employment after graduation?</label>
							</div>
							<!-- <label class='control-label col-md-2'></label> -->
							<div id='survey_employment_div'> 
								<label class='control-label col-md-1'>Yes</label>
								<div class='col-md-1'>
									<input type='radio' name='survey_employment' class='survey_employment' onclick='SurveyEmployment()' id='survey_employment_yes' value='1'>
								</div>
			
								<label class='control-label col-md-1'>No</label>
								<div class='col-md-1'>
									<input type='radio' name='survey_employment' class='survey_employment' onclick='SurveyEmployment()' id='survey_employment_no' value='0'>
								</div>
								<div class="alert alert-danger alert-dismissible col-md-4" id="surveyEmploymentAlertDiv" role="alert" style="display:none">
									<button type="button" class="alert-close close" ><span aria-hidden="true">&times;</span></button>
									<p id="surveyEmploymentAlertMsg"></p>
								</div>
							</div>
						</div>
											
						<!-- ALERT FOR NO Employment -->
						<div class="row">
							<div class="alert alert-danger alert-dismissible col-md-4" id="surveyEmploymentTextAlertDiv" role="alert" style="display:none">
								<button type="button" class="alert-close close" ><span aria-hidden="true">&times;</span></button>
								<p id="surveyEmploymentTextAlertMsg"></p>
							</div>
						</div>
						<!-- END ALERT -->
				
						<!-- Employment text area -->
						<div class="row">
							
							<div class='col-md-6' id='survey_employment_text_div' style='display: none;'>
								<input class='form-control' name='survey_employment_text' id='survey_employment_text' placeholder='Enter your employment information'/>
							</div>
							
						</div>
												
						<!-- END EMPLOYMENT-->
						
						<br>
						<div class="form-group" >
						 	
								<div class="col-md-4">
									<input type="submit" id='submit_survey' class='btn btn-success' onclick="SubmitSurvey()" value="SUBMIT">
								</div>
												
						</div>
					</div>
				</div>
			</div>
			<!-- END GRADUATION SURVEY -->
			
			<!-- SURVEY COMPLETED MSG -->
			<div id="survey_completed_div" style="display: none;">
				<label><font size="4"><i><u>Survey Completed! Please go ahead and fill your progress report below</u></i></font></label>
			</div>
			<!-- END SURVEY COMPLETED MSG -->
			<br>
			<!-- SECTION A STARTS -->
			<!-- <p><h3><b>Section A | Program of Study Status</b></h3></p> -->
			<div id="progress_report_div" <?php if($_GET['valid'] == 0) echo 'style="display: none;"'?>>
			<div class="panel panel-primary">
				<div class="panel-heading">Section A | Program of Study Status</div>
				<div class="panel-body">
					<!-- ACADEMIC YEAR -->
					<div class='form-group'>
						<div class="row">
						<div class="col-md-2 pad">
						<label class='control-label' >Academic year<sup class='star'>*</sup></label>
						</div>						
						<div class="col-md-1">					
						<label class='control-label col-md-1' for='academic_year_fall'>FALL</label>
						</div>						
						<div class='col-md-1'>
							<input type='text' class='form-control' id='academic_year_fall' name='academic_year_fall' data-calendar='false' <?php if($_GET['valid']==1)echo "style='background-color:#FCF5D8'";?> required disabled>
						</div>
						<div class="col-md-1">
						<label class='control-label' for='academic_year_spring'>SPRING</label>
						</div>	
						<div class='col-md-1'>
							<input type='text' class='form-control' id='academic_year_spring' name='academic_year_spring' data-calendar='false' <?php if($_GET['valid']==1){echo "style='background-color:#FCF5D8'";echo "value='$AcademicYear'";}?> required disabled>
						</div>
						<div class="alert alert-danger alert-dismissible col-md-3" id="academicYearAlertDiv" role="alert" style="display:none">
								<button type="button" class="alert-close close" ><span aria-hidden="true">&times;</span></button>
								<p id="academicYearAlertMsg"></p>
						</div>
						</div>	
					</div>
					<!-- FORM GROUP ENDS -->
			
					<!-- PERSONAL DETAILS -->
					<!-- NAME -->
					<div class="form-group">
					<div class="row">
						<div class="col-md-3 pad">
						<label class='control-label' for='first_name' >First Name<sup class='star'>*</sup></label>
						</div>						
						<div class='col-md-2'>          
							<input type='text' class='form-control' id='first_name' name='first_name' placeholder="Enter First Name" <?php if($_GET['valid']==1){echo "style='background-color:#FCF5D8'";echo "value='$FirstName'";}?> required>
						</div>
							
						<div class="col-md-2">
						<label class='control-label' for='second_name'>Last Name<sup class='star'>*</sup></label>
						</div>	
						<div class='col-md-2'>        
							<input type='text' class='form-control' id='second_name' name='second_name' placeholder="Enter Second Name" <?php if($_GET['valid']==1){echo "style='background-color:#FCF5D8'";echo "value='$SecondName'";}?> required>
						</div>
					</div>	
					</div>
					<!-- FORM GROUP ENDS -->
					
					<div class="row">
						<div class="alert alert-danger alert-dismissible col-md-4" id="firstNameAlertDiv" role="alert" style="display:none">
							<button type="button" class="alert-close close" ><span aria-hidden="true">&times;</span></button>
							<p id="firstNameAlertMsg"></p>
						</div>
						<div class="alert alert-danger alert-dismissible col-md-4" id="lastNameAlertDiv" role="alert" style="display:none">
							<button type="button" class="alert-close close" ><span aria-hidden="true">&times;</span></button>
							<p id="lastNameAlertMsg"></p>
						</div>
					</div>
			
					<!-- ACADEMIC INFROMATION -->
					<div class="form-group">
					<div class="row">
						<div class="col-md-3 pad">	
						<label class='control-label' for='asu_id'>ASU ID/Student ID Number<sup class='star'>*</sup></label>
						</div>
						<div class='col-md-2'>          
							<input type='text' class='form-control' id='asu_id' name='asu_id' placeholder="ASU ID/Student ID" <?php if($_GET['valid']==1){echo "style='background-color:#FCF5D8'";echo "value='$ASU_ID'";}?> required>
						</div> 
						<div class="col-md-2">
						<label class='control-label' for='student_mail'>ASURITE ID:<sup class='star'>*</sup></label>
						</div>
						<div class='col-md-2'>
							<input type='text' class='form-control' id='student_mail' name='student_mail' placeholder="Student ASURITE ID" <?php if($_GET['valid']==1){echo "style='background-color:#FCF5D8'";echo "value='$ASURITE'";}?> required>
						</div>
					</div>
					</div>
					<!-- FORM GROUP ENDS -->
					
					<div class="row">
						<div class="alert alert-danger alert-dismissible col-md-4" id="asuIDAlertDiv" role="alert" style="display:none">
							<button type="button" class="alert-close close" ><span aria-hidden="true">&times;</span></button>
							<p id="asuIDAlertMsg"></p>
						</div>
						<div class="alert alert-danger alert-dismissible col-md-4" id="asuriteIDAlertDiv" role="alert" style="display:none">
							<button type="button" class="alert-close close" ><span aria-hidden="true">&times;</span></button>
							<p id="asuriteIDAlertMsg"></p>
						</div>
					</div>
					
					<div class="form-group">
						<div class="row">
							<div class="col-md-3 pad">
								<label class='control-label' for='prog_start_date' >Program Start Date:<sup class='star'>*</sup></label>
							</div>
							<div class='col-md-2'>          
								<input type='text' class='form-control' id='prog_start_date' name='prog_start_date' data-calendar='false' <?php if($_GET['valid']==1){echo "style='background-color:#FCF5D8'";echo "value='$ProgramStart'";}?> required>
							</div>
							<div class="col-md-2">
								<label class='control-label' for='sem_in_prog'>Semester in Progress<sup class='star'>*</sup></label>
							</div>
							<div class='col-md-2'>          
								<select class='form-control' id='sem_in_prog' name='sem_in_prog' <?php if($_GET['valid']==1) echo"style='background-color:#FCF5D8'";?> required>
									<option disabled selected value='-1'> Current Semester</option>
										<?php foreach($semester_number_list as $semester_number)
											if($SemesterProgress===$semester_number)
												echo "<option value='$semester_number' selected>$semester_number</option>";
											else
												echo "<option value='$semester_number'>$semester_number</option>";
										?>
								</select>     
							</div>
						</div>
					</div>
					<!-- FORM GROUP ENDS -->
					
					<div class="row">
						<div class="alert alert-danger alert-dismissible col-md-4" id="pgmStartDateAlertDiv" role="alert" style="display:none">
							<button type="button" class="alert-close close" ><span aria-hidden="true">&times;</span></button>
							<p id="pgmStartDateAlertMsg"></p>
						</div>
						<div class="alert alert-danger alert-dismissible col-md-4" id="semInProgressAlertDiv" role="alert" style="display:none">
							<button type="button" class="alert-close close" ><span aria-hidden="true">&times;</span></button>
							<p id="semInProgressAlertMsg"></p>
						</div>
					</div>
					
					<div class="form-group">
						<div class="row">
							<div class="col-md-3 pad">					
								<label class='control-label' for='cumulative_gpa'>Cumulative GPA:<sup class='star'>*</sup></label>
							</div>					
							<div class='col-md-2'>          
									<input type='text' class='form-control' id='cumulative_gpa' name='cumulative_gpa' <?php if($_GET['valid']==1){echo "style='background-color:#FCF5D8'"; echo "value='$CGPA'";}?> required>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="alert alert-danger alert-dismissible col-md-4" id="cumGPAAlertDiv" role="alert" style="display:none">
							<button type="button" class="alert-close close" ><span aria-hidden="true">&times;</span></button>
							<p id="cumGPAAlertMsg"></p>
						</div>
					</div>
					
					<hr> 
					
					<!-- COURSES -->
					
					<!-- PREVIOUS YEARS -->
					<div class="form-group">
						
						<label><font size="2"><i><u>These are the courses you have taken previously</u></i></font></label>
											
						<div class="table-responsive">
							<table id="coursesTable_PY">
								<thead>
								<tr>
									<th data-formatter="getRowIndex_PY" style="width: 36px;"></th>
									<th data-field="courseUniqueID_PY" visible="false"></th>
									<th data-field="course_PY" data-title="Course"/>
									<th data-field="grade_PY" data-title="Grade"/>
								</tr>
								</thead>
							</table>
						</div>
					</div>
					<!-- END PREVIOUS YEARS -->
					
					<!-- CURRENT YEAR PREVIOUS SUBMISSION -->
					<?php if(count($Course_details) > 0)
					echo '<div class="form-group">
						<label><font size="2"><i><u>Courses for the current year</u></i></font></label>
						<div class="table-responsive">
							<table id="coursesTable_PS">
								<thead>
								<tr>
									<th data-formatter="getRowIndex_PS" style="width: 36px;"></th>
									<th data-field="courseUniqueID_PS" visible="false"></th>
									<th data-field="course_PS" data-title="Course"/>
									<th data-field="grade_PS" data-title="Grade"/>
								</tr>
								</thead>
							</table>
						</div>
					</div>';
					?>
					<!-- END CURRENT YEAR PREVIOUS SUBMISSION -->
					
					<!-- COURSE FOR CURRENT AY -->
					<div class="form-group">
				
						<label class='control-label col-md-4' for='course_currentAY'>Did you take courses in the current year?<sup class='star'>*</sup></label>
						<div id='course_currentAY_div'> 
							<label class='control-label col-md-1'>Yes</label>
							<div class='col-md-1'>
								<input type='radio' name='course_currentAY' class='course_currentAY' onclick='AddCourseCurrentAY()' id='course_currentAY_yes' value='1'>
							</div>
			
							<label class='control-label col-md-1'>No</label>
							<div class='col-md-1'>
								<input type='radio' name='course_currentAY' class='course_currentAY' onclick='AddCourseCurrentAY()' id='course_currentAY_no' value='0' 
								rel="courseCurrentAYTooltip" data-toggle="tooltip" title="Remove all Courses to select No">
							</div>
							<div class="alert alert-danger alert-dismissible col-md-3" id="courseCurrentAYAlertDiv" role="alert" style="display:none">
								<button type="button" class="alert-close close" ><span aria-hidden="true">&times;</span></button>
								<p id="courseCurrentAYAlertMsg"></p>
							</div>
						</div>
					</div>
					<!-- FORM GROUP ENDS -->
					
					<!-- ALERT FOR NO COURSE ADDED -->
					<div class="row">
						<div class="alert alert-danger alert-dismissible col-md-4" id="courseTableAlertDiv" role="alert" style="display:none">
							<button type="button" class="alert-close close" ><span aria-hidden="true">&times;</span></button>
							<p id="courseTableAlertMsg"></p>
						</div>
					</div>
					<!-- END ALERT -->
					
					<!-- REASON FOR NO COURSE IN CURRENT AY -->
					<div class="row">
						<div id="NoCourseReason_parentDiv" style="display:none">
							<label class='control-label col-md-4' for='NoCourseReason'>Reason for not completing any course in this year<sup class='star'>*</sup></label>
							<div class='col-md-8' id='NoCourseReason_div'>
								<textarea class='form-control' name='NoCourseReason' id='NoCourseReason' <?php if($_GET['valid']==1) echo "style='background-color:#FCF5D8;'"; ?>><?php if(count($Course_details)==0) echo $NoCourseReason; ?></textarea>
							</div>
						</div>
					</div>
					
					<!-- CURRENT YEAR NEW SUBMISSION-->
					<div class="form-group" id="courses_currentAY" style="display: none;">
						
						<div class="table-responsive">
							<table id="coursesTable">
								<thead>
								<tr>
									<th data-field="selectBoxCourse" style="display:none;"></th>
									<th data-formatter="getRowIndex" style="width: 36px;"></th>
									<th data-field="courseUniqueID" visible="false"></th>
									<th data-field="course" data-title="Course<span class='glyphicon glyphicon-info-sign'></span>" data-title-tooltip="Courses taken since last progress with grades" data-editable="true"/>
									<th data-field="grade" data-title="Grade" data-editable="true"/>
								</tr>
								</thead>
							</table>
						</div>
				
						<!-- ADD / REMOVE COURSES -->
						<div class='btn-group-horizontal'>
							<button type='button' class='btn btn-primary' data-toggle="modal" data-target="#addCourseModal" onclick="displayHiddenCourseTable()">Add Course</button>
							<button type='button' class='btn btn-primary' onclick="removeCourseRow()">Remove Course</button>
						</div>
				
						<!-- ADD COURSE MODAL -->
						<div id="addCourseModal" class="modal fade" role="dialog">
						  <div class="modal-dialog">

							<!-- Modal content-->
							<div class="modal-content">
							  <div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h4 class="modal-title">Add Course</h4>
							  </div>
							  <div class="modal-body">
								<form role="form" id="addCourseForm">
									<div class="form-group">
										<label for="courseTitle">Course</label>
										<input type="text" class="form-control" id="courseTitle" placeholder="Enter the name of the course" required>
									</div>
									<div class="row">
										<div class="alert alert-danger alert-dismissible col-md-5" id="courseTitleAlertDiv" role="alert" style="display:none">
											<p id="courseTitleAlertMsg"></p>
										</div>
									</div>
									
									<div class="form-group">
										<label for="courseGrade">Grade</label>
										<select class="form-control" id="courseGrade" name="courseGrade" required>
											<option disabled selected value='-1'> Please select the grade</option>
											<?php foreach($grade_list as $grade)
												echo "<option value='$grade'>$grade</option>";
											?>
										</select>
									</div>
									
									<div class="row">
										<div class="alert alert-danger alert-dismissible col-md-5" id="courseGradeAlertDiv" role="alert" style="display:none">
											<p id="courseGradeAlertMsg"></p>
										</div>
									</div>
									
								
								</form>
							  </div>
							  <div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
								<button type="button" class="btn btn-success" form="addCourseForm" onclick="addCourseRow()">OK</button>
								<!-- <input type="submit" class="btn btn-success" form="addCourseForm" data-dismiss="modal" onclick="addCourseRow()" value="OK"> -->
							  </div>
							</div>

						  </div>
						</div>
					</div>
					<!-- END CURRENT YEAR NEW SUBMISSION-->
					<!-- FORM GROUP ENDS -->
					
					<hr>
					
					<!-- ADVISORY COMMITTEE -->
					
					<!-- PREV SUBMISSION ADVISORY COMMITTEE TABLE -->
					<?php if($AdvisoryComPresent==='1') 
					echo '<div class="form-group">
						<label><font size="2"><i><u>Advisory Committee for the current year</u></i></font></label>	
						<div class="table-responsive" style="display:none" id="advisor_member_PS_div">
							<table id="advisorTable_PS">
								<thead>
									<tr>
										<th data-formatter="getRowIndex_PS" style="width: 36px;"></th>
										<th data-field="advisorUniqueID_PS" visible="false"></th>
										<th data-field="advisorType_PS" data-title="Chair/Co-Chair/Member"></th>
										<th data-field="advisorFirstName_PS" data-title="First Name"></th>
										<th data-field="advisorLastName_PS" data-title="Last Name"></th>
										<th data-field="advisorEmailID_PS" data-title="E-mail ID"></th>
									</tr>
								</thead>
							</table>
						</div>
					</div>'
					?>
					
					<div class="form-group">
				
							<label class='control-label col-md-4' for='advisory_committee'>Do you have an advisor?<sup class='star'>*</sup></label>
							<div id='adv_committee'> 
								<label class='control-label col-md-1'>Yes</label>
								<div class='col-md-1'>
									<input type="radio"	name='advisory_committee' class='advisory_committee' onclick='AdvisoryCommitteeFormed()' id='advisory_committee_yes' value='1'>
								</div>
				
								<label class='control-label col-md-1'>No</label>
								<div class='col-md-1'>
									<input type='radio' name='advisory_committee' class='advisory_committee' onclick='AdvisoryCommitteeFormed()' id='advisory_committee_no' value='0' 
									rel="advCommTooltip" data-toggle="tooltip" title="Remove all Advisors to select No" >
								</div>
								<div class="alert alert-danger alert-dismissible col-md-3" id="advisorCommitteeAlertDiv" role="alert" style="display:none">
									<button type="button" class="alert-close close" ><span aria-hidden="true">&times;</span></button>
									<p id="advisorCommitteeAlertMsg"></p>
								</div>
							</div>
					</div>
					<!-- FORM GROUP ENDS -->
					
					<div class="row">
						<div class="alert alert-danger alert-dismissible col-md-6" id="advisorTableAlertDiv" role="alert" style="display:none">
							<button type="button" class="alert-close close" ><span aria-hidden="true">&times;</span></button>
							<p id="advisorTableAlertMsg"></p>
						</div>
					</div>
					
					<!-- REASON FOR NO ADVISORY COMMITTEE IN CURRENT AY -->
					<div class="row">
						<div id="NoAdvCommReason_parentDiv" style="display:none">
							<label class='control-label col-md-4' for='NoAdvCommReason_div'>Reason for not having an Advisory Committee<sup class='star'>*</sup></label>
							<div class='col-md-8' for='NoAdvCommReason_div'>
								<textarea class='form-control' name='NoAdvCommReason_div' id='NoAdvCommReason_div' <?php if($_GET['valid']==1) echo "style='background-color:#FCF5D8;'"; ?>><?php if(count($AdvisorPosition)==0) echo $NoAdvCommReason; ?></textarea>
							</div>
						</div>
					</div>
					
					
					<!-- ADVISORY COMMITTEE TABLE -->
					<div class="form-group" id="advisor_member_div" style="display:none">	
							<div class="table-responsive">
								<table id="advisorTable">
									<thead>
									<tr>
										<th data-field="selectBoxAdvisor">
										<th data-formatter="getRowIndex" style="width: 36px;"></th>
										<th data-field="advisorUniqueID" visible="false"></th>
										<th data-field="advisorType" data-title="Chair/Co-Chair/Member" data-editable="true"></th>
										<th data-field="advisorFirstName" data-title="First Name" data-editable="true"></th>
										<th data-field="advisorLastName" data-title="Last Name" data-editable="true"></th>
										<th data-field="advisorEmailID" data-title="E-mail ID"></th>
									</tr>
									</thead>
								</table>
					
					
							<!-- ADD /REMOVE ADVISORS -->
							<div class='btn-group-horizontal'>
								<button type='button' class='btn btn-primary' data-toggle="modal" data-target="#addAdvisorModal">Add Advisors</button>
								<button type='button' class='btn btn-primary' onclick="removeAdvisorRow()">Remove Advisors</button>
							</div>
					
							<!-- ADD ADVISOR MODAL -->
							<div id="addAdvisorModal" class="modal fade" role="dialog">
							  <div class="modal-dialog">

								<!-- Modal content-->
								<div class="modal-content">
								  <div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h4 class="modal-title">Add Advisor</h4>
								  </div>
								  <div class="modal-body">
									<form role="form" id="addAdvisorForm">
										<div class="form-group">
											<label for="advisorModalPosition">Advisor Position</label>
											<select class="form-control" id="advisorModalPosition" name="advisorModalPosition" required>
												<option disabled selected value='-1'> Please select advisor position</option>
												<?php foreach($advisor_position_list as $advisor_position)
													echo "<option value='$advisor_position'>$advisor_position</option>";
												?>
											</select>
										</div>
										<div class="row">
											<div class="alert alert-danger alert-dismissible col-md-6" id="advisorPositionAlertDiv" role="alert" style="display:none">
												<p id="advisorPositionAlertMsg"></p>
											</div>
										</div>
										
										<div class="form-group">
											<label for="advisorModalFName">First Name</label>
											<input type="text" class="form-control" id="advisorModalFName" placeholder="Enter the first name of the advisor" required>
										</div>
										<div class="row">
											<div class="alert alert-danger alert-dismissible col-md-6" id="advisorFNameAlertDiv" role="alert" style="display:none">
												<p id="advisorFNameAlertMsg"></p>
											</div>
										</div>
										
										<div class="form-group">
											<label for="advisorModalLName">Last Name</label>
											<input type="text" class="form-control" id="advisorModalLName" placeholder="Enter the last name of the advisor" required>
										</div>
										<div class="row">
											<div class="alert alert-danger alert-dismissible col-md-6" id="advisorLNameAlertDiv" role="alert" style="display:none">
												<p id="advisorLNameAlertMsg"></p>
											</div>
										</div>
										
										<div class="form-group">
											<label for="advisorModalEmailID">E-mail ID</label>
											<input type="email" class="form-control" id="advisorModalEmailID" placeholder="Enter the e-mail id of the advisor" required>
										</div>
										<div class="row">
											<div class="alert alert-danger alert-dismissible col-md-6" id="advisorEmailIDAlertDiv" role="alert" style="display:none">
												<p id="advisorEmailIDAlertMsg"></p>
											</div>
										</div>
										
										<div class="form-group">
											<label for="advisorModalConfirmEmailID">Confirm E-mail ID</label>
											<input type="email" class="form-control" id="advisorModalConfirmEmailID" placeholder="Re-enter the e-mail id of the advisor" onpaste="return false;" required>
										</div>
										<div class="row">
											<div class="alert alert-danger alert-dismissible col-md-6" id="advisorConfirmEmailIDAlertDiv" role="alert" style="display:none">
												<p id="advisorConfirmEmailIDAlertMsg"></p>
											</div>
										</div>
										
									</form>
								  </div>
								  <div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
									<button type="button" class="btn btn-success" form="addAdvisorForm" onclick="addAdvisorRow()">OK</button>
								  </div>
								</div>

							  </div>
							</div>
							<!-- MODAL ENDS -->
							</div>
				
					</div>
					<!-- FORM GROUP ENDS -->
					
					<!-- STUDENT MET CHAIR -->
					<div class='form-group'>
						<div class="row">
							<label class='control-label col-md-4' for='advisor'> Have you met your advisor during this academic year?<sup class='star'>*</sup></label>
							<div id='advisor'>
								<label class='control-label col-md-1'>Yes</label>
								<div class='col-md-1'>
									<input type='radio' name='met_advisor' onclick='ChairMet(<?php echo json_encode($NotMetReason) ?>)' id='committee_formed_yes' class='met_advisor' value='1' <?php if($MetChair==='1') echo "checked='checked'" ?>>
								</div>
								<label class='control-label col-md-1'>No</label>
								<div class='col-md-1'>
									<input type='radio' name='met_advisor' onclick='ChairMet(<?php echo json_encode($NotMetReason) ?>)' id='committee_formed_no' class='met_advisor' value='0' <?php if($MetChair==='0') echo "checked='checked'" ?>>
								</div>
								<div class="alert alert-danger alert-dismissible col-md-3" id="chairNotMetAlertDiv" role="alert" style="display:none">
									<button type="button" class="alert-close close" ><span aria-hidden="true">&times;</span></button>
									<p id="chairNotMetAlertMsg"></p>
								</div>
							</div>
						</div>
						
						<!-- STUDENT NOT MET CHAIR REASON -->
						<div class="row">
							<div id="NotMetChairReason_div" style="display:none">
								<label class='control-label col-md-4' for='chair_notmet_reason'>Reason for not meeting the advisor<sup class='star'>*</sup></label>
								<div class='col-md-8' for='chair_notmet_reason'>
									<textarea class='form-control' name='chair_notmet_reason' id='chair_notmet_reason' <?php if($_GET['valid']==1) echo "style='background-color:#FCF5D8;'"; ?> required><?php if($MetChair==='0') echo $NotMetReason; ?></textarea>
								</div>
							</div>
						</div>
						
					</div>
					<!-- FORM GROUP ENDS -->
					
					<div class="row">
							<div class="alert alert-danger alert-dismissible col-md-offset-4 col-md-6" id="chairNotMetReasonAlertDiv" role="alert" style="display:none">
								<button type="button" class="alert-close close" ><span aria-hidden="true">&times;</span></button>
								<p id="chairNotMetReasonAlertMsg"></p>
							</div>			
					</div>
					
				</div>
				<!-- PANEL BODY ENDS -->
			</div>
			<!-- PANEL A ENDS -->
			
			<!-- PANEL B STARTS -->
			<div class="panel panel-primary">
				<div class="panel-heading">Section B | Student's Progress</div>
				<div class="panel-body">
				
					<!-- QUALIFYING EXAM -->
					
					<!-- Qualifying Exams Completed during previous years -->
					<div class="form-group">
						<label><font size='2'><i><u>These are the Qualifying Exams passed previously</u></i></font></label>
						<table id="qualifying_subject_table_PY">
							<thead>
							<tr>
								<th data-formatter="getRowIndex" style="width: 36px;"></th>
								<th data-field="qualSubUniqueID_PY" visible="false"></th>
								<th data-field="qualifyingSubject_PY" data-title="Qualifying Exam Subject">
								<th data-field="qualifyingSubjectGrade_PY" data-title="Grade">
							</tr>
							</thead>
						</table>
					</div>
					
					<!-- Qualifying Exams for current year -->
					
					<!-- PREV SUBMISSION FOR CURRENT YEAR -->
					<?php if($QualExamComp==='1')
					echo '<div class="form-group">
						<label><font size="2"><i><u>These are the Qualifying Exams you have passes previously</u></i></font></label>
						<div class="table-responsive" id="qualifying_exam_subjects_div_PS">	
					
							<table id="qualifying_subject_table_PS">
								<thead>
								<tr>
									<th data-formatter="getRowIndex" style="width: 36px;"></th>
									<th data-field="qualSubUniqueID_PS" visible="false"></th>
									<th data-field="qualifyingSubject_PS" data-title="Qualifying Exam Subject">
									<th data-field="qualifyingSubjectGrade_PS" data-title="Grade">
								</tr>
								</thead>
							</table>
						</div>
					</div>';
					?>
					
					<div class="form-group">
						<div class="row">
							<label class='control-label col-md-4' for='qualifying_exam_completed'>Did you take any Qualifying Exams in the current year?<sup class='star'>*</sup></label>
							<div id='qualifying_exam_completed'>
								<label class='control-label col-md-1'>Yes</label>
								<div class='col-md-1'>
									<input type='radio' name='qualifying_exam_completed' id='exam_yes' class='qualifying_exam_completed' onclick='qualifyingExamTable();resetQualifyingExamTable(<?php echo json_encode($Degree_program) ?>);' value='1'>
								</div>
							
								<label class='control-label col-md-1'>No</label>
								<div class='col-md-1'>
									<input type='radio' name='qualifying_exam_completed' id='exam_no' class='qualifying_exam_completed' onclick='qualifyingExamTable()' value='0' rel="qualExamTooltip" data-toggle="tooltip" title="Remove all Exams to select No">
								</div>
								
								<div class="alert alert-danger alert-dismissible col-md-3" id="qualExamAlertDiv" role="alert" style="display:none">
									<button type="button" class="alert-close close" ><span aria-hidden="true">&times;</span></button>
									<p id="qualExamAlertMsg"></p>
								</div>   
							</div>
						</div>
					</div>
						
					<div class="row">
						<div class="alert alert-danger alert-dismissible col-md-7" id="qualExamTableAlertDiv" role="alert" style="display:none">
							<button type="button" class="alert-close close" ><span aria-hidden="true">&times;</span></button>
							<p id="qualExamTableAlertMsg"></p>
						</div>
					</div>
						
					<div class="form-group">
						<div class="table-responsive" id="qualifying_exam_subjects_div" style="display:none">
							
							
								<table id="qualifying_subject_table">
									<thead>
									<tr>
										<th data-field="selectBoxQualifyingExam"></th>
										<th data-formatter="getRowIndex" style="width: 36px;"></th>
										<th data-field="qualSubUniqueID" visible="false"></th>
										<th data-field="qualifyingSubject" data-title="Qualifying Exam Subject" data-editable="true">
										<th data-field="qualifyingSubjectGrade" data-title="Grade" data-editable="true">
									</tr>
									</thead>
								</table>
								
								<!-- ADD /REMOVE QUALIFYING SUBJECTS -->
								<div class='btn-group-horizontal'>
									<button type='button' class='btn btn-primary' data-toggle="modal" data-target="#addQualSubjectModal">Add Qualifying Subject/Course</button>
									<button type='button' class='btn btn-primary' onclick="removeQualSubjectRow()">Remove</button>
								</div>
					
								<!-- ADD QUALIFYING SUBJECT MODAL -->
								<div id="addQualSubjectModal" class="modal fade" role="dialog">
								  <div class="modal-dialog">

									<!-- Modal content-->
									<div class="modal-content">
									  <div class="modal-header">
										<button type="button" class="close" data-dismiss="modal">&times;</button>
										<h4 class="modal-title">Add Qualifying Subject/Course</h4>
									  </div>
									  <div class="modal-body">
										<form role="form" id="addQualSubjectForm">
											<div class="form-group">
												<label for="selectQualSubject">Qualifying Subject/Course</label>
												<select class="form-control" id="selectQualSubject" name="selectQualSubject" style="width: 100%" required>
													<!-- <option disabled selected value='-1'> Please select a subject</option> -->
												</select>
											</div>
											<div class="row">
												<div class="alert alert-danger alert-dismissible col-md-6" id="selectQualSubjectAlertDiv" role="alert" style="display:none">
													<p id="selectQualSubjectAlertMsg"></p>
												</div>
											</div>
											<div class="form-group">
												<label for="selectQualGrade">Grade</label>
												<select class="form-control" id="selectQualGrade" name="selectQualGrade" style="width: 100%" required>
													<!-- <option disabled selected value='-1'> Please select a grade</option> -->
												</select>
											</div>
											<div class="row">
												<div class="alert alert-danger alert-dismissible col-md-6" id="selectQualGradeAlertDiv" role="alert" style="display:none">
													<p id="selectQualGradeAlertMsg"></p>
												</div>
											</div>
										</form>
									  </div>
									  <div class="modal-footer">
										<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
										<button type="button" class="btn btn-success" form="addQualSubjectForm" onclick="addQualSubjectRow()">OK</button>
									  </div>
									</div>

								  </div>
								</div>
								<!-- MODAL ENDS -->
							
							
						</div>
					</div>
					<!-- FORM GROUP ENDS -->
					
					<hr>
					
					<!--WRITTEN COMPREHENSIVE EXAM -->
					
					<!-- Written Comprehensive Exams Completed during previous years -->
					<div class="form-group">
						<label><font size='2'><i><u>These are the Written Comprehensive Exams you have passed previously</u></i></font></label>
						<table id="comprehensiveExamTable_PY">
							<thead>
							<tr>
								<th data-formatter="getRowIndex" style="width: 36px;"></th>
								<th data-field="compExamUniqueID_PY" visible="false"></th>
								<th data-field="comprehensiveExam_PY" data-title="Written Comprehensive Exam">
								<th data-field="compExamGrade_PY" data-title="Grade">
							</tr>
							</thead>
						</table>
					</div>
					
					<!--Written Comprehensive Exams for current year-->
					
					<!-- PREV SUBMISSION FOR CURRENT YEAR -->
					<?php if($ComprehensiveExamCompleted==='1')
					echo '<div class="form-group">
						<label><font size="2"><i><u>Written Comprehensive Exams completed during current year</u></i></font></label>
							<table id="comprehensiveExamTable_PS">
								<thead>
								<tr>
									<th data-formatter="getRowIndex" style="width: 36px;"></th>
									<th data-field="compExamUniqueID_PS" visible="false"></th>
									<th data-field="comprehensiveExam_PS" data-title="Written Comprehensive Exam">
									<th data-field="compExamGrade_PS" data-title="Grade">
								</tr>
								</thead>
							</table>
					</div>';
					?>
					
					<div class="form-group">
						<div class="row">
							<label class='control-label col-md-4' for='comprehensive_exam'>Did you take any Written Comprehensive Exams in the current year?<sup class='star'>*</sup></label>
							<div id='adv_committee'> 
							<label class='control-label col-md-1'>Yes</label>
							<div class='col-md-1'>
								<input type='radio' name='comprehensive_exam' onclick='ComprehensiveExamCompleted()' id='comprehensive_exam_yes' value='1'>
							</div>
			
							<label class='control-label col-md-1'>No</label>
							<div class='col-md-1'>
								<input type='radio' name='comprehensive_exam' onclick='ComprehensiveExamCompleted()' id='comprehensive_exam_no' value='0' 
								rel="compExamTooltip" data-toggle="tooltip" title="Remove all Exams to select No">
							</div>
							</div>
							<div class="alert alert-danger alert-dismissible col-md-3" id="compExamAlertDiv" role="alert" style="display:none">
									<button type="button" class="alert-close close" ><span aria-hidden="true">&times;</span></button>
									<p id="compExamAlertMsg"></p>
							</div> 
						</div>
					</div>
						
						<div class="row">
							<div class="alert alert-danger alert-dismissible col-md-8" id="compExamTableAlertDiv" role="alert" style="display:none">
								<button type="button" class="alert-close close" ><span aria-hidden="true">&times;</span></button>
								<p id="compExamTableAlertMsg"></p>
							</div>
						</div>
					
						<!--COMPREHENSIVE EXAM TABLE -->
						<div class="form-group">
					
							<div class="table-responsive" id="comprehensive_exam_div" style="display:none">
								
								<table id="comprehensiveExamTable">
									<thead>
									<tr>
										<th data-field="selectBoxComprehensiveExam">
										<th data-formatter="getRowIndex" style="width: 36px;"></th>
										<th data-field="compExamUniqueID" visible="false"></th>
										<th data-field="comprehensiveExam" data-title="Written Comprehensive Exam" data-editable="true">
										<th data-field="compExamGrade" data-title="Grade" data-editable="true">
									</tr>
									</thead>
								</table>
				
								<!-- ADD / REMOVE EXAM SUBJECTS -->
								<div class='btn-group-horizontal'>
									<button type='button' class='btn btn-primary' data-toggle="modal" data-target="#addCompExamModal"">Add Written Comp Subjects</button>
									<button type='button' class='btn btn-primary' onclick="removeComprehensiveExamRow()">Remove Subjects</button>
								</div>
				
								<!-- ADD EXAM SUBJECT MODAL -->
								<div id="addCompExamModal" class="modal fade" role="dialog">
								  <div class="modal-dialog">

									<!-- Modal content-->
									<div class="modal-content">
									  <div class="modal-header">
										<button type="button" class="close" data-dismiss="modal">&times;</button>
										<h4 class="modal-title">Add Comprehensive Exam Subject</h4>
									  </div>
									  <div class="modal-body">
										<form role="form" id="addCompExamForm">
											<div class="form-group">
												<label for="compSubjectTitle">Subject</label>
												<input type="text" class="form-control" id="compSubjectTitle" placeholder="Enter the name of the subject" required />
											</div>
											
											<div class="row">
												<div class="alert alert-danger alert-dismissible col-md-6" id="compSubjectAlertDiv" role="alert" style="display:none">
													<p id="compSubjectAlertMsg"></p>
												</div>
											</div>
											
											<div class="form-group">
												<label for="subjectGrade">Grade</label>
												<select class="form-control" id="compSubjectGrade" name="subjectGrade" required>
													<option disabled selected value='-1'> Please select the grade</option>
													<?php foreach($comprehensive_exam_grade_list as $grade)
														echo "<option value='$grade'>$grade</option>";
													?>
												</select>
											</div>
											
											<div class="row">
												<div class="alert alert-danger alert-dismissible col-md-6" id="compSubjectGradeAlertDiv" role="alert" style="display:none">
													<p id="compSubjectGradeAlertMsg"></p>
												</div>
											</div>
										</form>
									  </div>
									  <div class="modal-footer">
										<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
										<button type="button" class="btn btn-success" form="addCompExamForm" id="compExamModalSubmit" onclick="addComprehensiveExamRow()">OK</button>
									  </div>
									</div>

								  </div>
								</div>
								<!-- MODAL ENDS -->
							
						</div>
					</div>
					<!--FORM GROUP ENDS -->
					
					<hr>
										
					<!-- DISSERTATION PROSPECTUS -->
					<div class='form-group'  id='dissertation_prosectus_div'>
						<div class="row">
							<label class='control-label col-md-4' for='dissertation_prosectus'>Have you completed Dissertation Prospectus?<sup class='star'>*</sup></label>

							<label class='control-label col-md-1'>Yes</label>
							<div class='col-md-1'>
								<input type='radio' name='dissertation_prosectus' id='dissertation_prosectus' onclick="dissertationProspectus()" value='1' <?php if($DissertationProspectus==='1')echo "checked='checked' " ?>  >
							</div>

							<label class='control-label col-md-1'>No</label>
							<div class='col-md-1'>
								<input type='radio' name='dissertation_prosectus' id='dissertation_prosectus' onclick="dissertationProspectus()" value='0' <?php if($DissertationProspectus==='0')echo "checked='checked' " ?>  >
							</div>
							<div class="alert alert-danger alert-dismissible col-md-3" id="dissertationAlertDiv" role="alert" style="display:none">
									<button type="button" class="alert-close close" ><span aria-hidden="true">&times;</span></button>
									<p id="dissertationAlertMsg"></p>
							</div>
						
						</div>					
					
						<!-- COLLOQUIUM ATTENDED -->
						<div class="row">
							<label class='control-label col-md-4' for='colloquium'>Have you attended any Colloquium/Distinguished Lecture Series?<sup class='star'>*</sup></label>

							<label class='control-label col-md-1'>Yes</label>
							<div class='col-md-1'>
								<input type='radio' name='colloquium' id='colloquium_yes' class='colloquium' onclick='Check_Colloquium_Attended()' value='1' <?php if($Colloquium_Attended==='1')echo "checked='checked' " ?> >
							</div>
						
							<label class='control-label col-md-1'>No</label>
							<div class='col-md-1'>
								<input type='radio' name='colloquium' id='colloquium_no' class='colloquium' onclick='Check_Colloquium_Attended()' value='0' <?php if($Colloquium_Attended==='0')echo "checked='checked' " ?>  >
							</div>
							<div class="alert alert-danger alert-dismissible col-md-3" id="colloquiumAlertDiv" role="alert" style="display:none">
									<button type="button" class="alert-close close" ><span aria-hidden="true">&times;</span></button>
									<p id="colloquiumAlertMsg"></p>
							</div>
						</div>
						
						<div class="row">
							<div class="alert alert-danger alert-dismissible col-md-7" id="colloquiumSemesterAlertDiv" role="alert" style="display:none">
								<button type="button" class="alert-close close" ><span aria-hidden="true">&times;</span></button>
								<p id="colloquiumSemesterAlertMsg"></p>
							</div>
						</div>

						<!-- COLLOQUIUM ATTENDED YES-->
					
						<div class="row" id="colloquium_semester_div" style="display:none">
						<label class='control-label col-md-4' for='colloquium_semester'>Tick if attended more than 75% of the colloquium lectures for mentioned semesters<sup class='star'>*</sup></label>
						<div class='col-md-8' for='colloquium_semester'>
							<input type='checkbox' name='colloquium_semester' id='colloquium_semester' onchange='colloquiumSemChange(this);' value='Semester 1' <?php if(in_array('Semester 1',$Colloquium_Semesters))echo"checked='checked' disabled" ?> >Semester 1
							<input type='checkbox' name='colloquium_semester' id='colloquium_semester' onchange='colloquiumSemChange(this);' value='Semester 2' <?php if(in_array('Semester 2',$Colloquium_Semesters))echo"checked='checked' disabled" ?> >Semester 2
							<input type='checkbox' name='colloquium_semester' id='colloquium_semester' onchange='colloquiumSemChange(this);' value='Semester 3' <?php if(in_array('Semester 3',$Colloquium_Semesters))echo"checked='checked' disabled" ?> >Semester 3
							<input type='checkbox' name='colloquium_semester' id='colloquium_semester' onchange='colloquiumSemChange(this);' value='Semester 4' <?php if(in_array('Semester 4',$Colloquium_Semesters))echo"checked='checked' disabled" ?> >Semester 4
						</div>
						</div>
					</div>
					<!-- FORM GROUP ENDS -->
					
					<hr	>
					
					<!--
					<!-- CURRENT ACCOMPLISHED GOALS
					
					<!-- Goals Accomplished during previous years
					<div class="form-group">
						<label><font size='2'><i><u>Goals accomplished during previous years</u></i></font></label>
						<table id="currentGoalsTable_PY">
							<thead>
								<tr>
									<th data-formatter="getRowIndex" style="width: 36px;"></th>
									<th data-field="currentGoalUniqueID_PY" visible="false"></th>
									<th data-field="currentGoal_PY" data-title="Goals Accomplished Previously"/>
								</tr>
							</thead>
						</table>
					</div>
					
					<!-- Goals accomplished during current year
					<div class="row">
						<div class="alert alert-danger alert-dismissible col-md-5" id="currentGoalsTableAlertDiv" role="alert" style="display:none">
							<button type="button" class="alert-close close" ><span aria-hidden="true">&times;</span></button>
							<p id="currentGoalsTableAlertMsg"></p>
						</div>
					</div>
					
					<div class="form-group">
						<label><font size='2'><i><u>Goals accomplished during current year</u></i></font></label>
						<div class="table-responsive">
							<table id="currentGoalsTable">
								<thead>
									<tr>
										<th data-field="selectBoxCurrentGoal"></th>
										<th data-formatter="getRowIndex" style="width: 36px;"></th>
										<th data-field="currentGoalUniqueID" visible="false"></th>
										<th data-field="currentGoal" data-title="Current Accomplished Goals<span class='glyphicon glyphicon-info-sign'></span>" data-editable="true" data-title-tooltip="Enter goals you thought were important and you completed them. eg: Completed Qualification Exam. Completed current thesis work"/>
										
									</tr>
								</thead>
							</table>
							
							<!-- ADD / REMOVE CURRENT GOALS
							<div class='btn-group-horizontal'>
								<button type='button' class='btn btn-primary' data-toggle="modal" data-target="#addCurrentGoalModal"">Add Goals</button>
								<button type='button' class='btn btn-primary' onclick="removeCurrentGoalRow()">Remove Goals</button>
							</div>
			
							<!-- ADD CURRENT GOAL MODAL
							<div id="addCurrentGoalModal" class="modal fade" role="dialog">
							  <div class="modal-dialog">

								<!-- Modal content
								<div class="modal-content">
								  <div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h4 class="modal-title">Add Current Accomplished Goal</h4>
								  </div>
								  <div class="modal-body">
									<form role="form" id="addCurrentGoalForm">
										<div class="form-group">
											<label for="currentGoal">Goal</label>
											<input type="text" class="form-control" id="currentGoal" placeholder="Enter the accomplished goal" required />
										</div>
										
										<div class="row">
											<div class="alert alert-danger alert-dismissible col-md-6" id="addCurrentGoalAlertDiv" role="alert" style="display:none">
												<p id="addCurrentGoalAlertMsg"></p>
											</div>
										</div>
									</form>
								  </div>
								  <div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
									<button type="button" class="btn btn-success" form="addCurrentGoalForm" id="currentGoalModalSubmit" onclick="addCurrentGoalRow()">OK</button>
								  </div>
								</div>

							  </div>
							</div>
							<!-- MODAL ENDS
						</div>
					</div>
					<!-- FORM GROUP ENDS
					-->
					
					<!-- PUBLICATIONS -->
					<!-- Previous Years -->
					<div class="form-group">
						<label><font size='2'><i><u>These are your previous publications</u></i></font></label>
						<table id="publicationsTable_PY">
							<thead>
								<tr>
									<th data-formatter="getRowIndex" style="width: 36px;"></th>
									<th data-field="publicationUniqueID_PY" visible="false"></th>
									<th data-field="publication_PY" data-title="Publications"/>
								</tr>
							</thead>
						</table>
					</div>
					
					<!-- PREVIOUS SUBMISSION FOR CURRENT YEAR -->
					<?php if(count($Publication_Name) > 0)
					echo '<div class="form-group">
						<label><font size="2"><i><u>Publications during current year</u></i></font></label>
						<table id="publicationsTable_PS">
							<thead>
								<tr>
									<th data-formatter="getRowIndex" style="width: 36px;"></th>
									<th data-field="publicationUniqueID_PS" visible="false"></th>
									<th data-field="publication_PS" data-title="Publications"/>
								</tr>
							</thead>
						</table>
					</div>';
					?>
					
					<!-- Current Year -->
					
					<div class="row">
						<label class='control-label col-md-4' for='pub_currentAY'>Have you submitted/published in the current year?<sup class='star'>*</sup></label>

						<label class='control-label col-md-1'>Yes</label>
						<div class='col-md-1'>
							<input type='radio' name='pub_currentAY' id='pub_yes' class='pub_currentAY' onclick='PublicationCurrentAY()' value='1'>
						</div>
					
						<label class='control-label col-md-1'>No</label>
						<div class='col-md-1'>
							<input type='radio' name='pub_currentAY' id='pub_no' class='pub_currentAY' onclick='PublicationCurrentAY()' value='0' rel="publicationTooltip" data-toggle="tooltip" title="Remove all Publications to select No">
						</div>
						<div class="alert alert-danger alert-dismissible col-md-3" id="publicationAlertDiv" role="alert" style="display:none">
								<button type="button" class="alert-close close" ><span aria-hidden="true">&times;</span></button>
								<p id="publicationAlertMsg"></p>
						</div>
					</div>
					
					<div class="row">
						<div class="alert alert-danger alert-dismissible col-md-5" id="publicationsTableAlertDiv" role="alert" style="display:none">
							<button type="button" class="alert-close close" ><span aria-hidden="true">&times;</span></button>
							<p id="publicationsTableAlertMsg"></p>
						</div>
					</div>
					
					<!-- TABLE -->
					<div class="form-group" id="add_publication_div" style="display: none;">
						<div class="table-responsive">
							<table id="publicationsTable">
								<thead>
									<tr>
										<th data-field="selectBoxPublication"></th>
										<th data-formatter="getRowIndex" style="width: 36px;"></th>
										<th data-field="publicationUniqueID" visible="false"></th>
										<th data-field="publication" data-title="Publications<span class='glyphicon glyphicon-info-sign'></span>" data-title-tooltip="If you have not yet done a publication please write 'Yet To Do'"/>
									</tr>
								</thead>
							</table>
							
							<!-- ADD / REMOVE PUBLICATIONS -->
							<div class='btn-group-horizontal'>
								<button type='button' class='btn btn-primary' data-toggle="modal" data-target="#addPublicationModal">Add Publications</button>
								<button type='button' class='btn btn-primary' onclick="removePublicationRow()">Remove Publications</button>
							</div>
			
							<!-- ADD PUBLICATION MODAL -->
							<div id="addPublicationModal" class="modal fade" role="dialog">
							  <div class="modal-dialog">

								<!-- Modal content-->
								<div class="modal-content">
								  <div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h4 class="modal-title">Add Publication</h4>
								  </div>
								  <div class="modal-body">
								  <!--	This is where the change is being made-->
									
									<form role="form" id="addPublicationForm">
										<div class="form-group">
											
											<label for="publication_name">Publication</label>
											<input type="text" class="form-control" id="publication_name" placeholder="Enter Publication Name" required />
											<!-- This is where I am adding -->
											<label for="journal_name">Journal</label>
											<input type="text" class="form-control" id="journal_name" placeholder="Enter Journal Name" required />

											<label for="publication_status">Status</label>
											<select class="form-control" id="publication_status" name="publication_status" onchange="showFieldForDOI(this.options[this.selectedIndex].value)">

												<option value="Submitted">Submitted</option>
												<option value="Accepted">Accepted</option>
												<option value="Published">Published</option>
												<option value="ArXiv">ArXiv</option>
											</select>
											<div id="publication_DOI_div" style="display: none;">
												<label for="publication_DOI">DOI</label>
												<input type="text" class="form-control" id="publication_DOI" placeholder="Enter DOI" />
											</div>
											<div id="publication_URL_div" style="display:none">
												<label for="publication_URL">URL</label>
												<input type="url" class="form-control" id="publication_URL" placeholder="URL" /> 
											</div>
											
										</div>	
										<div class="row">
											<div class="alert alert-danger alert-dismissible col-md-8" id="addPublicationAlertDiv" role="alert" style="display:none">
												<p id="addPublicationAlertMsg"></p>
											</div>
										</div>
									</form>
								    	
								  	<!-- commented by tej 
									<form role="form" id="addPublicationForm">
										<div class="form-group">
											<label for="publication">Publication</label>
											<input type="text" class="form-control" id="publication" placeholder="Publication:Journal:Status=Approved/Rejected" required />
										</div>	
										<div class="row">
											<div class="alert alert-danger alert-dismissible col-md-8" id="addPublicationAlertDiv" role="alert" style="display:none">
												<p id="addPublicationAlertMsg"></p>
											</div>
										</div>
									</form>
								    -->

								  </div>
								  <div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
									<button type="button" class="btn btn-success" form="addPublicationForm" id="publicationModalSubmit" onclick="addPublicationRow()">OK</button>
								  </div>
								</div>

							  </div>
							</div>
							<!-- MODAL ENDS -->
						</div>
					</div>
					<!-- FORM GROUP ENDS -->
					
					<hr>
					
					<!-- PRESENTATIONS -->
					<!-- Previous Year -->
					<div class="form-group">
						<label><font size='2'><i><u>These are your previous presentations</u></i></font></label>
						<table id="presentationsTable_PY">
							<thead>
								<tr>
									<th data-formatter="getRowIndex" style="width: 36px;"></th>
									<th data-field="presentationUniqueID_PY" visible="false"></th>
									<th data-field="presentation_PY" data-title="Presentations"/>
								</tr>
							</thead>
						</table>
					</div>
					
					<!-- PREVIOUS SUBMISSION FOR CURRENT YEAR -->
					<?php if(count($Presentation_Type) > 0)
					echo '<div class="form">
						<label><font size="2"><i><u>Presentations during current year</u></i></font></label>
						<table id="presentationsTable_PS">
							<thead>
								<tr>
									<th data-formatter="getRowIndex" style="width: 36px;"></th>
									<th data-field="presentationUniqueID_PS" visible="false"></th>
									<th data-field="presentation_PS" data-title="Presentations"/>
								</tr>
							</thead>
						</table>
					</div>';
					?>
					
					<!-- Current Year -->
					
					<div class="row">
						<label class='control-label col-md-4' for='pres_currentAY'>Did you present any work during the current year?<sup class='star'>*</sup></label>

						<label class='control-label col-md-1'>Yes</label>
						<div class='col-md-1'>
							<input type='radio' name='pres_currentAY' id='pres_yes' class='pres_currentAY' onclick='PresentationCurrentAY()' value='1'>
						</div>
					
						<label class='control-label col-md-1'>No</label>
						<div class='col-md-1'>
							<input type='radio' name='pres_currentAY' id='pres_no' class='pres_currentAY' onclick='PresentationCurrentAY()' value='0' rel="presentationTooltip" data-toggle="tooltip" title="Remove all Presentations to select No">
						</div>
						<div class="alert alert-danger alert-dismissible col-md-3" id="presentationAlertDiv" role="alert" style="display:none">
								<button type="button" class="alert-close close" ><span aria-hidden="true">&times;</span></button>
								<p id="presentationAlertMsg"></p>
						</div>
					</div>
					
					<div class="row">
						<div class="alert alert-danger alert-dismissible col-md-5" id="presentationsTableAlertDiv" role="alert" style="display:none">
							<button type="button" class="alert-close close" ><span aria-hidden="true">&times;</span></button>
							<p id="presentationsTableAlertMsg"></p>
						</div>
					</div>
					
					<!-- TABLE -->
					<div class="form-group" id="add_presentation_div" style="display: none;">
					
						<div class="table-responsive">
							<table id="presentationsTable">
								<thead>
									<tr>
										<th data-field="selectBoxPresentation"></th>
										<th data-formatter="getRowIndex" style="width: 36px;"></th>
										<th data-field="presentationUniqueID" visible="false"></th>
										<th data-field="presentation" data-title="Presentations<span class='glyphicon glyphicon-info-sign'></span>" data-title-tooltip="If you have not yet done a presentation please write 'Yet To Do'"/>
									</tr>
								</thead>
							</table>
							
							<!-- ADD / REMOVE PRESENTATIONS -->
							<div class='btn-group-horizontal'>
								<button type='button' class='btn btn-primary' data-toggle="modal" data-target="#addPresentationModal">Add Presentations</button>
								<button type='button' class='btn btn-primary' onclick="removePresentationRow()">Remove Presentations</button>
							</div>
			
							<!-- ADD PRESENTATION MODAL -->
							<div id="addPresentationModal" class="modal fade" role="dialog">
							  <div class="modal-dialog">

								<!-- Modal content-->
								<div class="modal-content">
								  <div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h4 class="modal-title">Add Presentation</h4>
								  </div>
								  <div class="modal-body">
									<form role="form" id="addPresentationForm">
										
										<!--
											<label for="presentation">Presentation</label>
											<input type="text" class="form-control" id="presentation" placeholder="Presentation:Conference" required />
										-->
										<div class="form-group">
											<label for="presentation_type">Presentation</label>
											<select class="form-control" id="presentation_type" onchange="showFieldForPresType(this.options[this.selectedIndex].value)">
												<option value="Conference">Conference Talk</option>
												<option value="Poster">Poster</option>
												<option value="Seminar">Seminar</option>
												<option value="Other">Other</option>
											</select>
										</div>
										<div class="form-group" id="other_pres_type_div" style="display: none;">
											<input type="text" class="form-control" id="other_pres_type" placeholder="Enter presentation type" required />
										</div>
										<div class="form-group">
											<label for="presentation_title">Title</label>
											<input type="text" class="form-control" name="presentation_title" id="presentation_title" placeholder="Enter a title" required />
										</div>
										<div class="form-group">
											<label for="presentation_location">Where</label>
											<input type="text" class="form-control" name="presentation_location" id="presentation_location" placeholder="Enter the place" required />
										</div>
										
										<div class="form-group">
											<div class="alert alert-danger alert-dismissible col-md-8" id="addPresentationAlertDiv" role="alert" style="display:none">
												<p id="addPresentationAlertMsg"></p>
											</div>
										</div>
									</form>
								  </div>
								  <div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
									<button type="button" class="btn btn-success" form="addPresentationForm" id="presentationModalSubmit" onclick="addPresentationRow()">OK</button>
								  </div>
								</div>

							  </div>
							</div>
							<!-- MODAL ENDS -->
						</div>
					</div>
					<!-- FORM GROUP ENDS -->
					
					<!-- AWARDS -->
					<!-- Previous Years -->
					<div class="form">
						<label><font size='2'><i><u>These are the Awards you received previously</u></i></font></label>
						<table id="awardsTable_PY">
							<thead>
								<tr>
									<th data-formatter="getRowIndex" style="width: 36px;"></th>
									<th data-field="awardUniqueID_PY" visible="false"></th>
									<th data-field="award_PY" data-title="Awards Listed Previously"/>
								</tr>
							</thead>
						</table>
					</div>
					
					<!-- PREVIOUS SUBMISSION FOR CURRENT YEAR -->
					<?php if(count($Awards) > 0)
					echo '<div class="form">
						<label><font size="2"><i><u>Awards listed during current year</u></i></font></label>
						<table id="awardsTable_PS">
							<thead>
								<tr>
									<th data-formatter="getRowIndex" style="width: 36px;"></th>
									<th data-field="awardUniqueID_PS" visible="false"></th>
									<th data-field="award_PS" data-title="Awards"/>
								</tr>
							</thead>
						</table>
					</div>';
					?>
					
					<!-- Current Year -->
					
					<div class="row">
						<label class='control-label col-md-4' for='award_currentAY'>Did you receive any awards in the current year?<sup class='star'>*</sup></label>

						<label class='control-label col-md-1'>Yes</label>
						<div class='col-md-1'>
							<input type='radio' name='award_currentAY' id='award_yes' class='award_currentAY' onclick='AwardCurrentAY()' value='1'>
						</div>
					
						<label class='control-label col-md-1'>No</label>
						<div class='col-md-1'>
							<input type='radio' name='award_currentAY' id='award_no' class='award_currentAY' onclick='AwardCurrentAY()' value='0' rel="awardTooltip" data-toggle="tooltip" title="Remove all Awards to select No">
						</div>
						<div class="alert alert-danger alert-dismissible col-md-3" id="awardAlertDiv" role="alert" style="display:none">
								<button type="button" class="alert-close close" ><span aria-hidden="true">&times;</span></button>
								<p id="awardAlertMsg"></p>
						</div>
					</div>
					
					<div class="row">
						<div class="alert alert-danger alert-dismissible col-md-5" id="awardsTableAlertDiv" role="alert" style="display:none">
							<button type="button" class="alert-close close" ><span aria-hidden="true">&times;</span></button>
							<p id="awardsTableAlertMsg"></p>
						</div>
					</div>
					
					<div class="form-group" id="add_award_div" style="display: none;">
						
						<div class="table-responsive">
							<table id="awardsTable">
								<thead>
									<tr>
										<th data-field="selectBoxAward"></th>
										<th data-formatter="getRowIndex" style="width: 36px;"></th>
										<th data-field="awardUniqueID" visible="false"></th>
										<th data-field="award" data-title="Awards" data-editable="true"/>
									</tr>
								</thead>
							</table>
							
							<!-- ADD / REMOVE AWARDS -->
							<div class='btn-group-horizontal'>
								<button type='button' class='btn btn-primary' data-toggle="modal" data-target="#addAwardModal"">Add Awards</button>
								<button type='button' class='btn btn-primary' onclick="removeAwardRow()">Remove Awards</button>
							</div>
			
							<!-- ADD AWARD MODAL -->
							<div id="addAwardModal" class="modal fade" role="dialog">
							  <div class="modal-dialog">

								<!-- Modal content -->
								<div class="modal-content">
								  <div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h4 class="modal-title">Add Award</h4>
								  </div>
								  <div class="modal-body">
									<form role="form" id="addAwardForm">
										<div class="form-group">
											<label for="award">Award</label>
											<input type="text" class="form-control" id="award" placeholder="Enter information about the award" required />
										</div>
										<div class="row">
											<div class="alert alert-danger alert-dismissible col-md-6" id="addAwardAlertDiv" role="alert" style="display:none">
												<p id="addAwardAlertMsg"></p>
											</div>
										</div>
									</form>
								  </div>
								  <div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
									<button type="button" class="btn btn-success" form="addAwardForm" id="awardModalSubmit" onclick="addAwardRow()">OK</button>
								  </div>
								</div>

							  </div>
							</div>
							<!-- MODAL ENDS -->
						</div>
					</div>
					<!-- FORM GROUP ENDS -->
					
					<!-- FUTURE GOALS
					<!-- Previous Years
					<div class="form">
						<label><font size='2'><i><u>Future goals listed during previous years</u></i></font></label>
						<table id="futureGoalsTable_PY">
							<thead>
								<tr>
									<th data-formatter="getRowIndex" style="width: 36px;"></th>
									<th data-field="futureGoalUniqueID_PY" visible="false"></th>
									<th data-field="futureGoal_PY" data-title="Future Goals Listed Previously"/>
								</tr>
							</thead>
						</table>
					</div>
					
					<div class="row">
						<div class="alert alert-danger alert-dismissible col-md-5" id="futureGoalsTableAlertDiv" role="alert" style="display:none">
							<button type="button" class="alert-close close" ><span aria-hidden="true">&times;</span></button>
							<p id="futureGoalsTableAlertMsg"></p>
						</div>
					</div>
					
					<div class="form-group">
						<label><font size='2'><i><u>Future goals listed for the current year</u></i></font></label>
						<div class="table-responsive">
							<table id="futureGoalsTable">
								<thead>
									<tr>
										<th data-field="selectBoxFutureGoal"></th>
										<th data-formatter="getRowIndex" style="width: 36px;"></th>
										<th data-field="futureGoalUniqueID" visible="false"></th>
										<th data-field="futureGoal" data-title="Future Goals<span class='glyphicon glyphicon-info-sign'></span>" data-editable="true" data-title-tooltip="Enter goals you think are important and you need to complete them. eg: Completing Qualification Exam. Completing some current thesis work"/>
									</tr>
								</thead>
							</table>
							
							<!-- ADD / REMOVE FUTURE GOALS
							<div class='btn-group-horizontal'>
								<button type='button' class='btn btn-primary' data-toggle="modal" data-target="#addFutureGoalModal"">Add Goals</button>
								<button type='button' class='btn btn-primary' onclick="removeFutureGoalRow()">Remove Goals</button>
							</div>
			
							<!-- ADD FUTURE GOAL MODAL
							<div id="addFutureGoalModal" class="modal fade" role="dialog">
							  <div class="modal-dialog">

								<!-- Modal content
								<div class="modal-content">
								  <div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h4 class="modal-title">Add Future Goal</h4>
								  </div>
								  <div class="modal-body">
									<form role="form" id="addFutureGoalForm">
										<div class="form-group">
											<label for="futureGoal">Goal</label>
											<input type="text" class="form-control" id="futureGoal" placeholder="Enter the goal you want to accomplish" required />
										</div>
										<div class="row">
											<div class="alert alert-danger alert-dismissible col-md-6" id="addFutureGoalAlertDiv" role="alert" style="display:none">
												<p id="addFutureGoalAlertMsg"></p>
											</div>
										</div>
									</form>
								  </div>
								  <div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
									<button type="button" class="btn btn-success" form="addFutureGoalForm" id="futureGoalModalSubmit" onclick="addFutureGoalRow()">OK</button>
								  </div>
								</div>

							  </div>
							</div>
							<!-- MODAL ENDS
						</div>
					</div>
					<!-- FORM GROUP ENDS -->
					
				</div>
				<!-- PANEL BODY ENDS -->
			</div>
			<!-- PANEL B ENDS -->
			
			<!--
			<!-- PANEL C STARTS
			<div class="panel panel-primary">
				<div class="panel-heading">Section C | Transcripts</div>
				<div class="panel-body">
					<div class="form-group">
						<label class='control-label' for='transcript_file'>Please attach your current iPOS/Unofficial transcript<sup class='star'>*</sup></label>
						<input type='file' id='transcript_file' name='transcript_file'>
					</div>
					<div class="row">
						<div class="alert alert-danger alert-dismissible col-md-2" id="fileAlertDiv" role="alert" style="display:none">
							<button type="button" class="alert-close close" ><span aria-hidden="true">&times;</span></button>
							<p id="fileAlertMsg"></p>
						</div>
					</div>
				</div>
				<!-- PANEL BODY ENDS
			</div>
			<!-- PANEL C ENDS -->
			
			<!-- PANEL C STARTS -->
			<div class="panel panel-primary">
				<div class="panel-heading">Section C | END</div>
				<div class="panel-body">
					<div class="form-group">
						<label class='control-label' for='comments'>Please add further comments</label><i>(optional)</i>
      					<textarea class='form-control' name='comments' id='comments'><?php if($_GET['valid'] == 1) echo $Comments?></textarea>
					</div>
					<div class="form-group">
						<label><input type='checkbox' value='true' name='certify' id='certify'>I certify that the above information given is true and complete to the best of my knowledge.</label>
					</div>
					<div class="row">
						<div class="alert alert-danger alert-dismissible col-md-5" id="certifyAlertDiv" role="alert" style="display:none">
							<button type="button" class="alert-close close" ><span aria-hidden="true">&times;</span></button>
							<p id="certifyAlertMsg"></p>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-md-4 pad">
							<input type="submit" id='submit_progressReportForm' form="progressReportForm" class='btn btn-success' value="SUBMIT">
						</div>
						</div>
					</div>
				</div>
				<!-- PANEL BODY ENDS -->
			</div>
			<!-- PANEL C ENDS -->
			
			
			</div>
			<!-- END PROGRESS REPORT DIV-->
		</form>
	</div>
</body>

</html>
