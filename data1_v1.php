<?php

define('FPDF_FONTPATH','./font/');
require('fpdf.php');

include('connect.php');

//get values from the form

$DEGREE_SELECT=$_POST['degree_select'];
$MS_IN_PASSING = $_POST['ms_in_passing'];
$GRADUATION_COMPLETED = $_POST['graduation_completed'];
$ASU_ID = $_POST['asu_id'];
$FIRST_NAME = $_POST['first_name'];
$SECOND_NAME = $_POST['second_name'];
$ACADEMIC_YEAR =$_POST['academic_year'] ;
$ACADEMIC_YEAR_FALL =$_POST['academic_year_fall'] ;
$ACADEMIC_YEAR_SPRING =$_POST['academic_year_spring'] ;
$STUDENT_MAIL=$_POST['student_mail'];
$PROGRAM_DATE=$_POST['prog_start_date'];
$SEMESTER_PROGRESS=$_POST['sem_in_prog'];
$CUM_GPA=$_POST['cum_gpa'];
$COURSE=mysqli_real_escape_string($conn,$_POST['course']);
$GRADE=$_POST['grade'];
$WRITTENSUBJECTS=mysqli_real_escape_string($conn,$_POST['written_subjects']);
$WRITTENGRADES=$_POST['written_grades'];
$QUALIFYINGSUBJECTS=$_POST['qualifying_subjects'];
$QUALIFYINGGRADES=$_POST['qualifying_grades'];
$ADVISORPOSITION=$_POST['advisor_position'];
$ADVISORFIRSTNAME=$_POST['advisor_firstname'];
$ADVISORSECONDNAME=$_POST['advisor_secondname'];
$ADVISORMAIL=$_POST['advisor_mail'];
//$fileName = $ASU_ID."-StudentiPOS";

//$fileTmpLoc = $_FILES["file"]["tmp_name"];
//$file_size = $_FILES['file']['size'];
//$file_type = $_FILES['file']['type'];
// Path and file name
//$pathAndName = "/var/www/somss/uploads/".$fileName;
print_r($pathAndName);
// Run the move_uploaded_file() function here
//move_uploaded_file($fileTmpLoc, $pathAndName);
$ADVISORY_COMMITTEE=$_POST['advisory_committee'];
#$MAIL=$_POST['mail'];
$MET_ADVISOR=$_POST['met_advisor'];
$NO_COURSE_REASON = $_POST['no_course_reason'];
$NO_ADV_COMM_REASON = $_POST['no_adv_comm_reason'];
$ASURITE=$_POST['asurite'];
if($_POST['met_advisor']==='1')
{
        //$ADVISORY_COMMITTEE_REASON='The Student met the advisory committee';
        $ADVISORY_COMMITTEE_REASON='The Student met the Chair';
}
else
{
	$ADVISORY_COMMITTEE_REASON=mysqli_real_escape_string($conn,$_POST['chair_notmet_reason']);
}
$COMPREHENSIVE_EXAM=$_POST['comprehensive_exam'];
$ORAL_COMPREHENSIVE_EXAM=$_POST['oral_comprehensive_exam'];
$COLLOQUIUM=$_POST['colloquium'];
if($COLLOQUIUM==='1')
{
	$COLLOQUIUMSEMESTER=$_POST['colloquium_semester'];
}
else
{
	$COLLOQUIUMSEMESTER="The student has not attended any colloquium lectures";
}

$QUALIFYING_EXAM=$_POST['qualifying_exam'];

//$CURRENT_GOAL=mysqli_real_escape_string($conn,$_POST['current_goal']);
//$PUBLICATION=mysqli_real_escape_string($conn,$_POST['publication']);
$PUBLICATION_TITLE=mysqli_real_escape_string($conn,$_POST['publication_title']);
$PUBLICATION_JOURNAL=mysqli_real_escape_string($conn,$_POST['publication_journal']);
$PUBLICATION_STATUS=mysqli_real_escape_string($conn,$_POST['publication_status']);
$PUBLICATION_DOI=mysqli_real_escape_string($conn,$_POST['publication_doi']);
$PUBLICATION_URL=mysqli_real_escape_string($conn,$_POST['publication_url']);

//$PRESENTATION=mysqli_real_escape_string($conn,$_POST['presentation']);

