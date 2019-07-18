<?php

//if(isset($_POST['submitted']))
//{

        $servername = "localhost";
        $username = "root";
        $password = "Ra!nb0w";
        $db_name = "SOMSS";
// Create connection
        $conn = mysqli_connect($servername, $username, $password, $db_name);

// Check connection
        if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
                }
?>
