<?php
$host = "62.72.50.204";
$user = "u747739612_dermacarenew";
$pass = "Dermacarenew1!";
$dbname = "u747739612_derma";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>