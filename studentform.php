<?php

error_reporting(E_ERROR);
if($_GET['valid']==1){
  include('connect.php');
  $ASU_ID=$_GET['ID'];
  $sql = "SELECT * from SOMSS.somss_2016 where ASU_ID='$ASU_ID'";
  $retval = mysqli_query($conn,$sql);
  if (!$retval) {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
  }
  while($row = mysqli_fetch_array($retval, MYSQL_ASSOC))
  {
  $AcademicYear=$row['Academic_Year'];
  $Degree_program=$row['Degree'];
  $Degree_encode=json_encode($Degree_program);
  $FirstName=$row['First_Name'];
  $SecondName=$row['Second_Name'];
  $ASU_ID=$row['ASU_ID'];
  $ASURITE=$row['ASURITE'];
  $CGPA=$row['CGPA'];
  $SemesterProgress=$row['Semester_in_progress'];
  $ProgramStart=$row['Program_start_date'];
  $MetAdvisor=$row['Student_Advisory_Met'];
  $NotMetReason=$row['Not_Met_Reason'];
  $AdvisoryComPresent=$row['Adivisory_Committee'];
  $Colloquium=$row['Colloquium'];
  $OralComp=$row['Oral_Comprehensive'];
  $WrittenCompleted=$row['Written_Comprehensive'];
  $QualExamComp=$row['Qualifying_Exam_Completed'];
  $row_course=count(json_decode($row['Course']));
  $row_pub=count(json_decode($row['Publications']));
  $row_pre=count(json_decode($row['Presentations']));
  $row_future=count(json_decode($row['future_goal']));
  $row_current=count(json_decode($row['current_goal']));
  $row_qualifying_sub=count(json_decode($row['Qualifying_Subjects']));
  $row_written=count(json_decode($row['Written_Subjects']));
  $row_advisors=count(json_decode($row['Advisor_Firstname']));
  $commitee_members=$row['Advisor_Position'];
  $firstname=$row['Advisor_Firstname'];
  $lastname=$row['Advisor_Secondname'];
  $email_id=$row['Advisor_Mail'];
  $Course_details=$row['Course'];
  $Grade_details=$row['Grade'];
  $Current_details=$row['current_goal'];
  $Future_details=$row['future_goal'];
  $Publication_details=$row['Publications'];
  $Presentation_details=$row['Presentations'];
  $Qualifying_subjects=$row['Qualifying_Subjects'];
  $Qualifying_grades=$row['Qualifying_Grades'];
  $Written_Comp=$row['Written_Subjects'];
  $Written_Grades=$row['Written_Grades'];
  $Degree=$row['Degree'];
  $Degree='"'.$Degree.'"';
  $course=json_decode($row['Course'])[0];
  $grade=json_decode($row['Grade'])[0];
  $pub=json_decode($row['Publications'])[0];
  $cur=json_decode($row['current_goal'])[0];
  $pre=json_decode($row['Presentations'])[0];
  $fut=json_decode($row['future_goal'])[0];
  $colloquim=json_decode($row['Colloquium_Semester']);
  $qual_grade=json_decode($row['Qualifying_Grades'])[0];
  $writ_grade=json_decode($row['Written_Grades'])[0];
  $qualify_sub=json_decode($row['Qualifying_Subjects'])[0];
  $written=json_decode($row['Written_Subjects'])[0];
  $commitee_members1=json_decode($row['Advisor_Position'])[0];
  $firstname1=json_decode($row['Advisor_Firstname'])[0];
  $lastname1=json_decode($row['Advisor_Secondname'])[0];
  $email_id1=json_decode($row['Advisor_Mail'])[0];
  //print_r($commitee_members1);
  //have to save in every variable to avoid multipe pages problem. That can be done.
  }
}
echo"
<html lang='en'>
<head>
  <title>FORM</title>
  <meta charset='utf-8'>
  <meta name='viewport' content='width=device-width, initial-scale=1'>

  <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css'>
  <script src='https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js'></script>
  <script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js'></script>
  <link rel='stylesheet' href='//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css'>
  <script src = './student.js'></script>
  <script src='//code.jquery.com/jquery-1.10.2.js'></script>
  <script src='//code.jquery.com/ui/1.11.4/jquery-ui.js'></script>

<style>
.hide-calendar .ui-datepicker-calendar {
    display: none;
}
.star
{
  color:red;
}

</style>

</head>
<body onload='AddColumn($row_course,$Course_details,$Grade_details);AddPublications($row_pub,$Publication_details);
AddCurrentGoal($row_current,$Current_details);AddPresentations($row_pre,$Presentation_details);
AddFutureGoal($row_future,$Future_details);Colloquium();SelectDegree();completion_date();
AddQualifySub($row_qualifying_sub,$Qualifying_subjects,$Qualifying_grades,$Degree_encode);
WrittenComp();AddWritten($row_written,$Written_Comp,$Written_Grades);Member();TextBox();
AddAdvisors($row_advisors,$commitee_members,$firstname,$lastname,$email_id);'>
<div class='container'>
<h1><center><u>SCHOOL OF MATHEMATICAL & STATISTICAL SCIENCES</u></center></h1>
 <h2><center>PhD Program Report Form</center></h2>