$PRESENTATION_TITLE=mysqli_real_escape_string($conn,$_POST['presentation_title']);
$PRESENTATION_PLACE=mysqli_real_escape_string($conn,$_POST['presentation_place']);
$PRESENTATION_TYPE=mysqli_real_escape_string($conn,$_POST['presentation_type']);
$AWARDS = mysqli_real_escape_string($conn,$_POST['awards_array']);
$MAIN_ADVISOR=$_POST['main_advisor'];
//$FUTURE_GOAL=mysqli_real_escape_string($conn,$_POST['future_goal']);
$EXTRA=$_POST['extra'];
$APPROVAL=json_encode(array());
/*
$fileName = $ASU_ID."-StudentiPOS";

$fileTmpLoc = $_FILES["file"]["tmp_name"];
$file_size = $_FILES['file']['size'];
$file_type = $_FILES['file']['type'];
// Path and file name
$pathAndName = "/var/www/somss/uploads/".$fileName;
//print_r($pathAndName);
// Run the move_uploaded_file() function here
move_uploaded_file($fileTmpLoc, $pathAndName);
*/
//tables exist for every academic year
//create table if it doesn't exist for the academic year input
$table_name = $ACADEMIC_YEAR_FALL."_".$ACADEMIC_YEAR_SPRING;
$dt = date('Y-m-d');
//echo "'<script>console.log(\"$table_name\")</script>'";

/*
$createtable_query = "CREATE TABLE IF NOT EXISTS ".$table_name."(Degree varchar(30), ASU_ID bigint(1) NOT NULL PRIMARY KEY, ASURITE varchar(20), First_Name varchar(20), Second_Name varchar(20), Academic_Year varchar(12), Student_Mail varchar(40), Program_start_date varchar(30), Semester_in_progress varchar(12), CGPA float(3,2), Course varchar(3000), Grade varchar(100), Adivisory_Committee tinyint(1), Mail varchar(200), Advisor_Position varchar(100), Advisor_Firstname varchar(300), Advisor_Secondname varchar(300), Advisor_Mail varchar(400), Admin_Advisor varchar(30), Student_Advisory_Met tinyint(1), Not_Met_Reason varchar(200), Qualifying_Exam_Completed tinyint(1), Qualifying_Subjects varchar(1500), Qualifying_Grades varchar(70), Written_Comprehensive tinyint(1), Written_Subjects varchar(1500), Written_Grades varchar(70), Oral_Comprehensive tinyint(1), Colloquium tinyint(1), Colloquium_Semester varchar(70), current_goal varchar(500), Publications varchar(1000), Presentations varchar(1000), future_goal varchar(500), Extra varchar(1000), Approved varchar(255), Main_Advisor_Flag tinyint(1), Student_Rating varchar(300), Signature varchar(1000), Director_Comments varchar(500), Director_Signature varchar(200), File_Name varchar(30), Advisor_Team varchar(500), AdvisorComments varchar(500), ChairComments varchar(500), Submission_date date)";
*/

$createtable_query = "CREATE TABLE IF NOT EXISTS ".$table_name."(Degree varchar(30), MS_In_Passing tinyint(1), Graduation_Completed tinyint(1), ASU_ID bigint(1) NOT NULL PRIMARY KEY, ASURITE varchar(20), First_Name varchar(20), Second_Name varchar(20), Academic_Year varchar(12), Student_Mail varchar(40), Program_start_date varchar(30), Semester_in_progress varchar(12), CGPA float(3,2), Course varchar(3000), No_Course_Reason varchar(300), Grade varchar(100), Adivisory_Committee tinyint(1), No_Advisory_Committee_Reason varchar(300), Mail varchar(200), Advisor_Position varchar(100), Advisor_Firstname varchar(300), Advisor_Secondname varchar(300), Advisor_Mail varchar(400), Admin_Advisor varchar(30), Student_Advisory_Met tinyint(1), Not_Met_Reason varchar(200), Qualifying_Exam_Completed tinyint(1), Qualifying_Subjects varchar(1500), Qualifying_Grades varchar(70), Written_Comprehensive tinyint(1), Written_Subjects varchar(1500), Written_Grades varchar(70), Oral_Comprehensive tinyint(1), Colloquium tinyint(1), Colloquium_Semester varchar(70), Publication_Name varchar(2000), Publication_Journal_Name varchar(2000), Publication_Status varchar(200), Publication_DOI varchar(200), Presentation_Title varchar(2000), Presentation_Place varchar(2000), Presentation_Type varchar(200), Extra varchar(1000), Approved varchar(255), Main_Advisor_Flag tinyint(1), Student_Rating varchar(300), Signature varchar(1000), Director_Comments varchar(500), Director_Signature varchar(200), Advisor_Team varchar(500), AdvisorComments varchar(500), ChairComments varchar(500), Submission_date date, Publication_URL varchar(20000))";

