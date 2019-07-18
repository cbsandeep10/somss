
<?php
/*PDF
define('FPDF_FONTPATH','./font/');
require('fpdf.php');
*/

//require('./wordwrap.php');
/*
$servername = "localhost";
$username = "root";
$password = "root";
$db_name = "SOMSS";
*/
include('connect.php');

//global $to;
// Create connection


//$conn = mysqli_connect($servername, $username, $password, $db_name);


//$ASU_ID='1208604211';
//$sql = "SELECT * from Form_data_gumel.form where ASU_ID='$ASU_ID'";

//$retval = mysqli_query($conn,$sql);

$current_year = date('Y');
$current_month = date('m');

if($current_month < 7){
	$table_name = intval($current_year-1).'_'.$current_year; 
}
else{
	$table_name = $current_year.'_'.intval($current_year  + 1); 
}

$SIGNATURE=$_POST['signature'];
$ASU_ID=$_POST['asu_id'];
$DIRECTOR_COMMENTS= $_POST['director_comments'];
if($DIRECTOR_COMMENTS == 'StudentContacted'){
	$DIRECTOR_MSG = $_POST['directorMsg'];
}

$sql=$conn->query("UPDATE ".$table_name." 
 set Director_Signature='$SIGNATURE',
Director_Comments='$DIRECTOR_COMMENTS'
where ASU_ID='$ASU_ID'
");



//echo "<script>console.log($ASU_ID)</script>";
mysqli_query($conn,$sql);
$sql1 = "SELECT * from ".$table_name." where ASU_ID='$ASU_ID'";
//$sql1 = "SELECT * from somss_test where ASU_ID='$ASU_ID'";

$retval = mysqli_query($conn,$sql1);
$row = mysqli_fetch_array($retval, MYSQLI_ASSOC);
//echo "<script>console.log($ASU_ID)</script>";
//mysqli_close($conn);

//$name= "/home/gaurav/pdffolder/doc.pdf";
//$VALUE=mysqli_fetch_array($retval, MYSQLI_ASSOC);

//$pdf-> Output($name,"F");

$sql2 = "SELECT Student_Mail from ".$table_name." where ASU_ID='$ASU_ID'";
$retval = mysqli_query($conn,$sql2);
$row = mysqli_fetch_array($retval, MYSQLI_ASSOC);
$to = $row['Student_Mail'];
//$to =$VALUE['Student_Mail'];//'gaurav.ravetkar@gmail.com';
$from = 'somss.advising@asu.edu'; 
if($DIRECTOR_COMMENTS == 'DirectApproval'){
	$subject = "PhD Progress Form Approved"; 
	$message = "Your PhD Progress form has been approved! Wish you the best for your future endeavors!";
	$headers = 'From: somss.advising@asu.edu';
}
else if($DIRECTOR_COMMENTS == 'StudentContacted'){
	$subject = "PhD Progress Form"; 
	$message = "Director's comments: " . $DIRECTOR_MSG . "\r\nStudent's ASU ID: " . $ASU_ID;
	$headers = 'From: somss.advising@asu.edu' . "\r\n" .
			   'Cc: dieter@asu.edu';
}

/*PDF
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
$body .= "This is a MIME encoded message.".$eol;

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
*/

// send message
//mail($to, $subject, $body, $headers);	//PDF
mail($to, $subject, $message, $headers);


mysqli_close($conn);

?>