<br></br>
<form class='form-horizontal' role='form' method='POST'  enctype='multipart/form-data'  action='data1.php'>
 <div class='form-group' id='degree_program'>
      <label class='control-label col-md-2' for='degree_select'>Doctoral Degree Program<sup class='star'>*</sup></label>
      <div class='col-md-3'>
        <select class='form-control' id='degree_select' name='degree_select' ";if($_GET['valid']==1)echo"style='background-color:#FCF5D8'";echo"onchange='SelectDegree()'> 
            <option disabled selected value='-1'> -- select a Degree Program -- </option>
            <option value='Applied Mathematics'";if($Degree_program==='Applied Mathematics')echo "selected";echo">Applied Mathematics</option>
            <option value='Mathematics' ";if($Degree_program==='Mathematics')echo "selected";echo">Mathematics</option>
            <option value='Mathematics Education' ";if($Degree_program==='Mathematics Education')echo "selected";echo">Mathematics Education</option>
            <option value='Statistics' ";if($Degree_program==='Statistics')echo "selected";echo">Statistics</option>
        </select>
      </div>
 </div>

<p><h3><b>Section A | Program of Study Status</b></h3></p>

    <div class='form-group'>
      <label class='control-label col-md-8' for='academic_year'>Academic year:<sup class='star'>*</sup></label>
      <label class='control-label col-md-1' for='academic_year'>FALL</label>
      <div class='col-md-1'>
        <input type='text' class='form-control' id='academic_year' name='academic_year' data-calendar='false'";if($_GET['valid']==1)echo"style='background-color:#FCF5D8'";echo">
      </div>
      <label class='control-label col-md-1' for='academic_year'>SPRING</label>
      <div class='col-md-1'>
        <input type='text' class='form-control' id='academic_year1' name='academic_year' data-calendar='false'";if($_GET['valid']==1)echo"style='background-color:#FCF5D8'";echo"value=".$AcademicYear.">
      </div>
    </div>

    <div class='form-group'>
      <label class='control-label col-md-2' for='first_name' >First Name:<sup class='star'>*</sup></label>
      <div class='col-md-2'>          
        <input type='text' class='form-control' id='first_name' name='first_name' placeholder='Enter First Name'";if($_GET['valid']==1)echo"style='background-color:#FCF5D8'";echo"value=".$FirstName.">
      </div>
      <label class='control-label col-md-2' for='second_name'>Last Name:<sup class='star'>*</sup></label>
      <div class='col-md-2'>        
        <input type='text' class='form-control' id='second_name' name='second_name' placeholder='Enter Second Name' ";if($_GET['valid']==1)echo"style='background-color:#FCF5D8'";echo"value=".$SecondName.">
      </div>
      <label class='control-label col-md-2' for='asu_id'>ASU ID/Student ID Number:<sup class='star'>*</sup></label>
      <div class='col-md-2'>          
        <input type='text' class='form-control' id='asu_id' name='asu_id' placeholder='ASU ID/Student ID' ";if($_GET['valid']==1)echo"style='background-color:#FCF5D8'";echo"value=".$ASU_ID.">
      </div>
    </div>


    <div class='form-group'>
      <label class='control-label col-md-2' for='student_mail'>ASURITE ID:<sup class='star'>*</sup></label>
      <div class='col-md-2'defense_completion_date>
        <input type='text' class='form-control' id='student_mail' name='student_mail' placeholder='Student ASURITE ID'  ";if($_GET['valid']==1)echo"style='background-color:#FCF5D8'";echo"value=".$ASURITE.">
      </div>
      <label class='control-label col-md-2' for='prog_start_date' >Program Start Date:<sup class='star'>*</sup></label>
      <div class='col-md-2'>          
        <input type='text' class='form-control' id='prog_start_date' name='prog_start_date' data-calendar='false'  ";if($_GET['valid']==1)echo"style='background-color:#FCF5D8'";echo"value=".$ProgramStart.">
      </div>
      <label class='control-label col-md-2' for='sem_in_prog'>Semester in Progress<sup class='star'>*</sup></label>
      <div class='col-md-2'>          
        <select class='form-control' id='sem_in_prog' name='sem_in_prog' ";if($_GET['valid']==1)echo"style='background-color:#FCF5D8'";echo">
  <option disabled selected value='-1'> Current Semester</option>
  <option value='First'";if($SemesterProgress==='First')echo"selected";echo">First</option>
  <option value='Second'";if($SemesterProgress==='Second')echo"selected";echo">Second</option>
  <option value='Third'";if($SemesterProgress==='Third')echo"selected";echo">Third</option>
  <option value='Fourth'";if($SemesterProgress==='Fourth')echo"selected";echo">Fourth</option>
  <option value='Fifth'";if($SemesterProgress==='Fifth')echo"selected";echo">Fifth</option>
  <option value='Sixth'";if($SemesterProgress==='Sixth')echo"selected";echo">Sixth</option>
  <option value='Seventh'";if($SemesterProgress==='Seventh')echo"selected";echo">Seventh</option>
  <option value='Eight'";if($SemesterProgress==='Eight')echo"selected";echo">Eight</option>
  <option value='Ninth'";if($SemesterProgress==='Ninth')echo"selected";echo">Ninth</option>
  <option value='Tenth'";if($SemesterProgress==='Tenth')echo"selected";echo">Tenth</option>
  <option value='Eleventh'";if($SemesterProgress==='Eleventh')echo"selected='selected'";echo">Eleventh</option>
  <option value='Twelfth'";if($SemesterProgress==='Twelfth')echo"selected='selected'";echo">Twelfth</option>


  </select>     
      </div>
   </div>
    <div class='form-group'> 
      <label class='control-label col-md-2' for='cum_gpa'>Cumulative GPA:<sup class='star'>*</sup></label>
      <div class='col-md-2'>          
        <input type='text' class='form-control' id='cum_gpa' name='cum_gpa'  ";if($_GET['valid']==1)echo"style='background-color:#FCF5D8'";echo"value=".$CGPA.">
      </div>
    </div>

