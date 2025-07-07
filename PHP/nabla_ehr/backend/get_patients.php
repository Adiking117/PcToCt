<?php
include 'db.php';
$res = $conn->query("SELECT * FROM patient");
$patients = [];

while($row = $res->fetch_assoc()) {
    $patients[] = $row;
}

echo json_encode($patients);
?>
