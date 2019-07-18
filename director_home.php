<?php
require_once '../../CAS/config.php';
require_once $phpcas_path . 'CAS.php';

phpCAS::client(CAS_VERSION_2_0, $cas_host, $cas_port, $cas_context);
phpCAS::setNoCasServerValidation();
phpCAS::forceAuthentication();
phpCAS::handleLogoutRequests();
?>

<html>
<title>Director Home</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  <link rel="stylesheet" href="/resources/demos/style.css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.8.3.js"></script>
  <script src="//code.jquery.com/ui/1.9.2/jquery-ui.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="jqmeter.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript">

$(document).ready(function(){
var index = $("input[type=submit][clicked=true]").val();
//console.log(index);

    $(document).on("click",":submit",
    	function(evt){

        var i = $(this).val();
        console.log("ID: " + i);
        //var temp = 'ID_'+i;

        //var id = $('#'+temp).text();
        flag=true;

        if(flag==true){
            $.ajax({
            type: "POST",
            url: "./sendreminder.php",
            dataType:"json",
            data:({name:i}),
           
            success:function(data){},
            });

        }
            
    });
    

});

    function ApproveForm(Asu_id){
			console.log("approveform" + Asu_id);
			
			$.ajax({
				type: 'POST',
				url: 'director_data.php',
				data:{
					signature:"DirectApproval",
					asu_id:Asu_id,
					//index:Index,
					director_comments:"DirectApproval"
				},
				success: function(data){
				//alert(Director_Comments);
				alert("The progress report for the student has been approved!");
				window.location.href="https://mathcms.asu.edu/somss/director_home.php?key=2wsxZaq1";
				}
			});
			
		}

</script>

<style>
.approval{
    border-radius: 50px;
    height: 30px;
    width: 30px;
    background:red;
    margin:auto; 
}
.approval_green{
    border-radius: 50px;
    height: 30px;
    width: 30px;
    background:green;
    vertical-align:middle;
    float:center;

}

