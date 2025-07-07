<?php
include 'db.php';

$patient_id = $_GET['patient_id'];
$sql = "SELECT * FROM encounter WHERE patient_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $patient_id);
$stmt->execute();
$result = $stmt->get_result();

$encounters = [];
while($row = $result->fetch_assoc()) {
    $encounters[] = $row;
}

echo json_encode($encounters);
?>
