<?php
$servername = "localhost:3307";
$username = "root";  // your MySQL username
$password = "";      // your MySQL password
$dbname = "applied_physics";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
