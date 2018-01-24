<?php
$mysqli = mysqli_connect("localhost", "root", "root", "SOMSS");
/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

/*
$Fall = '2016';
$Spring = '2017';
$table_name = $Fall."_".$Spring;
printf ("%s \n", $table_name);
echo "<script>console.log(\"$table_name\")</script>";
//$sql = "SELECT ASU_ID from SOMSS.somss_2016 where ASU_ID='1206109121'";
$createtable_query = "CREATE TABLE IF NOT EXISTS ".$table_name."(name varchar(30), id int(1) not null primary key, age int(2))";
printf ("%s \n", $createtable_query);
//$sql = $conn->query($createtable_query);
$retval = mysqli_query($mysqli,$createtable_query);

$insert_query = "INSERT INTO ".$table_name." VALUES('gaurav', 1, 23)";
$retval = mysqli_query($mysqli,$insert_query);
//$row = mysqli_fetch_array($retval, MYSQLI_ASSOC);
//printf ("%s \n", $row['ASU_ID']);
*/
/*
$Academic_Year_list = array('2011_2012','2012_2013','2013_2014','2014_2015','2015_2016','2016_2017');
$ASU_ID = $_GET['ID'];
$Year = $_GET['AcademicYear'];
$sql = "SELECT * from SOMSS.".$Year." where ASU_ID='$ASU_ID'";
$retval = mysqli_query($mysqli,$sql);
printf ("Hello %s", $sql);
while($row = mysqli_fetch_array($retval, MYSQLI_ASSOC))
{
	printf ("Hello");
	$AcademicYear=$row['Academic_Year'];
	$Degree_program=$row['Degree'];
	printf ("%s \n", $AcademicYear);
	printf ("%s \n", $Degree_program);
}

$mysqli->close();
*/
//$fall_spring_year = explode("_",$_GET['AcademicYear']);

//echo "<script>alert('hello')</script>";

$Academic_Year_list = array('2011_2012','2012_2013','2013_2014','2014_2015','2015_2016','2016_2017');
$ASU_ID = '1209365010';
$student_record_list = array();
foreach($Academic_Year_list as $Year){
	$sql = "SELECT * from SOMSS.".$Year." where ASU_ID='$ASU_ID'";
	$retval = mysqli_query($mysqli,$sql);
	if (!$retval) {
	echo "Error: " . $sql . "<br>" . mysqli_error($mysqli);
	}
	

	while($row = mysqli_fetch_array($retval, MYSQLI_ASSOC))
	{
		$student_record->AcademicYear=$row['Academic_Year'];
		$student_record->Degree_program=$row['Degree'];
		$student_record->FirstName=$row['First_Name'];
		$student_record->SecondName=$row['Second_Name'];
		$student_record->ASU_ID=$row['ASU_ID'];
		$student_record->ASURITE=$row['ASURITE'];
		$studentJSON = json_encode($student_record);
		//var_dump(json_decode($studentJSON));
		array_push($student_record_list,$studentJSON);
		//echo "<script>alert($row['Academic_Year'])</script>";
		//echo $row['Academic_Year'];
	}
}


//echo "hello";

foreach($student_record_list as $record){
	var_dump(json_decode($record));
}


/*
echo "<html>
<script src='./testjs.js'></script>
<body onload='test(<?php echo $student_record_list?>);'>
	<input type='text' class='form-control' id='academic_year_fall' name='academic_year_fall' <?php echo "value='$fall_spring_year[0]'"; ?>>
</body>
</html>";
*/
?>
