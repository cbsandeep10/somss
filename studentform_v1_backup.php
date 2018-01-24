<?php

$_GET['valid'] = 1;
if($_GET['valid'] == 1){
//Connect to the database
include('connect.php');



//Fetch information for the below ASU ID from the database to populate in the form
//$ASU_ID = 1209365010; //1206109121 1205222274
$ASU_ID = $_GET['ID'];
$sql = "SELECT * from SOMSS.somss_test where ASU_ID='$ASU_ID'";
$retval = mysqli_query($conn,$sql);
if (!$retval) {
echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
while($row = mysqli_fetch_array($retval, MYSQLI_ASSOC))
{
	$AcademicYear=$row['Academic_Year'];
	$Degree_program=$row['Degree'];
	$FirstName=$row['First_Name'];
	$SecondName=$row['Second_Name'];
	$ASU_ID=$row['ASU_ID'];
	$ASURITE=$row['ASURITE'];
	$CGPA=$row['CGPA'];
	$SemesterProgress=$row['Semester_in_progress'];
	$ProgramStart=$row['Program_start_date'];
	$Course_details=json_decode($row['Course']);
  	$Grade_details=json_decode($row['Grade']);
  	$AdvisoryComPresent=$row['Adivisory_Committee'];
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
  	$Current_Goals=json_decode($row['current_goal']);
  	$cur=json_decode($row['current_goal'])[0];
  	$Publications=json_decode($row['Publications']);
  	$Presentations=json_decode($row['Presentations']);
  	$Future_Goals=json_decode($row['future_goal']);
	//foreach($Course_details as $course)
		//echo "'<script>console.log(\"$NotMetReason\")</script>'";
	
}
}

//List of degree programs
$degree_program_list = array('Applied Mathematics','Mathematics','Mathematics Education','Statistics');

//List of semester number
$semester_number_list = array('First','Second','Third','Fourth','Fifth','Sixth','Seventh','Eighth','Ninth','Tenth','Eleventh','Twelfth');

//List of Grades
$grade_list = array('A+','A','A-','B+','B','B-','C+','C','D','E','EN','I','NR','P','W','X','Y','Z','XE');
$comprehensive_exam_grade_list = array('Pass','Fail');

//List of Advisor Positions
$advisor_position_list = array('CHAIR','CO-CHAIR','MEMBER');

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
		var Asu_id = <?php echo $ASU_ID= $_GET['ID']; ?>;
	</script>
	
	
	
<style>
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
</style>
</head>
<body onload='setCourseTableTemplate();AddCourses(<?php echo json_encode($Course_details) ?>,<?php echo json_encode($Grade_details) ?>);setAdvisorTableTemplate();AddAdvisors(<?php echo json_encode($AdvisorPosition) ?>,<?php echo json_encode($AdvisorFirstName) ?>,<?php echo json_encode($AdvisorLastName) ?>,<?php echo json_encode($AdvisorEmailID) ?>);setQualifyingExamTableTemplate();resetQualifyingExamTable(<?php echo json_encode($Degree_program) ?>);AddQualifyingSubjects(<?php echo json_encode($Qualifying_subjects)?>,<?php echo json_encode($Qualifying_subjects_grades)?>);ChairMet(<?php echo json_encode($NotMetReason)?>);setComprehensiveExamTableTemplate();AddComprehensiveExams(<?php echo json_encode($ComprehensiveExamSubjects) ?>,<?php echo json_encode($ComprehensiveExamGrades) ?>);Check_Colloquium_Attended();setCurrentGoalsTableTemplate();AddCurrentGoals(<?php echo json_encode($Current_Goals) ?>);setPublicationsTableTemplate();AddPublications(<?php echo json_encode($Publications) ?>);setPresentationsTableTemplate();AddPresentations(<?php echo json_encode($Presentations) ?>);setFutureGoalsTableTemplate();AddFutureGoals(<?php echo json_encode($Future_Goals) ?>);'>
	<div class='container'>
	
		<!-- HEADING -->
		<h1><center><u>SCHOOL OF MATHEMATICAL & STATISTICAL SCIENCES</u></center></h1>
		<h2><center>PhD Program Report Form</center></h2>
		<br></br>
		
		<!-- FORM STARTS -->
		<form class='form-horizontal' role='form' method='POST'  id="progressReportForm"enctype='multipart/form-data'  action=''>
			
			<!-- SELECT DEGREE PROGRAM -->
			<div class='form-group' id='degree_program'>
				<label class='control-label col-md-3' for='degree_select'>Doctoral Degree Program<sup class='star'>*</sup></label>
					<div class='col-md-3'>
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
			
			<!-- SECTION A STARTS -->
			<!-- <p><h3><b>Section A | Program of Study Status</b></h3></p> -->
			<div class="panel panel-primary">
				<div class="panel-heading">Section A | Program of Study Status</div>
				<div class="panel-body">
					<!-- ACADEMIC YEAR -->
					<div class='form-group'>
						<label class='control-label col-md-2' >Academic year:<sup class='star'>*</sup></label>
						<label class='control-label col-md-1' for='academic_year_fall'>FALL</label>
						<div class='col-md-1'>
							<input type='text' class='form-control' id='academic_year_fall' name='academic_year_fall' data-calendar='false' <?php if($_GET['valid']==1)echo "style='background-color:#FCF5D8'";?> required>
						</div>
						<label class='control-label col-md-1' for='academic_year_spring'>SPRING</label>
						<div class='col-md-1'>
							<input type='text' class='form-control' id='academic_year_spring' name='academic_year_spring' data-calendar='false' <?php if($_GET['valid']==1){echo "style='background-color:#FCF5D8'";echo "value='$AcademicYear'";}?> required>
						</div>
						<div class="alert alert-danger alert-dismissible col-md-3" id="academicYearAlertDiv" role="alert" style="display:none">
								<button type="button" class="alert-close close" ><span aria-hidden="true">&times;</span></button>
								<p id="academicYearAlertMsg"></p>
						</div>
					</div>
					<!-- FORM GROUP ENDS -->
			
					<!-- PERSONAL DETAILS -->
					<!-- NAME -->
					<div class="form-group">
						<label class='control-label col-md-2' for='first_name' >First Name:<sup class='star'>*</sup></label>
						<div class='col-md-2'>          
							<input type='text' class='form-control' id='first_name' name='first_name' placeholder="Enter First Name" <?php if($_GET['valid']==1){echo "style='background-color:#FCF5D8'";echo "value='$FirstName'";}?> required>
						</div>
						<label class='control-label col-md-2' for='second_name'>Last Name:<sup class='star'>*</sup></label>
						<div class='col-md-2'>        
							<input type='text' class='form-control' id='second_name' name='second_name' placeholder="Enter Second Name" <?php if($_GET['valid']==1){echo "style='background-color:#FCF5D8'";echo "value='$SecondName'";}?> required>
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
						<label class='control-label col-md-2' for='asu_id'>ASU ID/Student ID Number:<sup class='star'>*</sup></label>
						<div class='col-md-2'>          
							<input type='text' class='form-control' id='asu_id' name='asu_id' placeholder="ASU ID/Student ID" <?php if($_GET['valid']==1){echo "style='background-color:#FCF5D8'";echo "value='$ASU_ID'";}?> required>
						</div> 
				
						<label class='control-label col-md-2' for='student_mail'>ASURITE ID:<sup class='star'>*</sup></label>
						<div class='col-md-2'>
							<input type='text' class='form-control' id='student_mail' name='student_mail' placeholder="Student ASURITE ID" <?php if($_GET['valid']==1){echo "style='background-color:#FCF5D8'";echo "value='$ASURITE'";}?> required>
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
						<label class='control-label col-md-2' for='prog_start_date' >Program Start Date:<sup class='star'>*</sup></label>
						<div class='col-md-2'>          
							<input type='text' class='form-control' id='prog_start_date' name='prog_start_date' data-calendar='false' <?php if($_GET['valid']==1){echo "style='background-color:#FCF5D8'";echo "value='$ProgramStart'";}?> required>
						</div>
				
						<label class='control-label col-md-2' for='sem_in_prog'>Semester in Progress<sup class='star'>*</sup></label>
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

						<label class='control-label col-md-2' for='cumulative_gpa'>Cumulative GPA:<sup class='star'>*</sup></label>
						<div class='col-md-2'>          
							<input type='text' class='form-control' id='cumulative_gpa' name='cumulative_gpa' <?php if($_GET['valid']==1){echo "style='background-color:#FCF5D8'"; echo "value='$CGPA'";}?> required>
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
						<div class="alert alert-danger alert-dismissible col-md-4" id="cumGPAAlertDiv" role="alert" style="display:none">
							<button type="button" class="alert-close close" ><span aria-hidden="true">&times;</span></button>
							<p id="cumGPAAlertMsg"></p>
						</div>
					</div>
					
					<!-- COURSES -->
					
					<div class="row">
						<div class="alert alert-danger alert-dismissible col-md-4" id="courseTableAlertDiv" role="alert" style="display:none">
							<button type="button" class="alert-close close" ><span aria-hidden="true">&times;</span></button>
							<p id="courseTableAlertMsg"></p>
						</div>
					</div>

					<div class="form-group">
												
						<!-- <label><font size='2'><i>Courses taken since last progress with grades<i></font></label> -->
						
						<div class="table-responsive">
							<table id="coursesTable">
								<thead>
								<tr>
									<th data-field="selectBoxCourse"></th>
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
							<button type='button' class='btn btn-primary' data-toggle="modal" data-target="#addCourseModal"">Add Course</button>
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
									
									<!--
									<div class="form-group">
										<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
										<!-- <button type="button" class="btn btn-success" form="addCourseForm" data-dismiss="modal" onclick="addCourseRow()">Submit</button>
										<input type="submit" class="btn btn-success" form="addCourseForm" onclick="addCourseRow()" value="OK">
									</div>
									-->
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
					<!-- FORM GROUP ENDS -->
					
					<!-- ADVISORY COMMITTEE -->
					<div class="form-group">
				
							<label class='control-label col-md-4' for='advisory_committee'>Advisory Committee Formed?<sup class='star'>*</sup></label>
							<div id='adv_committee'> 
								<label class='control-label col-md-1'>Yes</label>
								<div class='col-md-1'>
									<input type='radio' name='advisory_committee' class='advisory_committee' onclick='AdvisoryCommitteeFormed()' id='advisory_committee_yes' value='1' 
									<?php if($AdvisoryComPresent==='1') echo "checked='checked'"; ?>>
								</div>
				
								<label class='control-label col-md-1'>No</label>
								<div class='col-md-1'>
									<input type='radio' name='advisory_committee' class='advisory_committee' onclick='AdvisoryCommitteeFormed()' id='advisory_committee_no' value='0' 
									rel="advCommTooltip" data-toggle="tooltip" title="Remove all Advisors to select No" <?php if($AdvisoryComPresent==='0')echo "checked='checked'"; ?> >
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
					
					
					<!-- ADVISORY COMMITTEE TABLE -->
					<div class="form-group">	
				
				
							<div class="table-responsive" style="display:none" id="advisor_member_div">
								<table id="advisorTable">
									<thead>
									<tr>
										<th data-field="selectBoxAdvisor">
										<th data-formatter="getRowIndex" style="width: 36px;"></th>
										<th data-field="advisorUniqueID" visible="false"></th>
										<th data-field="advisorType" data-title="Chair/Co-Chair/Member" data-editable="true">
										<th data-field="advisorFirstName" data-title="First Name" data-editable="true">
										<th data-field="advisorLastName" data-title="Last Name" data-editable="true">
										<th data-field="advisorEmailID" data-title="E-mail ID" data-editable="true">
									</tr>
									</thead>
								</table>
					
					
							<!-- ADD /REMOVE ADVISORS -->
							<div class='btn-group-horizontal'>
								<button type='button' class='btn btn-primary' data-toggle="modal" data-target="#addAdvisorModal">Add Advisor Members</button>
								<button type='button' class='btn btn-primary' onclick="removeAdvisorRow()">Remove Advisor members</button>
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
										</div>1712036865
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
							<label class='control-label col-md-4' for='advisor'>Has the student met the Chair for the current academic year? If not,
							give reasons below<sup class='star'>*</sup></label>
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
								<label class='control-label col-md-4' for='chair_notmet_reason'>Reason for not having an advisory committee yet<sup class='star'>*</sup></label>
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
					<div class="form-group">
						<div class="row">
							<label class='control-label col-md-4' for='qualifying_exam_completed'>Qualifying Exam Completed?<sup class='star'>*</sup></label>
							<div id='qualifying_exam_completed'>
								<label class='control-label col-md-1'>Yes</label>
								<div class='col-md-1'>
									<input type='radio' name='qualifying_exam_completed' id='exam_yes' class='qualifying_exam_completed' onclick='qualifyingExamTable()' value='1' <?php if($QualExamComp==='1') echo "checked='checked'"; ?>>
								</div>
							
								<label class='control-label col-md-1'>No</label>
								<div class='col-md-1'>
									<input type='radio' name='qualifying_exam_completed' id='exam_no' class='qualifying_exam_completed' onclick='qualifyingExamTable()' value='0' rel="qualExamTooltip" data-toggle="tooltip" title="Remove all Exams to select No" <?php if($QualExamComp==='0') echo "checked='checked'" ?>>
								</div>
								
								<div class="alert alert-danger alert-dismissible col-md-3" id="qualExamAlertDiv" role="alert" style="display:none">
									<button type="button" class="alert-close close" ><span aria-hidden="true">&times;</span></button>
									<p id="qualExamAlertMsg"></p>
								</div>   
							</div>
						</div>
						
						
						<div class="row">
							<div class="alert alert-danger alert-dismissible col-md-7" id="qualExamTableAlertDiv" role="alert" style="display:none">
								<button type="button" class="alert-close close" ><span aria-hidden="true">&times;</span></button>
								<p id="qualExamTableAlertMsg"></p>
							</div>
						</div>
						
					
						<div class="row">
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
									<button type='button' class='btn btn-primary' data-toggle="modal" data-target="#addQualSubjectModal">Add Qualifying Subjects</button>
									<button type='button' class='btn btn-primary' onclick="removeQualSubjectRow()">Remove</button>
								</div>
					
								<!-- ADD QUALIFYING SUBJECT MODAL -->
								<div id="addQualSubjectModal" class="modal fade" role="dialog">
								  <div class="modal-dialog">

									<!-- Modal content-->
									<div class="modal-content">
									  <div class="modal-header">
										<button type="button" class="close" data-dismiss="modal">&times;</button>
										<h4 class="modal-title">Add Qualifying Subject</h4>
									  </div>
									  <div class="modal-body">
										<form role="form" id="addQualSubjectForm">
											<div class="form-group">
												<label for="selectQualSubject">Qualifying Subject</label>
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
					</div>
					<!-- FORM GROUP ENDS -->
					
					<!--WRITTEN COMPREHENSIVE EXAM -->
					<div class="form-group">
						<div class="row">
							<label class='control-label col-md-4' for='comprehensive_exam'>Written Comprehensive Exam Completed?<sup class='star'>*</sup></label>
							<div id='adv_committee'> 
							<label class='control-label col-md-1'>Yes</label>
							<div class='col-md-1'>
								<input type='radio' name='comprehensive_exam' onclick='ComprehensiveExamCompleted()' id='comprehensive_exam_yes' value='1' 
								<?php if($ComprehensiveExamCompleted==='1') echo "checked='checked'"; ?>>
							</div>
			
							<label class='control-label col-md-1'>No</label>
							<div class='col-md-1'>
								<input type='radio' name='comprehensive_exam' onclick='ComprehensiveExamCompleted()' id='comprehensive_exam_no' value='0' 
								rel="compExamTooltip" data-toggle="tooltip" title="Remove all Exams to select No" <?php if($ComprehensiveExamCompleted==='0')echo "checked='checked'"; ?>>
							</div>
							</div>
							<div class="alert alert-danger alert-dismissible col-md-3" id="compExamAlertDiv" role="alert" style="display:none">
									<button type="button" class="alert-close close" ><span aria-hidden="true">&times;</span></button>
									<p id="compExamAlertMsg"></p>
							</div> 
						</div>
						
						<div class="row">
							<div class="alert alert-danger alert-dismissible col-md-8" id="compExamTableAlertDiv" role="alert" style="display:none">
								<button type="button" class="alert-close close" ><span aria-hidden="true">&times;</span></button>
								<p id="compExamTableAlertMsg"></p>
							</div>
						</div>
					
						<!--COMPREHENSIVE EXAM TABLE -->
						<div class="row">
						
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
					</div>
					<!--FORM GROUP ENDS -->
										
					<!-- DISSERTATION PROSPECTUS -->
					<div class='form-group'  id='dissertation_prosectus_div'>
						<div class="row">
							<label class='control-label col-md-4' for='dissertation_prosectus'>Dissertation prospectus completed?<sup class='star'>*</sup></label>

							<label class='control-label col-md-1'>Yes</label>
							<div class='col-md-1'>
								<input type='radio' name='dissertation_prosectus' id='dissertation_prosectus' onclick="dissertationProspectus()" value='1' <?php if($DissertationProspectus==='1')echo "checked='checked'" ?> >
							</div>

							<label class='control-label col-md-1'>No</label>
							<div class='col-md-1'>
								<input type='radio' name='dissertation_prosectus' id='dissertation_prosectus' onclick="dissertationProspectus()" value='0' <?php if($DissertationProspectus==='0')echo "checked='checked'" ?> >
							</div>
							<div class="alert alert-danger alert-dismissible col-md-3" id="dissertationAlertDiv" role="alert" style="display:none">
									<button type="button" class="alert-close close" ><span aria-hidden="true">&times;</span></button>
									<p id="dissertationAlertMsg"></p>
							</div>
						
						</div>					
					
						<!-- COLLOQUIUM ATTENDED -->
						<div class="row">
							<label class='control-label col-md-4' for='colloquium'>Colloquium/Distinguished Lecture Series Attended?<sup class='star'>*</sup></label>

							<label class='control-label col-md-1'>Yes</label>
							<div class='col-md-1'>
								<input type='radio' name='colloquium' id='colloquium_yes' class='colloquium' onclick='Check_Colloquium_Attended()' value='1' <?php if($Colloquium_Attended==='1')echo "checked='checked'" ?> >
							</div>
						
							<label class='control-label col-md-1'>No</label>
							<div class='col-md-1'>
								<input type='radio' name='colloquium' id='colloquium_no' class='colloquium' onclick='Check_Colloquium_Attended()' value='0' <?php if($Colloquium_Attended==='0')echo "checked='checked'" ?> >
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
							<input type='checkbox' name='colloquium_semester' id='colloquium_semester' onchange='colloquiumSemChange(this);' value='Semester 1' <?php if(in_array('Semester 1',$Colloquium_Semesters))echo"checked='checked'" ?> >Semester 1
							<input type='checkbox' name='colloquium_semester' id='colloquium_semester' onchange='colloquiumSemChange(this);' value='Semester 2' <?php if(in_array('Semester 2',$Colloquium_Semesters))echo"checked='checked'" ?> >Semester 2
							<input type='checkbox' name='colloquium_semester' id='colloquium_semester' onchange='colloquiumSemChange(this);' value='Semester 3' <?php if(in_array('Semester 3',$Colloquium_Semesters))echo"checked='checked'" ?> >Semester 3
							<input type='checkbox' name='colloquium_semester' id='colloquium_semester' onchange='colloquiumSemChange(this);' value='Semester 4' <?php if(in_array('Semester 4',$Colloquium_Semesters))echo"checked='checked'" ?> >Semester 4
						</div>
						</div>
					</div>
					<!-- FORM GROUP ENDS -->
					
					<!-- CURRENT ACCOMPLISHED GOALS -->
					
					<div class="row">
						<div class="alert alert-danger alert-dismissible col-md-5" id="currentGoalsTableAlertDiv" role="alert" style="display:none">
							<button type="button" class="alert-close close" ><span aria-hidden="true">&times;</span></button>
							<p id="currentGoalsTableAlertMsg"></p>
						</div>
					</div>
					
					<div class="form-group">
						<!-- <label><font size='2'><i>Please hover over <span class='glyphicon glyphicon-info-sign help_current_goal'></span> to check for details<i></font></label> -->
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
							
							<!-- ADD / REMOVE CURRENT GOALS -->
							<div class='btn-group-horizontal'>
								<button type='button' class='btn btn-primary' data-toggle="modal" data-target="#addCurrentGoalModal"">Add Goals</button>
								<button type='button' class='btn btn-primary' onclick="removeCurrentGoalRow()">Remove Goals</button>
							</div>
			
							<!-- ADD CURRENT GOAL MODAL -->
							<div id="addCurrentGoalModal" class="modal fade" role="dialog">
							  <div class="modal-dialog">

								<!-- Modal content-->
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
							<!-- MODAL ENDS -->
						</div>
					</div>
					<!-- FORM GROUP ENDS -->
					
					<!-- PUBLICATIONS -->
					<div class="form-group">
					
						<div class="row">
							<div class="alert alert-danger alert-dismissible col-md-5" id="publicationsTableAlertDiv" role="alert" style="display:none">
								<button type="button" class="alert-close close" ><span aria-hidden="true">&times;</span></button>
								<p id="publicationsTableAlertMsg"></p>
							</div>
						</div>
					
						<!-- <label><font size='2'><i>Please hover over <span class='glyphicon glyphicon-info-sign help_current_goal'></span> to check for details<i></font></label> -->
						<div class="table-responsive">
							<table id="publicationsTable">
								<thead>
									<tr>
										<th data-field="selectBoxPublication"></th>
										<th data-formatter="getRowIndex" style="width: 36px;"></th>
										<th data-field="publicationUniqueID" visible="false"></th>
										<th data-field="publication" data-title="Publications<span class='glyphicon glyphicon-info-sign'></span>" data-title-tooltip="If you have not yet done a publication please write 'Yet To Do'" data-editable="true"/>
									</tr>
								</thead>
							</table>
							
							<!-- ADD / REMOVE PUBLICATIONS -->
							<div class='btn-group-horizontal'>
								<button type='button' class='btn btn-primary' data-toggle="modal" data-target="#addPublicationModal"">Add Publications</button>
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
					
					<!-- PRESENTATIONS -->
					<div class="form-group">
					
						<div class="row">
							<div class="alert alert-danger alert-dismissible col-md-5" id="presentationsTableAlertDiv" role="alert" style="display:none">
								<button type="button" class="alert-close close" ><span aria-hidden="true">&times;</span></button>
								<p id="presentationsTableAlertMsg"></p>
							</div>
						</div>
						
						<!-- <label><font size='2'><i>Please hover over <span class='glyphicon glyphicon-info-sign help_current_goal'></span> to check for details<i></font></label> -->
						<div class="table-responsive">
							<table id="presentationsTable">
								<thead>
									<tr>
										<th data-field="selectBoxPresentation"></th>
										<th data-formatter="getRowIndex" style="width: 36px;"></th>
										<th data-field="presentationUniqueID" visible="false"></th>
										<th data-field="presentation" data-title="Presentations<span class='glyphicon glyphicon-info-sign'></span>" data-title-tooltip="If you have not yet done a presentation please write 'Yet To Do'" data-editable="true"/>
									</tr>
								</thead>
							</table>
							
							<!-- ADD / REMOVE PRESENTATIONS -->
							<div class='btn-group-horizontal'>
								<button type='button' class='btn btn-primary' data-toggle="modal" data-target="#addPresentationModal"">Add Presentations</button>
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
										<div class="form-group">
											<label for="presentation">Presentation</label>
											<input type="text" class="form-control" id="presentation" placeholder="Presentation:Conference" required />
										</div>
										<div class="row">
											<div class="alert alert-danger alert-dismissible col-md-8" id="addPresentationAlertDiv" role="alert" style="display:none">
												<p id="addPresentationAlertMsg"></p>
											</div>
										</div>
									</form>
								  </div>
								  <div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
									<button type="button" class="btn btn-success" form="addPresentationForm" id="presentationModalSubmit" onclick="addPresentationRow()">Submit</button>
								  </div>
								</div>

							  </div>
							</div>
							<!-- MODAL ENDS -->
						</div>
					</div>
					<!-- FORM GROUP ENDS -->
					
					<!-- FUTURE GOALS -->
					
					<div class="row">
						<div class="alert alert-danger alert-dismissible col-md-5" id="futureGoalsTableAlertDiv" role="alert" style="display:none">
							<button type="button" class="alert-close close" ><span aria-hidden="true">&times;</span></button>
							<p id="futureGoalsTableAlertMsg"></p>
						</div>
					</div>
					
					<div class="form-group">
						<!-- <label><font size='2'><i>Please hover over <span class='glyphicon glyphicon-info-sign help_current_goal'></span> to check for details<i></font></label> -->
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
							
							<!-- ADD / REMOVE FUTURE GOALS -->
							<div class='btn-group-horizontal'>
								<button type='button' class='btn btn-primary' data-toggle="modal" data-target="#addFutureGoalModal"">Add Goals</button>
								<button type='button' class='btn btn-primary' onclick="removeFutureGoalRow()">Remove Goals</button>
							</div>
			
							<!-- ADD FUTURE GOAL MODAL -->
							<div id="addFutureGoalModal" class="modal fade" role="dialog">
							  <div class="modal-dialog">

								<!-- Modal content-->
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
									<button type="button" class="btn btn-success" form="addFutureGoalForm" id="futureGoalModalSubmit" onclick="addFutureGoalRow()">Submit</button>
								  </div>
								</div>

							  </div>
							</div>
							<!-- MODAL ENDS -->
						</div>
					</div>
					<!-- FORM GROUP ENDS -->
					
				</div>
				<!-- PANEL BODY ENDS -->
			</div>
			<!-- PANEL B ENDS -->
			
			<!-- PANEL C STARTS -->
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
				<!-- PANEL BODY ENDS -->
			</div>
			<!-- PANEL C ENDS -->
			
			<!-- PANEL D STARTS -->
			<div class="panel panel-primary">
				<div class="panel-heading">Section D | Comments</div>
				<div class="panel-body">
					<div class="form-group">
						<label class='control-label' for='comments'>Please mention if you wish to add anymore to this form</label><i>(optional)</i>
      					<textarea class='form-control' name='comments' id='comments'></textarea>
					</div>
				</div>
				<!-- PANEL BODY ENDS -->
			</div>
			<!-- PANEL C ENDS -->
			
			<div class="form-group">
				<label><input type='checkbox' value='true' name='certify' id='certify'>I certify that the above information given is true and complete to the best of my knowledge.</label>
				<div class="row">
					<div class="alert alert-danger alert-dismissible col-md-4" id="certifyAlertDiv" role="alert" style="display:none">
						<button type="button" class="alert-close close" ><span aria-hidden="true">&times;</span></button>
						<p id="certifyAlertMsg"></p>
					</div>
				</div>
				<input type="submit" id='submit_progressReportForm' form="progressReportForm" class='btn btn-success' value="SUBMIT">
			</div>
			
			
		</form>
	</div>
</body>

</html>