<div class='form-group'>
  
    <div class='table-responsive'>
      <table id='dataTable'>
         <thead>
           <tr class='academics'>
             <th><center><label for='course'>Course<sup class='star'>*</sup></label></center><font size='2'><i>Courses taken since last progress with grades<i></font></th>
             <th><label for='grade'>Grade<sup class='star'>*</sup></label></th>
          </tr>
          </thead>
            <tbody id='coursegrade_table_body'>
            <tr class='coursegrade0'>
               <td><input name='course' type='text' class='course' size='70' ";if($_GET['valid']==1)echo"style='background-color:#FCF5D8'";echo"value='".$course."'";echo"></td>
           <td> <select name='grade' class='grade'>";
         
         echo"
          <option disabled selected value='-1'> -- select Grade -- </option>
          <option value='A+'";if($grade==='A+')echo "selected";echo ">A+</option>
          <option value='A'";if($grade==='A')echo "selected";echo ">A</option>
          <option value='A-'";if($grade==='A-')echo "selected";echo ">A-</option>
          <option value='B+'";if($grade==='B+')echo "selected";echo ">B+</option>
          <option value='B'";if($grade==='B')echo "selected";echo ">B</option>
          <option value='B-'";if($grade==='B-')echo "selected";echo ">B-</option>
          <option value='C+'";if($grade==='C+')echo "selected";echo ">C+</option>
          <option value='C'";if($grade==='C')echo "selected";echo ">C</option>
          <option value='D'";if($grade==='D')echo "selected";echo ">D</option>
          <option value='E'";if($grade==='E')echo "selected";echo ">E</option>
          <option value='I'";if($grade==='I')echo "selected";echo ">I</option>
          <option value='NR'";if($grade==='NR')echo "selected";echo ">NR</option>
          <option value='P'";if($grade==='P')echo "selected";echo ">P</option>
          <option value='W'";if($grade==='W')echo "selected";echo ">W</option>
          <option value='X'";if($grade==='X')echo "selected";echo ">X</option>
          <option value='Y'";if($grade==='Y')echo "selected";echo ">Y</option>
          <option value='Z'";if($grade==='Z')echo "selected";echo ">Z</option>
          <option value='XE'";if($grade==='XE')echo "selected";echo ">XE</option>
          </select></td>
          </tr>
          </tbody>
      </table>
    <div class='btn-group-horizontal'>
      <button type='button' class='btn btn-primary' onclick=\"addRow('dataTable')\">Add Course</button>
      <button type='button' class='btn btn-primary' onclick=\"delRow('dataTable')\">Remove Course</button>
    </div>
  </div>
</div>


 <div class='form-group'>
 
      <label class='control-label col-md-4' for='advisory_committee'>Advisory Committee Formed?<sup class='star'>*</sup></label>
<div id='adv_committee'> 
     <label class='control-label col-md-1'>Yes</label>
      <div class='col-md-1'>
        
        <input type='radio' name='advisory_committee' class='advisory_committee' onclick='Member()' id='advisory_committee_yes' value='1'";
          if($AdvisoryComPresent==='1')echo " checked='checked' Member()" ;echo">
  </div>
      <label class='control-label col-md-1'>No</label>
      <div class='col-md-1'>
        <input type='radio' name='advisory_committee' class='advisory_committee' onclick='Member()' id='advisory_committee_no' value='0'";
        if($AdvisoryComPresent==='0')echo " checked='checked' Member()";echo">
      </div>
    </div>
</div>

<div id='advisor_member_div' style='display:none'>

<div class='table-responsive'>
    <table id='advisor_Table'>
       <thead>
         
           <th><center><label for='advisor_member' >CHAIR/CO-CHAIR/MEMBER</label></center></th>
           <th><label for='advisor_firstname' >FIRSTNAME</label></th>
     <th><label for='advisor_secondname' >LASTNAME</label></th>
     <th><label for='advisor_mail' >E-MAIL ID</label></th>
     <th><label for='advisor_remail' >RE-ENTER E-MAIL ID</label></th>
        
        </thead>
        <tbody id='advisor_table_body'>
        <tr class='signature0'>
     <td><select class='advisor_member' name='advisor_member'>
    <option value='CHAIR'";if($commitee_members1==='CHAIR')echo "selected";echo ">CHAIR</option>
          <option value='CO-CHAIR'";if($commitee_members1==='CO-CHAIR')echo "selected";echo ">CO-CHAIR</option>
          <option value='MEMBER'";if($commitee_members1==='MEMBER')echo "selected";echo ">MEMBER</option>
  


    </select>
     </td>

     <td><input name='advisor_firstname' type='text' class='advisor_firstname' size='30'  ";if($_GET['valid']==1)echo"style='background-color:#FCF5D8'";echo" value='".$firstname1."'></td>
     <td> <input name='advisor_secondname' type='text' class='advisor_secondname' size='30'  ";if($_GET['valid']==1)echo"style='background-color:#FCF5D8'";echo"value='".$lastname1."'> </td>
     <td> <input name='advisor_mail' type='text' placeholder='aaa@bbb.yyy format' class='advisor_mail' size='30'  ";if($_GET['valid']==1)echo"style='background-color:#FCF5D8'";echo"value='".$email_id1."'> </td>
     <td> <input name='advisor_remail' type='text' placeholder='cannot copy paste' class='advisor_remail' size='30'  ";if($_GET['valid']==1)echo"style='background-color:#FCF5D8'";echo"value='".$email_id1."'> </td>
        </tr>
    </tbody>
</table>
</div>
<div class='btn-group-horizontal'>
    <button type='button' class='btn btn-primary' onclick=\"addRow('advisor_Table')\">Add Advisor Members</button>
    <button type='button' class='btn btn-primary' onclick=\"delRow('advisor_Table')\">Remove Advisor members</button>
