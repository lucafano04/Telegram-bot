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
$sql  = 'SELECT * FROM `bot`.`gest` WHERE `ID` = '.$id;
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    echo "user Found";
    $info = $row;
  }
} else {
  	$sql = "INSERT INTO `gest` (`ID`, `Username`, `Nome`, `Cognome`, `page`) VALUES ('$id', '$username', '$nome', '$cognome', '')";
	if ($conn->query($sql) === TRUE) {}else{
    sendMessage($chat,"Utente non Creato\n$conn->error");
  }
}
$admin = array();
$sql  = 'SELECT * FROM `bot`.`gest` WHERE `Admin` = "Yes"';
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    $admin[] = (int)$row['ID'];
  }
}
?>