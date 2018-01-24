
<?php
include('connect.php');
  
$current_year = date('Y');
$current_month = date('m');
if($current_month < 7){
	$table_name = intval($current_year-1).'_'.$current_year; 
}
else{
	$table_name = $current_year.'_'.intval($current_year  + 1); 
}

$id = $_GET["archive_btn"];


 $sql = "insert into archives_test select * from ".$table_name." where ASU_ID=".$id;//.$id;
 $sql1 = "delete from ".$table_name." where ASU_ID=".$id;//.$id;
  //$sql2 = "delete from somss_test where ASU_ID=$id";
  $retval = mysqli_query($conn,$sql);
  $retval2 = mysqli_query($conn,$sql1);
  //$val = mysqli_query($conn,$sql2);
  if (!$retval) {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    echo "<script>
    alert('Error');
    </script>
    ";
  }
  if (!$retval1) {
    echo "Error: " . $sql1 . "<br>" . mysqli_error($conn);
    echo "<script>
    alert('Error');
    </script>
    ";
  }
  header("Location: https://mathesis.asu.edu/somss/testuser_home.php?key=2wsxZaq1"); /* Redirect browser */
  exit();
?>