</div>
</div>



 <div class='form-group'>
      <label class='control-label col-md-4' for='advisor'>Has the student met the Chair for the current academic year? If not,
give reasons below<sup class='star'>*</sup></label>
<div id='advisor'>
<label class='control-label col-md-1'>Yes</label>
      <div class='col-md-1'>
      <input type='radio' name='met_advisor' onclick='TextBox()' id='committee_formed_yes' class='met_advisor' value='1'";if($MetAdvisor==='1')echo "checked='checked' ";echo">
        </div>
        <label class='control-label col-md-1'>No</label>
        <div class='col-md-1'>
          <input type='radio' name='met_advisor' onclick='TextBox()' id='committee_formed_no' class='met_advisor' value='0'";if($MetAdvisor==='0')echo "checked='checked'";echo">
      </div>
    </div>
</div>

<div class='form-group' id='textbox' style='display:none'>
      <label class='control-label col-md-4' for='advisory_committee_reason'>Reason for not having an advisory committee yet<sup class='star'>*</sup></label>
      <div class='col-md-8' for='advisory_committee_reason'>
        <textarea rows='10' cols='70' name='advisory_committee_reason' id='advisory_committee_reason' ";if($_GET['valid']==1)echo"style='background-color:#FCF5D8'";echo">";if($MetAdvisor==='0')echo $NotMetReason;echo"</textarea>
      </div>
    </div>

<br><br>
<p></p><h3><b>Section B | Student's Progress</b></h3><p></p>
<br><br>

<!-- Applied Mathematics-->
<div id='qualifying_exam_applied_math' style='display:none'>
  <div class='form-group'>
        <label class='control-label col-md-4' for='qualifying_exam'>Qualifying Exam Completed?<sup class='star'>*</sup></label>
          <div id='qualifying_exam'>
               <label class='control-label col-md-1'>Yes</label>
                   <div class='col-md-1'>
                  <input type='radio' name='qualifying_exam' id='exam_yes' class='qualifying_exam'
                  onclick='completion_date()' value='1'";if($QualExamComp==='1')echo "checked='checked'";echo">
                   </div>
               <label class='control-label col-md-1'>No</label>
                   <div class='col-md-1'>
                  <input type='radio' name='qualifying_exam' id='exam_no' class='qualifying_exam' onclick='completion_date()' value='0'";if($QualExamComp==='0')echo "checked='checked'";echo">
                 </div>    
          </div>
  </div>
  <div id ='Q-exam' style='display:none'>
    <div class='table-responsive'>
      <div>
        <table id='qualifying_Table'>
        <thead>
          <tr>
          <th><label for='qualifying_details'></label></th>
          <th><center><label for='qualifying_details'>Qualifying Exam Subjects<sup class='star'>*</sup></label> </center></th>
          <th><center><label for='qualifying_grades'>Grades<sup class='star'>*</sup></label> </center></th>
          </tr>
        </thead>
        <tbody id='qualifying_table_body1'>
          <tr class='qualifyingexam1-0'>
          <td><input type='text' size='2' maxlength='2' value='1'></td>
          <td> <select name='qualifying_details' class='qualifying_details'>";
      echo"
            <option disabled selected> -- Select Qualifying Exam-- </option>
            <option value='APM 501 Differential Equations I'";if($qualify_sub=== 'APM 501 Differential Equations I')echo "selected";echo ">APM 501 Differential Equations I</option>
            <option value='APM 502 Differential Equations II'";if($qualify_sub==='APM 502 Differential Equations II')echo "selected";echo ">APM 502 Differential Equations II</option>
            <option value='APM 503 Applied Analysis'";if($qualify_sub==='APM 503 Applied Analysis')echo "selected";echo ">APM 503 Applied Analysis</option>
            <option value='APM 504 Applied Probability'";if($qualify_sub==='APM 504 Applied Probability')echo "selected";echo ">APM 504 Applied Probability</option>
            <option value='APM 505 Applied and Numerical Linear Algebra'";if($qualify_sub==='APM 505 Applied and Numerical Linear Algebra')echo "selected";echo ">APM 505 Applied and Numerical Linear Algebra</option>
            <option value='APM 506 Scientific Computing'";if($qualify_sub==='APM 506 Scientific Computing')echo "selected";echo ">APM 506 Scientific Computing</option>
              </select>
          </td>
          <td> <select name='qualifying_grades' class='qualifying_grades'>";
          
          echo"
          <option disabled selected value='-1'> -- Select Grade-- </option>
          <option value='A+'";if($qual_grade==='A+')echo "selected";echo ">A+</option>
          <option value='A'";if($qual_grade==='A')echo "selected";echo ">A</option>
          <option value='A-'";if($qual_grade==='A-')echo "selected";echo ">A-</option>
          <option value='B+'";if($qual_grade==='B+')echo "selected";echo ">B+</option>
          <option value='B'";if($qual_grade==='B')echo "selected";echo ">B</option>
          <option value='B-'";if($qual_grade==='B-')echo "selected";echo ">B-</option>
          <option value='C+'";if($qual_grade==='C+')echo "selected";echo ">C+</option>
          <option value='C'";if($qual_grade==='C')echo "selected";echo ">C</option>
          <option value='D'";if($qual_grade==='D')echo "selected";echo ">D</option>
          <option value='E'";if($qual_grade==='E')echo "selected";echo ">E</option>
          <option value='I'";if($qual_grade==='I')echo "selected";echo ">I</option>
          <option value='NR'";if($qual_grade==='NR')echo "selected";echo ">NR</option>
          <option value='P'";if($qual_grade==='P')echo "selected";echo ">P</option>
          <option value='W'";if($qual_grade==='W')echo "selected";echo ">W</option>
          <option value='X'";if($qual_grade==='X')echo "selected";echo ">X</option>
          <option value='Y'";if($qual_grade==='Y')echo "selected";echo ">Y</option>
          <option value='Z'";if($qual_grade==='Z')echo "selected";echo ">Z</option>
          <option value='XE'";if($qual_grade==='XE')echo "selected";echo ">XE</option>
          </select></td>
          </tr>
        </tbody>
        </table>
      </div>
    </div>
    <div class='btn-group-horizontal'>
        <button type='button' class='btn btn-primary' onclick=\"addRow('qualifying_Table')\">Add Qualifying Subjects</button>
        <button type='button' class='btn btn-primary' onclick=\"delRow('qualifying_Table')\">Remove Qualifying Subjects</button>
    </div>
  </div>
