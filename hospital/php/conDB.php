<?php

$severname = "localhost";
$username = "root";
$password = "";
$dbname = "db_project";

//create connection
$conn = new mysqli($severname,$username,$password,$dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
//echo "Connected successfully"; 
mysqli_set_charset($conn, "utf8");
?>