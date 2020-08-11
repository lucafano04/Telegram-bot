<?php
$servername = "localhost";
$username1 = "pmauser";
$password = "Zumbadance2";
$dbname = "bot";

// Create connection
$conn = new mysqli($servername, $username1, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$sql  = 'SELECT * FROM `gest` WHERE `ID` = `$id`';
$result = $conn->query($sql);

if ($result->num_rows > 0) {
}else{
	$sql = "INSERT INTO `gest` (`ID`, `Username`, `Nome`, `Cognome`, `page`) VALUES ('$id', '$username', '$nome', '$cognome', '')";
	if ($conn->query($sql) === TRUE) {
	}
}
?>