</div>


<!-- Mathematics Qualifying Exam-->
<div id='qualifying_exam_maths' style='display:none'>
<div class='form-group'>
      <label class='control-label col-md-4' for='qualifying_exam'>Qualifying Exam Completed?<sup class='star'>*</sup></label>
        <div id='qualifying_exam'>
             <label class='control-label col-md-1'>Yes</label>
                 <div class='col-md-1'>
                 <input type='radio' name='qualifying_exam' id='exam_yes_1' class='qualifying_exam' onclick='completion_date_1()' value='1'>
                 </div>
             <label class='control-label col-md-1'>No</label>
                 <div class='col-md-1'>
                <input type='radio' name='qualifying_exam' id='exam_no_1' class='qualifying_exam' onclick='completion_date_1()' value='0'>
               </div>    
        </div>
</div>
<div id ='Q-exam_1' style='display:none'>
<div class='table-responsive'>
        <div>
            <table id='qualifying_Table_1'>
                 <thead>
                        <tr>
                        <th><label for='qualifying_details'></label></th>
                         <th><center><label for='qualifying_details'>Qualifying Exam Subjects<sup class='star'>*</sup></label> </center></th>
                        <th><center><label for='qualifying_grades'>Grades<sup class='star'>*</sup></label> </center></th>

       </tr>
                </thead>
<tbody id='qualifying_table_body2'>
                        <tr class='qualifyingexam2-0'>
                        <td><input type='text' size='2' maxlength='2' value='1'></td>
      
      <td> <select name='qualifying_details' class='qualifying_details'> 
            <option value='Algebra'>Algebra</option>
            <option value='Real Analysis'>Real Analysis</option>
            <option value='Discrete Mathematics'>Discrete Mathematics</option>
            <option value='Geometry/Topology'>Geometry/Topology</option>            
          </select>
      </td>
      <td> <select name='qualifying_grades' class='qualifying_grades'> 
            <option value='MS Pass'>MS Pass</option>
            <option value='PhD Pass'>PhD Pass</option>
            <option value='Fail'>Fail</option>
          </select>
      </td>
                        </tr>
                </tbody>
            </table>
        </div>
</div>
<div class='btn-group-horizontal'>
  <button type='button' class='btn btn-primary' onclick=\"addRow('qualifying_Table_1')\">Add Qualifying Subjects</button>
  <button type='button' class='btn btn-primary' onclick=\"delRow('qualifying_Table_1')\">Remove Qualifying Subjects</button>
</div>
</div>
</div>


<!-- Mathematics Education Qualifying Exam-->
<div id='qualifying_exam_math_edu' style='display:none'>
<div class='form-group'>
      <label class='control-label col-md-4' for='qualifying_exam'>Qualifying Exam Completed?<sup class='star'>*</sup></label>
        <div id='qualifying_exam'>
             <label class='control-label col-md-1'>Yes</label>
                 <div class='col-md-1'>
                 <input type='radio' name='qualifying_exam' id='exam_yes_2' class='qualifying_exam' onclick='completion_date_2()' value='1'>
                 </div>
             <label class='control-label col-md-1'>No</label>
                 <div class='col-md-1'>
                <input type='radio' name='qualifying_exam' id='exam_no_2' class='qualifying_exam' onclick='completion_date_2()' value='0'>
               </div>    
        </div>
