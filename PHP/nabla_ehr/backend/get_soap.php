<?php
// backend/get_soap.php
include 'db.php';

$encounter_id = $_GET['encounter_id'];

$stmt = $conn->prepare("SELECT * FROM soap_notes WHERE encounter_id = ?");
$stmt->bind_param("i", $encounter_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode($result->fetch_assoc());
} else {
    echo json_encode(null);
}
?>
