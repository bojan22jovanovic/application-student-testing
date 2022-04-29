<?php
$servername = "localhost";
$username = "root";
$password = "";
$datebase = "php_kurs";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $datebase);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
echo "";
?>