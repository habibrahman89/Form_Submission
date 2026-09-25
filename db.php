<?php
// disable error display in production; enable briefly for debugging
ini_set('display_errors', 0);
error_reporting(0);

$host = "sql100.ezyro.com"; 
$user = "ezyro_40500147";
$pass = "c5e8bfacad";
$dbname = "ezyro_40500147_users";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    // in debugging set display_errors=1 and die with message; in prod hide message
    die("Database Connection Failed");
}
?>