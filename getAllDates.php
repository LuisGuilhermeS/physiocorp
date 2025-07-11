<?php
include 'config/connection.php';

$stmt = $conn->query("SELECT id, datas FROM freqMonth");
$pacientes = [];

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
  $pacientes[] = [
    'id' => $row['id'],
    'datas' => json_decode($row['datas'], true)
  ];
}

echo json_encode($pacientes);

