<?php



//$ASU_ID=$_POST['submit_btn'];
include('connect.php');


//$conn = mysqli_connect($servername, $username, $password, $db_name);

$current_year = date('Y');
$current_month = date('m');

if($current_month < 7){
	$table_name = intval($current_year-1).'_'.$current_year; 
}
else{
	$table_name = $current_year.'_'.intval($current_year  + 1); 
}

$ASU_ID=$_POST['name'];
$sql = "SELECT ASU_ID,First_Name,Second_Name,Adivisory_Committee,Advisor_Firstname,Approved,Main_Advisor_Flag,File_Name,Advisor_Secondname,Advisor_Mail,Advisor_Position from " . $table_name . 
	   " where ASU_ID='" . $ASU_ID . "'";
$retval = mysqli_query($conn,$sql);
     if (!$retval) {
                    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }

while($row = mysqli_fetch_array($retval, MYSQLI_NUM))
{
		$row[5]=json_decode($row[5]); // Approved has the First and Last Name
		$ADVISOR_POSITION = json_decode($row[10]);
        $ADVISOR_TEAM1=json_decode($row[4],true);//First Name of Advisor 
        $ADVISOR_TEAM2=json_decode($row[8],true);//Second Name of Advisor
        $MAILID=json_decode($row[9],true); // advisor mails these are unique
        $ADVISOR_TEAM=array();
        $MAILS=array();
        $Keys=array();
        foreach($ADVISOR_TEAM1 as $key=>$val){
                
                $val1=$ADVISOR_TEAM2[$key];
                
                $ADVISOR_TEAM[$key] = $val ." ". $val1;
                
            }

        $total_count=count($ADVISOR_TEAM);
        $unique_count=array_unique($row[5]);
        $total_approved=count($unique_count);
        $remaining=array_diff($ADVISOR_TEAM,$unique_count);
        $k=0;

        for($i=0;$i< $total_count;$i++){
        	if($ADVISOR_POSITION[$i] == "MEMBER")
				continue;
            if(array_key_exists($i,$remaining)){
                $MAILS[$k]=$MAILID[$i];
                $Keys[$k]=$i;
                $k++;
            }

        }



//Send reminder messages
$array_length = count($MAILS);
for($i=0;$i<$array_length;$i++)
{
	
$to      = $MAILS[$i];
$subject = '<<REMINDER>>Pending approval for student '.$row[1].'  '.$row[2];
$message = 'Approval for PhD Student '.$row[1].' '.$row[2].' is still pending.

Please visit the link below to sign the advisor form.
https://mathesis.asu.edu/somss/login.php?ASU_ID='.$row[0].'&index='.$Keys[$i].'

Please use the password 1qazXsw2 to login to the page and to approve the form.
Thank you!
';
$headers = 'From: somss.advising@asu.edu';// . "\r\n" .

mail($to, $subject, $message, $headers);

}

}
mysqli_close($conn);


?>
