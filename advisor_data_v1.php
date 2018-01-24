<?php

/*
This page is used for all data coming for the advisor's entry on their html page.
It is used to enter their rating and signature in the database.
Please look into this file if complaints of data not getting into the DB post sending from the HTML page.

*/

error_reporting(E_ERROR);

/*
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
*/
include('connect.php');



$STRING_SIG="MAIN Advisor approved";
$ASU_ID=$_POST['ASU_ID'];
//$ASU_ID='1208604211';
$INDEX=$_POST['Index'];
$MAIN_ADVISOR_FLAG=0;
$current_year = date('Y');
$current_month = date('m');
if($current_month < 7){
	$table_name = intval($current_year-1).'_'.$current_year; 
}
else{
	$table_name = $current_year.'_'.intval($current_year  + 1); 
}

$sql = "SELECT * from ".$table_name." where ASU_ID='$ASU_ID'";

//$sql="select * from SOMSS.somss_test where ASU_ID='$ASU_ID'";
$retval= mysqli_query($conn,$sql);
$VALUE=mysqli_fetch_array($retval, MYSQLI_ASSOC);
$ADVISOR_TEAM1=json_decode($VALUE['Advisor_Firstname'],true);

//print_r(count(json_decode($VALUE['Advisor_Firstname'],true)));
$ADVISOR_TEAM2=json_decode($VALUE['Advisor_Secondname'],true);
$ADVISOR_TEAM=array();
foreach($ADVISOR_TEAM1 as $key=>$val){
        
        $val1=$ADVISOR_TEAM2[$key];
        
        $ADVISOR_TEAM[$key] = $val ." ". $val1;
        
    }
    
if(isset($_POST['advisor_comments'])){

	$TEMP_ADVISOR_COMMENT=$_POST['advisor_comments'];
	$ADVISOR=$ADVISOR_TEAM[$INDEX];
	$ADVISOR_COMMENT1=array($ADVISOR=>$TEMP_ADVISOR_COMMENT);
	$Advisor_Comments = json_decode($VALUE['AdvisorComments'],true);
	
	if($Advisor_Comments=='null'|| $Advisor_Comments=="" ||$Advisor_Comments=='NULL'){
		$Advisor_Comments = json_encode($ADVISOR_COMMENT1);
	}
	else{
		
	$Advisor_Comments= array_merge($Advisor_Comments , $ADVISOR_COMMENT1);
	$Advisor_Comments = json_encode($Advisor_Comments);
	}
	
	//$ADVISOR=$ADVISOR_TEAM[$INDEX];
	//$Advisor_Comments_Array[$ADVISOR] = $ADVISOR_COMMENTS;
	//$Advisor_Comments_Array = json_encode($Advisor_Comments_Array);
	//$sqlquerychair=$conn->query("UPDATE SOMSS.somss_test set ChairComments='$CHAIR_COMMENTS' where ASU_ID='$ASU_ID'");
	//mysqli_query($conn,$sqlquerychair);
	

}

if($VALUE["Signature"]==null|| $VALUE["Signature"]=="" ||$VALUE["Signature"]==NULL)
{	
	$MAIN_ADVISOR_FLAG=1;
	$VALUE['Signature']=$_POST['Signature'];
	//$FULLNAME= $VALUE['Advisor_Firstname'] ." ".$VALUE['Advisor_Secondname'] ;
	//$ADVISOR_TEAM=json_decode($FULLNAME,true);
	$SIGNATURE_COUNT = count(json_decode($VALUE['Signature'],true));

	$ADVISOR=$ADVISOR_TEAM[$INDEX];
	$ADVISOR_LIST=json_encode(array($ADVISOR));
	$STUD_RATING=$_POST['Student_rating'];
	$STUDENT_RATING=array($ADVISOR=>$STUD_RATING);
	$STUDENT_RATING=json_encode($STUDENT_RATING);
	//$sqlquery3=$conn->query("UPDATE SOMSS.somss_test set Student_rating='$STUDENT_RATING' where ASU_ID='$ASU_ID'");
	//mysqli_query($conn,$sqlquery3);

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

$TEMP_STUD_RATING=$_POST['Student_rating'];
$SIGNATURE_COUNT = count(json_decode($VALUE['Signature'],true));

$MAIN_ADVISOR_FLAG=1;
$ADVISOR=$ADVISOR_TEAM[$INDEX];
$STUDENT_RATING1=array($ADVISOR=>$TEMP_STUD_RATING);

//$STUDENT_RATING1=json_encode($STUDENT_RATING1);
$STUDENT_RATING= array_merge($STUDENT_RATING , $STUDENT_RATING1);
$STUDENT_RATING=json_encode($STUDENT_RATING);
$ADVISOR_LIST1=array($ADVISOR);
$ADVISOR_LIST= array_merge($ADVISOR_LIST,$ADVISOR_LIST1);
$ADVISOR_LIST=json_encode($ADVISOR_LIST);
//$sqlquery13=$conn->query("UPDATE SOMSS.somss_test set Student_rating='$STUDENT_RATING' where ASU_ID='$ASU_ID'");
//mysqli_query($conn,$sqlquery13);

$TEMP_SIGNATURE=$_POST['Signature'];
$SIGNATURE1=array($ADVISOR=>$TEMP_SIGNATURE);
$SIGNATURE= array_merge($SIGNATURE , $SIGNATURE1);
$SIGNATURE=json_encode($SIGNATURE);

}

$sql1=$conn->query("UPDATE ".$table_name." 
set Signature='$SIGNATURE',
Approved='$ADVISOR_LIST',
Student_Rating='$STUDENT_RATING',
AdvisorComments='$Advisor_Comments',
Main_Advisor_Flag=$MAIN_ADVISOR_FLAG
where ASU_ID='$ASU_ID'
");

mysqli_query($conn,$sql1);

mysqli_close($conn);

//DIRECTOR
if($MAIN_ADVISOR_FLAG=='1')
{
	//change this
        //$to = "halsmith@asu.edu";
        $to = "tharangd95@gmail.com";	//Enter Director's emailID
        $subject = 'Please Approve Form for student '.$FIRST_NAME.'  '.$SECOND_NAME;
        $message = "The Advisory Committee has approved the form for the student. The Form needs Directors Signature.
        Please check and approve the form.
        https://mathesis.asu.edu/somss/director_login.php?ASU_ID=".$ASU_ID."

        The password for the approval from director is 2wsxZaq1";
        $headers = 'From: somss.advising_noreply@asu.edu';

        mail($to, $subject, $message, $headers);

}

?>