</div>
<div id ='Q-exam_2' style='display:none'>
<div class='table-responsive'>
        <div>
            <table id='qualifying_Table_2'>
                 <thead>
                        <tr>
                        <th><label for='qualifying_details'></label></th>
                         <th><center><label for='qualifying_details'>Qualifying Exam Subjects<sup class='star'>*</sup></label> </center></th>
                        <th><center><label for='qualifying_grades'>Grades<sup class='star'>*</sup></label> </center></th>

       </tr>
                </thead>
                <tbody id='qualifying_table_body3'>
                        <tr class='qualifyingexam3-0'>
                        <td><input type='text' size='2' maxlength='2' value='1'></td>
      
      <td> <select name='qualifying_details' class='qualifying_details'>

	    <optgroup label='Mathematics Education'>
		<option value='MTE 598: Topic - Research in Undergraduate Math Education I'>MTE 598:Topic:Research in Undergraduate Math Education I</option>
                <option value='MTE 598: Topic - Research in Undergraduate Math Education II'>MTE 598:Topic: Research in Undergraduate Math Education II</option>
	    </optgroup> 
            <optgroup label='Applied Mathematics'>
                    <option value='APM 501 Differential Equations I'>APM 501 Differential Equations I</option>
                    <option value='APM 502 Differential Equations II'>APM 502 Differential Equations II</option>
                    <option value='APM 503 Applied Analysis '>APM 503 Applied Analysis </option>
                    <option value='APM 504 Applied Probability'>APM 504 Applied Probability</option>
                    <option value='APM 505 Applied and Numerical Linear Algebra'>APM 505 Applied and Numerical Linear Algebra</option>
                    <option value='APM 506 Scientific Computing'>APM 506 Scientific Computing</option>
            </optgroup>
            <optgroup label='Mathematical Biology'>
                    <option value='AML 610 Topics in Applied Mathematics for the Life and Social Sciences'>AML 610 Topics in Applied Mathematics for the Life and Social Sciences</option>
                    <option value='APM 531 Mathematical Neurosciences I'>APM 531 Mathematical Neurosciences I</option>
                    <option value='AML 612 Applied Mathematics for the Life and social Sciences Modeling Seminar'>AML 612 Applied Mathematics for the Life and social Sciences Modeling Seminar</option>
                    <option value='AML 613 Probability and Stochastic Modeling for the Life and Social Sciences'>AML 613 Probability and Stochastic Modeling for the Life and Social Sciences</option>
            </optgroup>
            <optgroup label='Mathematics'>
                    <option value='MAT 512 Discrete Mathematics I'>MAT 512 Discrete Mathematics I</option>
                    <option value='MAT 513 Discrete Mathematics II'>MAT 513 Discrete Mathematics II</option>
                    <option value='MAT 516 Graph Theory I'>MAT 516 Graph Theory I</option>
                    <option value='MAT 517 Graph Theory II'>MAT 517 Graph Theory II</option>
                    <option value='MAT 543 Algebra I'>MAT 543 Algebra I</option>
                    <option value='MAT 544 Algebra II'>MAT 544 Algebra II</option>
                    <option value='MAT 570 Real Analysis I'>MAT 570 Real Analysis I </option>
                    <option value='MAT 571 Real Analysis II'>MAT 571 Real Analysis II</option>
            </optgroup>
            <optgroup label='Statistics'>
                    <option value='STP 501 Theory of Statistics 1'>STP 501 Theory of Statistics 1</option>
                    <option value='STP 502 Theory of Statistics 2'>STP 502 Theory of Statistics 2</option>
                    <option value='STP 525 Advance Probability'>STP 525 Advance Probability</option>
                    <option value='STP 526 Theory of Statistical Linear Model'>STP 526 Theory of Statistical Linear Model</option>
                    <option value='STP 527 Statistical Large Sample Theory'>STP 527 Statistical Large Sample Theory</option>
                    <option value='STP 530 Applied Regression Analysis'>STP 530 Applied Regression Analysis</option>
                    <option value='STP 531 Applied Analysis of Variance'>STP 531 Applied Analysis of Variance</option>
                    <option value='STP 532 Applied Nonparametric Statistics'>STP 532 Applied Nonparametric Statistics</option>
                    <option value='STP 533 Applied Multivariable Analysis'>STP 533 Applied Multivariable Analysis</option>
                    <option value='STP 535 Applied Sampling Methodology'>STP 535 Applied Sampling Methodology</option>
            </optgroup>            
          </select>
      </td>
      <td> <select name='qualifying_grades' class='qualifying_grades'> 
            <option value='MS Pass'>MS Pass</option>
            <option value='PhD Pass'>PhD Pass</option>
            <option value='Fail'>Fail</option>
      </td>
                        </tr>
                </tbody>
            </table>
        </div>
</div>
<div class='btn-group-horizontal'>
  <button type='button' class='btn btn-primary' onclick=\"addRow('qualifying_Table_2')\">Add Qualifying Subjects</button>
  <button type='button' class='btn btn-primary' onclick=\"delRow('qualifying_Table_2')\">Remove Qualifying Subjects</button>
</div>
</div>
</div>

<!-- Statistics Qualifying Exam-->
<div id='qualifying_exam_stat' style='display:none'>
<div class='form-group' >
      <label class='control-label col-md-4' for='qualifying_exam'>Qualifying Exam Completed?<sup class='star'>*</sup></label>
        <div id='qualifying_exam'>
             <label class='control-label col-md-1'>Yes</label>
                 <div class='col-md-1'>
                 <input type='radio' name='qualifying_exam' id='exam_yes_3' class='qualifying_exam' onclick='completion_date_3()' value='1'>
                 </div>
             <label class='control-label col-md-1'>No</label>
                 <div class='col-md-1'>
                <input type='radio' name='qualifying_exam' id='exam_no_3' class='qualifying_exam' onclick='completion_date_3()' value='0'>
               </div>    
        </div>
</div>
<div id ='Q-exam_3' style='display:none'>
<div class='table-responsive'>
        <div>
            <table id='qualifying_Table_3'>
                 <thead>
                        <tr>
                        <th><label for='qualifying_details'></label></th>
                         <th><center><label for='qualifying_details'>Qualifying Exam Subjects<sup class='star'>*</sup></label> </center></th>
                        <th><center><label for='qualifying_grades'>Grades<sup class='star'>*</sup></label> </center></th>

       </tr>
                </thead>
<tbody id='qualifying_table_body4'>
                        <tr class='qualifyingexam4-0'>
                        <td><input type='text' size='2' maxlength='2' value='1'></td>
      
      <td> <select name='qualifying_details' class='qualifying_details'> 
            <option value='STP 501/502 Theory of Statistics'>STP 501/502 Theory of Statistics</option>
            <option value='MAT 570 Real Analysis I/MAT 571 Real Analysis II'>MAT 570 Real Analysis I/MAT 571 Real Analysis II</option>
            <option value='APM 503 Applied Analysis/APM 504 Applied Probability'>APM 503 Applied Analysis/APM 504 Applied Probability</option>      
          </select>
      </td>
      <td> <select name='qualifying_grades' class='qualifying_grades'> 
            <option value='MS Pass'>MS Pass</option>
            <option value='PhD Pass'>PhD Pass</option>
            <option value='Fail'>Fail</option>
      </td>
                        </tr>
                </tbody>
            </table>
        </div>
