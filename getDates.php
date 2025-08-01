<?php
include 'config/connection.php';

$id = $_GET['id'] ?? 0;
$mes = $_GET['mes'] ?? ''; // formato esperado: "2025-07"

$stmt = $conn->prepare("SELECT datas FROM freqMonth WHERE id = :id");
$stmt->execute([':id' => $id]);
$result = $stmt->fetch();

if ($result) {
  $todasDatas = json_decode($result['datas'], true);
  if (isset($todasDatas[$mes])) {
    echo json_encode($todasDatas[$mes]);
  } else {
    echo json_encode([]); // mês não encontrado
  }
} else {
  echo json_encode([]); // paciente não encontrado
}