$sql =mysqli_query($conn,$createtable_query);

//insert vallues in database Colloquium,Colloquium_Semester '$COLLOQUIUM','$COLLOQUIUMSEMESTER',

/*
$sql =$conn->query("REPLACE INTO ".$table_name."
(Degree,ASU_ID,ASURITE,First_Name,Second_Name,Academic_Year,Student_Mail,Program_start_date,
Semester_in_progress,CGPA,Course,Grade,Adivisory_Committee,Advisor_Position,Advisor_Firstname,
Advisor_Secondname,Advisor_Mail,Admin_Advisor,Student_Advisory_Met,Not_Met_Reason,
Qualifying_Exam_Completed,Qualifying_Subjects,Qualifying_Grades,Written_Comprehensive,
Written_Subjects,Written_Grades,Oral_Comprehensive,current_goal,Colloquium,Colloquium_Semester,
Publications,Presentations,future_goal,Extra,Approved,File_Name, Submission_date)
VALUES 
('$DEGREE_SELECT','$ASU_ID','$ASURITE','$FIRST_NAME','$SECOND_NAME','$ACADEMIC_YEAR',
'$STUDENT_MAIL','$PROGRAM_DATE','$SEMESTER_PROGRESS','$CUM_GPA',
'$COURSE','$GRADE',
'$ADVISORY_COMMITTEE','$ADVISORPOSITION','$ADVISORFIRSTNAME','$ADVISORSECONDNAME',
'$ADVISORMAIL','$MAIN_ADVISOR','$MET_ADVISOR','$ADVISORY_COMMITTEE_REASON','$QUALIFYING_EXAM',
'$QUALIFYINGSUBJECTS','$QUALIFYINGGRADES','$COMPREHENSIVE_EXAM','$WRITTENSUBJECTS','$WRITTENGRADES',
'$ORAL_COMPREHENSIVE_EXAM','$CURRENT_GOAL','$COLLOQUIUM','$COLLOQUIUMSEMESTER','$PUBLICATION',
'$PRESENTATION','$FUTURE_GOAL','$EXTRA','$APPROVAL','$fileName', '$dt')");
*/


$sql =$conn->query("REPLACE INTO ".$table_name."
(Degree,MS_In_Passing,Graduation_Completed,ASU_ID,ASURITE,First_Name,Second_Name,Academic_Year,Student_Mail,Program_start_date,
Semester_in_progress,CGPA,Course,No_Course_Reason,Grade,Adivisory_Committee,No_Advisory_Committee_Reason,Advisor_Position,Advisor_Firstname,
Advisor_Secondname,Advisor_Mail,Admin_Advisor,Student_Advisory_Met,Not_Met_Reason,
Qualifying_Exam_Completed,Qualifying_Subjects,Qualifying_Grades,Written_Comprehensive,
Written_Subjects,Written_Grades,Oral_Comprehensive,Colloquium,Colloquium_Semester,
Publication_Name,Publication_Journal_Name,Publication_Status,Publication_DOI, Presentation_Title,Presentation_Place,Presentation_Type,Awards,Extra,Approved, Submission_date, Publication_URL)
VALUES 
('$DEGREE_SELECT','$MS_IN_PASSING','$GRADUATION_COMPLETED','$ASU_ID','$ASURITE','$FIRST_NAME','$SECOND_NAME','$ACADEMIC_YEAR',
'$STUDENT_MAIL','$PROGRAM_DATE','$SEMESTER_PROGRESS','$CUM_GPA',
'$COURSE','$NO_COURSE_REASON','$GRADE',
'$ADVISORY_COMMITTEE','$NO_ADV_COMM_REASON','$ADVISORPOSITION','$ADVISORFIRSTNAME','$ADVISORSECONDNAME',
'$ADVISORMAIL','$MAIN_ADVISOR','$MET_ADVISOR','$ADVISORY_COMMITTEE_REASON','$QUALIFYING_EXAM',
'$QUALIFYINGSUBJECTS','$QUALIFYINGGRADES','$COMPREHENSIVE_EXAM','$WRITTENSUBJECTS','$WRITTENGRADES',
'$ORAL_COMPREHENSIVE_EXAM','$COLLOQUIUM','$COLLOQUIUMSEMESTER','$PUBLICATION_TITLE','$PUBLICATION_JOURNAL','$PUBLICATION_STATUS','$PUBLICATION_DOI',
'$PRESENTATION_TITLE','$PRESENTATION_PLACE','$PRESENTATION_TYPE','$AWARDS','$EXTRA','$APPROVAL', '$dt', '$PUBLICATION_URL')");



$sqlcount=$conn->query("select count(*) from ".$table_name." where ASU_ID='$ASU_ID'");

$row=$sqlcount->fetch_row();

if (mysqli_query($conn,$sql)) {
    echo "New record created successfully";
	echo "'<script>console.log(\"New record created successfully\")</script>'";

} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    //echo "'<script>console.log(\"mysqli_error($conn)\")</script>'";
    //echo "'<script>console.log(\"Error\")</script>'";
}
//mysqli_close($conn);


