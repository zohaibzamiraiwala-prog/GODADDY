<?php
// db.php - Database connection file
$servername = "localhost"; // Assuming localhost, as not specified
$username = "unkuodtm3putf";
$password = "htk2glkxl4n4";
$dbname = "dbblb1kucgg4te";
 
$conn = new mysqli($servername, $username, $password, $dbname);
 
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
