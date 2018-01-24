<?php

define('FPDF_FONTPATH','./font/');
require('fpdf.php');
//require('./wordwrap.php');
/*
$servername = "localhost";
$username = "root";
$password = "root";
$db_name = "SOMSS";
*/
include('connect.php');

global $to;
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
		$semester = $row['Semester_in_Progress'];
		$cgpa = $row['CGPA'];

		// This will need to be a table .
		$course=json_decode($row['Course']);
		$grade=json_decode($row['Grade']);
		$subjects = array();
		foreach($course as $key=>$value){
			$subjects[$key]=($key+1).')Course: '.$course[$key].' Grade: '.$grade[$key];
		}

		$Subjects=implode("\n",$subjects);
		//$grade=implode("\n",$row['Grade']);
		//advisor committee formed?? 
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
		}


		if($row['Student_Advisory_Met']==='1')
		{
			$STUDENT_ADVISOR='Yes';
			$Reason = "Student met the advisor committee";
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
		}
	
	

	//Publications
	$Publications =json_decode($row['Publications']);
	$pub = array();
	foreach($Publications as $key=>$value)
	{
		$pub[$key]=($key+1).") ".$Publications[$key];
	}
	$Pubs=implode("\n",$pub);

	//Presentations
	$Presentations=json_decode($row['Presentations']);
	$pre = array();
	foreach($Presentations as $key=>$value)
	{
		$pre[$key]=($key+1).") ".$Presentations[$key];
	}
	$Pres=implode("\n",$pre);


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
 		

		$this->Cell(100,10,"CGPA",0);
                $this->Cell(80,10,$cgpa,0);
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

        $width = ceil($this->GetStringWidth($Advisor_list)/75);
        $width1=ceil($width/2);
        $total_width = $width + $width1;
        if($total_width==0){$total_width=1;}
        $this->Cell(100,5*$total_width,"Advisor Committee Members",0);
        $this->Multicell(80,5,$Advisor_list,0);
        $this->Ln();


        $this->Cell(100,10,"Student has met the Advisors and Advisory Committee?",0);
		$this->Cell(80,10,$STUDENT_ADVISOR,0);
        $this->Ln();

        $this->Cell(100,10,"Reason for not meeting the Advisory Committee?",0);
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

        $width= ceil($this->GetStringWidth($CG)/75);
       
        if($width==0){$width=1;}
        $this->Cell(100,5*$width,"Goals met in current period",0);
        $this->Multicell(80,5,$CG,0);
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
//$name= "/home/gaurav/pdffolder/doc.pdf";
//$VALUE=mysqli_fetch_array($retval, MYSQLI_ASSOC);

//$pdf-> Output($name,"F");

$sql2 = "SELECT Student_Mail from ".$table_name." where ASU_ID='$ASU_ID'";
$retval = mysqli_query($conn,$sql2);
$row = mysqli_fetch_array($retval, MYSQLI_ASSOC);
$to = $row['Student_Mail'];
//$to =$VALUE['Student_Mail'];//'gaurav.ravetkar@gmail.com';
$from = 'somss.advising@asu.edu'; 
$subject = "PhD Progress Form Approved"; 
$message = "<p>Your PhD Progress form has been approved. Please find attached the approved form with the Director's comments.</p>";

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

// send message
mail($to, $subject, $body, $headers);



mysqli_close($conn);

?>
