echo "<script> console.log(inside while);</script>";
error_reporting(E_ERROR);
include('connect.php');
$INDEX =$_POST['index'];
$ASU_ID= $_POST['ASU_ID'];
$current_year = date('Y');
$current_month = date('M');

if($current_month < 7){
	$table_name = intval($current_year-1).'_'.$current_year; 
}
else{
	$table_name = $current_year.'_'.intval($current_year  + 1); 
}

$sql = "SELECT * from ".$table_name." where ASU_ID='$ASU_ID'";
$retval = mysqli_query($conn,$sql);
if (!$retval) {
  echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}


while($row = mysqli_fetch_array($retval, MYSQLI_ASSOC))
{

$ADVISOR_TEAM1=json_decode($row['Advisor_Firstname'],true);	//List of Advisor first names
$ADVISOR_TEAM2=json_decode($row['Advisor_Secondname'],true);	//List of Advisor last names
$ADVISOR_TEAM=array();		//array of advisor names with values being full names
$Advisor_position_array = $row['Advisor_Position'];
foreach($ADVISOR_TEAM1 as $key=>$val){		//ADVISOR_TEAM1 accessed in key->value form eg. 0 -> advisor1; 1 -> advisor2
        
    $val1=$ADVISOR_TEAM2[$key];
    
    $ADVISOR_TEAM[$key] = $val ." ". $val1;
    
}
//$ADVISOR_TEAM=json_decode($row['Advisor_Team']);
//print_r($ADVISOR_TEAM);
$row['Advisor_Team']=implode("<br>",$ADVISOR_TEAM);
//print_r($ADVISOR_TEAM);
$APPROVAL=array_unique(json_decode($row['Approved'],true));
//$APPROVAL=implode("<br>",$APPROVAL);
if(in_array($ADVISOR_TEAM[$INDEX],$APPROVAL)){
	echo "You have already approved the Progress Report for this student!";
	return;
}


  $row['Mail']=json_decode($row['Mail']);
    $row['Course'] =json_decode($row['Course']);
    $row['Grade']=json_decode($row['Grade']);
    $row['Course']=implode("<br>",$row['Course']);
    $row['Grade']=implode("<br>",$row['Grade']);
    $row['Publications'] =json_decode($row['Publications']);
    $row['Presentations']=json_decode($row['Presentations']);
    $row['Publications']=implode("<br>",$row['Publications']);
    $row['Presentations']=implode("<br>",$row['Presentations']);
    $row['current_goal'] =json_decode($row['current_goal']);
    $row['current_goal']=implode("<br>",$row['current_goal']);
    $row['future_goal'] =json_decode($row['future_goal']);
    $row['future_goal']=implode("<br>",$row['future_goal']);
    $row['Qualifying_Subjects'] =json_decode($row['Qualifying_Subjects']);
    $row['Qualifying_Grades']=json_decode($row['Qualifying_Grades']);
    $row['Qualifying_Subjects']=implode("<br>",$row['Qualifying_Subjects']);
    $row['Qualifying_Grades']=implode("<br>",$row['Qualifying_Grades']);
    $row['Written_Subjects'] =json_decode($row['Written_Subjects']);
    $row['Written_Grades']=json_decode($row['Written_Grades']);
    $row['Written_Subjects']=implode("<br>",$row['Written_Subjects']);
    $row['Written_Grades']=implode("<br>",$row['Written_Grades']);
    $row['Colloquium_Semester']=json_decode($row['Colloquium_Semester']);
    $row['Colloquium_Semester']=implode("<br>",$row['Colloquium_Semester']);
    $Mail_length=sizeof(json_decode($row['Advisor_Mail'],true));
    $row['Advisor_Position'] =json_decode($row['Advisor_Position']);
    
    $row['Advisor_Firstname']=json_decode($row['Advisor_Firstname']);
    $row['Advisor_Position']=implode("<br>",$row['Advisor_Position']);
    $row['Advisor_Firstname']=implode("<br>",$row['Advisor_Firstname']);
    $row['Advisor_Secondname'] =json_decode($row['Advisor_Secondname']);
    $row['Advisor_Mail']=json_decode($row['Advisor_Mail']);
    $row['Advisor_Secondname']=implode("<br>",$row['Advisor_Secondname']);
    $row['Advisor_Mail']=implode("<br>",$row['Advisor_Mail']);


    $ADVISOR_TEAM=json_decode($row['Advisor_Team']);
    $row['Advisor_Team']=implode("<br>",$ADVISOR_TEAM);
    //$APPROVAL=json_decode($row['Approved']);
    //$APPROVAL=implode("<br>",$APPROVAL);
    //$MAIN_ADVISOR=$row['Admin_Advisor'];

    $FORM_ID=19*$ASU_ID;

    if($row['Written_Comprehensive']==='1'){$COMPREHENSIVE='Yes';}else{$COMPREHENSIVE='No';};
    if($row['Oral_Comprehensive']==='1'){$ORAL_COMPREHENSIVE='Yes';}else{$ORAL_COMPREHENSIVE='No';};
    if($row['Colloquium']==='1'){$COLLOQUIUM='Yes';}else{$COLLOQUIUM='No';};
    if($row['Adivisory_Committee']==='1'){$ADVISORY_COMMITTEE='Yes';}else{$ADVISORY_COMMITTEE='No';};
    if($row['Student_Advisory_Met']==='1'){$STUDENT_ADVISOR='Yes';}else{$STUDENT_ADVISOR='No';};
    if($row['Qualifying_Exam_Completed']==='1'){$QUALIFYING_EXAM='Yes';}else{$QUALIFYING_EXAM='No';};

$VALIDATE='true';


  echo"
<p><h3><b><center>ADVISOR APPROVAL FORM</center></b></h3></p> 
<p><h4><b><center>You are Selected as  ".$Advisor_position_array[$INDEX]." by the student below</center></b></h4></p>
<p><h5><b><center><i>Please approve the form for <u>{$row['First_Name']} {$row['Second_Name']}</u></i></center></b></h5></p>
<table align='center' border='2' style='width: auto;' class='table table-hover'>
";
echo"
<div class='container'><div class='col-md-12'><center><label>STUDENT FORM ID:</label><input type='text' name='random' id='random' readonly value = '$FORM_ID'><center></div></div>
<tr><th>Degree Program</th><td>{$row['Degree']}
<tr><th>Academic Year</th><td>{$row['Academic_Year']}
<tr><th>First Name</th><td>{$row['First_Name']}</td></tr>
<tr><th>Last Name</th><td>{$row['Second_Name']}</td></tr>
<tr><th>ASU ID/Student ID</th><td>{$row['ASU_ID']}</td></tr>
<tr><th>Program Start Date</th><td>{$row['Program_start_date']}</td></tr>
<tr><th>Semester In Progress</th><td>{$row['Semester_in_progress']}</td></tr>
<tr><th>CGPA</th><td>{$row['CGPA']}</td></tr>
<tr><th>Courses taken since last progress report with grades</th>
<td>
<table align='center' border='1' style='width: auto;' class='table table-bordered'>
<thead>
<tr>••••
<th>Course</th>
<th>Grade</th>
</tr>
</thead>
<tbody>
<tr>
<td>{$row['Course']}</td>
<td>{$row['Grade']}</td>

</tr>
</tbody>
</table>
</td>
</tr>
<tr><th>Advisory committee Formed?</th><td>$ADVISORY_COMMITTEE</td></tr>
<tr><th>Members of the commitee</th>
<td>
<table align='center' border='1' style='width: auto;' class='table table-bordered'>
<thead>
<tr>
<th>Position</th>
<th>Firstname</th>
<th>Lastname</th>
<th>E-mail</th>
</tr>
</thead>
<tbody>
<tr>
<td>{$row['Advisor_Position']}</td>
<td>{$row['Advisor_Firstname']}</td>
<td>{$row['Advisor_Secondname']}</td>
<td>{$row['Advisor_Mail']}</td>
</tr>
</tbody>
</table>
</td>
</tr>
<tr><th>Has the Student Met the Student Advisor and Advisory Committee?</th><td>$STUDENT_ADVISOR</td></tr>
<tr><th>Reason for not Meeting the Advisory Committee</th><td>{$row['Not_Met_Reason']}</td><tr>
<tr><th>Qualifying Exam Completed?</th><td>$QUALIFYING_EXAM</td></tr>

<tr><th>Qualifying Exam Subjects</th>
<td>
<table align='center' border='1' style='width: auto;' class='table table-bordered'>
<thead>
<tr>
<th>Qualifying Exam Courses</th>
<th>Qualifying Exam Grade</th>
</tr>
</thead>
<tbody>
<tr>
<td>{$row['Qualifying_Subjects']}</td>
<td>{$row['Qualifying_Grades']}</td>

</tr>
</tbody>
</table>
</td>
</tr>
<tr><th>Written Comprehensive Exam Completed?</th><td>$COMPREHENSIVE</td></tr>
<tr><th>Written Comprehensive Exam Subjects</th>
<td>
<table align='center' border='1' style='width: auto;' class='table table-bordered'>
<thead>
<tr>
<th>Written Comprehensive Exam Courses</th>
<th>Written Comprehensive Exam Grade</th>
</tr>
</thead>
<tbody>
<tr>
<td>{$row['Written_Subjects']}</td>
<td>{$row['Written_Grades']}</td>

</tr>
</tbody>
</table>
</td>
</tr>
<tr><th>Dissertation prospectus completed?</th><td>$ORAL_COMPREHENSIVE</td></tr>
<tr><th>Colloquium lecture attended?</th><td>$COLLOQUIUM</td></tr>
<tr><th>Which Semester where the lectures attended if Yes?</th><td>{$row['Colloquium_Semester']}</td></tr>

<tr><th>Outline the goals met in this reporting period</th><td>{$row['current_goal']}</td></tr>
<tr><th>Publications</th><td>{$row['Publications']}</td></tr>
<tr><th>Presentations</th><td>{$row['Presentations']}</td></tr>
<tr><th>Outline the goals for the next academic year</th><td>{$row['future_goal']}</td></tr>


<tr><th>Additonal Details/Information</th><td>{$row['Extra']}</td></tr>
</table></div>
<div id='prompt_password' style='display:none'><p> Enter your Password for Authentication</p>PASSWORD:<input type='password' id='advisor_password'/></div>
";

mysqli_close($conn);

}
/*
echo"
</table>
<div class='container'>
<form class='form-horizontal' role='form'>

  <p><h3><b>As the ".$Advisor_position_array[$INDEX]."  for the student, please comment on how the student is performing</i></b></h3></p>
  <p><h5><b><u><i> This will not be shown to the student, it's just for the Director's reference.</i></u></b></h5></p>
  <div class='form-group'>
      <label class='control-label col-md-4'><h4><b>Chair Comments<b></h4></label>
      <div class='col-md-6'>
        <textarea rows='5' cols='95' id='chair_comments'> </textarea>
      </div>
  </div>
<p><h3><b>Student Rating by Advisory Committee<i>(Please select one)</i></b></h3></p>
<div class='form-group'>
      <label class='control-label col-md-1'>Excellent</label>
      <div class='col-md-1'>
        <input type='radio' name='student_rating' id='student_rating' value='1'>
      </div>
      <label class='control-label col-md-1'>Good</label>
      <div class='col-md-1'>
        <input type='radio' name='student_rating' id='student_rating' value='2'>
      </div>
   <label class='control-label col-md-3'>Marginal<i>(In need of improvement)</i></label>
      <div class='col-md-1'>
        <input type='radio' name='student_rating' id='student_rating' value='3'>
      </div>
      <label class='control-label col-md-3'>Unsatisfactory<i>(Student does not meet minimum requirement)</i></label>
      <div class='col-md-1'>
        <input type='radio' name='student_rating' id='student_rating' value='4'>
      </div>
 </div>
 </div>
";

echo"
<p><h3><b>Signature of the Advisor</b></h3></p>

<div class='form-group'>
    <table id='permanent_adv'>
       <thead>
         <tr>
           <th><label for='signature'>MEMBER</label></th>
           <th><label for='signature'>NAME</label></th>
           <th><label for='signature'><center>SIGNATURE</center></label></th>
           <th><center for='signature'><center>DATE</center></label></th>
        </tr>
        </thead>
        <tbody id='permanent_advi'>
        <tr class='signature'>
           <th><input name='advisor_member' id='advisor_member'";
if($INDEX==$Mail_length){echo "value=Graduate Co-ordinator >";}else{ echo " value={$POS[$INDEX]}>";}
  echo"
    </select></th>
           <td> <input  name='name' class='name'  type='text' size='50'> </td>
           <td><input  name='1' class='password' id='password' type='text' size='50' readonly></td>
           <td> <input  class='date' type='text' size='30'> </td>
        </tr>
    </tbody>
</table>
</div>
<div class='form-group'><input type ='button'  id='submitBtn' name='submitBtn' onclick='submitForm()' class='submit' value='Submit'/></div>
</form>
</div>
";
*/
