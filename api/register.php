<?php
header("Content-Type: application/json");
include "db_connect.php";

$data = json_decode(file_get_contents("php://input"));

$email = $data->email;
$name = $data->name;
$address = $data->address;
$age = $data->age;
$sex = $data->sex;
$dob = $data->dob;
$phone = $data->phone;
$password = $data->password; // Removed password hashing

// Prepare SQL and bind parameters
$stmt = $conn->prepare("INSERT INTO patient (pemail, pname, paddress, page, psex, pdob, ptel, ppassword) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssssss", $email, $name, $address, $age, $sex, $dob, $phone, $password);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Registration successful"]);
} else {
    echo json_encode(["success" => false, "message" => "Registration failed"]);
}

$stmt->close();
$conn->close();
?>