</div>
<div class='btn-group-horizontal'>
        <button type='button' class='btn btn-primary' onclick=\"addRow('qualifying_Table_3')\">Add Qualifying Subjects</button>
        <button type='button' class='btn btn-primary' onclick=\"delRow('qualifying_Table_3')\">Remove Qualifying Subjects</button>
</div>
</div>
</div>



<div class='form-group'>
      <label class='control-label col-md-4' for='comprehensive_exam'>Written Comprehensive Exam Completed?<sup class='star'>*</sup></label>

      <label class='control-label col-md-1'>Yes</label>
      <div class='col-md-1'>
        <input type='radio' name='comprehensive_exam' id='comprehensive_exam_yes' value='1' onclick='WrittenComp()'";
        if($WrittenCompleted==='1')echo "checked='checked' ";echo">
      </div>
      <label class='control-label col-md-1'>No</label>
      <div class='col-md-1'>
        <input type='radio' name='comprehensive_exam' id='comprehensive_exam_no' value='0' onclick='WrittenComp()'";
        if($WrittenCompleted==='0')echo "checked='checked' ";echo">
      </div>
</div>

<div id='written_comp_div' style='display:none'>
<div class='table-responsive'>
    <table id='written_Table'>
       <thead>
         <tr>
           <th><label for='written_comprehensive'></label></th>
           <th><center><label for='written_comprehensive'>Written Comprehensive Exam<sup class='star'>*</sup></label> </center></th>
           <th><center><label for='written_grades'>Grades<sup class='star'>*</sup></label> </center></th>
        </tr>
        </thead>
        <tbody id='written_table_body'>
        <tr class='writtenexam0'>
           <td><input type='text' size='2' maxlength='2' value='1'></td>
          <td> <input name='written_comprehensive' class='written_comprehensive' type='text' size='70' ";if($_GET['valid']==1)echo"style='background-color:#FCF5D8'";echo"value='".$written."'";echo">
           </td>
           <td> <select name='written_grades' class='written_grades'>
                  <option disabled selected value='-1'> -- select a Grade-- </option>
                  <option value='Pass'";if($writ_grade==='Pass')echo "selected";echo ">Pass</option>
                  <option value='Fail'";if($writ_grade==='Fail')echo "selected";echo ">Fail</option>
                </select>

         </td>
        </tr>
    </tbody>
</table>
</div>
<div class='btn-group-horizontal'>
  <button type='button' class='btn btn-primary' onclick=\"addRow('written_Table')\">Add Written Comp Subjects</button>
  <button type='button' class='btn btn-primary' onclick=\"delRow('written_Table')\">Remove Written Comp Subjects</button>
</div>
</div>

<div class='form-group'  id='oral_comprehensive_exam_id'>
      <label class='control-label col-md-4' for='oral_comprehensive_exam'>Dissertation prospectus completed?<sup class='star'>*</sup></label>

      <label class='control-label col-md-1'>Yes</label>
      <div class='col-md-1'>
      <input type='radio' name='oral_comprehensive_exam' id='oral_comprehensive_exam' value='1'";
        if($OralComp==='1')echo "checked='checked'";echo">
      </div>
      <label class='control-label col-md-1'>No</label>
      <div class='col-md-1'>
        <input type='radio' name='oral_comprehensive_exam' id='oral_comprehensive_exam' value='0'";
        if($OralComp==='0')echo "checked='checked'";echo">
      </div>
</div>

<div class='form-group' id='coll'>
      <label class='control-label col-md-4' for='colloquium'>Colloquium/Distinguished Lecture Series Attended?<sup class='star'>*</sup></label>

      <label class='control-label col-md-1'>Yes</label>
      <div class='col-md-1'>
        <input type='radio' name='colloquium' id='colloquium_yes' class='colloquium' onclick='Colloquium()' value='1'";
        if($Colloquium==='1')echo "checked='checked'";echo">
      </div>
      <label class='control-label col-md-1'>No</label>
      <div class='col-md-1'>
        <input type='radio' name='colloquium' id='colloquium_no' class='colloquium' onclick='Colloquium()' value='0'";
        if($Colloquium==='0')echo "checked='checked'";echo">
      </div>
    </div>

<div class='form-group' id='check_coll_sem' style='display:none'>
      <label class='control-label col-md-4' for='colloquium_reason'>Tick if attended more than 75% of the colloquium lectures for mentioned semesters<sup class='star'>*</sup></label>
      <div class='col-md-8' for='colloquium_reason'>
 <input type='checkbox' name='colloquium_reason' id='colloquium_reason' class='colloquium_reason0' value='Semester 1'";
        if(in_array('Semester 1',$colloquim))echo"checked='checked'";echo">Semester 1
        <input type='checkbox' name='colloquium_reason' id='colloquium_reason' class='colloquium_reason1' value='Semester 2'";
        if(in_array('Semester 2',$colloquim))echo"checked='checked'";echo">Semester 2
        <input type='checkbox' name='colloquium_reason' id='colloquium_reason' class='colloquium_reason2' value='Semester 3'";
        if(in_array('Semester 3',$colloquim))echo"checked='checked'";echo">Semester 3
        <input type='checkbox' name='colloquium_reason' id='colloquium_reason' class='colloquium_reason3' value='Semester 4'";
        if(in_array('Semester 4',$colloquim))echo"checked='checked'";echo">Semester 4
        
      </div>
    </div>

