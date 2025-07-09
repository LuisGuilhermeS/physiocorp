<?php
include 'config/connection.php';

$data = json_decode(file_get_contents("php://input"), true);
$id = $data['id'];
$datas = $data['datas']; // ex: ["2025-07-02", "2025-07-04"]

$frequenciaPorMes = [];
foreach ($datas as $dataCompleta) {
  $mes = substr($dataCompleta, 0, 7);
  if (!isset($frequenciaPorMes[$mes])) {
    $frequenciaPorMes[$mes] = [];
  }
  $frequenciaPorMes[$mes][] = $dataCompleta;
}

// Verifica se já existe
$stmt = $conn->prepare("SELECT datas FROM freqMonth WHERE id = :id");
$stmt->execute([':id' => $id]);
$result = $stmt->fetch(PDO::FETCH_ASSOC);

if ($result) {
  $datasExistentes = json_decode($result['datas'], true);

  // Substituir os dados do mês atual pelos novos
  foreach ($frequenciaPorMes as $mes => $datasMesNovo) {
    $datasExistentes[$mes] = $datasMesNovo;
  }

  // Remove meses que não vieram mais (ex: se o usuário desmarcou todas)
  foreach ($datasExistentes as $mes => $datasSalvas) {
    if (!isset($frequenciaPorMes[$mes])) {
      unset($datasExistentes[$mes]);
    }
  }

  $datasAtualizadasJson = json_encode($datasExistentes);
  $update = $conn->prepare("UPDATE freqMonth SET datas = :datas WHERE id = :id");
  $update->execute([':datas' => $datasAtualizadasJson, ':id' => $id]);

} else {
  // Novo
  $jsonParaSalvar = json_encode($frequenciaPorMes);
  $insert = $conn->prepare("INSERT INTO freqMonth (id, datas) VALUES (:id, :datas)");
  $insert->execute([':id' => $id, ':datas' => $jsonParaSalvar]);
}

echo json_encode(['status' => 'ok']);
?>
