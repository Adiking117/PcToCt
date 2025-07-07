<?php
include 'db.php';

$data = json_decode(file_get_contents("php://input"), true);
$patient_id = $data['patient_id'];
$encounter_id = $data['encounter_id'];
$doctor_id = $data['doctor_id'];
$subjective = $data['subjective'];
$objective = $data['objective'];
$assesment = $data['assesment'];
$plan = $data['plan'];

$stmt = $conn->prepare("SELECT * FROM soap_notes WHERE encounter_id = ?");
$stmt->bind_param("i", $encounter_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $stmt = $conn->prepare("UPDATE soap_notes SET subjective=?, objective=?, assesment=?, plan=? WHERE encounter_id=?");
    $stmt->bind_param("ssssi", $subjective, $objective, $assesment, $plan, $encounter_id);
    $stmt->execute();
} else {
    $stmt = $conn->prepare("INSERT INTO soap_notes (patient_id, doctor_id, encounter_id, subjective, objective, assesment, plan) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iiissss", $patient_id, $doctor_id, $encounter_id, $subjective, $objective, $assesment, $plan);
    $stmt->execute();
}

echo json_encode(["status" => "success"]);
?>