.CSSTableGenerator {
        margin:0px;padding:0px;
        width:auto;
        box-shadow: 10px 10px 5px #888888;
        border:1px solid #000000;
        float:center;
}.CSSTableGenerator table{
    border-collapse: collapse;
	table-layout:auto;
        border-spacing: 0;
        width:100%;
        height:auto;
        margin:0px;padding:0px;
}.CSSTableGenerator tr:nth-child(odd){ background-color:#b2b2b2; }
.CSSTableGenerator tr:nth-child(even)    { background-color:#ffffff; }.CSSTableGenerator td{
        vertical-align:middle;
        border:1px solid #000000;
        border-width:0px 1px 1px 0px;
        text-align:left;
        padding:6px;
        font-size:15px;
        font-family:Arial;
        font-weight:normal;
        color:#000000;
}.CSSTableGenerator tr:last-child td{
        border-width:0px 1px 0px 0px;
}.CSSTableGenerator tr td:last-child{
        border-width:0px 0px 1px 0px;
}.CSSTableGenerator tr:last-child td:last-child{
        border-width:0px 0px 0px 0px;
}.CSSTableGenerator tr:first-child td{
                background:-o-linear-gradient(bottom, #bf0000 5%, #bf5f00 100%);        background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #bf0000), color-stop(1, #bf5f00) );
        background:-moz-linear-gradient( center top, #bf0000 5%, #bf5f00 100% );
        filter:progid:DXImageTransform.Microsoft.gradient(startColorstr="#bf0000", endColorstr="#bf5f00");      background: -o-linear-gradient(top,#bf0000,bf5f00);

        background-color:#bf0000;
        border:0px solid #000000;
        text-align:center;
        border-width:0px 0px 1px 1px;
        font-size:14px;
        font-family:Arial;
        font-weight:bold;
        color:#ffffff;
}
</style>
<body>
<form method="POST">
<?php
error_reporting(E_ERROR);
if($_GET['key']=='2wsxZaq1'){

    include('connect.php');
    //need to resolve this. for time being let it be like this but access should be with only jen and Hal and renate and me
    //$ADVISOR= phpCAS::getUser();

   // $ADVISOR=$_POST['Admin_Advisor'];

$current_year = date('Y');
$current_month = date('m');

if($current_month >= 7 && $current_month <=12){
	echo "<h3><center> PhD Student Reports - Fall ".$current_year."</center></h3>";
}
elseif($current_month>=1 && $current_month<=5){
	echo "<h3><center> PhD Student Reports - Spring ".$current_year."</center></h3>";  
}
else{
	echo "<h3><center> PhD Student Reports - Summer ".$current_year."</center></h3>";
}

if($current_month < 7){
	$table_name = intval($current_year-1).'_'.$current_year; 
}
else{
	// commented by Aneesh - this wont work anymore
	// $table_name = $current_year.'_'.intval($current_year  + 1); 
}
	$table_name = "2018_2019";
            $sql = "SELECT ASU_ID,First_Name,Second_Name,Adivisory_Committee,Advisor_Firstname,Approved,Main_Advisor_Flag,Advisor_Secondname,Advisor_Mail, Submission_date, Director_Comments, Director_Signature from ".$table_name." order by Submission_date desc";
            // where Admin_Advisor like '%$ADVISOR%'";

    $retval = mysqli_query($conn,$sql);
            if (!$retval) {
                    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
    
    echo "<div class='CSSTableGenerator'><table><tr><td>Sr.No</td><td>First Name</td><td>Last Name</td><td>ASU ID</td><td>Application Submission Date</td><td>ADVISORS PRESENT</td><td>Advisor Approval</td><td>Remind Advisors</td><td>Director Approval</td></tr>";
	$current_year = date('Y');
$current_month = date('m');
					if($current_month<7)
							{
									$current_academic_year=intval($current_year-1).'_'.$current_year;
							}
							else
							{
								
									$current_academic_year=$current_year.'_'.intval($current_year+1);

							}
							
							

    $count=1;
    $total_count=0;
	$unique_count=0;
	$total_approved=0;
	//$director_comments="dsfgj";	
		
    while($row = mysqli_fetch_array($retval, MYSQLI_NUM))
    {
		
		$director_comments = $row[10];
		$director_signature = $row[11];
        if($row[3]==1){
        $row[5]=json_decode($row[5]); // Approved has the First and Last Name
        $ADVISOR_TEAM1=json_decode($row[4],true);//First Name of Advisor 
        $ADVISOR_TEAM2=json_decode($row[7],true);//Second Name of Advisor
        $MAILID=json_decode($row[8],true); // advisor mails these are unique
        $ADVISOR_TEAM=array();
        $MAILS=array();
        foreach($ADVISOR_TEAM1 as $key=>$val){
                
                $val1=$ADVISOR_TEAM2[$key];
                
                $ADVISOR_TEAM[$key] = $val ." ". $val1;
                
            }

        $total_count=count($ADVISOR_TEAM);
        $unique_count=array_unique($row[5]);
        $total_approved=count($unique_count);
       
        }



    //$mail_flag=0;
    //https://pi.asu.edu/somss/main_advisor_noadvisor.php?ASU_ID=1204562770&index=0&key=1qazXsw2
    if($row[3]==="1")
    {
    $advisor_formed="YES";
    echo"<tr>
    <td name='srno' id='srno'>".$count."</td>
    <td>{$row[1]}</td><td>{$row[2]}</td>
	<!-- <td ><a href=student_demo.php?ID=$row[0]&AcademicYear=$current_academic_year name='ID' id='ID_".$count."' value=".$row[0].">{$row[0]}</a></td> -->
	<td ><a href=director.php?ASU_ID=$row[0]&key=2wsxZaq1 name='ID' id='ID_".$count."' value=".$row[0].">{$row[0]}</a></td>
	<td>{$row[9]}</td><td>$advisor_formed</td><td><div class='approval' id='approval$count' title='The form has not yet been approved by any member of the Advising Committee'></div></td><td>";
    
    if($total_approved == 0 && ($director_signature == null || $director_signature == "" || $director_signature == NULL)){
       echo "<button name='submit_btn' type='submit' class='submit' id='".$count."' value=".$row[0].">Reminder</button>";

    }
    echo "</td>";
    echo "<td>";
    if($director_comments!=null|| $director_comments!="" || $director_comments!=NULL){
		echo $director_comments;
    }
    if($director_comments != "DirectApproval"){
		echo "<input type='button' name='approveBtn' onclick='ApproveForm({$row[0]})' value='Approve'>";
    }
    echo "</td></tr>";
    }
    else if ($row[3]==="0")
    {
    $advisor_formed="NO";

    echo"<tr>
    <td name='srno' id='srno'>".$count."</td>
    <td>{$row[1]}</td><td>{$row[2]}</td>
    <!-- <td><a href=student_demo.php?ID=$row[0]&AcademicYear=$current_academic_year>{$row[0]}</a></td> -->
    <td><a href=director.php?ASU_ID=$row[0]&key=2wsxZaq1>{$row[0]}</a></td>
    <td>{$row[9]}</td><td>$advisor_formed</td><td><div class='approval' id='approval$count' title='The student does not have a Advising Committee'></div></td><td></td>";
    echo "<td>";
    if($director_comments!=null|| $director_comments!="" || $director_comments!=NULL){
		echo $director_comments;
    }
    if($director_comments != "DirectApproval"){
		echo "<input type='button' name='approveBtn' onclick='ApproveForm({$row[0]})' value='Approve'>";
    }
    echo "</td></tr>";
    }
    


    echo"
    <script>



      $('#approval$count').each(function() {
      	var abc = '$director_comments';
      	var n= abc.length;
      	//console.log(n);
    	if($total_approved!=0 || abc.length != 0)
    	{
    	$('#approval$count').attr('style','background:green');
    	$('#approval$count').attr('title','The Form is approved by the member(s) of the Advising Committee');
    	}

    	});


     


    </script>
    ";

    $count= $count + 1;
//echo "<tr><td>{$row[3]}</td></tr>";
    }
	
    echo"</table></div>";
    mysqli_close($conn);

}
else{

    echo "You have no acess to this page";
}



?>
</form>
</body> 

<script>
setTimeout(() => {
console.log('updating ui')
	let rows = Array.prototype.slice.call(document.getElementsByClassName('CSSTableGenerator')[0].getElementsByTagName('table')[0].getElementsByTagName('tr'))

	//document.getElementsByClassName('CSSTableGenerator').innerHTML = '';
	let op = '<form method="POST"><h3><center> PhD Student Reports - Fall 2019</center></h3><div id="tabs"><ul><li><a href="#2018">2018</a></li><li><a href="#2019">2019</a></li></ul>'
	let t1 = '<div class="CSSTableGenerator" id="2018"><table>'
	t1 += '<tr>'
	t1 += rows[0].innerHTML
	t1 += '</tr>'
	let t2 = '<div class="CSSTableGenerator" id="2019"><table>'
	t2 += '<tr>'
	t2 += rows[0].innerHTML
	t2 += '</tr>'

	rows.map(e => {
		if(e.getElementsByTagName('td')[4].innerText.split('-')[0] === "2018") {
			t1 += '<tr>'
			t1 += e.innerHTML
			t1 += '</tr>'
		}
		else if(e.getElementsByTagName('td')[4].innerText.split('-')[0] === "2019") {
			t2 += '<tr>'
			t2 += e.innerHTML
			t2 += '</tr>'
		}
	})
	t1 += "</table></div>"
	t2 += "</table></div>"
	op += t1
	op += t2
	op += "</div></form>"

	console.log(op)
	document.body.innerHTML = op
	$(function() {
		$('#tabs').tabs();
		console.log('done');
	});

}, 750)


</script>



</html>