<div class='table-responsive'>
    <table id='current_Table'>
       <thead>
         <tr>
           <th><label for='current_goal'></label></th>
           <th><center><label for='current_goal'>Current accomplished Goals<sup class='star'>*</sup></label>
            <span class='glyphicon glyphicon-info-sign help_current_goal' title='Enter goals you thought were important
            and you completed them.
            eg: Completed Qualification Exam.
            Completed current thesis work'></span>
           </center><font size='2'><i>(Please hover over <span class='glyphicon glyphicon-info-sign help_current_goal'></span> to check for details)</font></i></th>
        </tr>
        </thead>
        <tbody>
        <tr>
           <td><input type='text' size='2' maxlength='2' value='1'></td>
          <td> <input name='current_goal' class='current_goal' type='text' size='70'";if($_GET['valid']==1)echo"style='background-color:#FCF5D8'";echo"value='".$cur."'";echo">
           </td>
        </tr>
    </tbody>
</table>
</div>
<div class='btn-group-horizontal'>
  <button type='button' class='btn btn-primary' onclick=\"addRow('current_Table')\">Add Current Goals</button>
  <button type='button' class='btn btn-primary' onclick=\"delRow('current_Table')\">Remove Current Goals</button>
</div>
<br>

<div class='table-responsive'>
    <table id='publication_Table'>
       <thead>
         <tr>
           <th><label for='publication'></label></th>
           <th><center><label for='publication'>Publications<sup class='star'>*</sup></label>
            <span class='glyphicon glyphicon-info-sign help_current_goal' 
            title='Please Enter in following format.
            Publication:Journal:
            Status=Approved/Rejected.
            If you have not yet done a publication please write Yet To Do'></span>
           </center><font size='2'><i>(Please hover over <span class='glyphicon glyphicon-info-sign help_current_goal'></span> to check for details)</font></i></th>
        </tr>
        </thead>
        <tbody>
        <tr>
           <td><input type='text' size='2' maxlength='2' value='1'></td>
           <td> <input name='publication' class='publication' type='text' size='70'";if($_GET['valid']==1)echo"style='background-color:#FCF5D8'";echo"value='".$pub."'";echo">
           </td>
        </tr>
    </tbody>
</table>
</div>
<div class='btn-group-horizontal'>
  <button type='button' class='btn btn-primary' onclick=\"addRow('publication_Table')\">Add Publications</button>
  <button type='button' class='btn btn-primary' onclick=\"delRow('publication_Table')\">Remove Publications</button>
</div>
<br>

<div class='table-responsive'>
    <table id='presentation_Table'>
       <thead>
         <tr>
           <th><label for='presentation'></label></th>
           <th><center><label for='presentation'>Presentations<sup class='star'>*</sup></label>
            <span class='glyphicon glyphicon-info-sign help_current_goal' title='Please Enter in following format.Presentation:
            Conference
            If you have not yet done a presentation please write Yet To Do'></span>
           </center><font size='2'><i>(Please hover over <span class='glyphicon glyphicon-info-sign help_current_goal'></span> to check for details)</font></i></th>
        </tr>
        </thead>
        <tbody>
        <tr>
           <td><input type='text' size='2' maxlength='2' value='1'></td>
           <td> <input name='presentation' class='presentation' type='text' size='70'";if($_GET['valid']==1)echo"style='background-color:#FCF5D8'";echo"value='".$pre."'";echo">
           </td>
        </tr>
    </tbody>
</table>
</div>
<div class='btn-group-horizontal'>
  <button type='button' class='btn btn-primary' onclick=\"addRow('presentation_Table')\">Add Presentations</button>
  <button type='button' class='btn btn-primary' onclick=\"delRow('presentation_Table')\">Remove Presentations</button>
</div>
<br>


<div class='table-responsive'>
      <table id='future_Table'>
       <thead>
         <tr>
           <th><label for='future_goal'></label></th>
           <th><center><label for='future_goal'>Future Goals<sup class='star'>*</sup></label>
            <span class='glyphicon glyphicon-info-sign help_current_goal' title='Enter goals you think are important
            and you need to complete them.
            eg: Completing Qualification Exam.
            Completing some current thesis work'></span>
           </center><font size='2'><i>(Please hover over <span class='glyphicon glyphicon-info-sign help_current_goal'></span> to check for details)</font></i></th>
        </tr>
        </thead>
        <tbody>
        <tr>
           <td><input type='text' size='2' maxlength='2' value='1'></td>
          <td> <input name='future_goal' class='future_goal' type='text' size='70'";if($_GET['valid']==1)echo"style='background-color:#FCF5D8'";echo"value='".$fut."'";echo"></td>
        </tr>
    </tbody>
</table>
</div>
<div class='btn-group-horizontal'>
  <button type='button' class='btn btn-primary' onclick=\"addRow('future_Table')\">Add Future Goals</button>
  <button type='button' class='btn btn-primary' onclick=\"delRow('future_Table')\">Remove Future Goals</button>
</div>


<div class='form-group'>
        <label class='control-label col-md-7' for='file'>Please attach your current iPOS/Unofficial transcript</label>
  <div class='col-md-3'>
    <input type='file' id='file' name='file'>
  </div>
</div>

<div class='form-group'>
  
      <label class='control-label col-md-6' for='extra'>Please mention if you wish to add anymore to this form</label><i>(optional)</i>
      <textarea class='form-control' name='extra' id='extra'></textarea>
    </div>

    <div class='form-group'>        
      <div class='col-md-offset-2 col-md-10'>
        <div class='checkbox'>
          <label><input type='checkbox' value='true' name='certify' id='certify'>I certify that the above information given is true and complete to the best of my knowledge.</label>
        </div>
      </div>
    </div>
    <div class='form-group'>        
      <div class='col-md-offset-2 col-md-10'>
      <button id='myButton' class='submit'>SUBMIT</button>
  </div>
    </div>

  </form>
</div>
</body>
</html>";
?>
