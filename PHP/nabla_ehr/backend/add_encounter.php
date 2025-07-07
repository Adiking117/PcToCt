<?php
include 'db.php';

$data = json_decode(file_get_contents("php://input"), true);
$patient_id = $data['patient_id'];
$doctor_id = $data['doctor_id'];

$stmt = $conn->prepare("INSERT INTO encounter (patient_id, doctor_id) VALUES (?, ?)");
$stmt->bind_param("ii", $patient_id, $doctor_id);
$stmt->execute();

echo json_encode(["status" => "success", "encounter_id" => $stmt->insert_id]);
?>