//STORE GRADUATION SURVEY
$SURVEY_EMAIL = $_POST['survey_email_text'];
$SURVEY_EMPLOYMENT = $_POST['survey_employment'];
$SURVEY_EMPLOYMENT_TEXT = $_POST['survey_employment_text'];

if($GRADUATION_COMPLETED === '1'){

	$createtable_query = "CREATE TABLE IF NOT EXISTS graduation_survey(ASU_ID bigint(1) NOT NULL, Email varchar(40), employment_info tinyint(1), employment_info_detail varchar(300), PRIMARY KEY (ASU_ID))";

	$sql =mysqli_query($conn,$createtable_query);

	$sql = $conn->query("INSERT INTO graduation_survey(ASU_ID, Email, employment_info, employment_info_detail) 
						VALUES
						('$ASU_ID','$SURVEY_EMAIL','$SURVEY_EMPLOYMENT','$SURVEY_EMPLOYMENT_TEXT')");
	
	if (mysqli_query($conn,$sql)) {
		echo "New graduation_survey record created successfully";
		echo "'<script>console.log(\"New graduation_survey record created successfully\")</script>'";

	} else {
		echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		//echo "'<script>console.log(\"mysqli_error($conn)\")</script>'";
		//echo "'<script>console.log(\"Error\")</script>'";
	}
}

//GENERATE PDF REPORT
class PDF extends FPDF
{
function FancyTable($retval)
{
    // Colors, line width and bold font
    $this->SetFillColor(219,130,127);
    $this->SetTextColor(0);
    $this->SetDrawColor(128,0,0);
    $this->SetLineWidth(.3);
    $this->SetFont('','i');
	
	
	while($row = mysqli_fetch_array($retval, MYSQLI_ASSOC))
	{
	

		//echo "<script>console.log('Hello')</script>";
		//All this are fixed values and cannot change by any means.
		$ASU_ID = $row['ASU_ID'];
		$asurite = $row['ASURITE'];
		$firstname = $row['First_Name'];
		$secondname = $row['Second_Name'];
		$academicyear = $row['Academic_Year'];
		$studentmail = $row['Student_Mail'];
		$programstartdate= $row['Program_start_date'];
		$semester = $row['Semester_in_progress'];
		$cgpa = $row['CGPA'];
		
		
		
		if($row['MS_In_Passing']==='1')
		{
			$MS_IN_PASSING = "Yes";
		}
		else{
			$MS_IN_PASSING = "No";
		}

		if($row['Graduation_Completed']==='1')
		{
			$GRADUATION_COMPLETED = "Yes";
		}
		else{
			$GRADUATION_COMPLETED = "No";
		}

		
		// This will need to be a table .
		$COURSE_TAKEN = "No";
		$NO_COURSE_REASON = $row['No_Course_Reason'];
		if($NO_COURSE_REASON == ""){
			$COURSE_TAKEN = "Yes";
			$NO_COURSE_REASON = "Not Applicable";
		}
		
		$course=json_decode($row['Course']);
		$grade=json_decode($row['Grade']);
		$Subjects = "-";
		if($COURSE_TAKEN = "Yes"){
			$subjects = array();
			foreach($course as $key=>$value){
				$subjects[$key]=($key+1).')Course: '.$course[$key].' Grade: '.$grade[$key];
			}
			$Subjects=implode("\n",$subjects);
		}


		
		//$grade=implode("\n",$row['Grade']);
		//advisor committee formed?? 
		$NO_ADV_COMM_REASON = $row['No_Advisory_Committee_Reason'];
		if($NO_ADV_COMM_REASON == ""){
			$NO_ADV_COMM_REASON = "Not Applicable";
		}
	
		if($row['Adivisory_Committee']==='1')
		{
			$ADVISORY_COMMITTEE='Yes';
			$Advisor_Position = json_decode($row['Advisor_Position']);
			$Advisor_Firstname = json_decode($row['Advisor_Firstname']);
			$Advisor_Secondname = json_decode($row['Advisor_Secondname']);
			$Advisor_Mail = json_decode($row['Advisor_Mail']);
			$advisor_list = array();
			foreach($Advisor_Firstname as $key=>$value){
				$advisor_list[$key] =($key+1).") ".$Advisor_Position[$key]." ".$Advisor_Firstname[$key]." ".$Advisor_Secondname[$key]." ".$Advisor_Mail[$key];

			}
			$Advisor_list = implode("\n",$advisor_list);

		}
		else
		{
			$ADVISORY_COMMITTEE='No';
			$Advisor_list = "-";
		}


		if($row['Student_Advisory_Met']==='1')
		{
			$STUDENT_ADVISOR='Yes';
			$Reason = "Student met the Chair";
		}
		else
		{
			$STUDENT_ADVISOR='No';
			$Reason = $row['Not_Met_Reason'];
		}


		if($row['Qualifying_Exam_Completed']==='1')
		{
			$QUALIFYING_EXAM='Yes';
			//Qualifying subjects and grades ka table where we have to enter the value
			$qualify_subjects=json_decode($row['Qualifying_Subjects']);
			$qualify_grades=json_decode($row['Qualifying_Grades']);

			$qualify = array();
			foreach($qualify_subjects as $key=>$value)
			{
				$qualify[$key]=($key+1).") ".$qualify_subjects[$key]." ".$qualify_grades[$key];
			}
			$Qualify = implode("\n",$qualify);

		}
		else
		{
			$QUALIFYING_EXAM='No';
			$Qualify = "-";
			//Qualifying subjects N/A aana chaiye
		}




		//same as qualifying subjects
		if($row['Written_Comprehensive']==='1')
		{
			$WRITTEN_EXAM='Yes';
			//Written_Comprehensive subjects and grades ka table where we have to enter the value
			$written_subjects=json_decode($row['Written_Subjects']);
			$written_grades=json_decode($row['Written_Grades']);


			$written = array();
			foreach($written_subjects as $key=>$value)
			{
				$written[$key]=($key+1).") ".$written_subjects[$key]." ".$written_grades[$key];
			}

			$Written = implode("\n",$written);
		}
		else
		{
			$WRITTEN_EXAM='No';
			$Written = "-";
			//Written_Comprehensive N/A aana chaiye
		}


		if($row['Oral_Comprehensive']==='1')
		{
			$ORAL='Yes';
		}
		else
		{
			$ORAL='No';
		}



	
		if($row['Colloquium']==='1')
		{
			$Coll='Yes';
			//json decode the colloquim array
			$coll_sem=implode("\n",json_decode($row['Colloquium_Semester']));
		}
		else
		{
			$Coll='No';
			$coll_sem = "-";
		}
	
	

	//Publications
	$Publication_Title =json_decode($row['Publication_Name']);
	$Publication_Journal =json_decode($row['Publication_Journal_Name']);
	$Publication_Status =json_decode($row['Publication_Status']);
	$Publication_DOI =json_decode($row['Publication_DOI']);
	$Publication_URL = json_decode($row['Publication_URL']);
	$Pubs = "-";
	if(count($Publication_Title) > 0){
		$pub = array();
		foreach($Publication_Title as $key=>$value)
		{
			$pub_text = ($key+1).") ".$Publication_Title[$key]." : ".$Publication_Journal[$key]." : ".$Publication_Status[$key];
			if($Publication_Status[$key] == "Published")
				$pub_text = $pub_text." : ".$Publication_DOI[$key];
			if($Publication_Status[$key] == "ArXiv")
				$pub_text = $pub_text." : ".$Publication_URL[$key];
			$pub[$key]=$pub_text;
		}
		$Pubs=implode("\n",$pub);
	}

	//Presentations
	//$Presentations=json_decode($row['Presentations']);
	
	$Presentation_Title =json_decode($row['Presentation_Title']);
	$Presentation_Place =json_decode($row['Presentation_Place']);
	$Presentation_Type =json_decode($row['Presentation_Type']);
	$Pres = "-";
	if(count($Presentation_Title) > 0){
		$pre = array();
		foreach($Presentation_Title as $key=>$value)
		{
			$pre[$key]=($key+1).") ".$Presentation_Type[$key]." : ".$Presentation_Title[$key]." : ".$Presentation_Place[$key];
		}
		$Pres=implode("\n",$pre);
	}
	
	//Awards
	$Awards_array=json_decode($row['Awards']);
	$Awards = "-";
	if(count($Awards_array) > 0){
		$award = array();
		foreach($Awards_array as $key=>$value)
		{
			$award[$key]=($key+1).") ".$Awards_array[$key];
		}
		$Awards=implode("\n",$award);
	}

	
	/*

	//current goals
	$current_goal =json_decode($row['current_goal']);
	$cg = array();
	foreach($current_goal as $key=>$value)
	{
		$cg[$key]=($key+1).") ".$current_goal[$key];
	}
	$CG=implode("\n",$cg);


	//future goals
	$future_goal =json_decode($row['future_goal']);
	$fg = array();
	foreach($future_goal as $key=>$value)
	{
		$fg[$key]=($key+1).") ".$future_goal[$key];
	}
	$FG=implode("\n",$fg);


	//Student Rating
	//left

	//Signature of advisor and graduate co-ordinator
	$Signature = json_decode($row['Signature'],true);
	$sig = array();
	foreach($Signature as $key=>$value)
	{
		$sig[$key]=$Signature[$key];
	}
	$Sig=implode("\n",$sig);
 
	//Advisor Comments

	//chair comments
	$chair= $row['ChairComments'];
	//left

	//Director signature
	$DIRECTOR_SIGNATURE= json_decode($row['Director_Signature']);
	$DS=implode("\n",$DIRECTOR_SIGNATURE);

	$Director_Comments = $row['Director_Comments'];
	*/

	//print_r($row['Signature']);
	//$STUDENT_MAIL= $row['Student_Mail'];
	//global $STUDENT_MAIL;	
	$line_break=0;	



	    $this->Cell(80);
	    // Framed title
	    $this->Cell(30,10,'PhD Progress Report Form - Approved',0,0,'C');
	    // Line break
	    $this->Ln(20);


		$this->Cell(100,10,"Academic Year",0);
     	   	$this->Cell(80,10,$academicyear."-".($academicyear+1) ,0);
		$this->Ln();
		$this->Cell(100,10,"First Name",0);
        	$this->Cell(80,10,$firstname,0);
		$this->Ln();
		$this->Cell(100,10,"Last Name",0);
        	$this->Cell(80,10,$secondname,0);
		$this->Ln();
		$this->Cell(100,10,"ASU ID of Student",0);
        	$this->Cell(80,10,$ASU_ID,0);
		$this->Ln();
		$this->Cell(100,10,"Program Start Date",0);
        	$this->Cell(80,10,$programstartdate,0);
		$this->Ln();
 		$this->Cell(100,10,"Current Semester",0);
		$this->Cell(80,10,$semester,0);
		$this->Ln();

		$this->Cell(100,10,"CGPA",0);
                $this->Cell(80,10,$cgpa,0);
                $this->Ln();

		$this->Cell(100,10,"Have you applied for Masters in Passing?",0);
		$this->Cell(80,10,$MS_IN_PASSING,0);
		$this->Ln();
		$this->Cell(100,10,"Have you graduated?",0);
		$this->Cell(80,10,$GRADUATION_COMPLETED,0);
		$this->Ln();
	
	
		$this->Cell(100,10,"Did you take any Course(s) during the current academic year?",0);
		$this->Cell(80,10,$COURSE_TAKEN,0);
		$this->Ln();
		
		$this->Cell(100,10,"Reason for not taking any course",0);
		$this->Cell(80,10,$NO_COURSE_REASON,0);
		$this->Ln();
       
        $width = ceil($this->GetStringWidth($Subjects)/75);
        $width1=ceil($width/2);
        $total_width = $width + $width1;
		$this->Cell(100,5*$total_width,"Courses taken since last progress report",0);
		$this->Multicell(80,5,$Subjects,0);
		$this->Ln();


        $this->Cell(100,10,"Advisory Committee Formed?",0);
        $this->Cell(80,10,$ADVISORY_COMMITTEE,0);
        $this->Ln();
    
		$this->Cell(100,10,"Reason for not forming Advisory Committee",0);
		$this->Cell(80,10,$NO_ADV_COMM_REASON,0);
		$this->Ln();

        $width = ceil($this->GetStringWidth($Advisor_list)/75);
        $width1=ceil($width/2);
        $total_width = $width + $width1;
        if($total_width==0){$total_width=1;}
        $this->Cell(100,5*$total_width,"Advisor Committee Members",0);
        $this->Multicell(80,5,$Advisor_list,0);
        $this->Ln();


        $this->Cell(100,10,"Did you meet the Chair for the current academic year?",0);
		$this->Cell(80,10,$STUDENT_ADVISOR,0);
        $this->Ln();

        $this->Cell(100,10,"Reason for not meeting the Chair?",0);
		$this->Cell(80,10,$Reason,0);
        $this->Ln();

        $this->Cell(100,10,"Qualifying Exam Completed?",0);
		$this->Cell(80,10,$QUALIFYING_EXAM,0);
        $this->Ln();

        $width = ceil($this->GetStringWidth($Qualify)/75);
        
        if($width==0){$width=1;}
        $this->Cell(100,5*$width,"Qualify Exam Subjects",0);
        $this->Multicell(80,5,$Qualify,0);
        $this->Ln();

        $this->Cell(100,10,"Written Comprehensive Exam Completed?",0);
		$this->Cell(80,10,$WRITTEN_EXAM,0);
        $this->Ln();

        $width= ceil($this->GetStringWidth($Written)/75);
        if($width==0){$width=1;}
        $this->Cell(100,5*$width,"Written Comprehensive Exam Subjects",0);
        $this->Multicell(80,5,$Written,0);
        $this->Ln();


        $this->Cell(100,10,"Oral Comprehensive Exam Completed?",0);
		$this->Cell(80,10,$ORAL,0);
        $this->Ln();

        $this->Cell(100,10,"Colloquium lectures attended?",0);
		$this->Cell(80,10,$Coll,0);
        $this->Ln();

        $this->Cell(100,10,"Semester when lectures attended?",0);
		$this->Cell(80,10,$coll_sem,0);
        $this->Ln();

        $width= ceil($this->GetStringWidth($Pubs)/75);

        if($width==0){$width=1;}
        $this->Cell(100,5*$width,"Publications",0);
        $this->Multicell(80,5,$Pubs,0);
        $this->Ln();

        $width= ceil($this->GetStringWidth($Pres)/75);

        if($width==0){$width=1;}
        $this->Cell(100,5*$width,"Presentations",0);
        $this->Multicell(80,5,$Pres,0);
        $this->Ln();
        
        $width= ceil($this->GetStringWidth($Awards)/75);

        if($width==0){$width=1;}
        $this->Cell(100,5*$width,"Awards",0);
        $this->Multicell(80,5,$Awards,0);
        $this->Ln();
        
        /*
        $width= ceil($this->GetStringWidth($CG)/75);
       
        if($width==0){$width=1;}
        $this->Cell(100,5*$width,"Goals met in current period",0);
        $this->Multicell(80,5,$CG,0);
        $this->Ln();

        $width= ceil($this->GetStringWidth($FG)/75);

        if($width==0){$width=1;}
        $this->Cell(100,5*$width,"Goals for next academic year",0);
        $this->Multicell(80,5,$FG,0);
        $this->Ln();

        $width= ceil($this->GetStringWidth($Sig)/75);

        if($width==0){$width=1;}
        $this->Cell(100,5*$width,"Signature of the Advisor Team",0);
        $this->Multicell(80,5,$Sig,0);
        $this->Ln();


      	//student rating ????



        //director comments
        $width= ceil($this->GetStringWidth($director_comments)/75);
        if($width==0){$width=1;}
        $this->Cell(100,5*$width,"Director Comments",0);
        $this->Multicell(80,5,$Director_Comments,0);
        $this->Ln();


        //Director Signature.
        $this->Cell(100,10,"Director Signature with Date and Time",0);
		$this->Multicell(80,5,$row['Director_Signature'],0);
        $this->Ln();

		
		$to=$row['Student_Mail'];
		*/
        
	}
		//echo "<script>console.log('Hello')</script>";
}

}



$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',10);

$sql1 = "SELECT * from ".$table_name." where ASU_ID='$ASU_ID'";
//$sql1 = "SELECT * from somss_test where ASU_ID='$ASU_ID'";
$retval = mysqli_query($conn,$sql1);

$pdf->FancyTable($retval);

//send email to Student and Advisor

$array_length=count(json_decode($ADVISORMAIL,true));
$MAILLIST=json_decode($ADVISORMAIL,true);
$to      = $STUDENT_MAIL;
//$to      = 'gaurav.ravetkar@gmail.com';
$subject = 'PhD Progress Form Submitted';
$message = '<p>Your form has been submitted and awaits approval from your Advisors/Graduate Director. If you chose to not have an advisory committee yet, please get in touch with Graduate Director as soon as possible to have an advisory committee for yourself. You will receive an e-mail once your form is approved by Graduate Director. Please find attached a copy of the report for your reference.</p>';
$from = 'somss.advising@asu.edu';// . "\r\n" .
//$headers = 'From: gaurav.ravetkar@asu.edu';


// a random hash will be necessary to send mixed content
$separator = md5(time());

// carriage return type (we use a PHP end of line constant)
$eol = PHP_EOL;

// attachment name
$filename = $ASU_ID . ".pdf";

// encode data (puts attachment in proper format)
$pdfdoc = $pdf->Output("", "S");
$attachment = chunk_split(base64_encode($pdfdoc));

// main header
$headers  = "From: ".$from.$eol;
$headers .= "MIME-Version: 1.0".$eol; 
$headers .= "Content-Type: multipart/mixed; boundary=\"".$separator."\"";

// no more headers after this, we start the body! //

$body = "--".$separator.$eol;
$body .= "Content-Transfer-Encoding: 7bit".$eol.$eol;
$body .= "".$eol;

// message
$body .= "--".$separator.$eol;
$body .= "Content-Type: text/html; charset=\"iso-8859-1\"".$eol;
$body .= "Content-Transfer-Encoding: 8bit".$eol.$eol;
$body .= $message.$eol;

// attachment
$body .= "--".$separator.$eol;
$body .= "Content-Type: application/octet-stream; name=\"".$filename."\"".$eol; 
$body .= "Content-Transfer-Encoding: base64".$eol;
$body .= "Content-Disposition: attachment".$eol.$eol;
$body .= $attachment.$eol;
$body .= "--".$separator."--";

mail($to, $subject, $body, $headers);


/*
//mail the Advisor to approve the students and send it to the director.

for($i=0;$i<$array_length;$i++)
{
	
$to      = $MAILLIST[$i];
$subject = 'Please approve the PhD Form for student '.$FIRST_NAME.'  '.$SECOND_NAME;
$message = 'PhD Student '.$FIRST_NAME.' '.$SECOND_NAME.' submitted the PhD progress Report Form and chose you as the CHAIR/Co-CHAIR/Member of his committee.

Please visit the below link to sign the advisor form.
https://pi.asu.edu/somss/login.php?ASU_ID='.$ASU_ID.'&index='.$i.'.

Please use this as password 1qazXsw2 to login to the page and to approve the form.
Thank you!
';
//$headers = 'From: somss.advising@asu.edu';// . "\r\n" .
$headers = 'From: dieter@asu.edu';

mail($to, $subject, $message, $headers);

}
*/



//DIRECTOR
if($ADVISORY_COMMITTEE=='0')
{ // if no advisory committte then mail should go directly to director. See code from advisor_data.php last lines.

	$to = "dieter@asu.edu";
        $subject = 'Please Approve Form for student '.$FIRST_NAME.'  '.$SECOND_NAME;
        $message = 'PhD student '.$FIRST_NAME.' '.$SECOND_NAME.' submitted the PhD Progress report form but the student does not have an advising committee yet. Please review and approve the form and kindly meet with the student to form an advising committee.
https://mathcms.asu.edu/somss/director_login.php?ASU_ID='.$ASU_ID.'
        The password for the approval from director is 2wsxZaq1';
        $headers = 'From: somss.advising@asu.edu';

        mail($to, $subject, $message, $headers);

}
else if($ADVISORY_COMMITTEE=='1')
{

	$ADVISORPOSITIONLIST=json_decode($ADVISORPOSITION,true);

	for($i=0;$i<$array_length;$i++)
	{
		if($ADVISORPOSITIONLIST[$i]!= 'MEMBER')
		{
			$to      = $MAILLIST[$i];
			$subject = 'Please approve the PhD Form for student '.$FIRST_NAME.'  '.$SECOND_NAME;
			$message = 'PhD Student '.$FIRST_NAME.' '.$SECOND_NAME.' submitted the PhD progress Report Form and chose you as the '.$ADVISORPOSITIONLIST[$i].' of his committee.

			Please visit the below link to sign the advisor form.
			https://mathcms.asu.edu/somss/login.php?ASU_ID='.$ASU_ID.'&index='.$i.'

			Please use this as password 1qazXsw2 to login to the page and to approve the form.
			Thank you!
			';
			$headers = 'From: somss.advising@asu.edu';// . "\r\n" .
			//$headers = 'From: gaurav.ravetkar@asu.edu';

			mail($to, $subject, $message, $headers);
		}
	}

}

mysqli_close($conn);

?>




