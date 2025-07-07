<?php
include 'config/connection.php';

// Recebe dados do frontend
$data = json_decode(file_get_contents("php://input"), true);
$id_paciente = $data['id_paciente'];
$datas = $data['datas']; // array de datas ["2025-07-02", "2025-07-04"]

// Agrupa datas por mês
$frequenciaPorMes = [];

foreach ($datas as $dataCompleta) {
  $mes = substr($dataCompleta, 0, 7); // ex: "2025-07"
  if (!isset($frequenciaPorMes[$mes])) {
    $frequenciaPorMes[$mes] = [];
  }
  $frequenciaPorMes[$mes][] = $dataCompleta;
}

// Verifica se já existe registro no banco
$stmt = $conn->prepare("SELECT datas FROM frequencia WHERE id_paciente = :id");
$stmt->execute([':id' => $id_paciente]);
$result = $stmt->fetch(PDO::FETCH_ASSOC);

if ($result) {
  // Já existe, mesclar com o JSON existente
  $datasExistentes = json_decode($result['datas'], true);

  foreach ($frequenciaPorMes as $mes => $datasMesNovo) {
    if (!isset($datasExistentes[$mes])) {
      $datasExistentes[$mes] = [];
    }
    // Mesclar sem duplicar
    $datasExistentes[$mes] = array_unique(array_merge($datasExistentes[$mes], $datasMesNovo));
  }

  // Atualizar no banco
  $datasAtualizadasJson = json_encode($datasExistentes);
  $update = $conn->prepare("UPDATE frequencia SET datas = :datas WHERE id_paciente = :id");
  $update->execute([':datas' => $datasAtualizadasJson, ':id' => $id_paciente]);
} else {
  // Novo registro
  $jsonParaSalvar = json_encode($frequenciaPorMes);
  $insert = $conn->prepare("INSERT INTO frequencia (id_paciente, datas) VALUES (:id, :datas)");
  $insert->execute([':id' => $id_paciente, ':datas' => $jsonParaSalvar]);
}

echo json_encode(['status' => 'ok']);
?>
