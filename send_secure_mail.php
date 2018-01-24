<?php

   // Include the Mail package
   require "Mail.php";

   $name = $email = $title = $journal = $author = $paper = $accept = $acceptance = $remote_addr = $http_user_agent = $date = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $journal = $_POST["JOURNAL"];
  $title = $_POST["TITLE"];
  $author = $_POST["AUTHOR(S)"];
  $number = $_POST["PAPER NUMBER"];
  $name = $_POST["NAME"];
  $email = $_POST["EMAIL"];
  $accept = $_POST["ACCEPT"];
  $acceptance = $_POST["acceptance"];
  $remote_addr = $_SERVER["REMOTE_ADDR"];
  $http_user_agent = $_SERVER["HTTP_USER_AGENT"];
 // $date = $_SERVER["REQUEST_TIME"];
  $date = date(DATE_RFC850);

}
   $output = "JOURNAL: {$journal} \n TITLE:{$title} \n AUTHOR:{$author} \n NUMBER:{$number} \n NAME: {$name} \n EMAIL:{$email} \n ACCEPT:{$accept} \n acceptance: {$acceptance} \n REMOTE ADDRESS:{$remote_addr} \n HTTP_USER_AGENT: {$http_user_agent} \n DATE:{$date} \n";
   if(empty($output)==FALSE) {
   $sender    = "rmmcforms_app@asu.edu";
   $recipient = "aganesh8@asu.edu";
   $subject   = "RMMC";
   $body      = "{$output}";
  
   // Identify the mail server, username, password, and port
   $server   = "tls://smtp.asu.edu";
   $username = "rmmcforms_app";
   $password = "tsts.Rmmcj0urnals";
   $port     = "587";


   // Set up the mail headers
   $headers = array(
      "From"    => $sender,
      "To"      => $recipient,
      "Subject" => $subject
   );

   // Configure the mailer mechanism
   $smtp = Mail::factory("smtp",
      array(
        "host"     => $server,
        "username" => $username,
        "password" => $password,
        "auth"     => true,
        "port"     => 465
      )
   );

   // Send the message
   $mail = $smtp->send($recipient, $headers, $body);


   // Incase of sending errors
   if (PEAR::isError($mail)) {
      echo ($mail->getMessage());
   }

}

  // Redirect user to Thank you page
   header("Location: /ThankYou.html");
   exit();

?>

