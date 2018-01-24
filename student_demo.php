<?php

//Connect to the database
include('connect.php');

//Fetch information for the below ASU ID from the database to populate in the form
$ASU_ID = $_GET['ID'];
$Year = $_GET['AcademicYear'];
$sql = "SELECT * from SOMSS.".$Year." where ASU_ID='$ASU_ID'";
//$sql= "SELECT * from somss_test where ASU_ID='$ASU_ID'";
$retval = mysqli_query($conn,$sql);
if (!$retval) {
echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
while($row = mysqli_fetch_array($retval, MYSQLI_ASSOC))
{
	if($row['Director_Signature']!=null|| $row['Director_Signature']!="" ||$row['Director_Signature']!=NULL){
	echo "<p><h3><b><center>You have already approved the Progress Report for this student!</center></b></h3></p>";
}
	
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
  	//$Current_Goals=json_decode($row['current_goal']);
  	//$cur=json_decode($row['current_goal'])[0];
  	$Publications=json_decode($row['Publications']);
  	$Presentations=json_decode($row['Presentations']);
  	//$Future_Goals=json_decode($row['future_goal']);
  	$Comments=$row['Extra'];
	
}


$current_year = date('Y');
$current_month = date('M');
$fall_spring_year = explode("_",$_GET['AcademicYear']);


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
	<script src = './student_demo_js.js'></script>
	
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
    height: auto;
}
.col-md-off-4 {
  margin-right: 25%;
  margin-left: 25%;
}
.alert {
  padding: 1px 35px 1px 1px;
}
</style>
</head>
<body onload='setCourseTableTemplate();AddCourses(<?php echo json_encode($Course_details) ?>,<?php echo json_encode($Grade_details) ?>);setAdvisorTableTemplate();AddAdvisors(<?php echo json_encode($AdvisorPosition) ?>,<?php echo json_encode($AdvisorFirstName) ?>,<?php echo json_encode($AdvisorLastName) ?>,<?php echo json_encode($AdvisorEmailID) ?>);setQualifyingExamTableTemplate();AddQualifyingSubjects(<?php echo json_encode($Qualifying_subjects)?>,<?php echo json_encode($Qualifying_subjects_grades)?>);setComprehensiveExamTableTemplate();AddComprehensiveExams(<?php echo json_encode($ComprehensiveExamSubjects) ?>,<?php echo json_encode($ComprehensiveExamGrades) ?>);Check_Colloquium_Attended(<?php echo json_encode($Colloquium_Attended)?>);setPublicationsTableTemplate();AddPublications(<?php echo json_encode($Publications) ?>);setPresentationsTableTemplate();AddPresentations(<?php echo json_encode($Presentations) ?>);DisplayStudentComments(<?php echo json_encode($Comments) ?>);'>
	<div class='container'>
	
		<!-- HEADING -->
		<h1><center><u>SCHOOL OF MATHEMATICAL & STATISTICAL SCIENCES</u></center></h1>
		<h2><center>PhD Program Report Form</center></h2>
		<br></br>
		
		<!-- FORM STARTS -->
		<form class='form-horizontal' role='form'  id="progressReportForm" action=''>
			<!--
			<!-- SELECT ACADEMIC YEAR 
			<div class='form-group' id='academic_year'>
				<label class='control-label col-md-3' for='academic_year_select'>Academic Year</label>
					<div class='col-md-3'>
						<select class='form-control ' id='academic_year_select' name='academic_year_select' onchange='onAcademicYearChange()' required>
			
							<?php
							if($current_month<7)
							{
								if(intval($current_year-1).'_'.$current_year == $_GET['AcademicYear'])
									echo '<option value="'.intval($current_year-1).'_'.$current_year.'" selected>'.intval($current_year-1).'-'.$current_year.'</option>';
								else
									echo '<option value="'.intval($current_year-1).'_'.$current_year.'">'.intval($current_year-1).'-'.$current_year.'</option>';
							}
							else
							{
								if($current_year.'_'.intval($current_year+1) == $_GET['AcademicYear'])
									echo '<option value="'.$current_year.'_'.intval($current_year+1).'" selected>'.$current_year.'-'.intval($current_year+1).'</option>';
								else
									echo '<option value="'.$current_year.'_'.intval($current_year+1).'">'.$current_year.'-'.intval($current_year+1).'</option>';
							}
							foreach ( range( $current_year-1, $current_year - 6 ) as $i )
								if(intval($i-1).'_'.$i == $_GET['AcademicYear'])
									echo '<option value="'.intval($i-1).'_'.$i.'" selected>'.intval($i-1).'-'.$i.'</option>';
								else
									echo '<option value="'.intval($i-1).'_'.$i.'">'.intval($i-1).'-'.$i.'</option>';
							?>
						</select>
				   </div>
			</div>
			-->
			<!-- SELECT DEGREE PROGRAM -->
			<div class='form-group' id='degree_program_div'>
				<label class='control-label col-md-3' for='degree_program'>Doctoral Degree Program</label>
					<div class='col-md-3'>
						<input type="text" id="degree_program" name="degree_program" value="<?php echo $Degree_program; ?>" disabled/>
				   </div>
			</div>
			
			<!-- SECTION A STARTS -->
			<div class="panel panel-primary">
				<div class="panel-heading">Section A | Program of Study Status</div>
				<div class="panel-body">
					<!-- ACADEMIC YEAR -->
					<div class='form-group'>
						<label class='control-label col-md-2' >Academic year:</label>
						<label class='control-label col-md-1' for='academic_year_fall'>FALL</label>
						<div class='col-md-1'>
							<input type='text' class='form-control' id='academic_year_fall' name='academic_year_fall' data-calendar='false' <?php echo "value='$fall_spring_year[0]'"; ?> disabled>
						</div>
						<label class='control-label col-md-1' for='academic_year_spring'>SPRING</label>
						<div class='col-md-1'>
							<input type='text' class='form-control' id='academic_year_spring' name='academic_year_spring' data-calendar='false' <?php echo "value='$fall_spring_year[1]'";?> disabled>
						</div>
					</div>
					<!-- FORM GROUP ENDS -->
			
					<!-- PERSONAL DETAILS -->
					<!-- NAME -->
					<div class="form-group">
						<label class='control-label col-md-2' for='first_name' >First Name:</label>
						<div class='col-md-2'>          
							<input type='text' class='form-control' id='first_name' name='first_name' value="<?php echo $FirstName; ?>" disabled>
						</div>
						<label class='control-label col-md-2' for='second_name'>Last Name:</label>
						<div class='col-md-2'>        
							<input type='text' class='form-control' id='second_name' name='second_name' value="<?php echo $SecondName; ?>" disabled>
						</div>
						
					</div>
					<!-- FORM GROUP ENDS -->
			
					<!-- ACADEMIC INFROMATION -->
					<div class="form-group">
						<label class='control-label col-md-2' for='asu_id'>ASU ID/Student ID Number:</label>
						<div class='col-md-2'>          
							<input type='text' class='form-control' id='asu_id' name='asu_id' value="<?php echo $ASU_ID; ?>" disabled>
						</div> 
				
						<label class='control-label col-md-2' for='student_mail'>ASURITE ID:</label>
						<div class='col-md-2'>
							<input type='text' class='form-control' id='student_mail' name='student_mail' value="<?php echo $ASURITE; ?>" disabled>
						</div>
					</div>
					<!-- FORM GROUP ENDS -->
					
					<div class="form-group">
						<label class='control-label col-md-2' for='prog_start_date' >Program Start Date:</label>
						<div class='col-md-2'>          
							<input type='text' class='form-control' id='prog_start_date' name='prog_start_date' data-calendar='false' value="<?php echo $ProgramStart; ?>" disabled>
						</div>
				
						<label class='control-label col-md-2' for='sem_in_prog'>Semester in Progress:</label>
						<div class='col-md-2'>   
							<input type='text' class='form-control' id='sem_in_prog' name='sem_in_prog' data-calendar='false' value="<?php echo $SemesterProgress; ?>" disabled>          
						</div>

						<label class='control-label col-md-2' for='cumulative_gpa'>Cumulative GPA:</label>
						<div class='col-md-2'>          
							<input type='text' class='form-control' id='cumulative_gpa' name='cumulative_gpa' value="<?php echo $CGPA; ?>" disabled>
						</div>
					</div>
					<!-- FORM GROUP ENDS -->
					
					<!-- COURSES -->

					<div class="form-group">
												
						<div class="table-responsive">
							<table id="coursesTable">
								<thead>
								<tr>
									<th data-formatter="getRowIndex" style="width: 36px;"></th>
									<th data-field="courseUniqueID" visible="false"></th>
									<th data-field="course" data-title="Course"/>
									<th data-field="grade" data-title="Grade"/>
								</tr>
								</thead>
							</table>
						</div>

					</div>
					<!-- FORM GROUP ENDS -->
					
					<!-- ADVISORY COMMITTEE -->
					<div class="form-group">
				
							<label class='control-label col-md-5' for='advisory_committee'>Advisory Committee Formed?</label>
							<div id='adv_committee'> 
								<label class='control-label col-md-1'><?php if($AdvisoryComPresent == 1) echo "Yes"; else if($AdvisoryComPresent == 0) echo "No";?></label>
							</div>
					</div>
					<!-- FORM GROUP ENDS -->					
					
					<!-- ADVISORY COMMITTEE TABLE -->
					<div class="form-group">	
						<div class="table-responsive" style="display:none" id="advisor_member_div">
							<table id="advisorTable">
								<thead>
								<tr>
									<th data-formatter="getRowIndex" style="width: 36px;"></th>
									<th data-field="advisorUniqueID" visible="false"></th>
									<th data-field="advisorType" data-title="Advisor Position">
									<th data-field="advisorFirstName" data-title="First Name">
									<th data-field="advisorLastName" data-title="Last Name">
									<th data-field="advisorEmailID" data-title="E-mail ID">
								</tr>
								</thead>
							</table>
						</div>
					</div>
					<!-- FORM GROUP ENDS -->
					
					<!-- STUDENT MET CHAIR -->
					<div class='form-group'>
						<div class="row">
							<label class='control-label col-md-5' for='advisor'>Has the student met the Chair for the current academic year?</label>
							<div id='advisor'>
								<label class='control-label col-md-1'><?php if($MetChair == 1) echo "Yes"; else if($MetChair == 0) echo "No";?></label>
							</div>
						</div>
						<br>
						<!-- STUDENT NOT MET CHAIR REASON -->
						<div class="row">
							<div id="NotMetChairReason_div" <?php if($MetChair == 1) echo 'style="display:none"'; ?>>
								<label class='control-label col-md-4' for='chair_notmet_reason'>Reason for not having an advisory committee yet</label>
								<div class='col-md-8' for='chair_notmet_reason'>
									<textarea class='form-control' name='chair_notmet_reason' id='chair_notmet_reason' disabled><?php if($MetChair == 0) echo $NotMetReason; ?></textarea>
								</div>
							</div>
						</div>
					</div>
					<!-- FORM GROUP ENDS -->

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
						
							<label class='control-label col-md-4' for='qualifying_exam_completed'>Qualifying Exam Completed?</label>
							<div id='qualifying_exam_completed'>
								<label class='control-label col-md-1'><?php if($QualExamComp == 1) echo "Yes"; else if($QualExamComp == 0) echo "No";?></label> 
							</div>
					</div>
					<div class="form-group">
						<div class="table-responsive" id="qualifying_exam_subjects_div" style="display:none">	
						
							<table id="qualifying_subject_table">
								<thead>
								<tr>
									<th data-formatter="getRowIndex" style="width: 36px;"></th>
									<th data-field="qualSubUniqueID" visible="false"></th>
									<th data-field="qualifyingSubject" data-title="Qualifying Exam Subject">
									<th data-field="qualifyingSubjectGrade" data-title="Grade">
								</tr>
								</thead>
							</table>							
						</div>
					</div>
					<!-- FORM GROUP ENDS -->
					
					<!--WRITTEN COMPREHENSIVE EXAM -->
					<div class="form-group">
						<label class='control-label col-md-4' for='comprehensive_exam'>Written Comprehensive Exam Completed?</label>
						<div id='adv_committee'> 
							<label class='control-label col-md-1'><?php if($ComprehensiveExamCompleted == 1) echo "Yes"; else if($ComprehensiveExamCompleted == 0) echo "No";?></label>
						</div>
					</div>
					
					<!--COMPREHENSIVE EXAM TABLE -->
					<div class="form-group">
						<div class="table-responsive" id="comprehensive_exam_div" style="display:none">
							<table id="comprehensiveExamTable">
								<thead>
								<tr>
									<th data-formatter="getRowIndex" style="width: 36px;"></th>
									<th data-field="compExamUniqueID" visible="false"></th>
									<th data-field="comprehensiveExam" data-title="Written Comprehensive Exam">
									<th data-field="compExamGrade" data-title="Grade">
								</tr>
								</thead>
							</table>
						</div>
					</div>
					<!--FORM GROUP ENDS -->
										
					<!-- DISSERTATION PROSPECTUS -->
					<div class='form-group'>
						<div class="row">
							<label class='control-label col-md-4' for='dissertation_prosectus'>Dissertation prospectus completed?</label>
							<div id='dissertation_prosectus_div'> 
								<label class='control-label col-md-1'><?php if($DissertationProspectus == 1) echo "Yes"; else if($DissertationProspectus == 0) echo "No";?></label>
							</div>						
						</div>					
					
						<!-- COLLOQUIUM ATTENDED -->
						<div class="row">
							<label class='control-label col-md-4' for='colloquium'>Colloquium/Distinguished Lecture Series Attended?</label>
							<div id='colloquium_attended_div'> 
								<label class='control-label col-md-1'><?php if($Colloquium_Attended == 1) echo "Yes"; else if($Colloquium_Attended == 0) echo "No";?></label>
							</div>		
						</div>
						
						<!-- COLLOQUIUM ATTENDED YES-->
					
						<div class="row" id="colloquium_semester_div" style="display:none">
						<label class='control-label col-md-4' for='colloquium_semester'>Tick if attended more than 75% of the colloquium lectures for mentioned semesters</label>
						<div class='col-md-8' for='colloquium_semester'>
							<input type='checkbox' name='colloquium_semester' id='colloquium_semester' value='Semester 1' <?php if(in_array('Semester 1',$Colloquium_Semesters))echo"checked='checked'" ?> disabled>Semester 1
							<input type='checkbox' name='colloquium_semester' id='colloquium_semester' value='Semester 2' <?php if(in_array('Semester 2',$Colloquium_Semesters))echo"checked='checked'" ?> disabled>Semester 2
							<input type='checkbox' name='colloquium_semester' id='colloquium_semester' value='Semester 3' <?php if(in_array('Semester 3',$Colloquium_Semesters))echo"checked='checked'" ?> disabled>Semester 3
							<input type='checkbox' name='colloquium_semester' id='colloquium_semester' value='Semester 4' <?php if(in_array('Semester 4',$Colloquium_Semesters))echo"checked='checked'" ?> disabled>Semester 4
						</div>
						</div>
					</div>
					<!-- FORM GROUP ENDS -->
					
					<!-- CURRENT ACCOMPLISHED GOALS 
					
					<div class="form-group">
						<div class="table-responsive">
							<table id="currentGoalsTable">
								<thead>
									<tr>
										<th data-formatter="getRowIndex" style="width: 36px;"></th>
										<th data-field="currentGoalUniqueID" visible="false"></th>
										<th data-field="currentGoal" data-title="Current Accomplished Goals"/>									
									</tr>
								</thead>
							</table>
						</div>
					</div>
					<!-- FORM GROUP ENDS -->
					
					
					<!-- PUBLICATIONS -->
					<div class="form-group">

						<div class="table-responsive">
							<table id="publicationsTable">
								<thead>
									<tr>
										<th data-formatter="getRowIndex" style="width: 36px;"></th>
										<th data-field="publicationUniqueID" visible="false"></th>
										<th data-field="publication" data-title="Publications"/>
									</tr>
								</thead>
							</table>
						</div>
					</div>
					<!-- FORM GROUP ENDS -->
					
					<!-- PRESENTATIONS -->
					<div class="form-group">
										
						<div class="table-responsive">
							<table id="presentationsTable">
								<thead>
									<tr>
										<th data-formatter="getRowIndex" style="width: 36px;"></th>
										<th data-field="presentationUniqueID" visible="false"></th>
										<th data-field="presentation" data-title="Presentations"/>
									</tr>
								</thead>
							</table>
						</div>
					</div>
					<!-- FORM GROUP ENDS -->
					
					<!-- FUTURE GOALS 
					
					<div class="form-group">
						<div class="table-responsive">
							<table id="futureGoalsTable">
								<thead>
									<tr>
										<th data-formatter="getRowIndex" style="width: 36px;"></th>
										<th data-field="futureGoalUniqueID" visible="false"></th>
										<th data-field="futureGoal" data-title="Future Goals"/>
									</tr>
								</thead>
							</table>
						</div>
					</div>
					<!-- FORM GROUP ENDS -->
					
				</div>
				<!-- PANEL BODY ENDS -->
			</div>
			<!-- PANEL B ENDS -->
			
			<!-- PANEL C STARTS 
			<div class="panel panel-primary">
				<div class="panel-heading">Section C | Transcripts</div>
				<div class="panel-body">
					<div class="form-group">
						<a class="btn" href='./uploads/<?php echo $ASU_ID."-StudentiPOS"?>'>iPOS/Transcript</a>
					</div>
				</div>
				<!-- PANEL BODY ENDS 
			</div>
			<!-- PANEL C ENDS -->
			
			<!-- PANEL C STARTS -->
			<div class="panel panel-primary">
				<div class="panel-heading">Section C | Comments</div>
				<div class="panel-body">
					<div class="form-group">
      					<textarea class='form-control' name='comments_textarea' id='comments_textarea' disabled></textarea>
					</div>
				</div>
				<!-- PANEL BODY ENDS -->
			</div>
			<!-- PANEL C ENDS -->
			
		</form>
	</div>
</body>

</html>


