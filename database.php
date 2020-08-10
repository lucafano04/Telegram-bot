<?php
$servername = "localhost";
$username = "pmauser";
$password = "Zumbadance2";
$dbname = "bot";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

?>