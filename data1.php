<?php

//require_once './login.php';
error_reporting(E_ERROR);
$servername = "localhost";
$username = "root";
$password = "ra!nbow";
$db_name = "SOMSS";
// Create connection
$conn = mysqli_connect($servername, $username, $password, $db_name);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

//get values from the form

$DEGREE_SELECT=$_POST['degree_select'];
$ASU_ID = $_POST['asu_id'];
$FIRST_NAME = $_POST['first_name'];
$SECOND_NAME = $_POST['second_name'];
$ACADEMIC_YEAR =$_POST['academic_year'] ;
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

$ADVISORY_COMMITTEE=$_POST['advisory_committee'];
#$MAIL=$_POST['mail'];
$MET_ADVISOR=$_POST['met_advisor'];
$ASURITE=$_POST['asurite'];
if($_POST['met_advisor']==='1')
{
        $ADVISORY_COMMITTEE_REASON='The Student met the advisory committee';
}
else
{
	$ADVISORY_COMMITTEE_REASON=mysqli_real_escape_string($conn,$_POST['advisory_committee_reason']);
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
	$COLLOQUIUMSEMESTER="The student has not attented any colloquium lectures";
}

$QUALIFYING_EXAM=$_POST['qualifying_exam'];

$CURRENT_GOAL=mysqli_real_escape_string($conn,$_POST['current_goal']);
$PUBLICATION=mysqli_real_escape_string($conn,$_POST['publication']);
$PRESENTATION=mysqli_real_escape_string($conn,$_POST['presentation']);
$MAIN_ADVISOR=$_POST['main_advisor'];
$FUTURE_GOAL=mysqli_real_escape_string($conn,$_POST['future_goal']);
$EXTRA=$_POST['extra'];
$APPROVAL=json_encode(array());
$fileName = $ASU_ID."-StudentiPOS";

$fileTmpLoc = $_FILES["file"]["tmp_name"];
$file_size = $_FILES['file']['size'];
$file_type = $_FILES['file']['type'];
// Path and file name
$pathAndName = "/var/www/somss/uploads/".$fileName;
//print_r($pathAndName);
// Run the move_uploaded_file() function here
$moveResult = move_uploaded_file($fileTmpLoc, $pathAndName);


//insert vallues in database Colloquium,Colloquium_Semester '$COLLOQUIUM','$COLLOQUIUMSEMESTER',

$sql =$conn->query("INSERT INTO SOMSS.somss_2016 
(Degree,ASU_ID,ASURITE,First_Name,Second_Name,Academic_Year,Student_Mail,Program_start_date,
Semester_in_progress,CGPA,Course,Grade,Adivisory_Committee,Advisor_Position,Advisor_Firstname,
Advisor_Secondname,Advisor_Mail,Admin_Advisor,Student_Advisory_Met,Not_Met_Reason,
Qualifying_Exam_Completed,Qualifying_Subjects,Qualifying_Grades,Written_Comprehensive,
Written_Subjects,Written_Grades,Oral_Comprehensive,current_goal,Colloquium,Colloquium_Semester,
Publications,Presentations,future_goal,Extra,Approved,File_Name)
VALUES 
('$DEGREE_SELECT','$ASU_ID','$ASURITE','$FIRST_NAME','$SECOND_NAME','$ACADEMIC_YEAR',
'$STUDENT_MAIL','$PROGRAM_DATE','$SEMESTER_PROGRESS','$CUM_GPA',
'$COURSE','$GRADE',
'$ADVISORY_COMMITTEE','$ADVISORPOSITION','$ADVISORFIRSTNAME','$ADVISORSECONDNAME',
'$ADVISORMAIL','$MAIN_ADVISOR','$MET_ADVISOR','$ADVISORY_COMMITTEE_REASON','$QUALIFYING_EXAM',
'$QUALIFYINGSUBJECTS','$QUALIFYINGGRADES','$COMPREHENSIVE_EXAM','$WRITTENSUBJECTS','$WRITTENGRADES',
'$ORAL_COMPREHENSIVE_EXAM','$CURRENT_GOAL','$COLLOQUIUM','$COLLOQUIUMSEMESTER','$PUBLICATION',
'$PRESENTATION','$FUTURE_GOAL','$EXTRA','$APPROVAL','$fileName')");



$sqlcount=$conn->query("select count(*) from SOMSS.somss_2016 where ASU_ID='$ASU_ID'");

$row=$sqlcount->fetch_row();



if (mysqli_query($conn,$sql)) {
    echo "New record created successfully";


} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
mysqli_close($conn);


//send mail to Student and Advisor


if($row[0]==1){


$array_length=count(json_decode($ADVISORMAIL,true));
$MAILLIST=json_decode($ADVISORMAIL,true);
$to      = $STUDENT_MAIL;
$subject = 'Form Submitted';
$message = 'Your form has been auto-reviewed and has been submitted to the advisors.
Sit back as you will be notified after your progress report has been approved.
If you chose of not having an advisor committee yet please get in touch with Jennifer asap to have a committee for yourself.
Finally,you will receive an e-mail with the approved progress report once approved by both Graduate Co-ordinator and Director.
';
$headers = 'From: somss.advising@asu.edu';// . "\r\n" .

mail($to, $subject, $message, $headers);

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
$headers = 'From: somss.advising@asu.edu';// . "\r\n" .

mail($to, $subject, $message, $headers);

}

//i think i am not sending this variable 
$SIGNATURE1= implode("\n",$_POST['signature']);

$to      = $MAIN_ADVISOR;
$subject = 'Please Approve Form for student '.$FIRST_NAME.'  '.$SECOND_NAME;
if($ADVISORY_COMMITTEE=='0')
{
$message1='
PhD student '.$FIRST_NAME.' '.$SECOND_NAME.' does not have advisors yet. Please co-ordinate with the student and appoint a Chair,Co-Chair and members.
Once The Chair,Co-Chair and Members are appointed and the form is approved by them Please Approve the Form for Requesting the approval from the Director.
https://pi.asu.edu/somss/noadvisor_login.php?ASU_ID='.$ASU_ID;
}
else if($ADVISORY_COMMITTEE=='1')
{
$message1='
PhD student '.$FIRST_NAME.' '.$SECOND_NAME.' has mentioned the following advisors'.$SIGNATURE1.'

Once the Chair,Co-Chair and members Approve the Form only then will you be able to approve the form for Requesting the approval from the Director.
Please use the below link to approve the form.
https://pi.asu.edu/somss/main_advisor_withadvisor.php?ASU_ID='.$ASU_ID.'&index='.$array_length.'
OR
Please go the advisor page to check the status of student\'s approval. 
The password for approving the form and login is 1qazXsw2 ';

}
$headers = 'From: somss.advising@asu.edu';// . "\r\n" .

mail($to, $subject,$message1, $headers);

}

?>



