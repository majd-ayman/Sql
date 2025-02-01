<?php
$host = "localhost"; 
$username = "root"; 
$password = ""; 
$database = "crud"; 

$conn = new mysqli($host, $username, $password, $database); 

if ($conn->connect_error) { //Error handiling to cheeck if the coonection true contenuio if false stop and viwe messeg error 
}

    die("The connection failed" . $conn->connect_error);
?>
