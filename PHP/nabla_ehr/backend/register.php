<?php
include 'db.php';

$data = json_decode(file_get_contents("php://input"), true);
$name = $data['name'];
$role = $data['role'];

if ($role == "doctor") {
    $stmt = $conn->prepare("INSERT INTO doctor (name) VALUES (?)");
} else {
    $stmt = $conn->prepare("INSERT INTO patient (name) VALUES (?)");
}

$stmt->bind_param("s", $name);
$stmt->execute();

echo json_encode(["status" => "success"]);
?>
