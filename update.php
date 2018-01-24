<?php
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


//$Grade = array("A-","B+","A","A","B+","A","A","A","A","A","B","A","A-","A-","B+","A","A","A","B","A+");

//$grade = json_encode($Grade);


//$publications = json_encode(array("Numerical issues arising in the determination of interlayer conductivities in layered unsaturated soils:International Journal of Geomechanics:Status=Approved"));


//$advisors=array("pat.thompson@asu.edu","april.strom@scottsdalecc.edu","marilyn.carlson@asu.edu","james.middleton@asu.edu","ron.tzur@asu.edu");
//$Advisors=json_encode($advisors);

//$FIRST_NAME='Matthew';
//$SECOND_NAME='Weber';
//$ASU_ID='1205222274';

/*
$sql="select * from SOMSS.somss_2016 where ASU_ID='1207720315';";
$retval= mysqli_query($conn,$sql);
$VALUE=mysqli_fetch_array($retval, MYSQL_ASSOC);

*/


//$ADVISOR_TEAM=json_decode($VALUE['Advisor_Firstname'],true);
/*
$A=json_decode($VALUE['Advisor_Firstname'],true);
$B=json_decode($VALUE['Advisor_Secondname'],true);

$current_approved=json_decode($VALUE['Approved'],true);

foreach($current_approved as $key=>$value){
	foreach($A as $key1=>$value1){
	//print_r("Approved".$current_approved[$key]);
	//print_r($A[$key1]);
		if($current_approved[$key]==$A[$key1]){
			$current_approved[$key]=$A[$key1]." ".$B[$key1];
			print_r($current_approved[$key]);
		}
	}
} 

$final =json_encode($current_approved);

*/
//$final=array("Patrick","Marilyn","Fabio","Fabio");
//$final = json_encode($final);


$advisor_pos=["CHAIR","Member","Member","Member","Member"];
$a=json_encode($advisor_pos);

$sql1 =$conn->query("UPDATE SOMSS.somss_2016 set Advisor_Position='$a' where ASU_ID='1204129610';"); 

mysqli_query($conn,$sql1);
/*
if (mysqli_query($conn,$sql1)) {
    echo "Record updated  successfully";
} else {
    echo "Error: " . $sql1 . "<br>" . mysqli_error($conn);
}
*/
/*
$array_length=count(json_decode($Advisors,true));
$MAILLIST=json_decode($Advisors,true);

print_r($array_length);
print_r($MAILLIST);

for($i=0;$i<$array_length;$i++)
{

$to      = $MAILLIST[$i];
$subject = 'Please Approve PhD Form for student '.$FIRST_NAME.'  '.$SECOND_NAME;
$message = 'PhD Student '.$FIRST_NAME.' '.$SECOND_NAME.' has chosen you as the CHAIR/Co-CHAIR/Member please verify and approve the form.
The password for approving and signing the form will be 1qazXsw2
Please visit the below link to sign the advisor form.
https://pi.asu.edu/somss/login.php?ASU_ID='.$ASU_ID.'&index='.$i;
$headers = 'From: somss.advising@asu.edu';// . "\r\n" .

mail($to, $subject, $message, $headers);

}

*/
mysqli_close($conn);








?>


