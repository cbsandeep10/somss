<?php

/*
This page is used for all data coming for the advisor's entry on their html page.
It is used to enter their rating and signature in the database.
Please look into this file if complaints of data not getting into the DB post sending from the HTML page.

*/

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



$STRING_SIG="MAIN Advisor approved";
$ASU_ID=$_POST['ASU_ID'];
//$ASU_ID='1208604211';
$INDEX=$_POST['Index'];
$MAIN_ADVISOR_FLAG=0;

if(isset($_POST['chair_comments'])){

$CHAIR_COMMENTS=$_POST['chair_comments'];
$sqlquerychair=$conn->query("UPDATE SOMSS.somss_2016 set ChairComments='$CHAIR_COMMENTS' where ASU_ID='$ASU_ID'");
mysqli_query($conn,$sqlquerychair);

}

$sql="select * from SOMSS.somss_2016 where ASU_ID='$ASU_ID'";
$retval= mysqli_query($conn,$sql);
$VALUE=mysqli_fetch_array($retval, MYSQL_ASSOC);

//$ADVISOR_TEAM=json_decode($VALUE['Advisor_Firstname'],true);



$ADVISOR_TEAM1=json_decode($VALUE['Advisor_Firstname'],true);

if($VALUE['Adivisory_Committee']==0){
	$validate_flag=0;
}
else{
	$validate_flag = count(json_decode($VALUE['Advisor_Firstname'],true));
}

//print_r(count(json_decode($VALUE['Advisor_Firstname'],true)));
$ADVISOR_TEAM2=json_decode($VALUE['Advisor_Secondname'],true);
$ADVISOR_TEAM=array();
foreach($ADVISOR_TEAM1 as $key=>$val){
        
        $val1=$ADVISOR_TEAM2[$key];
        
        $ADVISOR_TEAM[$key] = $val ." ". $val1;
        
    }


if($VALUE["Signature"]=='null'|| $VALUE["Signature"]=="" ||$VALUE["Signature"]=='NULL')
{
	$VALUE['Signature']=$_POST['Signature'];
	$MAIN_ADVISOR='null';
	//$FULLNAME= $VALUE['Advisor_Firstname'] ." ".$VALUE['Advisor_Secondname'] ;
	//$ADVISOR_TEAM=json_decode($FULLNAME,true);
	$SIGNATURE_COUNT = count(json_decode($VALUE['Signature'],true));

        if($validate_flag-1 == $SIGNATURE_COUNT){
                $MAIN_ADVISOR_FLAG = 1;
                $MAIN_ADVISOR = "Bypass jennifer";
        }


	$ADVISOR=$ADVISOR_TEAM[$INDEX];
	$ADVISOR_LIST=json_encode(array($ADVISOR));
	$STUD_RATING=$_POST['Student_rating'];
	$STUDENT_RATING=array($ADVISOR=>$STUD_RATING);
	$STUDENT_RATING=json_encode($STUDENT_RATING);
	$sqlquery3=$conn->query("UPDATE SOMSS.somss_2016 set Student_rating='$STUDENT_RATING' where ASU_ID='$ASU_ID'");
	mysqli_query($conn,$sqlquery3);

	$SIGNATURE=$VALUE['Signature'];
	$SIGNATURE=array($INDEX=>$SIGNATURE);
	$SIGNATURE=json_encode($SIGNATURE);





}
else if ($VALUE["Signature"]!='null'|| $VALUE["Signature"]!="" ||$VALUE["Signature"]!='NULL')
{



$SIGNATURE=json_decode($VALUE['Signature'],true);
$ADVISOR_LIST=json_decode($VALUE['Approved'],true);
$INDEX=$_POST['Index'];
$STUDENT_RATING=json_decode($VALUE['Student_Rating'],true);
$COUNT=count($ADVISOR_TEAM);
$TEMP_SIGNATURE=$_POST['Signature'];
$TEMP_STUD_RATING=$_POST['Student_rating'];
$SIGNATURE_COUNT = count(json_decode($VALUE['Signature'],true));

/*

if($validate_flag-1 == $SIGNATURE_COUNT)
{

//	$MAIN_ADVISOR="Jennifer";
	$MAIN_ADVISOR_FLAG=1;
//	$INDEX=$COUNT;
//	$ADVISOR_COMMENTS=json_encode($_POST['advisor_comments']);
//	$ADVISOR_LIST=json_encode($ADVISOR_LIST);
	//$sqlquery=$conn->query("UPDATE SOMSS.somss_2016 set AdvisorComments='$ADVISOR_COMMENTS' where ASU_ID='$ASU_ID'");
	//mysqli_query($conn,$sqlquery);

} */
	$ADVISOR=$ADVISOR_TEAM[$INDEX];
	$STUDENT_RATING1=array($ADVISOR=>$TEMP_STUD_RATING);
	if($validate_flag-1 == $SIGNATURE_COUNT){
		$MAIN_ADVISOR_FLAG = 1;
		$MAIN_ADVISOR = "Bypass jennifer";
	}	
	//$STUDENT_RATING1=json_encode($STUDENT_RATING1);
	$STUDENT_RATING= array_merge($STUDENT_RATING , $STUDENT_RATING1);
	$STUDENT_RATING=json_encode($STUDENT_RATING);
	$ADVISOR_LIST1=array($ADVISOR);
	$ADVISOR_LIST= array_merge($ADVISOR_LIST,$ADVISOR_LIST1);
	$ADVISOR_LIST=json_encode($ADVISOR_LIST);
	$sqlquery13=$conn->query("UPDATE SOMSS.somss_2016 set Student_rating='$STUDENT_RATING' where ASU_ID='$ASU_ID'");
	mysqli_query($conn,$sqlquery13);


$SIGNATURE1=array($INDEX=>$TEMP_SIGNATURE);
$SIGNATURE= $SIGNATURE + $SIGNATURE1;
$SIGNATURE=json_encode($SIGNATURE);

}

$sql1=$conn->query("UPDATE SOMSS.somss_2016 
set Signature='$SIGNATURE',
Approved='$ADVISOR_LIST',
Admin_Advisor='$MAIN_ADVISOR',
Main_Advisor_Flag=$MAIN_ADVISOR_FLAG
where ASU_ID='$ASU_ID'
");

mysqli_query($conn,$sql1);

mysqli_close($conn);

/*
if($MAIN_ADVISOR_FLAG=='1')
{
	//change this
        $to = "halsmith@asu.edu";
        $subject = 'Please Approve Form for student '.$FIRST_NAME.'  '.$SECOND_NAME;
        $message = 'The Advisor Committee has approved the form for the student. The Form needs Directors Signature.
        Please check and Approve the form.
        https://pi.asu.edu/somss/director_login.php?ASU_ID='.$ASU_ID.'

        The password for the approval from director is 2wsxZaq1';
        $headers = 'From: somss.advising_noreply@asu.edu';

        mail($to, $subject, $message, $headers);

}
*/

?>
