<?php
$servername = "localhost";
$usr = "root";
$pass = "";
$dbname = "dulcesofia";

// Create connection
$conn = new mysqli($servername, $usr, $pass, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
