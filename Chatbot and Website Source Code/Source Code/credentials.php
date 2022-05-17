<?php

$hostname = "localhost";
$username = "root";
$password = "";
$database = "onlinebot";

$conn = mysqli_connect($hostname, $username, $password, $database) or die("Database connection failed");
    define("EMAILID",'Enter Your Email Id, from which you want to send mail'); //Enter your E-mail
    define('PASSWORD','Enter the password of the above entered e-mail'); //Enter your E-mail Account Password
?>
