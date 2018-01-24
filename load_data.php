<?php

include('connect.php');
$sql = "SELECT * from Form_data_gumel.somss where ASU_ID='$ASU_ID'";
$retval = mysqli_query($conn,$sql);
if (!$retval) {
	echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
while($row = mysqli_fetch_array($retval, MYSQL_ASSOC))
{




?>
